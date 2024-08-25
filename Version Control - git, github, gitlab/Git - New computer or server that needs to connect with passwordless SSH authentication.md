
Git has disabled password authentication and requires passwordless ssh authentication on all connections (like remote host to git push/pull or local computer git push/pull)

1. At your new host, if it's remote, check the user you're logged in as. Because if you are logged in as root, then git command checks /root/.ssh/config for the server name github and ssh key (aka IdentityFile). Otherwise if a non-root user, it'll check /home/USER/.ssh/config for the server name github and ssh ake (aka IdentityFile). To switch from root to a non-root user: `su - USER`
   
2. you will create a new SSH pair by running `ssh-keygen`. Then copy the contents of ~/.ssh/id_rsa.pub (or whichever algorithm or filename). Copy that content as an Authentication key in Github SSH keys.

3. You may need ~/.ssh/config (Adjust IdentityFile to the private key if not the default):
```
Host github.com
    User git
    HostName github.com
    IdentityFile ~/.ssh/id_rsa
    IdentitiesOnly yes
```
^You're keeping the User as "git"

Note if you're using a non-standard port, you can also specify that in the SSH config:
`Port 2222`

3. Assure the Permissions of Your SSH Private Key:
```
chmod 600 ~/.ssh/id_rsa
```


4. Ensure the SSH Key Is Loaded

Make sure SSH agent is started with:
```
eval "$(ssh-agent -s)"
```

Make sure the SSH key is loaded into the SSH agent
```
ssh-add ~/.ssh/id_rsa
```

5. Ensure Your Remote URL Uses SSH

Check that your Git remote URL is using the SSH format, not the HTTPS format. Run:
```
git remote -v
```

If you see URLs starting with `https://`, you need to change them to the SSH format. Copy it from your github repo page. Looks similar to:
```
git remote set-url origin git@github.com:your-username/your-repository.git
```

Now try git pulling