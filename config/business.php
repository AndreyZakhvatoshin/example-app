<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Business Logic Timezone
    |--------------------------------------------------------------------------
    |
    | This timezone is used for business logic operations like booking times,
    | calendar operations, etc. It ensures consistency across the application
    | for time-related business operations.
    |
    */

    'timezone' => env('BUSINESS_TIMEZONE', 'Europe/Moscow'),
];