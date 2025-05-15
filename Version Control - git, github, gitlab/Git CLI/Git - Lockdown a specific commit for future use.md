
You're exploring open source apps at Github.com. So you've cloned a repo on local machine and successfully ran it. 

Now you want to **save the exact version** so you can pull **that same image later** — maybe on a new computer or server — and ensure everything still works.

You can't just `git clone` a specific commit directly, but you can **clone the repo first, then checkout** the specific commit.  

**First time:**
Let's say you cloned a repo and it works fine on your local development. Then you may want to visit the git repo webpage and look for the latest commit hash (Go to commits page and copy the hash of the latest commit) and write it somewhere.

**Resetting to a specific commit**:

You could do a checkout which is softer:
```
git checkout COMMIT_ID
```

Or you could do a reset:
```
git reset --hard COMMIT_ID
```