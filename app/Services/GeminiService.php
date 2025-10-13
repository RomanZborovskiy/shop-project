<?php

namespace App\Services;

use Gemini\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function __construct(private readonly Client $client)
    {
    }

    public function generateDescription(string $name, string $brand, string $category): string
    {
        $prompt = <<<TEXT
        Згенеруй цікавий опис товару для інтернет-магазину.
        Назва: {$name}
        Бренд: {$brand}
        Категорія: {$category}

        Напиши 2–3 речення українською, у дружньому маркетинговому стилі.
        TEXT;

        try {
            $model = $this->client->generativeModel('gemini-2.5-flash');
            $response = $model->generateContent($prompt);
            $text = trim($response->text());

            return $text !== '' ? $text : "Опис поки що недоступний.";
        } catch (Exception $e) {
            Log::error('Gemini API error', [
                'exception' => $e,
                'prompt' => $prompt,
            ]);
            return "Не вдалося згенерувати опис. Будь ласка, перевірте лог-файли.";
        }
    }
}
