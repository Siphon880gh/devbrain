

Two styles:
```
my_file = open("hello.txt")
print(my_file.read())
my_file.close()

# Output : 
# Hello world
# I hope you're doing well today
# This is a text file
```


```
with open("hello.txt") as my_file:
    print(my_file.read())

# Output : 
# Hello world
# I hope you're doing well today
# This is a text file
```

---


Unlike `open()` where you have to close the file with the `close()` method, the `with` statement closes the file for you without you telling it to.


---

Catching errors:
```
try:
    with open("hello.txt") as my_file:
        print(my_file.read())
except FileNotFoundError:
    print("File not found.")
except IOError:
    print("An error occurred while reading the file.")

```