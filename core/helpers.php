<?php

use src\Repositories\ArticleRepository;

function image(string $filename): string {
	return "/images/$filename";
}

// checks if a session is logged in
function isAuthenticated(): bool {

    if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        return false;
    }
    return true;
}

// display appropriate nav for (in)authenticated users
function displayNav(): void {

    if(isAuthenticated()) {
        include(__DIR__ . '/../views/logged_in_nav.php');
    }
    else {
        include(__DIR__ . '/../views/nav.php');
    }
}

// checks if a URL is valid
function isValidUrl($url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// display error message
function displayError(): void {

    if (isset($_SESSION['error'])) {

        echo '<div class="text-red-500 mb-4" style="display: flex; justify-content: center; align-items: center;">';
        echo $_SESSION['error'];
        echo '</div>';
        unset($_SESSION['error']);
    }
}

// checks if a user is the author of a specific article
function isTheAuthorOf($articleId): bool {

    $articleRepository = new ArticleRepository();

    // checks if the user's session is set and the session id matches that of the
    // article's author id
    if(isAuthenticated() &&
        $articleRepository->getArticleById($articleId)->author_id == $_SESSION['user_id'])
    {
        return true;
    } else {
        return false;
    }
}

// checks if an image url is valid
function isValidImage($url): bool {

    $imageInfo = @getimagesize($url);
    return $imageInfo !== false;
}

// check if password is valid/strong
function isValidPassword($password): bool {

    // has at least one uppercase, lettercase, number, and a special character each
    // and is minimum 8 characters
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}