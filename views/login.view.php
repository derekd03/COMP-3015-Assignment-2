<?php

use core\Request;
use src\Controllers\LoginController;
use src\Repositories\UserRepository;

include('header.php');
displayNav();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// display the article fields or error message if not submitted
echo '<body>';
echo '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
echo '<h2 class="text-xl text-center font-semibold text-indigo-700 mt-10 mb-10">Login</h2>';

displayError();

echo '<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg">';
echo '<form method="POST">';
echo '<div class="mb-4">';
echo '<label for="email" class="text-lg font-medium text-gray-700">Email:</label>';
echo '<br>';
echo '<input type="text" name="email" class="mt-2 p-2 border border-gray-500 rounded w-full" required>';
echo '</div>';
echo '<div class="mb-4">';
echo '<label for="password" class="text-lg font-medium text-gray-700">Password:</label>';
echo '<br>';
echo '<input type="password" name="password" class="mt-2 p-2 border border-gray-300 rounded w-full" required>';
echo '</div>';
echo '<input type="submit" value="Submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">';
echo '</form>';
echo '</div>';
echo '</body>';

