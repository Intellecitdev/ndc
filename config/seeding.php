<?php

// Initial passwords of the seeded accounts (read through config so they also work with config:cache).
// No defaults on purpose: seeding stops until strong passwords are set in .env.
return [
    'admin_password' => env('SEED_ADMIN_PASSWORD'),
    'user_password' => env('SEED_USER_PASSWORD'),
];
