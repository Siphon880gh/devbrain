
Create a test.php from a webhost panel's File Manager or Filezilla (make sure Filezilla is not logged in as root, but is logged in as the default first account of that webhosted document root)

Can be test_ug.php:
```
<?php

// Fetch all users from /etc/passwd
$users = shell_exec('cat /etc/passwd | cut -d: -f1');
echo "Server All Users:<br/>";
echo "------------------<br/>";
echo $users . "<br/>";

echo "<br/>";

// Fetch all groups from /etc/group
$groups = shell_exec('cat /etc/group | cut -d: -f1');
echo "Server All Groups:<br/>";
echo "------------------<br/>";
echo $groups . "<br/>";


echo "<br/>";


echo "User and group information of the file and the permissions of the file test.php<br/>";
echo "------------------------------------------------------------------------------------------------------------------<br/>";
$command = sprintf('stat -c "%%U %%G %%a" %s', escapeshellarg(__FILE__));
$stat = shell_exec($command);
echo $stat . "<br/>";

echo "<br/>";


echo "User and group information of the process executing the PHP script<br/>";
echo "------------------------------------------------------------------------------------------------------------------<br/>";
// Get the user information
$userInfo = posix_getpwuid(posix_geteuid());
echo "Current User: " . $userInfo['name'] . "<br>";

// Get the group information
$groupInfo = posix_getgrgid(posix_getegid());
echo "Current Group: " . $groupInfo['name'] . "<br>";


?>
```


Visiting this page on the web browser will tell you who, what group, etc so you can modify accordingly in root.

Remember if a file belongs to root, it can't be displayed in the web browser because the process that shows webpage is not at root level security clearance

Logged in as root in SSH, you can change toe user and group of the file such that it's the same user and group of the PHP instance:
```
sudo chown -R USER:GROUP FOLDER
```