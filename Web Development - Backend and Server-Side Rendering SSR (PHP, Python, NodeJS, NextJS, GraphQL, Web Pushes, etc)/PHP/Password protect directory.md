
You have a folder people can go to download files. You would normally enable indexing with .htaccess
Or you could have an index.php that password protect its, then displays each file/folder link in a for loop:

```
<?php
$correct_password = 'YOUR_PASSWORD'; // Set the desired password
$passwordEntered = false;
$displayContents = false;

if (isset($_POST['password'])) {
    $passwordEntered = true;
    if ($_POST['password'] === $correct_password) {
        // Password is correct, set flag to display directory contents
        $displayContents = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Directory Viewer</title>
</head>
<body>
    <?php if (!$displayContents): ?>
        <!-- Show this form if the password is incorrect or not entered yet -->
        <form action="" method="post">
            Password: <input type="password" name="password">
            <input type="submit" value="Submit">
        </form>
        <p>Ask Weng for the password.</p>
        <?php if ($passwordEntered && !$displayContents): ?>
            <p>Incorrect password!</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($displayContents): ?>
        <!-- Display directory contents if the password is correct -->
        <h2>Directory contents:</h2>
        <ul>
            <?php
            $files = scandir('.');
            foreach ($files as $file) {
                if ($file != '.' && $file != '..' && $file != 'index.php') {
                    // Create a link for each file/directory, excluding index.php
                    echo "<li><a href='./$file'>$file</a></li>";
                }
            }
            ?>
        </ul>
    <?php endif; ?>
</body>
</html>

```