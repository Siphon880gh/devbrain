XenOrchestra is designed to work with XenServer (now known as Citrix Hypervisor) or its open-source variant, XenServer-NG (XCP-ng). It does not natively support direct management of Xen (the hypervisor) itself without one of these platforms.

With a goal to create VMs as VPS on dedicated servers, I have Xen installed but I dont have Xen-ng or XenServer. I want to do things free. But I want a GUI or online GUI. I have no access to the physical server in order to insert USB boot devices. What's next?
Prerequisite: Xen
Prerequisite:  Xen-NG or XenServer 
XenServer is not free
XCP-ng requires an ISO installation via a USB boot device, which involves physical access to the server (something you don't have)

So, in summary, XenOrchestra cannot directly manage Xen alone; you need XenServer or XCP-ng as an intermediary.