
Run:
```
echo "Memory (RAM):" && free -h  
echo ''  
echo -e "\nDisk Space:" && df -h  
echo ''  
echo -e "\nCPU Information:" && lscpu | grep "Model name\|CPU(s):\|MHz"
```