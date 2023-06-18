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

        // from the MySQL database, select every row from table articles
        $sqlStatement = $this->pdo->query('SELECT * FROM articles;');
		$rows = $sqlStatement->fetchAll();

        // create an empty array of articles and populate it
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

        $id = 0;
        $createdAt = date('Y-m-d');
        $updatedAt = date('Y-m-d');

        // create a new article with the parameters given
        $article = new Article([$id, $title, $url, $createdAt, $updatedAt, $authorId]);

        // into the MySQL database, insert the new article
        $sqlStatement = $this->pdo->prepare(
            'INSERT INTO articles (id, title, url, created_at, updated_at, author_id ) VALUES (?, ?, ?, ?, ?, ?)');

        // if the insert was successful, return the article object
        if($sqlStatement->execute([$id, $title, $url, $createdAt, $updatedAt, $authorId]))
        {
            return $article;
        }
        return false;
	}

	/**
	 * @param int $id
	 * @return Article|false Article object if it was found, false otherwise
	 */
	public function getArticleById(int $id): Article|false {

        // create a new article with the parameters given
        $article = new Article();

        // into the MySQL database, insert the new article
        $sqlStatement = $this->pdo->prepare('SELECT author_id, title, url FROM articles WHERE id = ?');

        // if the insert was successful, return the article object
        $sqlStatement->bindParam(1, $id, \PDO::PARAM_INT);

        $sqlStatement->execute();
        $resultSet = $sqlStatement->fetch();
        return $resultSet === false ? false : new Article($resultSet);
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $url
	 * @return bool true on success, false otherwise
	 */
	public function updateArticle(int $id, string $title, string $url): bool {

        // update a specific article,
        // return the result if any rows were effected
        $sqlStatement = $this->pdo->prepare('UPDATE articles SET title = ?, url = ? WHERE id = ?');
        $sqlStatement->execute([$title, $url, $id]);
        return $sqlStatement->rowCount() > 0;
	}

	/**
	 * @param int $id
	 * @return bool true on success, false otherwise
	 */
	public function deleteArticleById(int $id): bool {

        // delete a specific article,
        // return the result if any rows were effected
        $sqlStatement = $this->pdo->prepare('DELETE FROM articles WHERE id = ?');
        $sqlStatement->execute([$id]);
        return $sqlStatement->rowCount() > 0;
	}

	/**
	 * Given as an example. No other joins should be needed.
	 *
	 * @param string $articleId
	 * @return User|false
	 */
	public function getArticleAuthor(string $articleId): User|false {
		$sqlStatement = $this->pdo->prepare(
            'SELECT users.id, users.name, users.email, users.password_digest, users.profile_picture
                   FROM users INNER JOIN articles a ON users.id = a.author_id WHERE a.id = ?;');
		$success = $sqlStatement->execute([$articleId]);
		if ($success && $sqlStatement->rowCount() !== 0) {
			return new User($sqlStatement->fetch());
		} else {
			return false;
		}
	}

}
