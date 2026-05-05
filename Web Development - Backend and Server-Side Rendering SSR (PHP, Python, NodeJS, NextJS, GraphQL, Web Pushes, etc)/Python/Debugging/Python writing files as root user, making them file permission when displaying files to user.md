Python writing files as root user, making them file permission when displaying files to user

Is the python started by sh file (or sh file starting gunicorn that starts python)? Refer to [[Sh files - Started server, and server creates files belong to root, causing file permissions when displaying files in web browser]]


Otherwise if you run python directly as the website's SSH user (try that if you've been running the python server or script as root), continue following:


**Two approaches:**

Either approach requires you imported os:
```
import os
```

**Approach 1:** Before written, lets change files to the ownership both user and group of the folder it’s written to:

```
# Solves: Root user runs supervisor, sh, and gunicorn, and so it's probably going to write as root causing permission issues   
# when trying to read the file later  
  
# Get the ownership details of the possPath directory  
stat_info = os.stat(possPath)  
uid = stat_info.st_uid  # User ID of possPath  
gid = stat_info.st_gid  # Group ID of possPath  
  
# __A__: Then change the effective user and group IDs so files written will be under that user instead of root  
os.setegid(gid)  
os.seteuid(uid)  
  
with open(file_path, 'wb') as f:  
            for chunk in response.iter_content(chunk_size=CHUNK_SIZE):  
                if chunk:  
                    f.write(chunk)  
            f.flush()  # Ensure all data is written to the file system  
            os.fsync(f.fileno())  # Force writing to disk
```

  

**Approach 2:**  
if after written, you could imitate running a command chown literally with:
```
os.chown(file_path, uid, gid)
```