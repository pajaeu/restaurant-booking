<?php

return [
    'name' => env('RESTAURANT_NAME', 'Restaurant'),
    'open_hours' => [
        'open' => env('RESTAURANT_OPEN_HOUR', 10),
        'close' => env('RESTAURANT_CLOSE_HOUR', 21),
    ]
];