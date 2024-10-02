<?php
/* Curriculum repository of snippets, guides, and tutorials get pulled into this folder for the Gamified Knowledge app */
/* Curriculum is separated as another repository for authoring and contribution purposes over Github and Obsidian MD*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

$command1 = 'cd "' . __DIR__ . "'";
$command2 = 'git fetch origin; git reset --hard refs/remotes/origin/main';
$command = $command1 . $command2;
$output = shell_exec("$command 2>&1");
$exitCode = shell_exec('echo $?');

$command = "git remote get-url origin";
$output2 = shell_exec("$command 2>&1");

$processUser = posix_getpwuid(posix_geteuid());
$user = $processUser['name'];

$pwd = shell_exec("pwd");

echo "Executing user: " . $user . "<br/>";
echo "CWD:" . $pwd . "<br/>";
echo "COMMAND OUTPUT:" . $output . "<br/>";
echo "COMMAND OUTPUT:" . $output2 . "<br/>";
echo "EXIT CODE:" . $exitCode; "<br/>";

if ($output === null) {
    echo "Error executing the command.";
} else {
    echo "Command output:\n$output";
}

echo "<br/><br/>";
echo "View: <a href='../'>View web notes</a><br/>";

// Server migration:
// Running shell command and it's permission denied? Get user and add it to the folder you're at
// [root@s97-74-232-20 curriculum]# sudo chown -R <process_user> ./
// [root@s97-74-232-20 curriculum]# sudo chmod -R 755 ./
// [root@s97-74-232-20 curriculum]# sudo find ./ -type f -exec chmod 644 {} \;


?>