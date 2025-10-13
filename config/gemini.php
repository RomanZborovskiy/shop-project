<?php

// config/ai.php
return [
    // Драйвер за замовчуванням
    'default' => env('AI_DRIVER', 'openai'),

    // Опис доступних драйверів
    'drivers' => [
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => 'gpt-4o', // Модель за замовчуванням для цього драйвера
            'class' => App\Services\AI\Drivers\OpenAIDriver::class,
        ],
        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => 'gemini-1.5-pro-latest',
            'class' => App\Services\AI\Drivers\GeminiDriver::class,
        ],
        'log' => [ // Драйвер для тестування, просто логує запит
            'class' => App\Services\AI\Drivers\LogDriver::class,
        ],
    ],

    // Мапінг конкретних завдань на драйвери (опціонально)
    'tasks' => [
        // Для генерації SEO використовуємо дешевший GPT-3.5
        App\AITasks\GenerateSeoData::class => 'openai:gpt-3.5-turbo',
        // Для аналізу даних 
        App\AITasks\AnalyzeStatistics::class => 'gemini',
    ],
];