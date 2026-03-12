<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snelstart API Subscription Key
    |--------------------------------------------------------------------------
    |
    | The Ocp-Apim-Subscription-Key header value required for all API calls.
    |
    */
    'subscription_key' => env('SNELSTART_SUBSCRIPTION_KEY'),

    /*
    |--------------------------------------------------------------------------
    | OAuth2 Client Credentials
    |--------------------------------------------------------------------------
    |
    | Client key and secret for the OAuth2 client credentials flow used
    | to obtain Bearer tokens from the Snelstart auth server.
    |
    */
    'client_key' => env('SNELSTART_CLIENT_KEY'),
    'client_secret' => env('SNELSTART_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    */
    'base_url' => env('SNELSTART_BASE_URL', 'https://b2bapi.snelstart.nl/v2'),

    /*
    |--------------------------------------------------------------------------
    | OAuth2 Token URL
    |--------------------------------------------------------------------------
    */
    'token_url' => env('SNELSTART_TOKEN_URL', 'https://auth.snelstart.nl/b2b/token'),

    /*
    |--------------------------------------------------------------------------
    | Token Caching
    |--------------------------------------------------------------------------
    |
    | When enabled, the OAuth2 access token will be cached using Laravel's
    | cache driver to avoid unnecessary token requests.
    |
    */
    'cache_token' => env('SNELSTART_CACHE_TOKEN', true),

];
