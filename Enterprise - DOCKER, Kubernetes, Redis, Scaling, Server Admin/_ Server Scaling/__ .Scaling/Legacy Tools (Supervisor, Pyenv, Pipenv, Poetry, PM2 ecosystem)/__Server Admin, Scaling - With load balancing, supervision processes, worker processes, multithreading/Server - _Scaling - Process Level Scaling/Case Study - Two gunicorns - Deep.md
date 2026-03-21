
## Basics

\<
Lets say I have 8 cores. I am running two gunicorns consistently. First gunicorn is for video generation which is cpu intensive. Second gunicorn is for API which is more I/O bound workload. What should be the workers, thread, worker-connections, max-requests, that I pass into gunicorn? Im using gevent worker-class


\>
Given your setup with 8 CPU cores, running two Gunicorn instances, one for a CPU-intensive video generation task and the other for an I/O-bound API, here’s a suggested configuration:

### 1. **Video Generation Gunicorn (CPU-Intensive)**

- **Worker Class**: Gevent (as you're using it)
- **Workers**: Since this is CPU-intensive, you want to maximize CPU utilization:
  \[
  \text{Workers} = (\text{CPU Cores} / 2) \times 2 + 2 = (8 / 2) \times 2 + 2 = 10
  \]
  But since you're sharing the cores with another process, consider using half of the cores:
  \[
  \text{Workers} = (4 \times 2) + 2 = 10
  \]
  You may adjust this down slightly if you notice the system becoming CPU-bound.
- **Threads**: Generally, keeping threads to 1 is optimal for CPU-bound tasks, as adding more threads could introduce unnecessary context switching.
- **Worker Connections**: Since this is CPU-intensive, focus on the CPU, so keep this low (e.g., 100).
- **Max Requests**: You can leave this at the default or set a low number (e.g., 1000) if you want to prevent memory leaks.

### 2. **API Gunicorn (I/O-Bound)**

- **Worker Class**: Gevent
- **Workers**: You can allocate the remaining cores here:
  \[
  \text{Workers} = (4 \times 2) + 2 = 10
  \]
- **Threads**: Since this is I/O-bound, consider using more threads. You can start with 2-4 threads per worker.
- **Worker Connections**: Gevent can handle many connections, so a higher number is fine here (e.g., 1000).
- **Max Requests**: Set this to prevent memory leaks (e.g., 1000-5000).

### Summary Configuration

**Video Generation Gunicorn (CPU Intensive):**
```bash
gunicorn -w 10 --threads 1 --worker-connections 100 --max-requests 1000 --worker-class gevent app:app
```

**API Gunicorn (I/O Bound):**
```bash
gunicorn -w 10 --threads 4 --worker-connections 1000 --max-requests 1000 --worker-class gevent app:app
```

### Additional Considerations:
- **Monitoring**: Monitor the CPU and memory usage to adjust these settings as needed.
- **Worker Connections**: You may need to tweak `worker-connections` for the API service based on the number of simultaneous connections you expect.
- **Max Requests**: Adjusting `max-requests` can help mitigate potential memory leaks, especially in long-running processes.

These settings should give you a good starting point. Adjust based on the specific load and performance characteristics of your application.

---

## But proportional to usage

Since the video generation can take upwards to 4 mins for 4 min long videos... and the app is only a few pages to get to the video generation part.. should I allocate slightly more workers to video generation gunicorn? Maybe (6 x 2)+2=14?

Given the long processing time for video generation and the relative simplicity of the app leading to it, allocating slightly more workers to the video generation Gunicorn makes sense.

Video Generation Gunicorn (CPU Intensive):**
```bash
gunicorn -w 14 --threads 1 --worker-connections 100 --max-requests 1000 --worker-class gevent app:app
```

**API Gunicorn (I/O Bound):**
```bash
gunicorn -w 6 --threads 4 --worker-connections 1000 --max-requests 1000 --worker-class gevent app:app
```


---

## And looked at the threads per core

I ran `lscpu` and saw it's 8 threads per core!

\<
I just found out that my 8 cores.. is 8 threads per core. How to calculate gunicorn's workers, threads, worker connection? I know the old formula was physical cores x2 plus 2. Remember two gunicorns are running on the same computer

### Key Points:

- **Logical Cores**: You have a total of 64 logical cores (8 physical cores × 8 threads).
- **Worker Calculation**: The original formula (`CPU cores × 2 + 2`) was designed for physical cores, but with hyper-threading, you can still use it as a baseline and then tweak based on performance testing.
- **Caveat**: If your CPU-bound process is saturating the CPU, the I/O-bound process might experience slowdowns. Monitoring tools like `htop` or `top` can help you keep track of CPU and memory usage, allowing you to adjust the worker counts if necessary.


- A good rule of thumb is to leave around **20-25% headroom** of the total logical cores to prevent excessive context switching and ensure smooth performance. This margin helps accommodate system processes, background tasks, and any potential spikes in workload.
- At 64 total logical cores. The combined total of 22 workers from the video generation Gunicorn and 29 workers from the API Gunicorn equals 51 workers which leaves around 20% headroom of the 64 total logical cores.

### **1. Video Generation Gunicorn (CPU-Intensive)**
- **Threads**: For CPU-bound tasks, adding more threads per worker generally doesn’t add much benefit since these tasks need direct CPU time. Sticking to 1 thread per worker is still advisable to avoid unnecessary context switching, overhead from multiple threads and CPU contention (multiple processes or threads competing for limited CPU resources when the total demand for CPU time exceeds available capacity, leading to inefficiencies as the CPU switches between tasks).
  
  **Recommendation**:
	- **Workers**: 20-22
	- **Threads**: 1 (since it’s CPU-intensive)
  
  **Command**:
  ```bash
  gunicorn -w 22 --threads 1 --worker-connections 100 --max-requests 1000 --worker-class gevent app:app
  ```

### **2. API Gunicorn (I/O-Bound)**
- **Threads**: Since this is I/O-bound, more threads per worker can be beneficial. Threads allow a worker to handle multiple I/O-bound tasks simultaneously, taking advantage of the fact that many I/O operations (e.g., waiting for a database response) don’t require CPU time.
  
  **Recommendation**:
	- **Workers**: 24-29
	- **Threads**: 4-7 (to efficiently handle I/O operations)
  
  **Command**:
  ```bash
  gunicorn -w 29 --threads 7 --worker-connections 2000 --max-requests 1000 --worker-class gevent app:app
  ```

### Summary of Thread Configuration:

- **Video Generation Gunicorn**: Keep threads low (1 thread per worker) since it's CPU-bound.
- **API Gunicorn**: Use more threads (4-8 threads per worker) to handle multiple I/O tasks efficiently.

This configuration strikes a balance between leveraging physical cores and taking advantage of hyper-threading for I/O-bound workloads without overloading the CPU.