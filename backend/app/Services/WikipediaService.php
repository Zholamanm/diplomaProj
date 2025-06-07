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
                $slug = preg_replace('/[^\p{L}\p{Nd}]+/u', '_', $categoryName);
                $slug = trim($slug, '_');
                $response = $this->client->get('', [
                    'query' => [
                        'action'        => 'query',
                        'format'        => 'json',
                        'prop'          => 'extracts|pageimages|info',
                        'inprop'        => 'url',
                        'exintro'       => true,
                        'explaintext'   => true,
                        'redirects'     => 1,
                        'pithumbsize'   => 500,
                        'titles'        => $slug,
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
     * Get detailed information about a category/genre
     */
    public function getGenreInfo(string $categoryName): ?array
    {
        $cacheKey = 'wikipedia_genre_' . md5($categoryName);
        return Cache::remember($cacheKey, now()->addDays(7), function() use ($categoryName) {
            try {
                $slug = preg_replace('/[^\p{L}\p{Nd}]+/u', '_', $categoryName);
                $slug = trim($slug, '_');
                $response = $this->client->get('', [
                    'query' => [
                        'action'        => 'query',
                        'format'        => 'json',
                        'prop'          => 'extracts|pageimages|info',
                        'inprop'        => 'url',
                        'exintro'       => true,
                        'explaintext'   => true,
                        'redirects'     => 1,
                        'pithumbsize'   => 500,
                        'titles'        => $slug,
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

        $normalized = str_replace(' ', '_', $categoryName);
        $normalized = str_replace('Non_Fiction', 'Non-fiction', $normalized);
        $normalized = str_replace('Nonfiction', 'Non-fiction', $normalized);

        $encoded = urlencode($normalized);
        $encoded = str_replace('%26', '&', $encoded);
        return Cache::remember($cacheKey, now()->addDays(7), function() use ($encoded) {
            try {
                $response = $this->client->get('', [
                    'query' => [
                        'action' => 'query',
                        'format' => 'json',
                        'list' => 'categorymembers',
                        'redirects' => 1,
                        'cmtitle' => $encoded == 'Non-fiction' ? 'List of non-fiction writers' : 'Category:' . $encoded . '_writers',
                        'cmlimit' => 10,
                        'cmprop' => 'title|type',
                        'cmtype' => 'page',
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

    public function getNotableAuthorsByGenre(string $genreName): ?array
    {
        $cacheKey = 'wikipedia_genre_authors_' . md5($genreName);

        // Normalize the genre name
        $normalized = str_replace(' ', '_', $genreName);

        // Handle common genre naming variations
        $normalized = str_replace(
            ['Science_Fiction', 'Sci_Fi', 'Sci-fi'],
            'Science_fiction',
            $normalized
        );
        $normalized = str_replace(
            ['Fantasy_Fiction', 'High_Fantasy'],
            'Fantasy',
            $normalized
        );
        $normalized = str_replace('Non_Fiction', 'Non-fiction', $normalized);
        $normalized = str_replace('Nonfiction', 'Non-fiction', $normalized);

        $encoded = urlencode($normalized);
        $encoded = str_replace('%26', '&', $encoded);

        return Cache::remember($cacheKey, now()->addDays(7), function() use ($encoded, $normalized) {
            try {
                // First try the direct genre writers category
                $response = $this->client->get('', [
                    'query' => [
                        'action' => 'query',
                        'format' => 'json',
                        'list' => 'categorymembers',
                        'redirects' => 1,
                        'cmtitle' => 'Category:' . $encoded . '_writers',
                        'cmlimit' => 10,
                        'cmprop' => 'title|type',
                        'cmtype' => 'page',
                    ]
                ]);

                $data = json_decode($response->getBody(), true);

                // If no results, try alternative category naming patterns
                if (empty($data['query']['categorymembers'])) {
                    $alternativePatterns = [
                        'Category:' . $encoded . '_authors',
                        'Category:' . $encoded . '_novelists',
                        'Category:Writers_of_' . $encoded,
                        'Category:' . $encoded . '_literature'
                    ];

                    foreach ($alternativePatterns as $pattern) {
                        $response = $this->client->get('', [
                            'query' => [
                                'action' => 'query',
                                'format' => 'json',
                                'list' => 'categorymembers',
                                'redirects' => 1,
                                'cmtitle' => $pattern,
                                'cmlimit' => 10,
                                'cmprop' => 'title|type',
                                'cmtype' => 'page',
                            ]
                        ]);

                        $altData = json_decode($response->getBody(), true);
                        if (!empty($altData['query']['categorymembers'])) {
                            return $altData['query']['categorymembers'];
                        }
                    }

                    // If still no results, try getting from list pages for specific genres
                    $listPages = [
                        'Science_fiction' => 'List_of_science_fiction_authors',
                        'Fantasy' => 'List_of_fantasy_authors',
                        'Mystery' => 'List_of_mystery_writers',
                        'Horror' => 'List_of_horror_fiction_writers'
                    ];

                    if (isset($listPages[$normalized])) {
                        $response = $this->client->get('', [
                            'query' => [
                                'action' => 'query',
                                'format' => 'json',
                                'prop' => 'links',
                                'titles' => $listPages[$normalized],
                                'pllimit' => 10,
                                'redirects' => 1
                            ]
                        ]);

                        $listData = json_decode($response->getBody(), true);
                        $pages = current($listData['query']['pages'] ?? []);

                        if (isset($pages['links'])) {
                            return array_map(function($link) {
                                return ['title' => $link['title'], 'type' => 'page'];
                            }, $pages['links']);
                        }
                    }
                }

                return $data['query']['categorymembers'] ?? null;
            } catch (\Exception $e) {
                \Log::error("Wikipedia API genre authors error: " . $e->getMessage());
                return null;
            }
        });
    }
}
