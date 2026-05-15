When a user clicks a button on a website, the whole page should not feel blocked.

For example, the user might click:

```txt
Generate Image
Process Video
Create Report
Export File
Run Automation
```

The backend may need time to complete the work, but the website should still feel responsive.

A weak user experience feels like this:

```txt
Click button → Page freezes → Spinner appears → User waits → User cannot do anything useful
```

Even if the server is working correctly, this feels slow.

A better user experience feels like this:

```txt
Click button → Job starts → Website stays responsive → User keeps using the page → Website notifies user when done
```

This is the main idea behind using:

```txt
fetch()
background jobs
SSE
WebSocket
SPA-style navigation
```

The user action starts the work, but the entire website experience does not have to be locked to that one request.

---

## The Problem with Long `fetch()` Requests

A normal `fetch()` request works well when the server can respond quickly.

Example:

```js
const response = await fetch("/api/save-profile", {
  method: "POST",
  body: formData
});
```

This is fine for actions like:

```txt
Save form
Delete record
Load small data
Submit quick request
Update setting
```

The browser sends a request, waits, and receives a response.

But this pattern becomes weaker when the server needs a long time to finish.

Examples:

```txt
Generate a report
Process a video
Upload and convert a file
Export a ZIP file
Run an AI task
Import a large CSV
Sync data from another API
```

If the user has to stare at a spinner the whole time, the website can feel frozen.

Even if the backend is working correctly, the user experience feels slow.

---

## Better Pattern: Start the Job, Then Listen for Updates

A better pattern is to separate **starting the job** from **waiting for the result**.

The browser can use `fetch()` to start the job:

```txt
Browser: Please start this report.
Server: Okay. Here is jobId: abc123.
```

Then the backend continues working in the background.

The browser does not need to stay stuck waiting inside the original `fetch()` request.

Instead, the browser can listen for updates using **SSE** or **WebSocket**.

```txt
Server: Report is 25% done.
Server: Report is 60% done.
Server: Report is complete.
```

Now the user can keep using the page while the job continues.

This creates the feeling of a faster app because the interface is not blocked.

---

## Example: AI Image Generation

Imagine a user is on a website that generates images with AI.

They type a prompt:

```txt
A luxury modern house at sunset with cinematic lighting
```

Then they click:

```txt
Generate Image
```

A weaker experience is:

```txt
User clicks Generate Image
Website shows a loading spinner
User waits on the same screen
User cannot tell if anything is happening
Image finally appears
```

Even if the backend is working, the website can feel frozen or broken.

A better experience is:

```txt
User clicks Generate Image
Website starts the image generation job
Website immediately says: "Your image is being generated"
User can keep using the page
Server sends progress updates
Website notifies the user when the image is ready
```

The image may still take 30 seconds, 2 minutes, or longer to generate.

SSE and WebSocket do **not** magically make the AI model faster.

They improve **perceived performance**.

The server continues doing the work, while the browser remains responsive.

The website can say:

```txt
Generating your image in the background.
You can keep editing your prompt or browsing other results.
We will notify you when it is ready.
```

Then, when the backend finishes, it can send a message back to the browser:

```txt
Your image is ready.
```

That creates a smoother, more professional experience.

---

## Best UX: Keep the App Feeling Like a SPA

This pattern works best when the website behaves like a **SPA**, or single-page app.

That means internal links should not fully reload the entire webpage every time.

Instead, the app should do this:

```txt
User clicks internal link
Frontend changes the visible page/component
Address bar URL updates
Browser back/forward buttons still work
SSE connection can stay alive
```

This is how many modern frontend routers work.

The website can still have normal-looking URLs like:

```txt
/reports
/videos
/settings
```

But clicking those links does not have to fully reload the browser page.

The frontend can update the address bar using routing/history behavior, then re-render the correct view.

This helps because a full page reload closes the current SSE connection.

A SPA-style app can keep the connection alive while the user moves around the app.

So the user can:

```txt
Start a background job
Click around the app
Visit another internal page
Keep receiving progress updates
Get notified when the job is done
```

Important note:

This does not mean your app cannot have real URLs.

A good SPA can still support:

```txt
Address bar URL changes
Direct page visits
Browser back button
Browser forward button
Refresh recovery
```

The goal is to avoid unnecessary full page reloads during normal internal navigation.

---

## SSE: Server-Sent Events

SSE means **Server-Sent Events**.

It allows the server to send messages to the browser over an open connection.

SSE is best when communication mostly goes one direction:

```txt
Server → Browser
```

That makes SSE a good fit for:

```txt
Progress updates
Background job completion
Export status
Import status
AI streaming text
Notification messages
"Your file is ready" alerts
```

Example user experience:

```txt
Your report is being generated in the background.
You can continue using this page.
```

Then, when the backend finishes:

```txt
Your report is ready.
```

The user is not stuck on a loading screen.

The app feels more responsive, even though the server still needed time to complete the work.

---

## Clarifying “The Backend Pings the Frontend”

People often say:

```txt
The backend pings the frontend.
```

But with SSE, the backend does not randomly call the browser whenever it wants.

The browser must first open a connection.

The real flow is:

```txt
Frontend opens an SSE connection to the backend.
Backend keeps that connection open.
Backend writes messages into that connection.
Frontend receives those messages.
```

So it is more accurate to say:

```txt
The frontend listens.
The backend sends messages into the open connection.
```

One of those messages can tell the frontend that the job is done.

Example SSE message:

```txt
event: done
data: {"status":"done","downloadUrl":"/downloads/report-123.pdf"}
```

Then the frontend can detect that message:

```js
eventSource.addEventListener("done", (event) => {
  const data = JSON.parse(event.data);

  alert("Your report is ready.");

  localStorage.removeItem("activeReportJobId");
  eventSource.close();
});
```

The word `"done"` is not magical by itself.

It is just a value you choose in your own app.

You could send:

```json
{
  "status": "done"
}
```

Or:

```json
{
  "type": "complete"
}
```

Or:

```json
{
  "finished": true
}
```

The important thing is that the backend and frontend agree on what the message means.

---

## SSE Pattern: Start Job, Save Job ID, Listen for Updates

A useful SSE pattern is:

```txt
1. User clicks “Generate Report”
2. Browser sends fetch() request
3. Server returns a jobId
4. Browser saves jobId in localStorage
5. Browser opens SSE connection for that jobId
6. Server sends progress updates
7. Server sends ping messages to keep the connection alive
8. Server sends “done” when complete
9. Browser removes jobId from localStorage
```

The frontend starts the job:

```js
async function startReportJob() {
  const response = await fetch("/api/reports/start", {
    method: "POST"
  });

  const data = await response.json();

  localStorage.setItem("activeReportJobId", data.jobId);

  connectToReportEvents(data.jobId);
}
```

Then the frontend opens an SSE connection:

```js
function connectToReportEvents(jobId) {
  const eventSource = new EventSource(`/api/reports/events?jobId=${jobId}`);

  eventSource.addEventListener("connected", (event) => {
    const data = JSON.parse(event.data);
    console.log(data.message);
  });

  eventSource.addEventListener("progress", (event) => {
    const data = JSON.parse(event.data);
    console.log(`Progress: ${data.percent}%`);
  });

  eventSource.addEventListener("ping", (event) => {
    const data = JSON.parse(event.data);
    console.log("SSE connection is still alive:", data.time);
  });

  eventSource.addEventListener("done", (event) => {
    const data = JSON.parse(event.data);

    alert(`Report is ready: ${data.downloadUrl}`);

    localStorage.removeItem("activeReportJobId");
    eventSource.close();
  });

  eventSource.onerror = () => {
    console.log("SSE connection lost. Browser may retry automatically.");
  };
}
```

---

## Important Detail: `localStorage` Does Not Keep SSE Alive

`localStorage` only saves the job ID.

It does **not** keep the SSE connection running.

If the user refreshes the page, closes the tab, navigates away with a full reload, or loses internet connection, the old SSE connection is gone.

But because the job ID was saved, the webpage can recover.

When the page loads again, it can check:

```js
const jobId = localStorage.getItem("activeReportJobId");
```

If a job ID exists, the frontend can ask the backend:

```txt
What is the latest status of this job?
```

Then it can decide whether to:

```txt
Show the completed result
Reconnect to SSE
Clear the job from localStorage
```

---

## What If the Browser Misses the “Done” Message?

This is very important.

SSE messages are live messages.

They are not automatically stored like an inbox.

If the browser is connected when the backend sends this:

```txt
event: done
data: {"status":"done"}
```

Then the frontend receives it.

But if the user refreshed the page, closed the tab, lost internet, or caused a full page reload, the SSE connection was closed.

During that disconnected time, the backend may have already sent the `"done"` message.

The frontend may miss it.

That is why you should not rely only on the SSE message.

The backend should store the real job state somewhere, such as:

```txt
Database
Redis
Queue system
Job table
In-memory map for simple demos
```

Then the frontend can recover by asking the backend:

```txt
What is the current status for jobId abc123?
```

Example frontend recovery code:

```js
window.addEventListener("load", async () => {
  const jobId = localStorage.getItem("activeReportJobId");

  if (!jobId) return;

  const response = await fetch(`/api/reports/status?jobId=${jobId}`);
  const data = await response.json();

  if (data.status === "done") {
    alert(`Report is ready: ${data.downloadUrl}`);
    localStorage.removeItem("activeReportJobId");
    return;
  }

  if (data.status === "failed") {
    alert("The report failed. Please try again.");
    localStorage.removeItem("activeReportJobId");
    return;
  }

  connectToReportEvents(jobId);
});
```

The recovery flow should be:

```txt
1. Page loads
2. Frontend checks localStorage for jobId
3. Frontend calls /status?jobId=abc123
4. Backend returns current job state
5. If done, frontend shows the finished result
6. If failed, frontend shows an error
7. If still processing, frontend reconnects to SSE
```

The `/status` endpoint is the safety net.

---

## SSE + Status Endpoint Pattern

For reliable background jobs, use both:

```txt
/events?jobId=abc123
/status?jobId=abc123
```

Use SSE for live updates.

Use the status endpoint for recovery.

The mental model is:

```txt
SSE = live updates
/status = source of truth
localStorage = remembers which job to check
```

So if the frontend receives a live message like this:

```json
{
  "status": "done",
  "downloadUrl": "/downloads/report-abc123.pdf"
}
```

Great.

It can immediately update the UI.

But if the frontend misses that message, it can still recover by calling:

```txt
/status?jobId=abc123
```

Then the backend can respond:

```json
{
  "status": "done",
  "downloadUrl": "/downloads/report-abc123.pdf"
}
```

That way the user does not lose the result just because the browser refreshed or disconnected.

---

## Can SSE Replay Missed Messages?

SSE has a built-in concept called `Last-Event-ID`.

The server can send event IDs like this:

```txt
id: 42
event: progress
data: {"percent":60}
```

If the connection drops, the browser may reconnect and send the last event ID it received.

Then the backend can decide what to do.

But the important detail is:

```txt
SSE does not automatically replay old messages unless your backend stores them.
```

If you want replay behavior, your backend needs to keep a short event history.

Example:

```txt
Job abc123 events:
- id 1: progress 20%
- id 2: progress 40%
- id 3: progress 60%
- id 4: done
```

Then if the browser reconnects and says:

```txt
Last-Event-ID: 2
```

The backend can replay:

```txt
id 3: progress 60%
id 4: done
```

That is possible, but for many apps it is more complicated than needed.

For most apps, the simpler and more reliable pattern is:

```txt
SSE sends live updates.
/status checks the real current state.
```

---

## Backend SSE Example with Node.js and Express

This example uses memory for simplicity.

In production, you would usually store jobs in a database, Redis, or a queue system.

```js
import express from "express";
import crypto from "crypto";

const app = express();

app.use(express.json());

const jobs = new Map();
const clients = new Map();

function sendSse(res, eventName, data) {
  res.write(`event: ${eventName}\n`);
  res.write(`data: ${JSON.stringify(data)}\n\n`);
}

function broadcastToJob(jobId, eventName, data) {
  const jobClients = clients.get(jobId);

  if (!jobClients) return;

  for (const res of jobClients) {
    sendSse(res, eventName, data);
  }
}

app.post("/api/reports/start", (req, res) => {
  const jobId = crypto.randomUUID();

  jobs.set(jobId, {
    status: "processing",
    percent: 0,
    downloadUrl: null
  });

  res.json({ jobId });

  // Demo background job.
  // In production, use a real queue or worker.
  let percent = 0;

  const timer = setInterval(() => {
    percent += 20;

    const job = jobs.get(jobId);

    if (!job) {
      clearInterval(timer);
      return;
    }

    job.percent = percent;

    broadcastToJob(jobId, "progress", {
      status: "processing",
      percent
    });

    if (percent >= 100) {
      job.status = "done";
      job.downloadUrl = `/downloads/report-${jobId}.pdf`;

      broadcastToJob(jobId, "done", {
        status: "done",
        downloadUrl: job.downloadUrl
      });

      clearInterval(timer);
    }
  }, 1000);
});

app.get("/api/reports/events", (req, res) => {
  const { jobId } = req.query;

  if (!jobId || !jobs.has(jobId)) {
    return res.status(404).json({ error: "Job not found" });
  }

  res.setHeader("Content-Type", "text/event-stream");
  res.setHeader("Cache-Control", "no-cache");
  res.setHeader("Connection", "keep-alive");

  res.flushHeaders?.();

  if (!clients.has(jobId)) {
    clients.set(jobId, new Set());
  }

  clients.get(jobId).add(res);

  sendSse(res, "connected", {
    message: "Connected to report updates.",
    jobId
  });

  const pingTimer = setInterval(() => {
    sendSse(res, "ping", {
      time: Date.now()
    });
  }, 15000);

  req.on("close", () => {
    clearInterval(pingTimer);

    const jobClients = clients.get(jobId);

    if (jobClients) {
      jobClients.delete(res);

      if (jobClients.size === 0) {
        clients.delete(jobId);
      }
    }
  });
});

app.get("/api/reports/status", (req, res) => {
  const { jobId } = req.query;

  const job = jobs.get(jobId);

  if (!job) {
    return res.status(404).json({ error: "Job not found" });
  }

  res.json(job);
});

app.listen(3000, () => {
  console.log("Server running on http://localhost:3000");
});
```

The important part is this function:

```js
function sendSse(res, eventName, data) {
  res.write(`event: ${eventName}\n`);
  res.write(`data: ${JSON.stringify(data)}\n\n`);
}
```

That is how the backend sends a message into the open SSE connection.

This is what people usually mean when they say:

```txt
The backend pings the frontend.
```

Technically, the frontend opened the connection first.

Then the backend writes messages into that open connection.

---

## Backend SSE Example with PHP

For PHP, the basic idea is:

```php
<?php

$jobId = $_GET["jobId"] ?? null;

if (!$jobId) {
    http_response_code(400);
    echo "Missing jobId";
    exit;
}

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");
header("X-Accel-Buffering: no"); // Helpful when behind Nginx

while (true) {
    // In a real app, check job status from a database, Redis, or queue.
    $job = getJobStatus($jobId);

    echo "event: progress\n";
    echo "data: " . json_encode([
        "status" => $job["status"],
        "percent" => $job["percent"]
    ]) . "\n\n";

    if ($job["status"] === "done") {
        echo "event: done\n";
        echo "data: " . json_encode([
            "status" => "done",
            "downloadUrl" => $job["downloadUrl"]
        ]) . "\n\n";

        ob_flush();
        flush();
        break;
    }

    echo "event: ping\n";
    echo "data: " . json_encode([
        "time" => time()
    ]) . "\n\n";

    ob_flush();
    flush();

    sleep(3);
}

function getJobStatus($jobId) {
    // Demo only.
    // Replace this with a database or Redis lookup.
    return [
        "status" => "processing",
        "percent" => 50,
        "downloadUrl" => null
    ];
}
```

Important PHP note:

If you are behind Nginx, buffering may prevent SSE messages from reaching the browser immediately.

This header helps:

```php
header("X-Accel-Buffering: no");
```

You may also need to adjust Nginx buffering settings depending on your setup.

---

## Backend SSE Example with Python Flask

```python
from flask import Flask, Response, request
import json
import time

app = Flask(__name__)

jobs = {
    "abc123": {
        "status": "processing",
        "percent": 0,
        "downloadUrl": None
    }
}

def sse_event(event_name, data):
    return f"event: {event_name}\ndata: {json.dumps(data)}\n\n"

@app.route("/api/reports/events")
def report_events():
    job_id = request.args.get("jobId")

    if job_id not in jobs:
        return {"error": "Job not found"}, 404

    def stream():
        while True:
            job = jobs[job_id]

            yield sse_event("progress", {
                "status": job["status"],
                "percent": job["percent"]
            })

            yield sse_event("ping", {
                "time": time.time()
            })

            if job["status"] == "done":
                yield sse_event("done", {
                    "status": "done",
                    "downloadUrl": job["downloadUrl"]
                })
                break

            time.sleep(3)

    return Response(stream(), mimetype="text/event-stream")
```

Again, the important idea is:

```txt
Frontend opens the connection.
Backend keeps it open.
Backend yields/writes messages.
Frontend receives those messages.
```

---

Yes — that section should explain **why WebSocket feels more natural for chatrooms and games**, even though some of the same things can technically be done with SSE. Add/replace the WebSocket section with this expanded version.

---

## WebSocket for Two-Way Real-Time Communication

WebSocket is different from SSE because WebSocket is designed for continuous two-way communication.

SSE is mostly:

```txt
Server → Browser
```

WebSocket is:

```txt
Browser → Server
Server → Browser
Browser → Server
Server → Browser
```

That symmetry matters.

With WebSocket, both sides can send messages through the same open connection.

That makes the code structure feel more natural for apps where the user and server constantly talk back and forth.

---

### Why WebSocket Makes More Sense for Chatrooms

A chatroom is a good example.

In a chatroom, the browser needs to send messages to the server:

```txt
User sends message → Server
```

Then the server needs to send that message to other connected users:

```txt
Server sends message → Other users
```

You could build parts of this with normal `fetch()` plus SSE:

```txt
Browser sends chat message with fetch()
Server sends incoming chat messages with SSE
```

That can work.

But it splits the communication into two different systems:

```txt
fetch() for Browser → Server
SSE for Server → Browser
```

With WebSocket, the mental model is cleaner:

```txt
One open connection
Browser sends messages through it
Server sends messages through it
```

Example:

```txt
Browser: send_chat_message
Server: new_chat_message
Browser: typing_started
Server: user_typing
Browser: typing_stopped
Server: user_stopped_typing
```

This is why WebSocket often makes more sense for chatrooms.

Not because SSE is impossible, but because WebSocket’s syntax and communication model match the shape of the problem better.

Chat is naturally two-way.

WebSocket is naturally two-way.

---

### WebSocket Example for Chat

Frontend:

```js
const socket = new WebSocket("wss://example.com/chat");

socket.addEventListener("open", () => {
  console.log("Connected to chat server.");
});

socket.addEventListener("message", (event) => {
  const message = JSON.parse(event.data);

  if (message.type === "new_message") {
    console.log(`${message.username}: ${message.text}`);
  }

  if (message.type === "typing") {
    console.log(`${message.username} is typing...`);
  }
});

function sendChatMessage(text) {
  socket.send(JSON.stringify({
    type: "send_message",
    text
  }));
}

function sendTypingStatus() {
  socket.send(JSON.stringify({
    type: "typing"
  }));
}
```

The same connection handles both sending and receiving.

That is the main reason WebSocket feels cleaner for chat.

---

### Why WebSocket Makes More Sense for Multiplayer Games

WebSocket is also better for low-latency interactive apps, especially multiplayer games.

For example:

```txt
Multiplayer game
MMORPG
Live cursor movement
Real-time drawing
Collaborative editing
Trading dashboard
Real-time control panel
```

In a multiplayer game, the browser may need to send frequent updates:

```txt
Player moved
Player attacked
Player changed direction
Player used item
Player sent command
```

The server also needs to send frequent updates back:

```txt
Other player moved
Enemy spawned
Health changed
Attack landed
World state updated
```

This is constant two-way communication.

For a game, you usually do not want this pattern:

```txt
fetch() request
wait for response
fetch() request
wait for response
SSE update
fetch() request
```

That is too clunky for fast interaction.

WebSocket is better because the connection stays open and both sides can send messages immediately.

```txt
Browser → Server: player moved
Server → Browser: nearby players updated
Browser → Server: player attacked
Server → Browser: enemy health updated
```

For low-latency apps, WebSocket is usually the better fit.

---

### SSE Can Do Some Similar Things, But It Is Not as Symmetrical

It is important to understand the difference clearly.

SSE can still be used for many “real-time” features.

For example, you could use SSE for:

```txt
New chat messages
Notifications
Progress updates
Live activity feed
AI streaming text
Background job completion
```

But SSE only handles the server-to-browser side.

If the browser also needs to send messages, you usually combine SSE with `fetch()`:

```txt
Browser → Server: fetch()
Server → Browser: SSE
```

That can be perfectly fine for many apps.

For example, a simple notification system does not need WebSocket.

A background report generator does not need WebSocket.

An AI text stream often works well with SSE.

But if the app constantly needs communication in both directions, WebSocket usually fits better.

---
## Simple Rule of Thumb

Use `fetch()` when the server can respond quickly.

Good examples:

```txt
Save a form
Delete a record
Update a setting
Load a small amount of data
Submit a quick request
```

Use **SSE** when the browser mostly needs to listen for server updates.

Good examples:

```txt
Background job progress
Report completion
File export status
Import status
AI text streaming
Notifications
Activity feed
```

SSE is especially useful when the server needs to push progress updates or completion messages to the browser.

Use **WebSocket** when the browser and server both need to talk often through the same open connection.

Good examples:

```txt
Chatrooms
Typing indicators
Multiplayer games
MMORPGs
Collaborative editing
Live control panels
Low-latency dashboards
```

The practical difference is:

```txt
fetch() = quick request and response
SSE = simpler for server → browser updates
WebSocket = better for constant browser ↔ server communication
```

For many long-running website actions, a strong pattern is:

```txt
fetch() starts the job
backend returns a jobId
frontend saves jobId in localStorage
frontend opens an SSE connection
backend sends progress, ping, and done messages
SPA navigation keeps the connection alive during internal page changes
/status checks the true current state after refresh or reconnect
frontend removes jobId when the job is complete
```

The most important mental model is:

```txt
SSE messages are helpful live notifications.
The backend job status is the source of truth.
```

That way, even if the browser misses a live `"done"` message, the app can still recover by checking `/status`.

So for background job updates, SSE is usually simpler.

For chatrooms, multiplayer games, collaborative editing, and fast two-way interactions, WebSocket usually makes more sense.

This keeps the website responsive, resilient, and more professional.