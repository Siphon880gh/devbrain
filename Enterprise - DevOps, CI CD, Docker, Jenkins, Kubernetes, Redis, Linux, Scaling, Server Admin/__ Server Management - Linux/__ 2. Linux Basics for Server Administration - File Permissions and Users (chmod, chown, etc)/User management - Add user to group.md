To add a user to a group in Unix/Linux systems, you can use the `usermod` command. For example, to add a user named `username` to a group named `groupname`, you can use the following command:

```
sudo usermod -aG groupname username
```

- `-aG`: This option adds the user to the supplementary group(s). Without `-a`, the user is removed from any other groups not listed.