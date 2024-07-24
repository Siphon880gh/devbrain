
Aka Docker in Docker (DinD)

For example: I have a task that itself runs inside Docker container, what that means is that I need Docker in Docker in order to run CI job.  So I’m doing Docker in Docker and what I'm getting as output here is: `Devices cgroup isn't mounted`   
^ From: [https://github.com/concourse/docker-image-resource/issues/93](https://github.com/concourse/docker-image-resource/issues/93)  
  

The error message `Devices cgroup isn't mounted` typically appears when Docker tries to access certain kernel features that aren't available because the container doesn't have the necessary privileges.  For example, using mount and umount.

  

To solve this, running a container in privileged mode would grants it all the capabilities of the host machine, effectively removing the restrictions imposed by the container environment. This approach is often necessary for Docker in Docker setups, especially when the inner Docker needs to manage other containers or perform tasks that require more than basic container capabilities.

  

To fix this, you run a variation of this command:
```
docker run -it --privileged=true my-image.
```

---

Why is the error referring to cgroup?

  
Background:
![](https://i.imgur.com/kAcVC2b.png)
^ From: [https://medium.com/@boutnaru/linux-cgroups-control-groups-part-1-358c636ffde0](https://medium.com/@boutnaru/linux-cgroups-control-groups-part-1-358c636ffde0)

Cgroup stands for control groups.

Cgroups allow you to allocate resources — such as CPU time, system memory, network bandwidth, or combinations of these resources — among user-defined groups of tasks (processes) running on a system. You can monitor the cgroups you configure, deny cgroups access to certain resources, and even reconfigure your cgroups dynamically on a running system. The `cgconfig` (_control group config_) service can be configured to start up at boot time and reestablish your predefined cgroups, thus making them persistent across reboots.
^ From: https://docs.redhat.com/en/documentation/red_hat_enterprise_linux/6/html/resource_management_guide/ch01