<?php

namespace src\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use core\Request;
use JetBrains\PhpStorm\NoReturn;
use PDOException;
use src\Repositories\UserRepository  as UserRepository;
use src\Controllers\Controller as Controller;

class RegistrationController extends Controller {

    /**
     * @return void
     */
    public function index(): void {
        $this->render('register');
    }

    /**
     * @param Request $request
     * @return void
     */
    #[NoReturn] public function register(Request $request): void {

        $userRepository = new UserRepository();

        $error = '';

        // get entered fields from post array
        $email = $_POST['email'] ?? '';
        $name = $_POST['name'] ?? '';
        $plaintext_password = $_POST['password'] ?? '';
        $plaintext_repeatPassword = $_POST['repeatPassword'] ?? '';

        // if plaintext_password is invalid
        !(isValidPassword($plaintext_password)) ? $error =
            'Password must have a lowercase letter, 
            an uppercase letter, a number, a special character, 
            and be at least 8 characters': '';

        // if plaintext_password does not match repeated plaintext_password
        !($plaintext_password === $plaintext_repeatPassword) ? $error = 'Passwords do not match' : '';

        // if an email already exists in the database
        ($userRepository->getUserByEmail($email)) ? $error = 'Email already exists' : '';

        // clear the post error
        $_POST = [];

        $pfp = 'default.jpg';

        if (empty($error)) {

            // encrypt the user's plaintext_password
            $hash = password_hash($plaintext_password, PASSWORD_BCRYPT);

            // save user to the database
            $userRepository->saveUser(
                $name,
                $email,
                $hash,
                $pfp
            );

            // log the user in
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['authenticated'] = true;

            $user = $userRepository->getUserByEmail($email);

            // store the created user's id in the session
            $_SESSION['user_id'] = $user->id;

            // url to be displayed in the logged in navigation bar
            $_SESSION['pfp'] = $pfp;

            // redirect to homepage
            header('Location: /');

        } else {
            // store the error in the session
            $_SESSION['error'] = $error;
            // retry registry
            header('Location: /register');
        }
        exit();
    }
}
