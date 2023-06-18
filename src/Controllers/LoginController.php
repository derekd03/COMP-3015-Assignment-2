<?php

namespace src\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use core\Request as Request;
use JetBrains\PhpStorm\NoReturn;
use src\Models\User;
use src\Repositories\UserRepository as UserRepository;

class LoginController extends Controller {

	/**
	 * Show the login page.
	 * @return void
	 */
	public function index(): void {
		$this->render('login');
	}

	/**
	 * Process the login attempt.
	 * @param Request $request
	 * @return void
	 */
	#[NoReturn] public function login(Request $request): void {

        $userRepository = new UserRepository();

        // get the email and plaintext_password entered
        $email = trim($_POST['email']);
        $plaintext_password = $_POST['password'];

        // error array
        $error = '';

        // create a user instance
        $user = new User;

        // check if the user exists in the database by email
        if($userRepository->getUserByEmail($email)) {

            // get the hash password
            $hash = $user->password_digest;

            // detect if a user's plaintext_password is incorrect
            !(password_verify($plaintext_password, $hash)) ? $error = 'Password is incorrect': '';
        } else {
            $error = 'User not found';
        }

        (!filter_var($email, FILTER_VALIDATE_EMAIL) ? $error = 'Invalid email format' : '');

        if(empty($error)) {

            // successful login
            // redirect to the home/landing page
            $_SESSION['user_id'] = $user->id;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user->name;
            $_SESSION['pfpURL'] = $user->profile_picture;
            $_SESSION['authenticated'] = true;

            header('Location: /');
        } else {

            // unsuccessful login
            // store the error in the session and redirect back to login page
            $_SESSION['error'] = $error;
            header('Location: /login');
        }
        exit;
    }

}
