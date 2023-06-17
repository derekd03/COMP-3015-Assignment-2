<?php

use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

include('header.php');
displayNav();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$articleId = $articleId ?? '';

// display the article fields or error message if not submitted
echo '<body>';
echo '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
echo '<h2 class="text-xl text-center font-semibold text-indigo-700 mt-10 mb-10">Update Article</h2>';

displayError();

echo '<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg">';
echo '<form method="POST" action="edit">';
echo '<input type="hidden" name="id" value="' . intval($articleId) . '">';
echo '<div class="mb-4">';
echo '<label for="title" class="text-lg font-medium text-gray-700">Title:</label>';
echo '<br>';
echo '<input type="text" name="title" class="mt-2 p-2 border border-gray-500 rounded w-full">';
echo '</div>';
echo '<div class="mb-4">';
echo '<label for="url" class="text-lg font-medium text-gray-700">URL:</label>';
echo '<br>';
echo '<input type="text" name="url" class="mt-2 p-2 border border-gray-300 rounded w-full">';
echo '</div>';

// display error message if there is one
if (isset($error)) {
    echo "<p class='text-red-500'>{$error}</p>";
}

echo '<input type="submit" value="Update" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">';
echo '</form>';
echo '</div>';
echo '</body>';
