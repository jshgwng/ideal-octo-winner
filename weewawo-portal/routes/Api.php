<?php
use Steampixel\Route;

/**
 * Example API route: login a user 
 * endpoint : http://localhost/v1/user/login
 */
Route::add('/v1/user/login', function () {
    header('Content-Type: application/json');
    return login_user();
}, 'POST');

// Register a user
Route::add('/v1/user/register', function () {
    header('Content-Type: application/json');
    return register_user();
}, 'POST');