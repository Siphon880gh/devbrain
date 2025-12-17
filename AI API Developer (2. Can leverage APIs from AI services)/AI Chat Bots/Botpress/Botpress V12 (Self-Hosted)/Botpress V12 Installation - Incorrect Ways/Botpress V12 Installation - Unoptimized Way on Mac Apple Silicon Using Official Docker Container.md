Only on Mac - if using official docker container, it's incorrect because their container is optimized for x86_64 and MacBook Pro with M1 chip needs arm64 instead.

---

The Docker container already includes the `node_modules` directory, prebuilt for x86_64 systems. However, there's no native ARM64 image available—so on Macs with M1/M2 chips, Docker has to emulate x86_64, which makes everything sluggish. You'll notice choppy performance and even slow startup or shutdown times (sometimes taking several minutes).

That said, in production environments—especially on Linux servers with x86_64 architecture—performance should be smooth and fast.

In case fails on MacBook Pro 2021, what worked was: `botpress/server:v12_26_7` 

Firstly, pull image from Docker Hub:
```
docker pull botpress/server
```

Botpress run container on DockerHub:
```
docker run -it --name botpress_v12 -p 127.0.0.1:3000:3000 -v ~/botpress_v12_data:/botpress/data botpress/server
```

On a Mac, it's being emulated because there's no class for ARM64 architecture, so there will be errors and slowness.

```
Error: v12_26_7 Unable to find image 'botpress/server:v12_26_7' locally  
```

Then it appears to hang? It's just the slow container. Just wait it out.


Terminal continues by pulling in the image if you don't have the image at the Docker system:
```
Error:

v12_26_7: Pulling from botpress/server

Digest: sha256:05450cd0ac9790ce9eaf1b67d8104eb1c117dd9a78479ee03bbfe31b8838e83c

Status: Downloaded newer image for botpress/server:v12_26_7

WARNING: The requested image's platform (linux/amd64) does not match the detected host platform (linux/arm64/v8) and no specific platform was requested

05/15/2025 13:18:20.770 **Database** Created table 'srv_metadata' 
```

Then appears to hang at srv_metadata. Just wait: It's fine. It'll just be slower because your Mac will emulate.

Taking forever:
![[Pasted image 20250517064213.png]]

  

But after MINUTES (if on Mac because of ARM64), it'll finally output this:
```
05/16/2025 09:29:39.133 [Messaging] Launcher ===========================================================================  
                                                                         Botpress Messaging                              
                                                              Version 0.1.17 - Build 20211105-2136_BIN                   
                                             ===========================================================================  
05/16/2025 09:29:39.667 [Messaging] Database Created table 'msg_meta'  
05/16/2025 09:29:39.710 [Messaging] Database Created table 'msg_channels'  
05/16/2025 09:29:39.784 [Messaging] Database Created table 'msg_providers'  
05/16/2025 09:29:39.798 [Messaging] Database Created table 'msg_clients'  
05/16/2025 09:29:39.817 [Messaging] Database Created table 'msg_webhooks'  
05/16/2025 09:29:39.827 [Messaging] Database Created table 'msg_kvs'  
05/16/2025 09:29:39.847 [Messaging] Database Created table 'msg_conduits'  
05/16/2025 09:29:39.870 [Messaging] Database Created table 'msg_users'  
05/16/2025 09:29:39.882 [Messaging] Database Created table 'msg_conversations'  
05/16/2025 09:29:39.897 [Messaging] Database Created table 'msg_messages'  
05/16/2025 09:29:39.910 [Messaging] Database Created table 'msg_tunnels'  
05/16/2025 09:29:39.928 [Messaging] Database Created table 'msg_identities'  
05/16/2025 09:29:39.944 [Messaging] Database Created table 'msg_senders'  
05/16/2025 09:29:39.959 [Messaging] Database Created table 'msg_threads'  
05/16/2025 09:29:39.973 [Messaging] Database Created table 'msg_usermap'  
05/16/2025 09:29:39.989 [Messaging] Database Created table 'msg_convmap'  
05/16/2025 09:29:40.009 [Messaging] Database Created table 'msg_sandboxmap'  
05/16/2025 09:29:40.017 [Messaging] Database Created table 'msg_status'  
05/16/2025 09:29:40.028 [Messaging] Database Created table 'msg_health'  
05/16/2025 09:29:40.039 [Messaging] Launcher Using channels: messenger, slack, teams, telegram, twilio, discord, smooch, vonage  
05/16/2025 09:29:40.088 [Messaging] Launcher Messaging is listening at: http://localhost:3100
```

And the page loads
![[Pasted image 20250517064235.png]]

If creating account Times Out, very likely the start has frozen at NLU and forgot to start other servers. If the tail of the tail is like this:
```
05/18/2025 10:08:10.342 **[NLU] Launcher** ===========================================================================

                                                                 **Botpress Standalone NLU**                          

                                                         Version 1.0.2 - Build 20220909-2040_BIN                  

                                       ===========================================================================

05/18/2025 10:08:16.939 **[NLU] Launcher** Loading config from environment variables

05/18/2025 10:08:17.053 **[NLU] Launcher** limit: disabled (no protection - anyone can query without limitation)

05/18/2025 10:08:17.183 **[NLU] Launcher** duckling: enabled url=http://localhost:8000

05/18/2025 10:08:17.518 **[NLU] Launcher** lang server: url=https://lang-01.botpress.io

05/18/2025 10:08:17.680 **[NLU] Launcher** body size: allowing HTTP requests body of size 2mb

05/18/2025 10:08:17.801 **[NLU] Launcher** models stored at "/botpress"

05/18/2025 10:08:18.035 **[NLU] Launcher** batch size: allowing up to 1 predictions in one call to POST /predict

05/18/2025 10:09:23.104 **[NLU] Launcher** NLU Server is ready at http://localhost:3200/. Make sure this URL is not publicly available.

05/18/2025 10:09:25.230 **Mod[nlu]** Standalone NLU Server is ready.
```


And signup keeps timing out:
![[Pasted image 20250518031118.png]]

Then shut down and restart container. It should proceed to the next port listening

---

Shut down either with CMD+D signal termination on an -it foreground container, OR `docker stop CONTAINER_ID` will appear to hang
![[Pasted image 20250517064439.png]]

If curious, you ran `docker ps` - seeing it's still "up":
![[Pasted image 20250517064458.png]]

You have to wait a while. Could take upwards to 2 minutes. But it will shut down.

---


If you run the container to the background detached, running `docker ps`  will say it's up under STATUS, but visiting localhost:3000 will automatically not open

Eventually after about 2 mins, visiting localhost:3000 will hang on loading:
- At 2 min:
  ![[Pasted image 20250517064627.png]]
- Web browser:
  ![[Pasted image 20250517064639.png]]

3 minutes in, it will load correctly:
- At 3 mins:
  ![[Pasted image 20250517064702.png]]
- Web browser - you'll see sign up page or the dashboard:
  ![[Pasted image 20250517064724.png]]
  