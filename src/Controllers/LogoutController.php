<?php

namespace src\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');

class LogoutController extends Controller {

	/**
	 * @return void
	 */
	public function logout(): void {

        // destroy the session
        session_destroy();
        // redirect to login
        header("Location: /login");
	}

}