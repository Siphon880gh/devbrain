<?php
/* Curriculum repository of snippets, guides, and tutorials get pulled into this folder for the Brain Notes app (Like Notebook) */
/* Curriculum is separated as another repository for authoring and contribution purposes over Github and Obsidian MD */

/* Migration sensitive */
$npmBuildScript = "build-devbrain";

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

$rebuildCommand = "cd .. && npm run $npmBuildScript";
$rebuildCommandExec = shell_exec("$rebuildCommand 2>&1");
$rebuildCommandOutput = shell_exec('echo $?');

echo "<h1>Updating notes online</h1>";
echo "<p>From Obsidian MD, you ran the npm deploy script which committed and pushed local curriculum changes to Github/Gitlab, then the npm script opened the online PHP script in the web browser. That online PHP script is part of the online curriculum repo and is pulling in curriculum updates from Github/Gitlab into the remote server, then the PHP script cd out into the note-reading app to rebuild the cached render for the online audience by running NodeJS scripts that build the PHP partial.</p><p></p>"
;
echo "<b>Shell user:</b> " . $user . "<p></p>";
echo "<b>PHP __DIR:</b> " . $dir . "<p></p>";
echo "<b>CWD:</b> " . $pwd . "<p></p><p></p>";

echo "<b>COMMAND cd, git fetch, git reset:</b> " . $cdFetchAndResetCommand . "<p></p>";
echo "<b>OUTPUT cd, git fetch, git reset:</b> " . $cdFetchAndResetCommandOutput . "<p></p><p></p>";

echo "<b>COMMAND git origin:</b> " . $gitOriginCommand . "<p></p>";
echo "<b>OUTPUT git origin:</b> " . $gitOriginCommandOutput; "<p></p><p></p>";

echo "<b>COMMAND NODE VERSION:</b> " . $nodeVersionCommand; "<p></p>";
echo "<b>OUTPUT NODE VERSION:</b> " . $nodeVersionCommandOutput; "<p></p><p></p>";

echo "<b>COMMAND BUILD CACHED RENDERING:</b> " . $rebuildCommand; "<p></p>";
echo "<b>OUTPUT BUILD CACHED RENDERING:</b> " . $rebuildCommandOutput; "<p></p><p></p>";

echo "<p></p><p></p>";
echo "<b>View:</b> <a href='../'>View web notes</a><p></p>";

// Server migration:
// Running shell command and it's permission denied? Get user and add it to the folder you're at
// [root@s97-74-232-20 curriculum]# sudo chown -R <process_user> ./
// [root@s97-74-232-20 curriculum]# sudo chmod -R 755 ./
// [root@s97-74-232-20 curriculum]# sudo find ./ -type f -exec chmod 644 {} \;

?>