
## Why Gunicorn

<< If unicorn is set to 4, does that mean someone can use my script 4 times concurrently?

\>>
I you've set "unicorn" to 4 in your script or server configuration, it generally means that your application can handle 4 concurrent requests or users at the same time. Each "unicorn" worker would handle one request at a time, so with 4 workers, you can serve 4 requests concurrently. This setup is used to increase the responsiveness and throughput of your application.

<< My cpu cores is 2. How many worker processes can I set with unicorn?

\>>
When you have 2 CPU cores, the ideal number of worker processes to set for Unicorn (or any multi-process server) depends on the nature of your application and the workload it handles. However, there are some general guidelines you can follow:

1. **One Worker Per Core**: A common starting point is to have the same number of worker processes as you have CPU cores. This would mean setting Unicorn to 2 workers on a 2-core system. This allows your application to fully utilize the CPU resources without overloading the system with too many processes competing for CPU time.

2. **Consider I/O Wait**: If your application spends a lot of time waiting for I/O (like reading from a disk or network), you might benefit from having more worker processes than CPU cores. This is because while one process is waiting for I/O, another can be processing. However, too many processes can lead to context switching and other overheads that might reduce overall performance.

3. **Memory Constraints**: More worker processes mean more memory usage. Ensure that you have enough RAM to handle the number of worker processes you want to run. If each worker uses a significant amount of memory, running too many could cause your system to start swapping to disk, which will dramatically slow down performance.

4. **Testing and Monitoring**: The best number can vary widely based on your specific application and workload. Start with a number that seems reasonable, then monitor your system's CPU, memory, and response times. Adjust the number of workers as necessary based on your observations.

For a 2-core system, you might start with 2 worker processes and adjust as needed. If your application is mostly I/O-bound, you could experiment with increasing the number to see if it improves performance without exhausting system resources. Always monitor the system's performance and stability as you make changes.


---

## Technical

Make sure gunicorn is installed. Use pip install.

Head’s up: You could run gunicorn -w 6 to spawn 6 process workers, which will instruct Gunicorn to run a Python WSGI HTTP server, which requires a wsgi.py that loads in your app (regardless if it’s Flask app). Reworded: You do not run gunicorn directly on your python script. You have an intermediate script wsgi.

 to spawn 6 worker processes. Each worker is a separate process capable of handling requests independently. This means that your application can handle more concurrent requests because each worker can handle one request at a time.

Here's a brief overview of what happens:

1. **Master Process**: Gunicorn starts a master process.
2. **Workers**: The master process then spawns 6 worker processes as specified by the `-w` flag.
3. **Load Balancing**: The master process listens for requests and assigns them to available worker processes in a load-balanced manner.
4. **Concurrency**: With 6 workers, your application can handle up to 6 concurrent requests. If a seventh request comes in and all workers are busy, it will have to wait until one becomes available.

The number of workers is often set based on the characteristics of the system and the application. A common heuristic used is `2-4 x (number_of_cpu_cores)` to determine the number of workers, but this can vary based on your specific workload and performance requirements. It's important to monitor and tune the number of workers to balance the load and resource utilization effectively. Too few workers might lead to underutilization of your server, while too many might lead to excessive memory usage and context-switching overhead.


Issue: Need more concurrency? Go multithreaded with Unicorn

Background:
You could run gunicorn -w 6 to spawn 6 process workers. If you have synchronous blocking scripts, this is more the reason to do so. However, at each process worker, you can make it multithreaded.

Reworded: Gunicorn's standard workers are synchronous and handle one request at a time per worker. They are not inherently multithreaded. Each worker is a separate process with its own Python interpreter. This means that while you can have multiple worker processes (as set with the `-w` option), each worker process is handling only one request at a time.

However, Gunicorn does support different types of worker classes which can handle requests differently:

1. **Sync Workers (default)**: As mentioned, these handle one request at a time per worker. They are best suited for I/O-bound applications that spend most of their time waiting for external events (like database queries or network calls).

2. **Gevent Workers**: These use the `gevent` library to provide asynchronous, non-blocking IO. They are lightweight and can handle many simultaneous connections. This can be a good choice for applications that make a lot of network requests or need to handle a large number of long-lived connections.

3. **Tornado Workers**: These use the Tornado networking library to handle asynchronous IO and can also handle many simultaneous connections.

4. **Gthread Workers (threaded workers)**: These are a type of worker that spawns threads to handle requests. They allow for concurrency within a single worker by using threads. This means that a single worker process can handle multiple requests at the same time using threads.

To use multithreaded workers, you would set the worker class to `gthread` and configure the number of threads per worker. This is done with the `--worker-class` flag and the `--threads` flag. For example:

```bash
gunicorn -w 4 --worker-class=gthread --threads=4 myapp:app
```

This command would start Gunicorn with 4 worker processes, each capable of running 4 threads to handle requests, allowing up to 16 requests to be handled concurrently.

When choosing a worker type, it's important to consider the nature of your application and the environment it runs in. If your app is I/O-bound and makes a lot of blocking I/O calls, gevent or gthread workers might improve performance. If it's CPU-bound, having multiple synchronous workers might be a better choice. Experimenting and profiling with different configurations will help determine the best setup for your specific case.


---


You run the command
`gunicorn -w 12 -b 0.0.0.0:5001 wsgi:app`
b stands for bind


wsgi is for wsgi.py which is a convention
```
from server import create_app

app = create_app()

if __name__ == "__main__":
    app.run()
```



Which references your actual python script. In this case it's a Flask python script server.py. 


A http Flask (no SSL or https) would be:
```
if __name__ == "__main__":
    try:
        app = create_app()
        app.run(host='0.0.0.0', port=5001,)
    except NameError:
        print("Remote HTTP Flask connection not setup right")
```


---

If https / SSL, a https Flask would normally have to run as:
-- Wrong --
```
import ssl;

ssl_context = ssl.create_default_context(ssl.Purpose.CLIENT_AUTH)

ssl_context.load_cert_chain('/home/etc/ssl/certs/something.crt', '/home/etc/ssl/certs/something.key')

# ...

if __name__ == "__main__":
    try:
        app = create_app()
        app.run(ssl_context=ssl_context, host='0.0.0.0', port=5001)
    except NameError:
        print("Remote HTTPS Flask connection not setup right")

```


**But** when  running gunicorn to https, you must use the http version in your Flask python app, and have your gunicorn be the exclusive one setting up the https. Otherwise it won't port right. See this:

1. Use http version in FLask
2. Move the cert and private key inputs into the gunicorn command
```
gunicorn -w 6 -b 0.0.0.0:5001 --certfile=/home/etc/ssl/certs/something.crt --keyfile=/home/etc/ssl/certs/something.key wsgi:app
```

### Detailed Explanation:

1. **`-b` or `--bind`**: This option tells Gunicorn which network address and port to bind to.
2. **`0.0.0.0`**: This is a special address that binds the server to all available IPv4 addresses on the local machine. It makes the server accessible from any network interface on the host.
3. **`5001`**: This is the port number on which the server will listen for incoming connections.
4. certfile and keyfile is so it's https compatible (which is required nowadays)

---


Gunicorn is not good with error reporting! You can try to squeeze out more errors if any:
`gunicorn -w 12 -b 0.0.0.0:5001 wsgi:app --log-level debug`

But that might not be helpful still. You’ll have to troubleshoot outside of gunicorn.


---

This is how it'll look:
![](https://i.imgur.com/CY4lPHy.png)

You may want to run gunicorn in the background. Supervisor with the right settings can help with running in the background the process that start multiple process workers (and hence run the multiple process workers in the background too). In addition, Supervisor lets you manage turning them on and off based on app name in the command.

---

REWORDED + Multiple instances

When determining the optimal number of instances and workers for your application, you need to balance the load across your available CPU cores to maximize performance and efficiency. Here’s a mathematical approach to configuring instances and workers:

### Understanding the Components

1. **Instances (numprocs in Supervisor):**
   - Each instance represents a separate process managed by Supervisor.
   - Instances can be run on different ports or sockets.

2. **Workers per Instance (Gunicorn workers):**
   - Each worker is a separate process that handles incoming requests.

### Goal

Maximize the use of available CPU cores without overloading the system. The ideal configuration will depend on whether your application is CPU-intensive or I/O-intensive.

### General Guidelines

1. **CPU-Intensive Applications:**
   - For CPU-bound applications, you typically want the number of workers to be equal to or slightly more than the number of CPU cores to fully utilize the CPU.

2. **I/O-Intensive Applications:**
   - For I/O-bound applications, you can afford to have more workers than CPU cores, as they spend a lot of time waiting for I/O operations (e.g., database queries, file I/O).

### Formula

1. **Determine the total number of workers needed:**
   - For non-CPU-intensive (I/O-bound) applications, a common guideline is to use `(2 * CPU cores) + 1` workers.
   - For an 8-core machine, this would be `(2 * 8) + 1 = 17` workers.

2. **Distribute workers across instances:**
   - Decide on the number of instances (`numprocs`) and divide the total number of workers among these instances.
   - Ensure that the total number of workers across all instances does not exceed the calculated number.

### Example Calculation

#### Step 1: Calculate Total Workers

For an 8-core machine, the total number of workers:
\[ \text{Total Workers} = (2 \times 8) + 1 = 17 \]

#### Step 2: Distribute Workers Across Instances

Suppose you choose 4 instances:
- Each instance should then have approximately \(\frac{17}{4} \approx 4.25\) workers.

Since we can only assign whole numbers of workers, you can round down or up, depending on your exact needs. For simplicity, you could configure 4 instances, each with 4 workers (giving you a total of 16 workers, slightly under the calculated 17):

```ini
[program:my_app]
command=gunicorn -w 4 -b 127.0.0.1:%(process_num)5001 my_app:app
autostart=true
autorestart=true
numprocs=4  ; This starts 4 instances of Gunicorn, each with 4 workers
process_name=%(program_name)s_%(process_num)02d
```

### Refinements

- **Adjust Based on Performance:** Monitor the performance of your application and adjust the number of workers and instances as needed.
- **Test Different Configurations:** Different applications and workloads may benefit from different configurations, so it’s a good idea to test a few variations to find the optimal setup.
- **Consider Overheads:** Keep in mind the memory and resource overhead of each worker and instance. Ensure your system has enough memory and resources to handle the configuration.

### Summary

To determine the number of instances and workers:

1. Calculate the total number of workers using \((2 \times \text{CPU cores}) + 1\) for I/O-bound applications.
2. Choose the number of instances (`numprocs`) and divide the total workers among these instances.
3. Adjust and refine based on performance monitoring and resource availability.

For an 8-core machine with a non-CPU-intensive application, a reasonable starting configuration might be 4 instances, each with 4 workers, resulting in a total of 16 workers. Adjustments can be made based on observed performance and system resource utilization.