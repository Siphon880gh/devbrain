
You can install all the packages with `composer install` but make sure to remove or at least rename composer.lock as a backup first, otherwise it'll complain it's been locked.

Purpose of composer.lock is to have dependencies of the dependencies specific to the OS you're installing on.