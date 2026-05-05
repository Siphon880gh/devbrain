
On Ubuntu they both work. Whats the difference?

`sudo systemctl status supervisor` 

`sudo service supervisor status` 


---

`sudo systemctl status supervisor` 

This command uses **systemd**, the modern service manager used by most Linux distributions, including the latest versions of Ubuntu.

`sudo service supervisor status` 

On systems where `systemd` is the default service manager (like modern Ubuntu versions), `service` acts as a wrapper around `systemctl` for compatibility with older scripts and habits.  

Therefore on a modern Ubuntu system, both commands should provide similar output for checking the status of services. It's generally recommended to use systemctl directly for managing services on systems that use systemd for better consistency and access to more advanced features.