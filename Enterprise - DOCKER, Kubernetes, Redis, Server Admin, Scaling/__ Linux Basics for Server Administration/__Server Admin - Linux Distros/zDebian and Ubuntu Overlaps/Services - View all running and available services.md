
## systemctl and services

In Ubuntu 22, you can view all the running and available services using two different methods:

1. **Using `systemctl` in the terminal:**
   - To see all active services, use the command:
     ```bash
     systemctl list-units --type=service --state=running
     ```
   - To see all services, whether active, inactive, or failed, use:
     ```bash
     systemctl list-units --type=service
     ```

2. **Using the `Services` app (Graphical User Interface):**
   - Open the Activities overview and start typing "Services."
   - Click on the **Services** app (also sometimes called "Startup Applications").
   - This GUI tool allows you to manage and view system services.

These two methods give you a comprehensive view of the services on your Ubuntu 22 system.

---

## Directories

1. **System services managed by `systemd`:**
   - The primary directory for system-wide services is:
     ```bash
     /etc/systemd/system/
     ```
   - Another important directory for unit files provided by installed packages is:
     ```bash
     /lib/systemd/system/
     ```
   - Additionally, user-specific services can be found in:
     ```bash
     ~/.config/systemd/user/
     ```

2. **Legacy `init.d` services:**
   - Although Ubuntu primarily uses `systemd`, some older services might still be managed by `init.d`. You can find these scripts in:
     ```bash
     /etc/init.d/
     ```

You can navigate these directories to view or manage service files directly.