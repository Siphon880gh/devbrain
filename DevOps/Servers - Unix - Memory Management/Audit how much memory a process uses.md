
```
ps aux | grep USER; ps aux | grep processName
```

When you run these commands, you have three important memory information
- `%MEM`: Represents the percentage of physical memory that each process is using. 
- `VSZ`: Virtual memory size of the process in KiB (kibibytes).
- `RSS`: Resident Set Size, the non-swapped physical memory the process has used, in KiB.

### Resident Set Size (RSS)

- **What it represents**: RSS is the portion of a process's memory that is held in RAM. This includes both the memory it has explicitly requested (e.g., via `malloc` in C) and any additional space the operating system requires for administrating the process itself. Importantly, RSS does not include memory that has been swapped out to disk.
- **Units**: RSS is typically measured in kilobytes (KB).
- **Why it's important**: RSS gives you a snapshot of how much physical memory is being actively used by a process. If a process's RSS value is very high, it indicates that the process is using a significant amount of RAM. This can be particularly relevant in systems with limited memory resources, as a high RSS value could lead to memory pressure, causing the system to swap more aggressively, which in turn can degrade overall system performance.

### Virtual Memory Size (VSZ)

- **What it represents**: VSZ is the total amount of virtual memory that a process has access to. This includes all the memory the process can access, including code, data, libraries, and memory that has been swapped out or that is mapped but not used. Virtual memory combines physical RAM with space on the disk that is set aside for temporary storage (swap space) to give processes more memory than might physically be available.
- **Units**: VSZ is also typically measured in kilobytes (KB).
- **Why it's important**: VSZ gives you an overview of the total potential memory footprint of a process. However, because it includes all memory that a process can access, regardless of whether it's currently in use or even necessary, VSZ can sometimes be a misleading indicator of the actual memory pressure a process places on the system. For example, a process may have mapped a large file into its address space without actually reading it into RAM, which would increase its VSZ without affecting its actual use of physical memory.

### Comparing RSS and VSZ

- **RSS vs. VSZ**: RSS is generally a better indicator of the actual memory pressure a process is exerting on the system at any given time because it reflects actual usage of physical RAM. VSZ, on the other hand, can give insight into the potential maximum demand a process could place on the system's memory resources but may not accurately reflect current usage.
- **Interpretation**: High RSS values indicate high physical memory usage, which could impact system performance if RAM becomes scarce. A high VSZ value, especially when significantly larger than RSS, indicates that a process has a large virtual address space; however, it does not necessarily mean the process is heavily using physical memory resources.

Understanding both RSS and VSZ can help in diagnosing memory-related performance issues and in planning for adequate memory resources for applications.