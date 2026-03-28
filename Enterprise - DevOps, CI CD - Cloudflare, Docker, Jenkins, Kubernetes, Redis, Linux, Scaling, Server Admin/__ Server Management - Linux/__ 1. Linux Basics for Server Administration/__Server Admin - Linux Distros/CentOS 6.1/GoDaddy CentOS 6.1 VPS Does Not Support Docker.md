
## Reason 1
CentOS 6.1 and docker
CentOS 6.1 only supports the old Docker
Docker removed older version from most package manager repos that supports. 
Docker’s newer versions post 2020 support CentOS 7 and 8 only
But upgrading from CentOS 6.1 to CentOS 7 is not supported.

---

## Reason 2
There is one place you could find a CentOS 6.1 compatible Docker  1.7.1, but this will ultimately fail because GoDaddy’s CentOS 6.1 outdated VPS don’t have the right kernel modules (kernel code) and I'm not allowed to modify it when asking Customer Support

Here is the old Docker 1.7.1
```
rpm -iUvh https://get.docker.com/rpm/1.7.1/centos-6/RPMS/x86_64/docker-engine-1.7.1-1.el6.x86_64.rpm
```
^ Who knows if it would be removed in the future. 

You’ll find you need libcgroup when the docker installation fails so you install that too
```
wget https://vault.centos.org/6.6/os/x86_64/Packages/libcgroup-0.40.rc1-12.el6.x86_64.rpm  
  
sudo rpm -ivhf libcgroup-0.40.rc1-12.el6.x86_64.rpm
```  

  
If needed, this will install the version of `libcgroup` that is available in the CentOS 6 repositories, which is typically compatible with the older versions of Docker like 1.7.1.
```
sudo yum install -y libcgroup
```
^ CentOS uses both rpm and yum for managing packages. RPM is low level. YUM is high level that includes figuring out dependencies for you.

Now when you try to run the service with
```
sudo service docker start
```


You get this error
```
Starting cgconfig service: Error: cannot mount cpuset to /cgroup/cpuset: Permission denied

/sbin/cgconfigparser; error loading /etc/cgconfig.conf: Cgroup mounting failed

Failed to parse /etc/cgconfig.conf or /etc/cgconfig.d      [FAILED]

Starting docker: ∂                                  [  OK  ]
```
`

It said ok starting dock after it failed, but that’s a lie and it caused a deadlock because a file that’s not supposed to be running is now on read-only. Between fix attempts had to remove the deadlock file. So you manually remove with
```
sudo rm /var/lock/subsys/docker
```

The error mentions Cgroup

Croup is using kernel modules my system doesn’t have enabled (specifically, ip_nat, ip_conntrack, and iptables kernel module), so u have to reconfigure kernel source code then recompile. 

However my current cent is t.2 us a special patched kernel (actually Virtuozzo containers which is a virtualization technology) that GoDaddy won’t provide source code to (I asked).

Background: ip_nat and ip_conntrack are for NAT and connection server.
Background: 
- A kernel module, often referred to simply as a module, is a piece of code that can be loaded into the kernel of an operating system on demand, without necessarily rebooting the system
- The kernel is the core component of an operating system. It acts as a bridge between applications and the actual data processing done at the hardware level. The kernel's responsibilities include managing the system's resources (like the CPU, memory, and disk space) and allowing software and hardware to communicate with each other.