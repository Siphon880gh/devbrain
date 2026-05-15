
Some online directories (eg. Ubuntu distro) lets you download .gz and gz.zync files. 

If there’s a file and there is a corresponding `.zsync` file, you can use `wget` command for downloading both the `.gz` file and its `.zsync` file. This command will download the file, using any existing data in your directory to minimize the amount of data transferred. Great for interrupted downloading.

### **Command to Download the `.gz` File**:
```bash
wget https://old-releases.ubuntu.com/releases/22.04.2/ubuntu-22.04-live-server-riscv64.img.gz
```

### **Command to Download the `.zsync` File**:
```bash
wget https://old-releases.ubuntu.com/releases/22.04.2/ubuntu-22.04-live-server-riscv64.img.gz.zsync
```

These commands will download the specified files from the given URL to your current working directory. If the download is interrupted, `wget` can resume it using the `-c` option:

### **Command to Resume a Download with `wget`**:
```bash
wget -c https://old-releases.ubuntu.com/releases/22.04.2/ubuntu-22.04-live-server-riscv64.img.gz
```

### **Using `zsync` for Efficient Downloads**:
If you want to use `zsync` to download the `.gz` file, leveraging the `.zsync` file for efficiency, you can use:

```bash
zsync https://old-releases.ubuntu.com/releases/22.04.2/ubuntu-22.04-live-server-riscv64.img.gz.zsync
```