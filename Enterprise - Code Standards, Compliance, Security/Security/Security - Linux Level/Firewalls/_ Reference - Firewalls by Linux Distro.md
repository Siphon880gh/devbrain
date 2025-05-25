Here’s a summary of common Linux distributions and the default firewall management tool they typically use:

| **Linux Distro** | **Default Firewall Tool**                                    | **UFW Preinstalled?** |
| ---------------- | ------------------------------------------------------------ | --------------------- |
| **Ubuntu**       | `iptables` (via **UFW**)                                     | ✅ Yes (usually)       |
| **Debian**       | `iptables` (UFW optional)                                    | ❌ No                  |
| **CentOS 7+**    | **firewalld** (uses `iptables` or `nftables` under the hood) | ❌ No                  |
| **RHEL 7+**      | **firewalld**                                                | ❌ No                  |
| **Fedora**       | **firewalld**                                                | ❌ No                  |
| **Arch Linux**   | `iptables` or `nftables` (UFW optional)                      | ❌ No                  |
| **Alpine Linux** | `iptables` or `nftables`                                     | ❌ No                  |

### Notes:
- **UFW** is just a simplified frontend for `iptables`.
- **firewalld** is a dynamic firewall manager that replaces manual `iptables` rules.
- **nftables** is slowly replacing `iptables` on newer distros.