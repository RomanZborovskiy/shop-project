<?php

namespace App\Services;

use OpenAI;

class OpenAiService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('openai.api_key'));
    }

    public function generateDescription(string $name, string $brand, string $category): string
    {
        $prompt = "Згенеруй цікавий опис товару для інтернет-магазину.
        Назва: {$name}
        Бренд: {$brand}
        Категорія: {$category}
        
        Напиши 2–3 речення українською, у дружньому маркетинговому стилі.";

        $result = $this->client->chat()->create([
            'model' => 'models/gemini-1.5-pro',
            'messages' => [
                ['role' => 'system', 'content' => 'Ти копірайтер інтернет-магазину. Пиши коротко, цікаво, українською.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.6,
            'max_tokens' => 200,
        ]);

        return trim($result['choices'][0]['message']['content']);
    }
}