You have a web app that connects to api to send data back and forth from a video generator and database. You broke the app into two microservices: API and video generator script.

Set gunicorn worker processes and threads in sh files. You have two sh files running: sh file #1 runs the video generator, and sh file #2 runs the api. Here are the gunicorn settings for reach sh file:

### **1. Video Generation Gunicorn (CPU-Intensive)**

- **Threads**: For CPU-bound tasks, adding more threads per worker generally doesn’t add much benefit since these tasks need direct CPU time. Sticking to 1 thread per worker is still advisable to avoid unnecessary context switching, overhead from multiple threads and CPU contention (multiple processes or threads competing for limited CPU resources when the total demand for CPU time exceeds available capacity, leading to inefficiencies as the CPU switches between tasks).

  **Recommendation**:
 - **Workers**: 20-22
 - **Threads**: 1 (since it’s CPU-intensive)

  **Command**:
```
gunicorn -w 22 --threads 1 --worker-connections 100 --max-requests 1000 --worker-class gevent app:app  
```
  

### **2. API Gunicorn (I/O-Bound)**

- **Threads**: Since this is I/O-bound, more threads per worker can be beneficial. Threads allow a worker to handle multiple I/O-bound tasks simultaneously, taking advantage of the fact that many I/O operations (e.g., waiting for a database response) don’t require CPU time.

  **Recommendation**:
 - **Workers**: 24-29
 - **Threads**: 4-7 (to efficiently handle I/O operations)

  **Command**:
```
gunicorn -w 29 --threads 7 --worker-connections 2000 --max-requests 1000 --worker-class gevent app:app
```

---

Prompt description: Get your machine’s CPU cores, how many threads per core, how much memory, then talk about the microservices and ask for their gunicorn workers, threads, worker-connections, max-requests. Remind it to calculate the logical cores with core count x threads, then give 20-25% overhead to the cpu.