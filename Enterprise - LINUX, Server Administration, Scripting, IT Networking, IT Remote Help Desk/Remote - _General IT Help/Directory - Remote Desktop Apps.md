Paid remote-access tools are often roughly **~$9/month when paid annually**, depending on the vendor and plan. Some are cheaper for personal use, while business/team tools can become much more expensive.

**FOSS = Free and Open Source Software.**

## Main Point

- **Google Remote Desktop**
    
    - Good for basic remote access
        
    - Free
        
    - Plug-and-play
        
    - Easy to set up
        
    - Best for simple personal use
        
    - Not ideal for gaming, IT fleet management, or advanced control
        

## Alternatives by Use Case

### Remote Gaming

- **Parsec**
    
    - Best for remote gaming
        
    - Very low latency
        
    - Smooth high-FPS performance
        
    - Better than Google Remote Desktop for gaming
        
    - Paid plans are often around the ~$9/month range when billed annually
        

## Personal / Family Support

- **RemotePC**
    
    - Easy and friendly for personal or family support
        
    - Good when helping parents, relatives, or non-technical users
        
    - Simpler than many enterprise tools
        
    - Good for basic remote access, troubleshooting, and occasional support
        
    - Paid, but usually positioned more affordably than heavy enterprise tools
        
- **Google Remote Desktop**
    
    - Good free option for simple personal access
        
    - Works well when the other person can follow basic setup steps
        
    - Less feature-heavy than paid support tools
        
- **AnyDesk**
    
    - Easy to install and use
        
    - Good for quick remote support
        
    - **Caution as of October 2025:** file transfer can feel slow, especially for larger files or less direct connections
        
- **TeamViewer**
    
    - Easy for non-technical users
        
    - Very well-known
        
    - Good for quick support
        
    - **Downside:** expensive, especially for business use
        

## Open Source, FOSS, and More Control

- **RustDesk**
    
    - FOSS/open-source-friendly remote desktop option
        
    - Lightweight
        
    - Free
        
    - Can be self-hosted
        
    - Good when you want more control over your data
        
- **Apache Guacamole**
    
    - **FOSS**
        
    - **Self-Hosted:** browser-based remote desktop gateway
        
    - Supports **RDP, VNC, and SSH**
        
    - Good for homelabs, sysadmins, and controlled infrastructure
        
    - No special client app needed on the computer you are connecting from
        
    - More setup than Google Remote Desktop
        
- **xrdp**
    
    - **FOSS**
        
    - Best for Linux boxes that you want to access using **RDP**
        
    - Lets a Linux machine accept Remote Desktop connections
        
    - Works with Windows Remote Desktop, Remmina, Thincast, Guacamole, and other RDP clients
        
    - Usually requires a Linux desktop environment like XFCE, MATE, or similar
        
- **MeshCentral**
    
    - **FOSS**
        
    - Good for self-hosted remote device management
        
    - Supports unattended access
        
    - Good for managing multiple machines
        
    - Often favored by sysadmins and homelab users
        

## Browser-Based Remote Access Gateway

- **Apache Guacamole**
    
    - **Self-Hosted:** runs as your own remote access web portal
        
    - Best when you want one browser-based dashboard for multiple machines
        
    - Can access RDP, VNC, and SSH from the browser
        
    - Good for centralized access to servers and desktops
        
    - Great combo with **xrdp** for Linux desktop access
        

## Linux Boxes / Linux Desktop Remote Access

- **xrdp**
    
    - FOSS
        
    - Best when you want to remote into a Linux desktop using RDP
        
    - Good for Linux VPS, lab machines, or internal servers with a GUI
        
    - More manual setup than Google Remote Desktop
        
- **Apache Guacamole + xrdp**
    
    - Strong self-hosted Linux remote desktop combo
        
    - xrdp runs on the Linux box
        
    - Guacamole provides browser-based access to that Linux box
        
    - Useful when you want remote Linux desktops without installing a client app on every device
        

## RDP / Windows-Style Remote Desktop

- **Thincast Remote Desktop Client**
    
    - Good RDP client
        
    - Useful when your environment already uses RDP
        
    - Good for connecting to Windows desktops, virtual apps, remote desktop servers, or Linux machines running xrdp
        
    - **Self-Hosted:** fits well into self-hosted RDP-style infrastructure, especially when you control the remote desktop servers yourself
        
    - More of an RDP client/infrastructure tool than a simple remote-support tool
        
- **xrdp**
    
    - Good on the Linux server side
        
    - Lets Linux accept RDP connections
        
    - Pairs well with Thincast, Remmina, Windows Remote Desktop, or Guacamole
        

## Quick Client-Based Support

- **RemotePC**
    
    - Good for easy personal/family support
        
    - Friendly enough for non-technical users
        
    - Good for occasional troubleshooting
        
    - Easier than setting up a full self-hosted stack
        
- **HelpWire**
    
    - Good for quick support sessions
        
    - Free alternative
        
    - Uses quick, unique session connections
        
    - Does not require full unattended-access setup
        
    - Good when helping a client, friend, or coworker temporarily
        
- **TeamViewer**
    
    - Very well-known for client support
        
    - Easy for non-technical users
        
    - Good for attended support and remote troubleshooting
        
    - **Downside:** expensive compared with many alternatives
        
- **AnyDesk**
    
    - Easy to install and use
        
    - Good for quick remote support
        
    - Lighter-feeling alternative to TeamViewer for many users
        
    - **Caution as of October 2025:** file transfer can be slow in some setups
        

## Enterprise Device Management (MDM)

Fleet management is different from remote desktop. MDM configures, patches, and secures many devices; remote desktop is for interactive support on one machine.

- **Jamf Pro / Jamf Now**
    
    - Apple device management for Mac, iPhone, iPad
        
    - Enrollment, app deployment, FileVault, wipe/lock
        
    - See [[__ PRIMER - Jamf Product Suite]] and [[Directory - Device Management Tools]]
        
- **Microsoft Intune**
    
    - Windows-first; also manages Mac and mobile
        
    - Pairs with Autopilot and Entra ID
        
    - See [[Corporate - Microsoft Intune]]
        
- **Kandji / Mosyle / Addigy**
    
    - Mac-native MDM alternatives
        
    - See [[__ REFERENCE - Apple MDM Alternatives (Kandji, Mosyle, Addigy, Intune)]]

## Enterprise or IT Management (Remote Access)

- **Action1**
    
    - Good for IT management
        
    - Supports unattended access
        
    - Useful when managing multiple machines
        
    - More business/IT focused
        
- **MeshCentral**
    
    - **FOSS**
        
    - Good for enterprise, IT, or homelab use
        
    - Supports unattended access
        
    - Good for managing many machines
        
    - Self-hostable
        
- **Apache Guacamole**
    
    - **FOSS**
        
    - **Self-Hosted:** centralized access portal for RDP, SSH, and VNC
        
    - Useful for controlled environments
        
    - Good when you want browser-based access without installing remote clients everywhere
        
- **xrdp**
    
    - **FOSS**
        
    - Good for Linux desktop access over RDP
        
    - Works well inside an IT/admin setup when combined with VPN, Guacamole, or internal network access
        
- **TeamViewer**
    
    - Strong commercial remote support platform
        
    - Good for organizations that want polished support workflows
        
    - Good brand recognition and easy client onboarding
        
    - **Downside:** expensive, especially compared with FOSS tools or lower-cost paid tools
        
- **AnyDesk**
    
    - Commercial remote support option
        
    - Easier to deploy than self-hosted tools
        
    - Useful for remote access and quick support
        
    - **Downside:** file transfer can be a weak point, especially for larger files
        
- **Thincast**
    
    - Good for enterprise RDP environments
        
    - Useful for virtual desktops, remote apps, and Windows/Linux RDP systems
        
    - **Self-Hosted:** fits best when you are building or managing your own RDP/remote desktop infrastructure
        
    - Client-side RDP tool rather than a full remote-support platform