<?php

use core\Router;
use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

Router::get('/', [ArticleController::class, 'index']); // the root/index page

// User/Auth related

Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);

Router::get('/register', [RegistrationController::class, 'index']); // show registration form.
Router::post('/register', [RegistrationController::class, 'register']); // process a registration req.

// Routes that require authentication
Router::get('/settings', [SettingsController::class, 'index']);
Router::post('/settings', [SettingsController::class, 'update']);

Router::post('/logout', [LogoutController::class, 'logout']);

Router::get('/create', [ArticleController::class, 'create']);
Router::post('/create', [ArticleController::class, 'store']);

Router::get('/edit', [ArticleController::class, 'edit']);
Router::post('/edit', [ArticleController::class, 'update']);

Router::get('/delete', [ArticleController::class, 'delete']);
