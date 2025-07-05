
Non-root Superuser: A non-root superuser is a regular user who has been granted administrative privileges. This user can perform administrative tasks by prefixing commands with sudo because they’ve been added to the sudo group.

### Non-root user exists

To add a user to the sudo group (granting them non-root superuser privileges), you would typically use the following command:
```
sudo usermod -aG sudo USERNAME
```

Verify the group added successfully
```
id USERNAME
```


### Non-root user doesn’t exist

Verify the user exists:
```
cat /etc/passwd | grep USERNAME
```

If you haven’t created the user yet, create the user, THEN add them to the sudo group.
```
adduser USERNAME
```

