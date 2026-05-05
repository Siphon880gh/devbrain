It's important to know the os of your server especially if running comamnds or installing other packages and you need to know the command for that package manager for that os. Once you know the os, then it's a matter of searching google.

There are commands that print out the os, but the problem is every os has a different command for that so you have to guess which commands and try them all.

An uniform way is to use node. If the specific linux distribution (eg. CentOS) doesn't matter, then you can find out with the module "os" that comes with node; otherwise, for more specific linux distribution, you have to install a node module and for that, please refer to lesson on finding linux distro os. 

Worth noting, Mac OS is known as "Darwin". 

Run these commands in the terminal line by line to get your general os:
```
node << END
const os = require("os");
console.log(os.type());
console.log(os.release());
console.log(os.platform());
END
```

One example computer would show up:
"Windows_NT"
"10.0.14393"
"win32"

You can also find the home directory:
```
console.log(os.homedir());
```