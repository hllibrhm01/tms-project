<?php

return array(
    'dsn' => env('SENTRY_DSN'),
    'release' => '1.0.1',
    'traces_sample_rate' => floatval(env('SENTRY_SAMPLE_RATE')) # be sure to lower this in production to prevent quota issues
);