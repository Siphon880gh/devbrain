```toc
```

#### Runs in cli
  
Composer is typically installed globally on your system, and it is done using the Composer Installer, a command-line tool for installing Composer itself. You can find installation instructions on the official Composer website ([https://getcomposer.org/download/](https://getcomposer.org/download/)), and it usually involves running a command in your terminal or command prompt. Once installed globally, you can use Composer to manage dependencies in your PHP projects.

#### Built in PHP

Composer is primarily written in PHP. It's a dependency manager for PHP, and its codebase is designed to be compatible with PHP 5.3.2 and above. The Composer tool itself is a PHP application used for managing the dependencies of PHP projects

#### Why it can run as a command line

When you install Composer globally, it typically involves downloading the `composer.phar` (PHP Archive) file and then making it accessible system-wide by creating a symlink or alias.

Here are the general steps:

1. **Download `composer.phar`:** When you run the installation command, such as:

    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    ```

    Composer downloads the `composer.phar` file, which is the main executable.

2. **Create Symlink or Alias:** To make Composer globally accessible from the command line, it is common to create a symlink or alias. For example:

    - **Symlink (UNIX-based systems):**
        ```bash
        mv composer.phar /usr/local/bin/composer
        ```

    - **Alias (Windows):**
        ```bash
        move composer.phar C:\path\to\your\directory\composer.bat
        ```

    On Windows, the Composer executable is often named `composer.bat`.

3. **Adjusting System's PATH (Optional):** For some systems, you might need to ensure that the directory containing the symlink or alias is included in the system's `PATH` environment variable. This allows you to run `composer` from any directory in the command line.

The creation of a symlink or alias is what allows you to type `composer` in the terminal or command prompt, and the system knows to execute the `composer.phar` file. This way, Composer becomes a globally available command-line tool for managing PHP dependencies across your projects.

**So phar file type is executable**

#### Phar is a PHP unarchiving file type that has its own scripts and argument values...

Phar file type can also run scripts to help with file creations before ultimately unpacking files into your computer. Phar can take arguments, like the "composer" command can take arguments

---


#### Related: PHP is not just for websites

PHP can be a server sided script that may optionally render into HTML
- Web browser navigates to a .php file
- A php file imports in another php file for rendering or logic purposes
- AJAX connects to a php file that may optionally return a response (whatever is echoed, printed, etc), or only affects targets in the backend (eg. database, other server files)

Or  a command line executable as in the case of phar. You can also run php files as a script from command line though (helpful for php scripts that does file structure changes or database changes). PHP files can receive arguments, as does phar files. 
Eg.
`php script.php arg1 arg2 arg3`


---

ChatGPT Thread:
https://chat.openai.com/c/cd744418-e766-480d-bfc5-9f4b72a55c53