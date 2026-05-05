Recommended for Web Apps: Use .env + vlucas/phpdotenv

1. Install with Composer:
```
composer require vlucas/phpdotenv
```

2. Create .env file:
```
MY_VAR=hello
```

3. Load it in your PHP app:
```
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo $_ENV['MY_VAR'];
```
