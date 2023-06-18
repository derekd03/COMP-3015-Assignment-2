<?php

namespace src\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');

use core\Request;
use JetBrains\PhpStorm\NoReturn;
use src\Repositories\UserRepository;

class SettingsController extends Controller {

	/**
	 * Render the settings page.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function index(Request $request): void {

        if(isAuthenticated())
        {
            $this->render('settings');
        }
	}

	/**
	 * Process the request to update user data.
	 *
	 * @param Request $request
	 * @return void
	 */
    #[NoReturn] public function update(Request $request): void
    {
        $userRepository = new UserRepository();

        $error = '';

        // Get entered fields from request parameters
        $name = $request->input('name', '');
        $pfp = $request->input('pfp', '');

        $originalFileName = '';

        if(!empty($pfp)) {

            // define the file
            $file = $_FILES[$pfp];
            // get the temporary file location
            $tempPath = $file['tmp_name'];
            // get the pfp file name
            $originalFileName = $file['name'];
            // move file from the temporary to destination location
            move_uploaded_file($tempPath, __DIR__."public/images/$originalFileName");
            // check if the pfp url entered is a valid image
            isValidImage(__DIR__."public/images/$originalFileName") ? $error = 'File is not a valid image': '';
        }

        if (empty($error)) {

            // Update the user in the database

            if($userRepository->updateUser($_SESSION['user_id'], $name, $originalFileName)) {
                $_SESSION['name'] = $name;
                $_SESSION['pfp'] = $originalFileName;
            }

        } else {
            // Store the error in the session
            $_SESSION['error'] = $error;
        }

        // Redirect to settings page on either success or failure
        header('Location: /settings');
        exit();
    }

}
