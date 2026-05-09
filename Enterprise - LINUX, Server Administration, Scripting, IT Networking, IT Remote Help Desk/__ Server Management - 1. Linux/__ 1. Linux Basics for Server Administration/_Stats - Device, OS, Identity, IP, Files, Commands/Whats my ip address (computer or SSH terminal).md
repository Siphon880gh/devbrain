This works on your computer (eg. Mac which has incorporated much of Linux)
And this works on your remote server via the SSH terminal

Cleanest way (gives you the ip address):
```
hostname -i
```

More in-depth that shows loopback etc (therefore other internal addresses too)
```
ip a
```