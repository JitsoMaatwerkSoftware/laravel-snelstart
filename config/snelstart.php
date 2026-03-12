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
    | Authentication Type
    |--------------------------------------------------------------------------
    |
    | Supported: "oauth", "clientkey"
    |
    | "oauth"     — Uses the OAuth2 client credentials flow (requires
    |               both client_key and client_secret).
    | "clientkey" — Uses the simpler clientkey grant (requires only
    |               client_key).
    |
    */
    'authentication_type' => env('SNELSTART_AUTH_TYPE', 'oauth'),

    /*
    |--------------------------------------------------------------------------
    | Client Credentials
    |--------------------------------------------------------------------------
    |
    | client_key is required for both authentication types.
    | client_secret is only required when authentication_type is "oauth".
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
