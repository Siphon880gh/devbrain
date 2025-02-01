TLDR:
- Authentication with keys involves 2 things: generating a key pair (eg ssh-keygen), and then _sending the public key to the party to which you want to authenticate_. Did you provide git server with the public key of the user or root or both?
- The private key stays with your computer that requires authentication

I. Concepts

SSH keys is how one machine can allow another machine access. Remember when we connect to a server, that server is also a computer like ours, so SSH keys deal more with how one machine allows another machine access to it.

WIth SSH keys, we can disable the need to enter password. The best practice now is to disable password authentication and have the server our computer connecting to let us in as long as the SSH key files are on our computer. No need to enter passwords. And we cannot be hacked by password bruting.

How this works?
First we disable password authentication. Then we generate a private and public key file pair using the command ssh-keygen, for example id_rsa and id_rsa.pub. At the remote server, we edit .ssh/authorized_keys by adding the public key contents into that file (authorized_keys is a file). At the local machine, we connect to SSH by specifying the private key in the command. The SSH will then look at the same folder where the private key file is, and see if the private and  public key files there are a pair, and this would prove this is the machine that should have access. You see, the private key file's permissions is such that it can't be moved out of that folder or computer without being the user that owns it. So this proves the machine is the right user. As a consequence, SSH also checks the chmod of the private and public files.

* It usually does not matter where you use ssh-keygen to generate the private and public key file because you would have SSH installed on your machine and the server and they use the same algorithm to generate the private public SSH pair. 
    - But if you generate it on the remote server's terminal, then you need to download the files back to your computer - requiring extra steps. Remember that the local machine should house both private and public SSH files. The remote server has a string of the public file in authorized_keys, so you would still need to append it there (for example, `id_rsa.pub >> ./.ssh/authorized_keys`). Why is it okay to have public key info exposed like that? Well, a hacker can sniff your SSH connection  and still get your public key, but they don't have the private key file information that is on your computer because that's never sent on a connection. That's why the SSH first checks the private key to the public key on your machine before doing any online connections. When it connects to the remote server, your machine sends the public file info only. Finally, the remote server checks your public key to see if it matches the list of public key strings in authorized_keys (could be separated by blank lines).
    - You do however have to generate the private and public keys for services like github.com because you do not have access to their authorized_keys file, so as part of generating their pair of private and public files, they automatically append your public key contents into their authorized_keys file. Finally, they let you download or copy/paste the private and public key files to your computer so that you can use it with the SSH command.

II. Things to ignore: 
- You may notice along tue authorized_keys file at the remote server, there's a known_hosts file. That file lets the client authenticate that the server isn't connecting to an impersonator ina middle of the man hack. We don't really need to touch that.
- Later you may notice after generating the public and private key pair, you'll get a random art image like:

+--[ RSA 2048]----+
|        G o      |
|         o o     |
|          + .    |
|       . . =     |
|      o S . o    |
|     . -   . .  .|
|      . .   +  o.|
|           . +ooo|
|         .ooo+= o|
+-----------------+

We can ignore that. It's a way for humans to quickly recognize it's the machine they are expecting because the SSH contents are too gibberish.


**III. Instructions**

1. Generate a public and private key on any machine with SSH installed - does not matter server or your local machine unless this is an online platform like github that doesn't allow access to their authorized_keys file (Read above). Doesn't matter if you're at ~/.ssh. It will tell you before proceeding
```
ssh-keygen
```

2. Make sure the private and public files are in the same folder, best at your local machine user's designated .ssh/ folder.

3. Change permissions of private and public files and ownership so that no one else can view or move with the files:
```
sudo chmod 700 ~/.ssh/
sudo chmod 600 ~/.ssh/*
sudo chown -R <username> ~/.ssh/
sudo chgrp -R <username> ~/.ssh/
```

4. Go into your remote server's terminal. Usually on Cpanel there is a Terminal app. Other web hosting interfaces will have their own way you can access the Terminal app within your web browser. Now, append your public key file's contents to the server's ~/.ssh/authorized_keys. Make sure you are doing this in the remote user's .ssh folder that you'll authenticate into. If you are doing this in another user's .ssh folder at the remote server, then you are wasting time.If authorized_keys file is missing, create it.

What do you mean by append? The authorized_keys have the public key file's contents. It can have multiple public key file contents on different lines, allowing different machines to connect to this remote server. For example, you may have a team of web developers that should have access to the remote server. They are connecting to main@<IP Address>, so the .ssh/authorized_keys file will have all their computer's SSH public key file contents. If each computer user connects to their own user on the remote server, then you'll have their public key file in the respective .ssh/authorized_keys file.

5. Connect from your local machine to the remote server with:
```
ssh root@<SERVER+IP> -i /Users/<USER>/.ssh/id_rsa -v
```

The i stands for IdentityFile, also known as the private SSH key file. Remember that the private key has no file extension and that the public key file has the file extension .pub. For remembering, SSH's first step is to check if the private key really is private (chmod permissions indicate it only belongs and can be read and modified by you the user), so point the SSH command to the private key file, not the public key file.

The v option is for verbose, so you can see any errors if this does not run.

IV. Troubleshooting

You run in verbose mode with -v on the SSH command, and your machine cannot connect to the SSH server.

# No more authentication methods to try?
A. Make sure file permissions are good on your local machine AND remote server:

sudo chmod 700 ~/.ssh/
sudo chmod 600 ~/.ssh/*
sudo chown -R <username> ~/.ssh/
sudo chgrp -R <username> ~/.ssh/

B. Make sure the ssh command is pointing to the private key file (no file extension)

C. Make sure the remote server's authorized_keys file has your public key file's contents. Make sure it's the authorized_keys file in the correct user's folders (the user profile on the remote server that you are connecting to).

Check if public file is valid format:
ssh-keygen -l -f id_rsa.pub
(Would warn it isn't)

Confirm if private key file validates
ssh-keygen -y -f id_rsa

vi /etc/ssh/sshd_config
disable password authentication
add PermitRootLogin at /etc/ssh/sshd_config
and ChallengeResponseAuthentication to no
and PubkeyAuthentication=no
and MaxAuthTries 9999

Make sure they're not commented (# begins line of comment)

With all setting changes, you must restart SSH on the remote server side before trying to connect, so the settings can apply. The troublesome part is depending on your remote server's os, it can be different commands:

Try to restart SSH with:
```
sudo systemctl restart ssh
```

Or try to restart SSH with:
```
sudo service ssh restart
```

Or try to restart SSH with: 
```
sudo stop ssh
sudo start ssh
```

Read more on SSH key concepts at: https://kb.iu.edu/d/aews