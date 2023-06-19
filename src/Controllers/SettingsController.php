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
        else
        {
            header('Location: /login');
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

        // get entered fields from request parameters
        $name = $request->input('name', '');
        $pfp = $_FILES['pfp'];

        // if no new name and pfp were entered, just do nothing
        if(empty($name) && $pfp['error'] === UPLOAD_ERR_NO_FILE) {
            header('Location: /settings');
            exit();
        }

        // store the current user's pfp as a placeholder
        $originalFileName = $userRepository->getUserByEmail($_SESSION['email'])->profile_picture;

        if($pfp['error'] !== UPLOAD_ERR_NO_FILE) {

            // get the temporary pfp location
            $temporaryPath = $pfp['tmp_name'];

            if (!isValidImage($temporaryPath)) {
                $error = 'File is not a valid image';
            } else {
                // get the pfp name
                $originalFileName = $pfp['name'];
                // move the pfp from the temporary to the destination location
                $destinationPath = realpath('images') . DIRECTORY_SEPARATOR . $originalFileName;
                move_uploaded_file($temporaryPath, $destinationPath);
            }
        }

        if (empty($error)) {

            // update the user in the database
            if($userRepository->updateUser($_SESSION['user_id'], $name, $originalFileName)) {
                $_SESSION['name'] = $name;
                $_SESSION['pfp'] = $originalFileName;
            }

        } else {
            // store the error in the session
            $_SESSION['error'] = $error;
        }

        // redirect to settings page on either success or failure
        header('Location: /settings');
        exit();
    }

}
