
Eg.
`php script.php arg1 arg2 arg3`

To run a PHP script with arguments in the terminal, you use the `php` command followed by the script's filename and any arguments you want to pass. Here's a basic example:

```bash
php script.php arg1 arg2 arg3
```

In this command:

- `php` is the PHP interpreter.
- `script.php` is the name of your PHP script.
- `arg1`, `arg2`, and `arg3` are the arguments you're passing to the script.

Within your PHP script (`script.php` in this example), you can access these arguments using the `$argv` array. Here's a simple script to illustrate:

```php
<?php
// script.php

// The first element of $argv is the script name itself, so we start from index 1.
foreach ($argv as $index => $argument) {
    echo "Argument $index: $argument\n";
}
```

When you run the PHP script with the provided arguments, you'll get output similar to:

```bash
Argument 0: script.php
Argument 1: arg1
Argument 2: arg2
Argument 3: arg3
```

In the script, `$argv` is an array that holds all command-line arguments, where the script name is at index 0, and subsequent arguments follow. The `foreach` loop iterates through these arguments, printing their index and value.

Keep in mind that these are positional arguments, and you might want to use a more sophisticated approach (e.g., getopt) for handling named options and values in more complex scenarios.