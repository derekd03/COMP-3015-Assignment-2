<?php

namespace src\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use core\Request as Request;
use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

class ArticleController extends Controller {

    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    /**
	 * Display the page showing the articles.
	 *
	 * @return void
	 */
    public function index(): void {

        // get all the articles to display on the landing page
        $articles = $this->articleRepository->getAllArticles();
        $this->render('index', ['articles' => $articles]);
    }


    /**
	 * Process the storing of a new article.
	 *
     * @param Request $request
	 * @return void
	 */
    public function create(Request $request): void {

        // if the user is authenticated, allow them to create an article
        if(isAuthenticated()) {
            $this->render('new_article');
        } else {
            header('Location: /login');
        }
    }


    /**
	 * Save an article to the database.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function store(Request $request): void {

        // upon a successful submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userRepository = new UserRepository();

            // retrieve the form data to create an article object
            $title = $_POST['title'];
            $url = $_POST['url'];
            $authorId = $_SESSION['user_id'];

            // validate the URL
            !isValidUrl($url) ? $error = 'Invalid URL': '';

            // validate the title
            empty($title) || empty($url) ? $error = 'Required fields are missing' : '';

            // if no error, save the article
            if (!isset($error)) {
                $articleRepository = new ArticleRepository();
                $articleRepository->saveArticle($title, $url, $authorId);

                // redirect the user to the article list page
                header('Location: /');
            } else {
                // store the error in the session
                $_SESSION['error'] = $error;
                header('Location: /create');
            }
            exit;
        }
	}

	/**
	 * Show the form for editing an article.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function edit(Request $request): void {

        $articleRepository = new ArticleRepository();

        // get the article id from query parameter
        $articleId = $request->input('id');

        if(isTheAuthorOf($articleId)) {
            // render the update view for the specific article
            $this->render('update_article', ['articleId' => $articleId]);
        }
        else {
            header('Location: /');
        }
	}

	/**
	 * Process the editing of an article.
	 *
	 * @param Request $request
	 * @return void
	 */
    public function update(Request $request): void {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // get articleId from query parameter
            $articleId = $request->input('id');

            // retrieve the updated title and URL from the form
            $title = $_POST['title'];
            $url = $_POST['url'];

            // validate the URL
            !isValidUrl($url) ? $error = 'Invalid URL': '';

            // if no error, save the article
            if (!isset($error)) {
                $articleRepository = new ArticleRepository();
                $articleRepository->updateArticle($articleId, $title, $url);

                // redirect the user to the article list page
                header('Location: /');
            } else {
                // store the error in the session
                $_SESSION['error'] = $error;
                header('Location: /create');
            }
            exit;
        }
    }


    /**
	 * Process the deleting of an article.
	 *
	 * @param Request $request
	 * @return void
	 */
    public function delete(Request $request): void {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            // get articleId from query parameter
            $articleId = $request->input('id');

            if(isTheAuthorOf($articleId)) {
                // delete the article specified by articleId
                $this->articleRepository->deleteArticleById($articleId);
            }
            header('Location: /');
            exit();
        }
    }


}