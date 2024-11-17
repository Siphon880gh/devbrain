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


echo "Shell user: " . $user . "<br/>";
echo "PHP __DIR: " . $dir . "<br/>";
echo "CWD:" . $pwd . "<br/><br/>";

echo "COMMAND cd, git fetch, git reset:" . $cdFetchAndResetCommand . "<br/>";
echo "OUTPUT cd, git fetch, git reset:" . $cdFetchAndResetCommandOutput . "<br/><br/>";

echo "COMMAND git origin:" . $gitOriginCommand . "<br/>";
echo "OUTPUT git origin:" . $gitOriginCommandOutput; "<br/><br/>";

echo "COMMAND NODE VERSION:" . $nodeVersionCommand; "<br/>";
echo "OUTPUT NODE VERSION:" . $nodeVersionCommandOutput; "<br/><br/>";

echo "COMMAND BUILD CACHED RENDERING:" . $rebuildCommand; "<br/>";
echo "OUTPUT BUILD CACHED RENDERING:" . $rebuildCommandOutput; "<br/><br/>";

echo "<br/><br/>";
echo "View: <a href='../'>View web notes</a><br/>";

// Server migration:
// Running shell command and it's permission denied? Get user and add it to the folder you're at
// [root@s97-74-232-20 curriculum]# sudo chown -R <process_user> ./
// [root@s97-74-232-20 curriculum]# sudo chmod -R 755 ./
// [root@s97-74-232-20 curriculum]# sudo find ./ -type f -exec chmod 644 {} \;

?>