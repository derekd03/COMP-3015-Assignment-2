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

function debug_to_console($data): void
{
    $output = $data;

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// display error message
function displayError(): void
{
    if (isset($_SESSION['error'])) {

        echo '<div class="text-red-500 mb-4" style="display: flex; justify-content: center; align-items: center;">';
        echo $_SESSION['error'];
        echo '</div>';
        unset($_SESSION['error']);
    }
}

function canEditOrDeleteArticle($articleId): bool {

    $articleRepository = new ArticleRepository();

    if(isAuthenticated() &&
        $articleRepository->getArticleById($articleId)->author_id == $_SESSION['user_id'])
    {
        return true;
    } else {
        return false;
    }
}