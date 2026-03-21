Check ports are opened:
sudo lsof -i TCP:21 -i TCP:22  

If you’re using uwf as firewall:
sudo ufw status