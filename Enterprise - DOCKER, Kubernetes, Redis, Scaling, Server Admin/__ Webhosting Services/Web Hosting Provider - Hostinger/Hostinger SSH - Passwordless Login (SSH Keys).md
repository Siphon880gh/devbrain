If you've generated a pair before (for another website, etc),  and you dont care about compromise of that key affecting multiple websites (a very unlikely event):
- You enter your public key file contents into hostinger's dashboard.

Otherwise, generate a pair with `ssh-keygen -t ed25519 -C ["your_email@example.com"](mailto:"your_email@example.com" "mailto:\"your_email@example.com\"")` and then you share the public key contents into hostinger, and make sure the private key file stays on your computer (don't delete it!)

Your ssh command will reference that private key on your computer, thus making SSH root into the terminal passwordless and more secured
```
ssh -i ~/.ssh/newmac2023_hostinger -p 22 root@XX.XX.XXX.XX
```

Next you could disable SSH root login via password and/or rename root user to another user (dont use default names like "root")

And your .bash_profile etc can have:
```
alias vlai='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/wengindustries/htdocs/wengindustries.com"; ssh -i ~/.ssh/newmac2023_hostinger -p 22 root@XX.XX.XXX.XX'
```

---

If you want the ssh to cd into a specific folder once ssh login successful:
```
ssh -i ~/.ssh/newmac2023_hostinger -p 22 root@31.97.143.85 -tt "cd /home/videolistings/htdocs/videolistings.ai && bash --login"
```

Then your .bash_profile etc script becomes:
```
alias vlai='echo -e "Local: /Users/wengffung/dev/web/storyway/app-vlai\nRemote: /Users/wengffung/dev/web/storyway/app-vlai"; ssh -i ~/.ssh/newmac2023_hostinger -p 22 root@31.97.143.85 -tt "cd /home/videolistings/htdocs/videolistings.ai && bash --login"'
```