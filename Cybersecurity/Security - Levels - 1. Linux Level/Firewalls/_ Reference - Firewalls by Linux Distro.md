
| **Linux Distro / Version**           | **Default / Common Firewall Tool**                                                | **Backend Usually Used**                                   | **UFW Preinstalled?** |
| ------------------------------------ | --------------------------------------------------------------------------------- | ---------------------------------------------------------- | --------------------- |
| **Ubuntu 20.04 / 22.04 / 24.04 LTS** | **UFW**                                                                           | `iptables` / `nftables` through UFW                        | ✅ Yes, usually        |
| **Debian 10 / 11 / 12 / 13**         | **nftables** recommended; UFW optional                                            | `nftables` / `iptables-nft` compatibility layer            | ❌ No                  |
| **CentOS 7**                         | **firewalld**                                                                     | `iptables` backend historically                            | ❌ No                  |
| **CentOS Stream 8 / 9 / 10**         | **firewalld**                                                                     | usually `nftables` backend                                 | ❌ No                  |
| **RHEL 7**                           | **firewalld**                                                                     | `iptables` backend historically                            | ❌ No                  |
| **RHEL 8 / 9 / 10**                  | **firewalld**                                                                     | usually `nftables` backend                                 | ❌ No                  |
| **Fedora 32+ / current Fedora**      | **firewalld**                                                                     | `nftables` backend                                         | ❌ No                  |
| **Arch Linux**                       | No single default firewall manager                                                | `nftables`, `iptables`, UFW, or firewalld can be installed | ❌ No                  |
| **Alpine Linux 3.x**                 | No single default firewall manager; `awall`, `nftables`, or `iptables` are common | `iptables` or `nftables` depending on setup                | ❌ No                  |
| **openSUSE Leap / Tumbleweed**       | **firewalld**                                                                     | usually `nftables` backend on modern systems               | ❌ No                  |
| **Rocky Linux 8 / 9**                | **firewalld**                                                                     | usually `nftables` backend                                 | ❌ No                  |
| **AlmaLinux 8 / 9**                  | **firewalld**                                                                     | usually `nftables` backend                                 | ❌ No                  |
| **Amazon Linux 2**                   | `iptables` commonly used; firewalld optional                                      | `iptables`                                                 | ❌ No                  |
| **Amazon Linux 2023**                | **nftables** / firewalld optional                                                 | `nftables`                                                 | ❌ No                  |
| **Oracle Linux 8 / 9**               | **firewalld**                                                                     | usually `nftables` backend                                 | ❌ No                  |

## Notes

- **Debian 12 and newer:** Think **nftables first**. Debian’s wiki describes `nftables` as the default and recommended firewalling framework, replacing older `iptables` tooling. Debian also uses `iptables-nft` compatibility, which lets some `iptables` commands interact with the nftables backend. ([Debian Wiki](https://wiki.debian.org/nftables?utm_source=chatgpt.com "nftables"))
    
- **Ubuntu:** Ubuntu usually ships with **UFW** as the friendly firewall interface. Modern Ubuntu documentation describes UFW as a frontend for both `iptables` and `nftables`, so UFW is not the firewall engine itself; it is the easier command layer. ([documentation.ubuntu.com](https://documentation.ubuntu.com/security/security-features/network/firewall/?utm_source=chatgpt.com "Firewall - Ubuntu security documentation"))
    
- **RHEL / Rocky / Alma / CentOS Stream:** These usually use **firewalld**. On modern RHEL-family systems, firewalld commonly uses an **nftables backend** rather than the older iptables backend. Red Hat’s docs discuss firewalld running with an nftables backend and its runtime/permanent configuration model. ([Red Hat Documentation](https://docs.redhat.com/en/documentation/red_hat_enterprise_linux/9/html/configuring_firewalls_and_packet_filters/using-and-configuring-firewalld_firewall-packet-filters?utm_source=chatgpt.com "Chapter 1. Using and configuring firewalld"))
    
- **Fedora:** Fedora moved firewalld’s default backend to **nftables**, which reduced duplicated IPv4/IPv6 rule handling and moved firewalld primitives onto the nftables backend. ([Fedora Project](https://fedoraproject.org/wiki/Changes/firewalld_default_to_nftables?utm_source=chatgpt.com "Changes/firewalld default to nftables - Fedora Project Wiki"))
    
- **Alpine:** Alpine is more minimal. You often install what you want: `nftables`, `iptables`, or Alpine’s `awall`. Alpine’s docs note that `awall` requires iptables but can work with nftables and legacy iptables backends. ([wiki.alpinelinux.org](https://wiki.alpinelinux.org/wiki/How-To_Alpine_Wall?utm_source=chatgpt.com "How-To Alpine Wall"))
    

## Simple way to remember it

For modern Linux:

- **Ubuntu** → use `ufw`
    
- **Debian 12+** → use `nftables` directly, or install `ufw` if you want simpler commands
    
- **RHEL / Rocky / Alma / Fedora / CentOS Stream** → use `firewalld`
    
- **Arch / Alpine** → you choose; commonly `nftables`, `iptables`, UFW, or firewalld
    

## Important clarification

`iptables`, `nftables`, `ufw`, and `firewalld` are not all the same kind of thing.

- **`nftables`** is the modern Linux firewall framework.
    
- **`iptables`** is the older firewall command system, now often using an nftables compatibility layer on newer distros.
    
- **UFW** is a simpler frontend, common on Ubuntu.
    
- **firewalld** is a firewall management service, common on Fedora/RHEL-family distros.
    

So on a modern server, you might type `ufw allow 22`, but under the hood the actual packet filtering may still end up going through `iptables-nft` or `nftables`.