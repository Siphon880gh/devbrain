
Run:
```
sudo dmidecode --type memory
echo "Memory (RAM):" && free -h  
echo ''
echo -e "\nDisk Space:" && df -h  
echo ''  
echo -e "\nCPU Information:" && lscpu | grep "Model name\|CPU(s):\|MHz"
```

Get your OS distro with:
```
cat /etc/os-release
```