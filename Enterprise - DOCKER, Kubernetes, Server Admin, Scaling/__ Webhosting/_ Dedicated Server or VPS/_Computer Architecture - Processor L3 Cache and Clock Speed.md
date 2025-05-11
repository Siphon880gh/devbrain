Purpose of the cache in the CPU/GPU is so that data can be accessed closer to the processor chip rather than accessed in the slower RAM. 

When data is found at the processor's cache, it's a cache hit, and it's fast retrieval. If the data is not found there, it's a cache miss, and it must be fetched from a lower level of the memory hierarchy (e.g., from RAM) and that's slower.

Having a large L3 cache is something you want to check when purchasing a new processor chip, rather it's for your dedicated server, or other purposes.

Below discuss the difference between GPU and CPU and their caching
### GPU Cache:
- **Levels of Cache:** GPUs typically have multiple levels of cache, such as L1 and L2 cache (and sometimes L3). These caches are used to store frequently accessed data close to the GPU cores, minimizing the need to access slower main memory (RAM).
- **Purpose:** The primary purpose of the GPU cache is to reduce the latency of memory accesses and improve the throughput of the GPU, especially in parallel processing tasks like rendering or running machine learning models.

### CPU Cache:
- **Levels of Cache:** CPUs also have multiple levels of cache, typically labeled as L1, L2, and L3.
  - **L1 Cache:** This is the smallest and fastest cache, located closest to the CPU cores. It's usually split into separate caches for instructions and data.
  - **L2 Cache:** Larger and slightly slower than L1, L2 cache serves as an intermediary between L1 and L3 cache.
  - **L3 Cache:** Even larger and slower than L2, L3 cache is shared among multiple CPU cores and helps reduce the time needed to access data from RAM.
- **Purpose:** The CPU cache serves a similar purpose as the GPU cache: to store frequently accessed data close to the CPU cores, reducing the time it takes to fetch this data from RAM and speeding up computation.

### Key Differences:
- **Design Focus:** The cache hierarchy in a CPU is often more complex and designed to optimize single-threaded performance, whereas GPU cache systems are optimized for parallel processing and throughput.
- **Size and Latency:** CPU caches, especially L1 and L2, are generally smaller but faster compared to GPU caches, reflecting the different workload characteristics of CPUs (which often require fast access to a smaller set of data) versus GPUs (which handle large datasets with high parallelism).

In summary, both CPUs and GPUs have their own cache systems, but they are tailored to the specific needs of their respective architectures and the types of tasks they handle.

---

When purchasing a core:

How much L3 cache is in the chip? 
	- Multiple concurrent users generating videos? You need a large L3 cache (Not Intel Xeon CPU E3-1270 v5's)
		- When one user generating video, it's able to work in cache more frequently
			- With a larger L3 cache, more data can be stored closer to the GPU cores, reducing the number of cache misses.
		- With multiple users, it work in cache less frequently
			- In summary, with multiple users, the cache is less likely to hold the relevant data for any given user at a given time, reducing its overall effectiveness and leading to more frequent accesses to the slower main memory RAM
		- The memory manager is the slowest component in the CPU and accessing RAM or flushing the cache is another few cycles wasted
			- The memory manager is responsible for managing the flow of data between different levels of memory (e.g., L1, L2, L3 caches, and RAM). When the GPU frequently accesses RAM, the memory manager has to work harder to coordinate these data transfers, manage cache coherency, and ensure efficient use of memory resources. This increased workload can create overhead, indirectly affecting performance.
			- If the L3 cache is larger, it can store more frequently accessed data, reducing the need to access the slower RAM.
			- A larger L3 cache may also reduce the frequency of cache flushes, as it can hold more data before needing to evict older data to make room for new data.
			- Eg. Intel Xeon CPU E3-1270 (Q4 2015 release) has 8MB L3 cache shared among the cores


---

Sizes of cache

L1 and L2 are very small sizes and are close to the CPU. They are per Core.
L3 are shared among the Cores.

![](mdjer2g.png)
^ The above from https://teivah.medium.com/go-and-cpu-caches-af5d32cc5592


Also from that webpage:
"The closer a cache is to a CPU core the smaller is its access latency and size:"

L1 access takes ~ 1-3 cycles for any operation (read or write) and is sized between 32 KB and 512 KB. If the CPU is 4.7GHZ, each clock cycle taking ~.213 nanoseconds (if CPU clock speed 4.7 GHz)

L2 access takes ~ 4-12 cycles for any operation (read or write), and is sized between 128 KB and 24 MB, each clock cycle taking 0.213 nanoseconds (if CPU clock speed 4.7 GHz)

L3 access takes ~ 10-40 for any operation (read or write), and is sized between 2 MB and 32 MB, each clock cycle taking 0.213 nanoseconds (if CPU clock speed 4.7 GHz)


For example:
- If the L1 cache has a latency of 3 cycles, then at 4.70 GHz, it would take approximately 3 cycles to retrieve data, meaning it happens very quickly within the billion cycles the CPU performs each second.
- The faster the clock speed, the shorter the actual time (in nanoseconds) each cycle takes, but the number of cycles required to access each cache level is determined by the cache's latency, not by the clock speed itself.

Cache latency is the number of CPU clock cycles required to access data from a specific level of cache. The exact latency can vary depending on the specific CPU architecture. (CPU architecture is how bits are stored and manipulated, how the CPU processes instructions (eg. add two registers aka temp storage locations within CPU), handles data, and communicates with other system components - RAM, Storage Device HDD/SSD, etc)
