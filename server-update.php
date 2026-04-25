<?php
/* Curriculum repository of snippets, guides, and tutorials get pulled into this folder for the Brain Notes app (Like Notebook) */
/* Curriculum is separated as another repository for authoring and contribution purposes over Github and Obsidian MD */

/* Migration sensitive */
$npmBuildScript = "build-devbrain";

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Run a shell command and capture stdout, stderr, and the exit code reliably.
 * shell_exec() drops the exit code, and `echo $?` in a separate shell_exec()
 * always returns 0 because it runs in a fresh shell. Use exec() instead.
 *
 * IMPORTANT: shell redirections (2>&1) bind to a single command, so for chains
 * like "cmd1 && cmd2 && cmd3" we wrap the whole thing in a subshell so that
 * stderr from EVERY command in the chain is captured, not just the last one.
 */
function runCommand($command, $envPrefix = '') {
    $output = [];
    $exitCode = -1;
    $wrapped = ($envPrefix !== '' ? $envPrefix . ' ' : '') . '( ' . $command . ' ) 2>&1';
    exec($wrapped, $output, $exitCode);
    return [
        'command'  => $command,
        'output'   => implode("\n", $output),
        'exitCode' => $exitCode,
    ];
}

function renderStep($label, $result) {
    $ok = ($result['exitCode'] === 0);
    $statusColor = $ok ? '#1b7a3f' : '#b00020';
    $statusText  = $ok ? 'OK (exit 0)' : 'FAILED (exit ' . htmlspecialchars((string)$result['exitCode']) . ')';
    $outputText  = trim($result['output']) === '' ? '(no output)' : $result['output'];

    echo '<section style="margin: 0 0 22px 0; padding: 12px 14px; border-left: 4px solid ' . $statusColor . '; background: #fafafa;">';
    echo '<div style="font-weight: 700; font-size: 15px; margin-bottom: 6px;">' . htmlspecialchars($label) . '</div>';
    echo '<div style="margin-bottom: 6px;"><b>Status:</b> <span style="color:' . $statusColor . '; font-weight:600;">' . $statusText . '</span></div>';
    echo '<div style="margin-bottom: 6px;"><b>Command:</b> <code>' . htmlspecialchars($result['command']) . '</code></div>';
    echo '<div><b>Output:</b></div>';
    echo '<pre style="background:#111; color:#eee; padding:10px 12px; border-radius:4px; white-space:pre-wrap; word-break:break-word; margin:6px 0 0 0; font-size:12.5px; line-height:1.45;">' . htmlspecialchars($outputText) . '</pre>';
    echo '</section>';
}

$processUser = posix_getpwuid(posix_geteuid());
$user     = $processUser['name'];
$userHome = $processUser['dir'];
$dir  = __DIR__;
$pwd  = trim((string)shell_exec('pwd'));

/*
 * PHP-FPM strips most env vars, so git can't find ~/.gitconfig or ~/.ssh/
 * unless we explicitly set HOME. GIT_TERMINAL_PROMPT=0 and BatchMode=yes
 * make sure git fails fast instead of hanging on a credential prompt.
 *
 * Note: we use $HOME (with explicit env var) instead of ~ in commands below
 * because tilde expansion is unreliable in PHP-invoked shells — tilde inside
 * quotes does NOT expand, and even unquoted it can fail when HOME is unset.
 */
$gitEnvPrefix = 'HOME=' . escapeshellarg($userHome)
              . ' GIT_TERMINAL_PROMPT=0'
              . ' GIT_SSH_COMMAND=' . escapeshellarg('ssh -o BatchMode=yes -o StrictHostKeyChecking=accept-new');

$cdCommand            = 'cd ' . escapeshellarg($dir);
$fetchAndResetCommand = 'git fetch --verbose origin && git reset --hard refs/remotes/origin/main';
$gitOriginCommand     = $cdCommand . ' && git remote get-url origin';
$gitStatusCommand     = $cdCommand . ' && git status --short --branch';
$gitHeadCommand       = $cdCommand . ' && git log -1 --pretty=format:"%h %s (%an, %ar)"';
$nodeVersionCommand   = 'node -v';
$rebuildCommand       = $cdCommand . ' && cd .. && npm run ' . escapeshellarg($npmBuildScript);

$diagnosticsCommand = $cdCommand
    . ' && echo "--- whoami ---" && whoami'
    . ' && echo "--- env: HOME, PATH, USER ---" && echo "HOME=$HOME" && echo "PATH=$PATH" && echo "USER=$USER"'
    . ' && echo "--- ls -la \"$HOME\" (top-level) ---" && (ls -la "$HOME" 2>&1 || true)'
    . ' && echo "--- ls -la \"$HOME/.ssh\" (may not exist) ---" && (ls -la "$HOME/.ssh" 2>&1 || true)'
    . ' && echo "--- known_hosts present? ---" && (test -f "$HOME/.ssh/known_hosts" && echo "yes ($HOME/.ssh/known_hosts)" || echo "no")'
    . ' && echo "--- /etc/ssh/ssh_known_hosts present? ---" && (test -f /etc/ssh/ssh_known_hosts && echo "yes" || echo "no")'
    . ' && echo "--- git config --global --list ---" && (git config --global --list 2>&1 || true)'
    . ' && echo "--- git remote -v ---" && git remote -v'
    . ' && echo "--- .git ownership ---" && ls -ld .git'
    . ' && echo "--- git version ---" && git --version'
    . ' && echo "--- ssh -V ---" && ssh -V 2>&1'
    . ' && echo "--- ssh -T git@github.com (auth probe, expects exit 1 on success) ---" && (ssh -o BatchMode=yes -o StrictHostKeyChecking=accept-new -T git@github.com 2>&1 || true)';

$diagnosticsResult = runCommand($diagnosticsCommand, $gitEnvPrefix);
$gitOriginResult   = runCommand($gitOriginCommand,   $gitEnvPrefix);
$fetchResetResult  = runCommand($cdCommand . ' && ' . $fetchAndResetCommand, $gitEnvPrefix);
$gitStatusResult   = runCommand($gitStatusCommand,   $gitEnvPrefix);
$gitHeadResult     = runCommand($gitHeadCommand,     $gitEnvPrefix);
$nodeVersionResult = runCommand($nodeVersionCommand);
$rebuildResult     = runCommand($rebuildCommand);

$allOk = $gitOriginResult['exitCode'] === 0
      && $fetchResetResult['exitCode'] === 0
      && $nodeVersionResult['exitCode'] === 0
      && $rebuildResult['exitCode'] === 0;

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Updating notes online</title>
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; max-width: 980px; margin: 24px auto; padding: 0 18px; color: #222; line-height: 1.5; }
  h1 { margin: 0 0 8px 0; }
  .intro { color: #555; margin-bottom: 18px; }
  .env { background:#f0f4f8; border-radius:6px; padding:12px 14px; margin-bottom: 22px; font-size: 13.5px; }
  .env div { margin: 2px 0; }
  .banner { padding: 10px 14px; border-radius: 6px; font-weight: 600; margin-bottom: 18px; }
  .banner.ok   { background:#e6f4ec; color:#1b7a3f; border:1px solid #b7dcc4; }
  .banner.fail { background:#fdecef; color:#b00020; border:1px solid #f5b8c1; }
  code { background:#eef1f4; padding: 1px 5px; border-radius: 3px; font-size: 12.5px; }
  a { color: #0a66c2; }
</style>
</head>
<body>

<h1>Updating notes online</h1>
<p class="intro">
  From Obsidian MD, you ran the npm deploy script which committed and pushed local curriculum changes
  to Github/Gitlab, then the npm script opened this online PHP script in the web browser.
  This script is part of the online curriculum repo and pulls curriculum updates from Github/Gitlab
  into the remote server, then <code>cd</code>s out into the note-reading app to rebuild the cached
  render for the online audience by running NodeJS scripts that build the PHP partial.
</p>

<div class="banner <?= $allOk ? 'ok' : 'fail' ?>">
  <?= $allOk ? 'All steps completed successfully.' : 'One or more steps FAILED — see red-bordered sections below.' ?>
</div>

<div class="env">
  <div><b>Shell user:</b> <?= htmlspecialchars($user) ?></div>
  <div><b>PHP __DIR__:</b> <?= htmlspecialchars($dir) ?></div>
  <div><b>CWD (pwd):</b> <?= htmlspecialchars($pwd) ?></div>
</div>

<?php
renderStep('0. Environment diagnostics (whoami, HOME, .ssh, known_hosts, git config, ssh probe)', $diagnosticsResult);
renderStep('1. Git remote origin URL', $gitOriginResult);
renderStep('2. Git fetch + hard reset to origin/main', $fetchResetResult);
renderStep('3. Git status (post-reset)', $gitStatusResult);
renderStep('4. Git HEAD commit (post-reset)', $gitHeadResult);
renderStep('5. Node version', $nodeVersionResult);
renderStep('6. Build cached rendering (npm run ' . $npmBuildScript . ')', $rebuildResult);
?>

<p style="margin-top: 28px;"><b>View:</b> <a href="../">View web notes</a></p>

</body>
</html>

<?php
// Server migration:
// Running shell command and it's permission denied? Get user and add it to the folder you're at
// [root@s97-74-232-20 curriculum]# sudo chown -R <process_user> ./
// [root@s97-74-232-20 curriculum]# sudo chmod -R 755 ./
// [root@s97-74-232-20 curriculum]# sudo find ./ -type f -exec chmod 644 {} \;
?>