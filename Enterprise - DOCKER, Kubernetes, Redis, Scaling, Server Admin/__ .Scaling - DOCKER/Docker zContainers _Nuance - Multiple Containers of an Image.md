
If you intend to have multiple containers of an image to all share the same database - Let’s compare two example Docker commands:

```bash
docker run -it -v ~/fbdata:/opt/focalboard/data -p 8000:8000 focalboard
docker run -it -v ~/fbdata2:/opt/focalboard/data -p 8001:8000 focalboard
```

Each container is using a **different volume** (`fbdata` vs `fbdata2`). That’s fine for development or testing, but it **won’t work for scalable production** — the containers don’t share state or data.

If your app stores persistent data, you'll need to decide how containers share that data safely. Here are two common approaches:
#### ✅ Option 1: Use a Shared Docker Volume (With Caution)

You can mount the **same named volume** into multiple containers:

```bash
docker volume create focalboard-data
```

```bash
docker run -d -v focalboard-data:/opt/focalboard/data -p 80:8000 focalboard
docker run -d -v focalboard-data:/opt/focalboard/data -p 81:8000 focalboard
```

> ⚠️ **Be careful**: Most apps (like Focalboard) aren’t built to support multiple instances writing to the same local storage. This can lead to **data corruption** or race conditions.

#### ✅ Option 2: Externalize App State (Recommended for Scaling)

For proper horizontal scaling:

- Run the app in **server mode** (if available) and connect to an external **database** (e.g., PostgreSQL or MySQL)
    
- Store uploads (like attachments) in **external object storage** (e.g., AWS S3)
    
- Containers now become **stateless app servers**, free to scale up/down
    

This is the approach used by scalable architectures — each container runs independently and talks to a shared backend.

---

## Here's proof containers are isolated by default

These two screens are both running on the same machine at the same time

Screen one is port 80's instance of focalboard ran with `docker run -it -v ~/fbdata:/opt/focalboard/data -p 80:8000 focalboard`
![[Pasted image 20250515043429.png]]

Screen two is port 81's instance of focalboard ran with `docker run -it -v ~/fbdata2:/opt/focalboard/data -p 80:8000 focalboard

![[Pasted image 20250515043553.png]]

They are both the same user Weng. However, on screen two I had to sign up as Weng again (it didn't recognize the login). Furthermore, each screen's added boards are entirely different.

This is probably not what you want when hosting it on your server and you want a HPA (Horizontal Pod Autoscaling) to spin up new Focalboards at ports 80, 81, 82, 83... and spin down them based on traffic, all while being underneath the same URL (Not shown in this tutorial). You'll have some users on a different "database".