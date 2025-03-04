
**Worker processes and threads**
The part of the app that generates the video (Python using MoviePy/ffmpeg) is CPU bound and I increased the worker processes on that. 

The API part where the user waits for the video to generate, because there's concurrency, I keep the worker processes the same number of CPU cores but added multithreading


Reworded:
It sounds like you've implemented a thoughtful approach to handle the different requirements of video generation and API responsiveness. By increasing the worker processes for the CPU-bound video generation, you're ensuring that multiple video processing tasks can be handled concurrently. For the API part, adding multithreading to the worker processes helps manage the concurrent user requests effectively without overloading the CPU.


You set the worker processes and threads at the **gunicorn** command options.

---

In the future instead of a request taking so long to send a response (the generated video's url) back to the web app, I'll use SSE or web sockets

---

And best these parts are different **microservices** (like two groups of gunicorns if python flask servers or python scripts)