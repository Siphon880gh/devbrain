![[Pasted image 20250213023001.png]]

Rawly:
```
To github.com:Siphon880gh/devbrain.git

 ! [remote rejected] main -> main (push declined due to repository rule violations)

error: failed to push some refs to 'github.com:Siphon880gh/devbrain.git'
```

This is because you've accidentally exposed an API key. Git prevents you from pushing online if an API key is exposed.


---


What if you really want to push the API key and make it publicly available?

Theoretically, you could force the API key up to the repo:
```sh
git push --no-verify -f
```

But **if your company has DLP (Data Loss Prevention) or GitHub Security Policies**, this might not work.

Keep in mind that attackers scrape GitHub for leaked keys **within seconds**! 🚨