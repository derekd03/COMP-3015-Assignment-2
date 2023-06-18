<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('header.php');
displayNav();

?>

<body>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<h2 class="text-xl text-center font-semibold text-indigo-700 mt-10 mb-10">Register</h2>
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg">
    <?php displayError(); ?>
    <form method="post">
        <div class="mb-4">
            <label for="email" class="text-lg font-medium text-gray-700">Email:</label>
            <br>
            <input type="text" name="email" class="mt-2 p-2 border border-gray-500 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="name" class="text-lg font-medium text-gray-700">Name:</label>
            <br>
            <input type="text" name="name" class="mt-2 p-2 border border-gray-500 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="password" class="text-lg font-medium text-gray-700">Create Password:</label>
            <br>
            <input type="password" name="password" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="repeatPassword" class="text-lg font-medium text-gray-700">Repeat Password:</label>
            <br>
            <input type="password" name="repeatPassword" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
        </div>
        <input type="submit" value="Submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
    </form>
</div>
</body>
