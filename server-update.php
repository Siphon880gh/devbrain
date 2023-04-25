<?php
/* Curriculum repository of snippets, guides, and dtutorials get pulled into this folder for the Gamified Knowledge app */
/* Curriculum is separated as another repository for authoring and contribution purposes over Github and Obsidian MD*/

$command = 'git fetch origin && git reset --hard refs/remotes/origin/main';
$output = shell_exec($command);
echo $output;

?>