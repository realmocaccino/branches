<?php
return [

    'webhooks' => [
        'exception_reporting' => env('DISCORD_WEBHOOK_EXCEPTION_REPORTING'),
        'new_collection' => env('DISCORD_WEBHOOK_NEW_COLLECTION'),
        'new_game' => env('DISCORD_WEBHOOK_NEW_GAME'),
        'new_review' => env('DISCORD_WEBHOOK_NEW_REVIEW')
    ]

];
