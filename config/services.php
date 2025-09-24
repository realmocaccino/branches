<?php

return [

    'facebook' => [
    	'client_id'     => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect'      => env('FACEBOOK_URL'),
    ],
	
	'giantbomb' => [
		'key' => env('GIANTBOMB_KEY'),
		'url' => env('GIANTBOMB_URL')
	],
	
	'google' => [
		'key'           => env('GOOGLE_KEY'),
		'client_id'     => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect'      => env('GOOGLE_URL'),
	],
	
	'igdb' => [
	    'auth_url' => env('IGDB_AUTH_URL'),
		'client_id' => env('IGDB_ID'),
		'client_secret' => env('IGDB_SECRET'),
		'url' => env('IGDB_URL')
	],
	
	'recaptcha' => [
		'site_key' => env('RECAPTCHA_SITE_KEY'),
		'secret_key' => env('RECAPTCHA_SECRET_KEY')
	],
	
	'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION')
    ],
    
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET')
    ],
    
    'twitter' => [
    	'client_id'     => env('TWITTER_ID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect'      => env('TWITTER_URL'),
    ]
    
];