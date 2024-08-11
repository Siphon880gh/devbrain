
How run dataview queries:

Make sure dataview installed and enabled

You run it like this:

```
table file.name from ""  
```


Make sure your code is like this, otherwise it will just think it's a code snippet and won't run dataview:
![](https://i.imgur.com/ebZwgiJ.png)

You have to **make sure** “dataview” is in the first line

  
---

Show all files and folders from root:
```
table file.name from ""  
```


Limit output rows:
```
table file.name from "" LIMIT 1  
```

  
Show only files in the folder ACC/ that has the filename containing 23. Not case sensitive
```
TABLE title, tags FROM "Acc"  WHERE contains(lower(file.name), "23")  
```
  
```
TABLE title, tags FROM "Acc"  WHERE contains(lower(file.name), "pay")  
```
^ make sure to use lower case query for the case insensitive to work

---

Notice file.name was used. To see what other attributes possible
```
table file from "" LIMIT 1
```

![](https://i.imgur.com/YGKdkaU.png)


^ That particular path just happens to be the first file that Obsidian recognizes from root of document vault, but most importantly it gave information about the file object, such that had you ran `table file.name from "" LIMIT 1`

---

You also have list:
```
LIST "Unreal" LIMIT 5
```
![](https://i.imgur.com/Q94eRED.png)

Shortest table:
```
TABLE "Unreal" LIMIT 5
```

![](https://i.imgur.com/7Hj7Pwa.png)

---

You can sort by modified day or created day:

```
TABLE file.name, file.path, file.mday, file.mday, file.cday, file.ctime FROM "Queue Unreal" LIMIT 5
```

![](https://i.imgur.com/DTe3x73.png)

-->

![](https://i.imgur.com/J5mdDzt.png)

^ You click the column header