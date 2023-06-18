<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

use PDOException;
use src\Models\User;

class UserRepository extends Repository {

	/**
	 * @param string $id
	 * @return User|false
	 */
	public function getUserById(string $id): User|false {

        // if somehow no id was provided, return false
        if (empty($id)) {
            return false;
        }

        // from the MySQL database, select the specific user row matching the given id
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $sqlStatement->execute([$id]);
        $result = $sqlStatement->fetch();

        // return a new User object if successful
        return $result ? new User($result) : false;
	}

	/**
	 * @param string $email
	 * @return User|false
	 */
	public function getUserByEmail(string $email): User|false {

        // from the MySQL database, select the specific user row matching the given email
        $sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $sqlStatement->execute([$email]);
        $result = $sqlStatement->fetch();

        // return a new User object if successful
        return $result ? new User($result) : false;
	}

	/**
	 * @param string $passwordDigest
	 * @param string $email
	 * @param string $name
	 * @return User|false
	 */
	public function saveUser(string $name, string $email, string $passwordDigest, string $pfpURL): User|false {

        try {

            // into the MySQL database, insert a row with the given fields
            $sqlStatement = $this->pdo->prepare(
                'INSERT INTO users (name, email, password_digest, profile_picture) VALUES (?, ?, ?, ?)'
            );
            $sqlStatement->execute([$name, $email, $passwordDigest, $pfpURL]);

            // get the auto-incremented id so that a new user could be returned
            $id = $this->pdo->lastInsertId();

            // return a new User object if successful
            return $id ? new User([$id, $name, $email, $passwordDigest, $pfpURL]) : false;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            exit();
        }
	}

	/**
	 * @param int $id
	 * @param string $name
     * @param string $profile_picture
	 * @return bool
	 */
    public function updateUser(int $id, string $name = '', string $profile_picture = ''): bool
    {
        // if somehow no id was provided, return false
        if (empty($id)) {
            return false;
        }

        if (!empty($name) && !empty($profile_picture)) {
            // query to update both the name and the profile picture
            $sql = 'UPDATE users SET name = ?, profile_picture = ? WHERE id = ?';
            $executionArray = [$name, $profile_picture, $id];

        } else if (!empty($name)) {
            // query to update only the name
            $sql = 'UPDATE users SET name = ? WHERE id = ?';
            $executionArray = [$name, $id];

        } else if(!empty($profile_picture)) {
            //query to update only the profile picture
            $sql = 'UPDATE users SET profile_picture = ? WHERE id = ?';
            $executionArray = [$profile_picture, $id];
        } else {
            return false;
        }

        $sqlStatement = $this->pdo->prepare($sql);

        // boolean based on success of execution
        return $sqlStatement->execute($executionArray);
    }
}
