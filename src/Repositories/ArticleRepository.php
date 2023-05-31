<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/Article.php';

use src\Models\Article as Article;
use src\Models\User;

class ArticleRepository extends Repository {

	/**
	 * Given as an example.
	 *
	 * @return Article[]
	 */
	public function getAllArticles(): array {
		$sqlStatement = $this->pdo->query("SELECT * FROM articles;");
		$rows = $sqlStatement->fetchAll();

		$articles = [];
		foreach ($rows as $row) {
			$articles[] = new Article($row);
		}

		return $articles;
	}

	/**
	 * @param string $title
	 * @param string $url
	 * @param string $authorId
	 * @return Article|false
	 */
	public function saveArticle(string $title, string $url, string $authorId): Article|false {
		// TODO
	}

	/**
	 * @param int $id
	 * @return Article|false Article object if it was found, false otherwise
	 */
	public function getArticleById(int $id): Article|false {
		// TODO
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $url
	 * @return bool true on success, false otherwise
	 */
	public function updateArticle(int $id, string $title, string $url): bool {
		// TODO
	}

	/**
	 * @param int $id
	 * @return bool true on success, false otherwise
	 */
	public function deleteArticleById(int $id): bool {
		// TODO
	}

	/**
	 * Given as an example. No other joins should be needed.
	 *
	 * @param string $articleId
	 * @return User|false
	 */
	public function getArticleAuthor(string $articleId): User|false {
		$sqlStatement = $this->pdo->prepare("SELECT users.id, users.name, users.email, users.password_digest, users.profile_picture FROM users INNER JOIN articles a ON users.id = a.author_id WHERE a.id = ?;");
		$success = $sqlStatement->execute([$articleId]);
		if ($success && $sqlStatement->rowCount() !== 0) {
			return new User($sqlStatement->fetch());
		} else {
			return false;
		}
	}

}
