<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QuoteService
{
    /**
     * Get a random quote from the Quotable API
     *
     * @return array|null
     */
    public function getRandomQuote(): ?array
    {
        $response = Http::get('https://api.quotable.io/random');

        if ($response->successful()) {
            $data = $response->json();

            return [
                'content' => $data['content'] ?? null,
                'author'  => $data['author'] ?? null,
            ];
        }

        return null;
    }
}
