
There are multiple levels of scaling your server for traffic, load, and computation. There are also strategies:
- Process level scaling
- Thread level scaling
- Async level scaling
- Horizontal scaling including Load balancer (more ports or more servers or more secondary drives)
- Vertical scaling (upgrading hardware)

"The basics of scaling is just increase instance and increase gunicorn worker. There are also many forms of scaling depending on your bottlenecks. Usually the first bottleneck is the db, then you add cache and etc."

For example, increasing the number of instances generally refers to adding more instances of the application to handle more traffic. When using Supervisor, this can be done by increasing the `numprocs` parameter in the Supervisor configuration file. The `numprocs` setting determines how many instances of the specified program should be started.

Here is an example of how you might configure this in your Supervisor configuration file:

```ini
[program:your_program_name]
command=path_to_your_application
autostart=true
autorestart=true
numprocs=5  ; This starts 5 instances of your application
process_name=%(program_name)s_%(process_num)02d
```

By increasing the `numprocs` value, you are effectively increasing the number of instances of your application running under Supervisor's control. But keep in mind that each process has to listen to a different port using an upstream block in nginx to perform load balancing OR have each process listen to different Unix socket (sock files) then configure Nginx to route traffic to these sockets. That's all load balancing aka scaling horizontally. Refer to other guide..

Additionally, increasing the number of Gunicorn workers is another way to handle more traffic. This is more process level scaling. This can be done by adjusting the `workers` parameter when starting Gunicorn:

```bash
gunicorn -w 4 your_app:app
```

In this example, `-w 4` starts Gunicorn with 4 worker processes.

In summary, increasing instances in Supervisor is done by adjusting the `numprocs` setting, while increasing Gunicorn workers is done by adjusting the `workers` parameter. Both methods help to scale your application to handle more traffic.

Refer to Gunicorn guides because there's more involved like asynchronous options and multithreading. This is asynchronous scaling and thread-level scaling

Still refer to the guide if performing worker processes because there's also technical scenarios and math involved in figuring out the number of worker processes.

---

You can monitor your server performance then there might come a point you have to upgrade your memory, add secondary slave harddrives, upgrade bandwidth, etc

---

### **Process-Level Scaling (Increasing Workers):**
    
    - **Advantages:** Easy to set up, improves concurrency, and can effectively utilize multiple CPU cores.
    - **Limitations:** Limited by the number of CPU cores and can lead to higher memory usage since each worker is a separate process.

### **Thread-Level Scaling:**
    
    - Involves increasing the number of threads within a process. Each thread can handle a request concurrently, sharing the same memory space.
    - **Advantages:** Lower memory overhead compared to processes, better for I/O-bound tasks.
    - **Limitations:** Threads share the same memory space, which can lead to concurrency issues and is limited by Python's Global Interpreter Lock (GIL) in CPython.

### **Asynchronous Scaling:**
    
    - Uses asynchronous programming models (e.g., async/await in Python) to handle many concurrent I/O-bound operations in a single process.
    - **Advantages:** Efficiently handles a large number of I/O-bound tasks with low memory overhead.
    - **Limitations:** More complex to implement and debug, not suitable for CPU-bound tasks.

### Horizontal Scaling

**Definition:** Horizontal scaling (also known as scaling out) involves adding more instances (servers, machines, or nodes) to your infrastructure to handle an increased load.

**Characteristics:**

1. **Adding More Units:**
    
    - Increase the number of servers or instances in your system.
    - Each unit can handle a portion of the total load.
2. **Fault Tolerance:**
    
    - Improved fault tolerance and redundancy because if one instance fails, others can continue to handle the load.
    - Easier to achieve high availability.
3. **Cost:**
    
    - May involve higher initial costs because you need more hardware or cloud instances.
    - Often more cost-effective in the long run due to better resource utilization.
4. **Complexity:**
    
    - Requires a load balancer to distribute traffic across multiple instances.
    - More complex to manage, as it involves synchronizing data and ensuring consistency across instances.
5. **Elasticity:**
    
    - Easier to scale dynamically based on demand.
    - Can quickly add or remove instances in cloud environments.
6. **Example:**
    
    - A web application running on multiple servers behind a load balancer.

### Vertical Scaling

**Definition:** Vertical scaling (also known as scaling up) involves adding more power (CPU, RAM, storage) to an existing server or instance to handle an increased load.

**Characteristics:**

1. **Adding More Resources:**
    
    - Increase the capacity of a single server by adding more CPU, RAM, or storage.
    - Enhances the performance of a single instance.
2. **Fault Tolerance:**
    
    - Limited improvement in fault tolerance. If the single upgraded instance fails, the entire system could be affected.
    - Single point of failure remains a concern.
3. **Cost:**
    
    - Can be more cost-effective initially, as it avoids the need for additional hardware or instances.
    - Hardware upgrades can become increasingly expensive, and there are limits to how much you can scale vertically.
4. **Complexity:**
    
    - Simpler to manage since it involves only one server or instance.
    - No need for load balancers or complex data synchronization.
5. **Elasticity:**
    
    - Less flexible compared to horizontal scaling.
    - Upgrading hardware or instance types can be time-consuming and may require downtime.
6. **Example:**
    
    - Upgrading the CPU and RAM of a database server to improve performance.

### When to Use Each Strategy

**Horizontal Scaling:**

- Suitable for applications with a high number of concurrent users or requests.
- Ideal for distributed systems, web servers, and microservices.
- Provides better fault tolerance and redundancy.

**Vertical Scaling:**

- Suitable for applications with high resource demands that cannot be easily distributed, such as databases.
- Ideal when simpler management and lower initial costs are important.
- Practical up to the point where hardware limitations are reached.