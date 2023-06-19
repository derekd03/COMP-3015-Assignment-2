<?php
function active($page): bool {
    $pageFromUri = explode('/', $_SERVER['SCRIPT_NAME']);
    return $page === end($pageFromUri);
}

$user = (new \src\Repositories\UserRepository)->getUserById($_SESSION['user_id']);

?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<nav class="navbar bg-gray-800">
    <div class="mx-auto container px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">

            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <img src="<?= image($user?->profile_picture) ?>" alt="" class="inline-block h-5 w-5 rounded-full ring-2 ring-white cover">
                        <?php echo '<span style="color: white;">'.$_SESSION['name'].':'.'</span>'?>
                        <a class="
                            <?php
                        echo active('login.view.php') ?
                            'btn btn-primary hover:bg-opacity-75 hover:text-opacity-75 text-white' :
                            'btn btn-secondary hover:bg-opacity-75 hover:text-opacity-75 text-white'
                        ?>"
                           href="#" onclick="function logout() {

                               // creates a form so a post method can be used
                               // to log the user out with the click of an anchor link
                               const form = document.createElement('form');
                               form.method = 'post';
                               form.action = '/logout';

                               document.body.appendChild(form);
                               form.submit();
                           }
                           logout()">Logout</a>
                        <a class="
                            <?php
                        echo active('settings.view.php') ?
                            'btn btn-primary hover:bg-opacity-75 hover:text-opacity-75 text-white' :
                            'btn btn-secondary hover:bg-opacity-75 hover:text-opacity-75 text-white'
                        ?>"
                           href="/settings">Settings</a>
                        <a class="
                            <?php
                        echo active('index.view.php') ?
                            'btn btn-primary hover:bg-opacity-75 hover:text-opacity-75 text-white' :
                            'btn btn-secondary hover:bg-opacity-75 hover:text-opacity-75 text-white'
                        ?>"
                           href="/">Home</a>
                        <a class="
                            <?php
                        echo active('new_article.view.php') ?
                            'btn btn-primary hover:bg-opacity-75 hover:text-opacity-75 text-white' :
                            'btn btn-secondary hover:bg-opacity-75 hover:text-opacity-75 text-white'
                        ?>"
                           href="/create">New Article</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>
