<?php

return [
    'available' => [
        'UAH',
        'USD',
        'EUR',
        'GBP',
        'PLN',
    ],

    'default' => 'UAH',

    'api_url' => 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json',

    'cache_ttl' => 3600,

];