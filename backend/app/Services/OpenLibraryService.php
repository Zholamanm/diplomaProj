<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenLibraryService
{
    protected string $baseUrl = 'https://openlibrary.org';

    /**
     * Search books by title, author, or ISBN.
     *
     * @param string $query
     * @param int $limit
     * @return array|null
     */
    public function searchBooks(string $query, int $limit = 10): ?array
    {
        $response = Http::get("{$this->baseUrl}/search.json", [
            'q' => $query,
            'limit' => $limit,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Search books by title
     *
     * @param string $query
     * @param int $limit
     * @return array|null
     */
    public function searchBookByTitle(string $query): ?array
    {
        $response = Http::get("{$this->baseUrl}/search.json", [
            'title' => $query,
            'limit' => 10,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Get book details by Open Library ID (OLID).
     *
     * @param string $olid
     * @return array|null
     */
    public function getBookByOLID(string $olid): ?array
    {
        $response = Http::get("{$this->baseUrl}/books/{$olid}.json");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Get book details by ISBN.
     *
     * @param string $isbn
     * @return array|null
     */
    public function getBookByISBN(string $isbn): ?array
    {
        $response = Http::get("{$this->baseUrl}/isbn/{$isbn}.json");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
