In other words: Copy into and out of running container.. changing the app's behavior TEMPORARILY

Note: We are using the focalboard app as an example.

---

### Step 1: 
Eg. Copy config.json from container to host machine
```
docker cp focalboard:/opt/focalboard/config.json ./config.json
```
  
### Step 2: 
Edit it on your local machine

### Step 3: Copy it back into the container 
Edit it on your local machine
```
docker cp ./config.json focalboard:/opt/focalboard/config.json  
```
  
### Step 4: Restart the container  
```
docker restart focalboard
```