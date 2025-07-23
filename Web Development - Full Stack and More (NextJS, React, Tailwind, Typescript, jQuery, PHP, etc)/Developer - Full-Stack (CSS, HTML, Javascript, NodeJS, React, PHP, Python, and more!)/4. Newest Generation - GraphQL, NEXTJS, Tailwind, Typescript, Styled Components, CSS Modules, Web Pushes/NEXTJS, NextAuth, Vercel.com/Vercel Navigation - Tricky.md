If you're in a specific project, then Storage tab works different compared to when in all projects' Storage tab.

All project's Storage tab will generate .env.local and ORM connector code after you click the database at the Storage tab. At a deeper workflow, you can also view tables and their data.

A specific project's Storage tab will not allow you to click the database. There is a connect button for the database which is a different purpose.

---

CORRECT (Notice top right says "Weng Fei Fung's projects" ONLY)

![[Pasted image 20250316034209.png]]

And then clicking the database name "wayne-teaches-code", that takes you to generating .env.local and ORM connector code:
![[Pasted image 20250316034236.png]]

---

INCORRECT (Notice top right says "Weng Fei Fung's projects", then to the right has the vercel project name, in this case, "app1"):

![[Pasted image 20250316034350.png]]

To correct course, click your projects (In this case, "Weng Fei Fung's projects" at the top left). That will kick you to the correct dashboard, then you may select Storage tab.

---
---

You are supposed to be able to access your Neon postgreSQL database from within Vercel.com, but you could also access it at Neon.tech. 

So if you still have problems accessing the Storage details, you can visit Neon directly. FYI, Neon has formed a strategic partnership with Vercel. That's why postgreSQL is known as Neon postgreSQL on vercel.

You visit Neon directly at
- [https://console.neon.tech/app/](https://console.neon.tech/app/)
- And then login with the same account details as vercel.com's

As of 3/2025, Neon.tech can give you the postgresql connection string but doesn't nicely generate .env.local or ORM connector code like vercel.com does. Both vercel.com and neon.tech lets you view table data.

