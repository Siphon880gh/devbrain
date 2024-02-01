CentOS 6.1:

`vmstat` (virtual memory statistics) is a system monitoring command used in Unix-like systems, including Linux, to report information about processes, memory, paging, block IO, traps, and CPU activity. The command `vmstat` followed by a number specifies the delay between each update.

Continuously monitor how much memory used on CentOS 6.1
```
vmstat 1
```


- **Free Memory:** This is the amount of physical memory that's available for new processes to use. It's not being used by any processes right now.

![](https://i.imgur.com/ZHcoiKI.png)

^bo shows mostly 0 but every 10th row shows 12. That suggests a pattern in disk write activity that's not constant but has periodic bursts. With such low 12 blocks per operation periodically, it's likely normal behavior of your os or server. If it had used up much memory, you'd use iostat, iotop, strace, or perf to investigate the events related to disk I/O.

`vmstat` (virtual memory statistics) is a command-line utility that provides information about system processes, memory, paging, block IO, traps, and CPU activity in real-time. It helps in monitoring a system's performance and identifying bottlenecks. The output of `vmstat` can be a bit cryptic if you're not familiar with it. Below, I'll explain the typical columns you'll see in the output of `vmstat`:

1. **Procs (Processes)**
   - `r`: The number of processes waiting for runtime.
   - `b`: The number of processes in uninterruptible sleep.

2. **Memory**
   - `swpd`: The amount of virtual memory used.
   - `free`: The amount of idle memory.
   - `buff`: The amount of memory used as buffers.
   - `cache`: The amount of memory used as cache.

3. **Swap**
   - `si`: Amount of memory swapped in from disk (/s).
   - `so`: Amount of memory swapped to disk (/s).

4. **IO (Input/Output)**
   - `bi`: Blocks received from a block device (blocks/s).
   - `bo`: Blocks sent to a block device (blocks/s).

5. **System**
   - `in`: The number of interrupts per second, including the clock.
   - `cs`: The number of context switches per second.

6. **CPU (These are percentages of total CPU time)**
   - `us`: Time spent running non-kernel code. (user time, including nice time)
   - `sy`: Time spent running kernel code. (system time)
   - `id`: Time spent idle. Prior to Linux 2.5.41, this included IO-wait time.
   - `wa`: Time waiting for IO. (Since Linux 2.5.41)
   - `st`: Time stolen from a virtual machine. Present only in environments that use a hypervisor to distribute CPU time between virtual machines.

The output from `vmstat` provides a snapshot of the system's state at the moment of execution, but it can be run with additional parameters to update this information at regular intervals or to modify the level of detail provided.

For example, running `vmstat 1` will update and display system performance information every second.

It's a powerful tool for diagnosing system performance issues and understanding how the system resources are being used.


---


On mac, the equivalent is:
```
vm_stat 1
```

- **Pages free**: The amount of memory that is currently unused and available.
- **Pages active**: Memory that is currently in use and contains actively accessed data.
- **Pages inactive**: Memory that contains data that has not been accessed recently.
- **Pages speculative**: Memory that is reserved for potential future use but does not yet contain data.
- **Pages wired down**: Memory that cannot be moved to disk and must stay in RAM. This includes memory used by the kernel and certain system structures.

A page is a fixed-length contiguous block of virtual memory. The size of a page can vary, but on many systems, it is typically 4 KB (kilobytes).


But you might find the header titles wiped out, so you can run this - which delegates the 1 second refreshes to while loop rather than vm_stat:
```
while true; do echo "procs -----------memory---------- ---swap-- -----io---- --system-- -----cpu-----"; echo "r  b   swpd   free   buff  cache   si   so    bi    bo   in   cs us sy id wa st"; vm_stat; sleep 1; done;
```

![](https://i.imgur.com/5ggdnek.png)

^The equivalent of 55,163 pages in kilobytes, assuming a page size of 4 KB, is 220,652 KB. ​

---

Mac Memory's Pages?

The use of page units in `vm_stat` and similar tools is primarily due to the way operating systems manage memory at a low level. Here are a few reasons why memory statistics are often expressed in pages rather than bytes or gigabytes:

1. **Page-based Memory Management**: Modern operating systems manage memory in pages, which are fixed-size blocks. This approach simplifies memory allocation, deallocation, and access, making it easier to manage virtual memory, implement paging algorithms, and handle page faults efficiently.

2. **Efficiency and Performance**: Working with pages allows the operating system to efficiently manage memory resources and perform operations like swapping (moving pages between RAM and disk) and memory mapping (mapping file contents directly into the virtual address space of a process) more effectively.

3. **Hardware Support**: Hardware architectures and memory management units (MMUs) are designed to work with pages. They use page tables to map virtual addresses to physical memory addresses, and these operations are inherently page-oriented. By using page units, `vm_stat` aligns with the underlying hardware mechanisms.

4. **Abstraction and Uniformity**: Expressing memory usage in pages provides a level of abstraction over the actual physical memory size. It allows the operating system to present a consistent view of memory management that is not tied to the specific byte size of RAM installed in the system. This abstraction is useful for developers and system administrators when monitoring and optimizing system performance.

5. **Precision and Granularity**: Using pages as the unit of measurement gives a more precise and granular view of memory usage. Since operations like allocation and swapping are performed on a per-page basis, reporting in pages accurately reflects the actual memory management activities of the system.

While expressing memory in bytes or gigabytes might be more intuitive for understanding the overall size of RAM or files, using pages in `vm_stat` and other system tools provides insights that are more aligned with the operating system's internal memory management practices and the needs of professionals who are tuning and troubleshooting system performance.