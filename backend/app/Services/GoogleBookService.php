<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GoogleBookService
{
    protected Client $client;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.googleapis.com/books/v1/',
            'timeout'  => 5.0,
        ]);

        $this->apiKey = env('GOOGLE_BOOKS_API_KEY');
    }

    /**
     * Search for books by subject (category).
     *
     * @param  string  $subject    The subject name, e.g. "Science Fiction"
     * @param  int     $maxResults Number of results (1–40)
     * @return array
     */
    public function getBooksBySubject(string $subject, int $maxResults = 10): array
    {
        $cacheKey = 'google_books_subject_'.md5($subject.$maxResults);

        return Cache::remember($cacheKey, now()->addHours(12), function() use ($subject, $maxResults) {
            $query = [
                'q'          => 'subject:'.Str::of($subject)->replace(' ', '+'),
                'maxResults' => min(max($maxResults, 1), 40),
            ];

            if ($this->apiKey) {
                $query['key'] = $this->apiKey;
            }

            $resp = $this->client->get('volumes', ['query' => $query]);
            $data = json_decode($resp->getBody()->getContents(), true);

            $items = $data['items'] ?? [];

            return array_map(function(array $item) {
                $info = $item['volumeInfo'] ?? [];

                return [
                    'id'            => $item['id'] ?? null,
                    'title'         => $info['title'] ?? null,
                    'authors'       => $info['authors'] ?? [],
                    'publisher'     => $info['publisher'] ?? null,
                    'publishedDate' => $info['publishedDate'] ?? null,
                    'description'   => $info['description'] ?? null,
                    'thumbnail'     => $info['imageLinks']['thumbnail'] ?? null,
                    'infoLink'      => $info['infoLink'] ?? null,
                ];
            }, $items);
        });
    }
}
