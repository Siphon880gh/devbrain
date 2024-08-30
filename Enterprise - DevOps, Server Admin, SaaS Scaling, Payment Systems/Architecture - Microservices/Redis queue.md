Redis lets you share persistent state that dont need to be as permanent as Mongo and MySQL. You can share redis between microservices or between api calls or between user sessions

In this example, we share Redis between api calls. This is great for when there's a lot of user traffic and some users need to be queued in line so your system doesn't overload.

We need to install the python redis wrapper and to install redis-queue for a data structure

python’s:
```
pip install rq redis
```
If you’re using pyenv-virtualenv with pipenv: `pipenv install rq redis`  while your shell is in the virtual environment

^ FYI: RQ, or Redis Queue, is a Python library that uses Redis, an in-memory data store, to process tasks asynchronously. RQ is designed to handle tasks that can be defined as Python functions. It's lightweight and offers support for beginners, making it easy to install, use, and manage. With RQ, developers can queue tasks, distribute them across workers, and monitor their progress in real-time.

rq_worker.py:
```
import os  
import redis  
from rq import Worker, Queue, Connection  
  
listen = ['default']  
  
redis_url = os.getenv('REDISTOGO_URL', 'redis://localhost:6379')  
  
conn = redis.from_url(redis_url)  
  
if __name__ == '__main__':  
    with Connection(conn):  
        worker = Worker(list(map(Queue, listen)))  
        worker.work()
```

rq_tasks.py:
```
import time  
  
def see_pic(picture_url):  
    # Simulate video generation process  
    print(f"AI is seeing the picture {picture_url}")  
    time.sleep(10)  
    return f"AI has learned the picture {picture_url}"
```

rq_server.py:
```
from flask import Flask, request, jsonify, Response  
import random  
from rq import Queue  
from redis import Redis  
from rq_tasks import see_pic  
  
app = Flask(__name__)  
  
# Redis - Setup methods  
redis_conn = Redis()  
queue = Queue(connection=redis_conn)  
  
def generate_random_picture_url():  
    base_urls = [  
        "https://picsum.photos/200/300",  
        "https://placekitten.com/200/300",  
        "https://placebear.com/200/300",  
        "https://loremflickr.com/200/300",  
        "https://placeimg.com/200/300/any"  
    ]  
  
    # Select a random base URL from the list  
    random_url = random.choice(base_urls)  
  
    return random_url  
  
# Start job of training AI with a picture. You might want to spam this endpoint to test the enqueue  
@app.route('/testapi/test', methods=["GET"])  
def test():  
    picture_urls = generate_random_picture_url()  
  
    # Enqueue task using a function task and its argument  
    job = queue.enqueue(see_pic, picture_urls)  
  
    return jsonify({'job_id': job.get_id()}), 202  
  
# View status of a job  
@app.route('/testapi/job_status/<job_id>', methods=['GET'])  
def job_status(job_id):  
    job = queue.fetch_job(job_id)  
    if job.is_finished:  
        return jsonify({'status': 'finished', 'result': job.result}), 200  
    elif job.is_queued:  
        return jsonify({'status': 'queued'}), 202  
    elif job.is_started:  
        return jsonify({'status': 'in progress'}), 202  
    else:  
        return jsonify({'status': 'unknown'}), 404  
  
# List all enqueued jobs  
@app.route('/testapi/jobs', methods=['GET'])  
def list_jobs():  
    jobs = queue.jobs  # Get all jobs in the queue  
    jobs_info = [{'id': job.get_id(), 'status': job.get_status()} for job in jobs]  
    return jsonify(jobs_info), 200  
  
# Count the number of jobs  
@app.route('/testapi/job_count', methods=['GET'])  
def job_count():  
    total_jobs = len(queue.jobs)  # Count all jobs in the queue  
    return jsonify({'total_jobs': total_jobs}), 200  
  
if __name__ == '__main__':  
    cert = "/etc/nginx/ssl-certificates/DOMAIN.ai.crt"  
    key = "/etc/nginx/ssl-certificates/DOMAIN.ai.key"  
  
    app.run(debug=True, port=5002, ssl_context=(cert, key))  
```
^ why not have the task inside the server instead of its own module rq_tasks.py?`rq` does not allow functions from the `__main__` module to be enqueued. You’d have gotten error: ValueError: Functions from the `__main__` module cannot be processed by workers:

### Run the Worker

Start the Redis worker using the command:
```
python worker-rq.py
```

### Test Enqueueing

Url may be directly to 5002 if you did not perform reverse proxy (which abstracts away port 5001 from the web browser under the guise of /api or /testapi)


Visit these endpoints in the web browser (after adjusting their final URLs based on your environment or server) in the order it’s presented
```
https://DOMAIN.ai/testapi/test
https://DOMAIN.ai/testapi/test
https://DOMAIN.ai/testapi/test
https://DOMAIN.ai/testapi/test
https://DOMAIN.ai/testapi/jobs
https://DOMAIN.ai/testapi/job_count
```

Each time you visited test, it should a job id
```
{  
"job_id": "bc6c9e46-ea0e-4a4c-9126-93ed9ff40bf7"  
}
```

when you visit /jobs right away, it’ll list 4 jobs like this:
```
[
 {
  "id": "8d70dabe-373e-452e-a9a7-8e926c3b2950",
  "status": "queued"
 },
 {
  "id": "952a7005-de78-4191-9076-b4668b11379a",
  "status": "queued"
 },
 {
  "id": "b4d5056b-ece2-4b10-bcc9-39d21899e398",
  "status": "queued"
 },
 {
  "id": "6058b965-25e7-4326-912e-b8daca729b68",
  "status": "queued"
 }
]

```

/job_count shows:
```
{  
"total_jobs": 4  
}
```

Wait 10 seconds for a job to finish. Then refreshing either of the previous two endpoints. You should see the queued jobs decrease! Our see_pic task function waits for 10 seconds.

Curiously, your worker’s console can look like:
```
AI is seeing the picture https://picsum.photos/200/300  
10:38:50 default: Job OK (6058b965-25e7-4326-912e-b8daca729b68)  
10:38:50 Result is kept for 500 seconds  
10:38:50 default: rq_tasks.see_pic('https://placekitten.com/200/300') (ec652138-1de4-43c3-858f-2807c87ac6a2)  
AI is seeing the picture https://placekitten.com/200/300  
10:39:10 default: Job OK (ec652138-1de4-43c3-858f-2807c87ac6a2)  
10:39:10 Result is kept for 500 seconds  
10:39:10 default: rq_tasks.see_pic('https://placebear.com/200/300') (b6c626df-e8da-4144-8b29-ffe5a11945f2)  
AI is seeing the picture https://placebear.com/200/300  
10:39:30 default: Job OK (b6c626df-e8da-4144-8b29-ffe5a11945f2)  
10:39:30 Result is kept for 500 seconds  
10:40:26 default: rq_tasks.see_pic('https://placeimg.com/200/300/any') (bc6c9e46-ea0e-4a4c-9126-93ed9ff40bf7)  
AI is seeing the picture https://placeimg.com/200/300/any  
10:40:46 default: Job OK (bc6c9e46-ea0e-4a4c-9126-93ed9ff40bf7)  
10:40:46 Result is kept for 500 seconds
```

### More Practical Enqueueing

Keep in mind

Visit these endpoints in the web browser (after adjusting their final URLs based on your environment or server) in the order it’s presented
```
https://DOMAIN.ai/testapi/test  
https://DOMAINai/testapi/job_status/JOB_ID
```

You visit the first endpoint, then copy the job id to your clipboard

You enter the second endpoint into the web browser, replacing the job ID at the end. It would say:
```
{  
  "status": "in progress"  
}  

```
  

And eventually it says
```
{  
  "result": "AI has learned the picture https://placeimg.com/200/300/any",  
  "status": "finished"  
}
```
  

For practical purposes, you can code something that follows this similar workflow behind the hood. Then you can do things like queue lines for users, etc