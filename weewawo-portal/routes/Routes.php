<?php
use Steampixel\Route;

/**
 * Example View (Shows the index page)
 * PHP version 7.0
 */

// Login View
Route::add('/login', function () {
  include 'views/login.php';
});

// Register View
Route::add('/register', function () {
  include 'views/register.php';
});

// Forgot Password View
Route::add('/forgot-password', function () {
  include 'views/forgot-password.php';
});

Route::add('/([a-z-0-9-]*)', function () {
  include 'views/index.php';
});


Route::add('/blog', function () {
  include 'views/blog.php';
});