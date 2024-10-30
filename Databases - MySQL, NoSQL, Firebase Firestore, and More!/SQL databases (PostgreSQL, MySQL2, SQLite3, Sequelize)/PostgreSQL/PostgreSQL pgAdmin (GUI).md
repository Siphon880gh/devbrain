
For users preferring a graphical interface, **pgAdmin** is a popular option across Linux, macOS, and Windows. It provides an intuitive interface for creating databases, tables, running queries, and managing settings.

## Download and Installation

Make sure when you download, you dont click a fake download button from a misleading ad:
https://www.pgadmin.org/

When you choose Mac, you're presented with:
```

CURRENT_MAINTAINER
pgadmin4-8.12-arm64.dmg
pgadmin4-8.12-x86_64.dmg
```

ARM64 chips are the Mac M1 and M2
X86_64 are the 74 bit of Intel and AMD

## Initial Setup

Register a new server under the server group
![](https://i.imgur.com/Kge3sX2.png)

Give the server a name under General tab (Eg. Localhost)
![](https://i.imgur.com/eHeJ2j9.png)

Under Connection tab, fill in hostname, username, password (Port is prefilled 5432, Database is prefilled `postgre` which is a default existing database):
![](https://i.imgur.com/4LxRKUw.png)

Then click "Save" to connect

When successfully connected, it'll show the Database sessions (right) as well as a list of your Databases (left)
![](https://i.imgur.com/9vY0BvL.png)

You can right click your database on the left to create new items:
![](https://i.imgur.com/ZJqJCxk.png)
