You can run your index.js file on the web server's SSH (Mnemonic: Nohup is no hangup, because back then modems hang up shutting down a connection):
```
nohup node ./test.js > /dev/null 2>&1 &
```

Explanation of the command: https://gist.github.com/andreasonny83/c35b51c4197d09af1b8c0510c0b1d1ea

Then it will run in the background. You can kill the process later if you have to. Firsts find the process ID, then kill the ID:
```
ps
kill -9 _pid_
```

Hint: man kill will show you the number signals. -9 means kill.

If the script does not show up in the process list, then it may have errored in the background. Then check your script. A good clean script to test is an express server.