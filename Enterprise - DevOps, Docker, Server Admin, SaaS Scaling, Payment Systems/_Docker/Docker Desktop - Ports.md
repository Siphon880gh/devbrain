Does not automatically expose the container’s app port to your computer. You would have to input the port settings at the time you run the container off the image:
![](https://i.imgur.com/rT1us9I.png)

Problem is sometimes it will say there are no ports and then it won’t let you enter any ports, even though if you had ran the docker compose file or ran docker run terminal command with the ports opened, it would work.

---


Visually confirm the ports

At the top:
![](https://i.imgur.com/fATjqVm.png)


Also port column at Containers screen:
![](https://i.imgur.com/lAOrUn6.png)

Remember:
Host_port:Container_app_port

So you visit Host_port on your web browser or connect to that port with cURL or etc, whatever the purpose of the port access is for.

---

Mnemonic

If you keep forgetting which side is what port.

Dockerfile:

docker-compose.yml:
```
version: '3.8'  
services:  
  metabase:  
    image: stephaneturquay/metabase-arm64:latest  
    ports:  
      - "${PORT:-3000}:${PORT:-3000}"  
# ...
```

Left is server’s local computer port and right is the container’s port

Mnemonic:

Event netstat, which checks what ports are opening and listening to the internet, is host on the left and host adjacent on the right:

sudo netstat -tuln | grep :27017

tcp        0      0 0.0.0.0:27017           0.0.0.0:*               LISTEN    

In that case 0.0.0.0:27017 local server computer can get internet requests from any ip address at any port

To remember this, with netstat you type user%, so the direction is user << server << internet

To remember this for docker file by remembering netstat’s: host << app

Also, Docker Compose is designed with a “host-first” approach. Since Docker containers are isolated, port mappings are thought of from the perspective of how the host machine (local) interacts with the container. By defining `host:container`, the focus is on how the _host machine_ reaches into the _container_.