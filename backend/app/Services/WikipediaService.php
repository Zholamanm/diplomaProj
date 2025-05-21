<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WikipediaService
{
    protected $client;
    protected $baseUrl = 'https://en.wikipedia.org/w/api.php';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5.0,
        ]);
    }

    /**
     * Get detailed information about a category/genre
     */
    public function getCategoryInfo(string $categoryName): ?array
    {
        $cacheKey = 'wikipedia_category_' . md5($categoryName);

        return Cache::remember($cacheKey, now()->addDays(7), function() use ($categoryName) {
            try {
                $response = $this->client->get('', [
                    'query' => [
                        'action'        => 'query',
                        'format'        => 'json',
                        'prop'          => 'extracts|pageimages|info',
                        'inprop'        => 'url',
                        'exintro'       => true,
                        'explaintext'   => true,
                        'pithumbsize'   => 500,
                        'titles'        => str_replace(' ', '_', $categoryName),
                        'origin'        => '*',
                    ]
                ]);

                $data = json_decode($response->getBody(), true);
                $page = current($data['query']['pages']);

                if (isset($page['missing'])) {
                    return null;
                }

                if (isset($page['extract'])) {
                    $infoText = $page['extract'] ?? 'No historical information available';

                    if (strlen($infoText) > 250) {
                        $infoText = substr($infoText, 0, 250) . '...';
                    }
                    $page['extract'] = $infoText;
                }

                return [
                    'title' => $page['title'],
                    'extract' => $page['extract'] ?? '',
                    'thumbnail' => $page['thumbnail']['source'] ?? null,
                    'url' => 'https://en.wikipedia.org/wiki/' . str_replace(' ', '_', $page['title'])
                ];
            } catch (\Exception $e) {
                \Log::error("Wikipedia API error: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get authors associated with this category
     */
    public function getNotableAuthors(string $categoryName): ?array
    {
        $cacheKey = 'wikipedia_authors_' . md5($categoryName);
        $encoded = str_replace(' ', '_', $categoryName);
        $encoded = urlencode($encoded);
        $encoded = str_replace('%26', '&', $encoded);
        return Cache::remember($cacheKey, now()->addDays(7), function() use ($encoded) {
            try {
                $response = $this->client->get('', [
                    'query' => [
                        'action' => 'query',
                        'format' => 'json',
                        'list' => 'categorymembers',
                        'cmtitle' => 'Category:' . $encoded . ' writers',
                        'cmlimit' => 10,
                        'cmprop' => 'title'
                    ]
                ]);

                $data = json_decode($response->getBody(), true);
                return $data['query']['categorymembers'] ?? null;
            } catch (\Exception $e) {
                \Log::error("Wikipedia API authors error: " . $e->getMessage());
                return null;
            }
        });
    }
}
