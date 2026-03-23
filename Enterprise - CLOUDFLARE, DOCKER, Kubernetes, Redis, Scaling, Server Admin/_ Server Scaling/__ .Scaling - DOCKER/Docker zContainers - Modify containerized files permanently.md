In other words: Permanently change files inside the container.. changing the app's behavior PERMANENTLY

Note: We are using the focalboard app as an example.

---

Use mounting to the file you're using as what's going to override the container's file:
```
docker run -d --restart=unless-stopped \  
  --name focalboard \  
  -p 127.0.0.1:8000:8000 \  
  -v $(pwd)/config.json:/opt/focalboard/config.json \  
  focalboard
```

OR if it's an image built from a Dockerfile. That Dockerfile copies files into the container. You can modify the files. Then build the image from the Dockerfile. Note with the approach, don't forget to remove old container and old image from Docker system.