<?php
/* Curriculum repository of snippets, guides, and tutorials get pulled into this folder for the Brain Notes app (Like Notebook) */
/* Curriculum is separated as another repository for authoring and contribution purposes over Github and Obsidian MD */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$processUser = posix_getpwuid(posix_geteuid());
$user = $processUser['name'];
$dir = __DIR__;
$pwd = shell_exec("pwd");

$cdCommand = 'cd "' . $dir . '"';
$fetchAndResetCommand = 'git fetch origin; git reset --hard refs/remotes/origin/main';
$cdFetchAndResetCommand = $cdCommand . " && " . $fetchAndResetCommand;
$cdFetchAndResetCommandExec = shell_exec("$cdFetchAndResetCommand 2>&1");
$cdFetchAndResetCommandOutput = shell_exec('echo $?');

$gitOriginCommand = "git remote get-url origin";
$gitOriginCommandExec = shell_exec("$gitOriginCommand 2>&1");
$gitOriginCommandOutput = shell_exec('echo $?');

$nodeVersionCommand = "node -v";
$nodeVersionCommandExec = shell_exec("$nodeVersionCommand 2>&1");
$nodeVersionCommandOutput = shell_exec('echo $?');

$rebuildCommand = "cd .. && npm run build-devbrain";
$rebuildCommandExec = shell_exec("$rebuildCommand 2>&1");
$rebuildCommandOutput = shell_exec('echo $?');


echo "<b>Shell user:</b> " . $user . "<br/>";
echo "<b>PHP __DIR:</b> " . $dir . "<br/>";
echo "<b>CWD:</b> " . $pwd . "<br/><br/>";

echo "<b>COMMAND cd, git fetch, git reset:</b> " . $cdFetchAndResetCommand . "<br/>";
echo "<b>OUTPUT cd, git fetch, git reset:</b> " . $cdFetchAndResetCommandOutput . "<br/><br/>";

echo "<b>COMMAND git origin:</b> " . $gitOriginCommand . "<br/>";
echo "<b>OUTPUT git origin:</b> " . $gitOriginCommandOutput; "<br/><br/>";

echo "<b>COMMAND NODE VERSION:</b> " . $nodeVersionCommand; "<br/>";
echo "<b>OUTPUT NODE VERSION:</b> " . $nodeVersionCommandOutput; "<br/><br/>";

echo "<b>COMMAND BUILD CACHED RENDERING:</b> " . $rebuildCommand; "<br/>";
echo "<b>OUTPUT BUILD CACHED RENDERING:</b> " . $rebuildCommandOutput; "<br/><br/>";

echo "<br/><br/>";
echo "<b>View:</b> <a href='../'>View web notes</a><br/>";

// Server migration:
// Running shell command and it's permission denied? Get user and add it to the folder you're at
// [root@s97-74-232-20 curriculum]# sudo chown -R <process_user> ./
// [root@s97-74-232-20 curriculum]# sudo chmod -R 755 ./
// [root@s97-74-232-20 curriculum]# sudo find ./ -type f -exec chmod 644 {} \;

?>