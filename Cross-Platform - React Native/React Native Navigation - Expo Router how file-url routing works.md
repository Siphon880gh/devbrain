
This is based primarily off of Next.js from the Web React ecosystem

**The /app directory**
Must /app with files for routes
You declare routes with folder and file creations in app/
https://docs.expo.dev/router/introduction/

If /app doesn't exist, you should create the folder

**Platform naming still allowed**:
about.web.tsx file is used as the about page for the web, and the about.tsx file is used on all other platforms.

**Grouped routes**
2:10 why
https://youtu.be/Tpo5wBuk3po?si=0__tOObHACycYR5s
For example, (auth)/ containing all path segments for authentication like login.jsx, signout.jsx (or login/index.jsx, etc) that way your app/ doesn't have all the routes that should be next to each other but all scattered

You can prevent a segment from showing in the URL by using the group syntax ().
app/root/home.tsx matches /root/home
app/(root)/home.tsx matches /home

---

Screenshots and explanations of filenames and their url route equivalents (so you can .navigate to the relative url):
![](https://i.imgur.com/k2JfOWc.png)

![](https://i.imgur.com/RUxCq7x.png)

![](https://i.imgur.com/0KSFcv1.png)
