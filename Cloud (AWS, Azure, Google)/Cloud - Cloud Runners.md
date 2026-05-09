Required Knowledge:
[[Cloud - Every-So-Often Requests vs. Warm Requests vs. Forever-On]]

---

Cloud Runners Across AWS, Azure, and Google Cloud

“Cloud runner” is not always one exact product name. People often use it loosely to mean:

```text
A cloud service that runs code for you
```

That could mean a serverless function, a container service, or a scheduled background worker.

The right cloud service depends on what you are trying to do.

---

# Cloud Runners for Scheduled Pings and Always-On Workers

## The basic use case

If your goal is:

```text
Ping a server multiple times
```

Then the architecture usually looks like this:

```text
Cloud scheduler
   ↓
Cloud runner / serverless function
   ↓
HTTP request to your server
```

Example:

```text
Every 5 minutes:
Request https://example.com/health
```

This is a normal cloud automation pattern.

---

## Scheduled pings across Google Cloud, AWS, and Azure

Each major cloud has a scheduler and a serverless runner.

|Cloud|Scheduler|Serverless runner|
|---|---|---|
|Google Cloud|Cloud Scheduler|Cloud Run / Cloud Run functions|
|AWS|EventBridge Scheduler|Lambda|
|Azure|Timer Trigger|Azure Functions|

The general pattern is the same:

```text
Schedule triggers function
   ↓
Function runs code
   ↓
Function sends HTTP request
   ↓
Function exits
```

This is a good fit for tasks like:

- Pinging a health-check URL
    
- Keeping an app warm
    
- Running a small script every few minutes
    
- Calling multiple APIs on a schedule
    
- Triggering cache refreshes
    

Example logic:

```js
const urls = [
  "https://example.com/health",
  "https://api.example.com/ping",
  "https://another-site.com/status"
];

for (const url of urls) {
  try {
    const res = await fetch(url);
    console.log(`${url}: ${res.status}`);
  } catch (err) {
    console.error(`${url}: failed`, err);
  }
}
```

---

## Google Cloud option

On Google Cloud, a common setup is:

```text
Cloud Scheduler
   ↓
Cloud Run service or Cloud Run function
   ↓
Ping your server
```

Use this when you want scheduled HTTP requests.

Google Cloud Run is useful if you want to deploy a containerized app that responds to HTTP requests. Cloud Run functions are useful for simpler function-style code.

For longer background work, Google Cloud also has options like:

- Cloud Run jobs
    
- Cloud Run worker pools
    
- Compute Engine VM
    
- Google Kubernetes Engine
    

Use Cloud Run or Cloud Run functions for short scheduled work.

Use worker pools, VMs, or Kubernetes for continuous background work.

---

## AWS option

On AWS, a common setup is:

```text
EventBridge Scheduler
   ↓
Lambda
   ↓
Ping your server
```

This is one of the most common ways to run scheduled serverless code on AWS.

Use Lambda when the task is short and event-based.

For long-running background services, use something like:

- ECS Service
    
- AWS Fargate
    
- EC2
    
- EKS
    

Use Lambda for scheduled pings.

Use ECS, Fargate, EC2, or EKS for always-running workers.

---

## Azure option

On Azure, a common setup is:

```text
Azure Functions Timer Trigger
   ↓
Azure Function
   ↓
Ping your server
```

Azure Functions has a Timer Trigger designed for scheduled execution.

Use this for:

- Scheduled pings
    
- Timed jobs
    
- Small background tasks
    
- Periodic API calls
    

For long-running services, Azure has options like:

- Azure Container Apps
    
- Azure Virtual Machines
    
- Azure Kubernetes Service
    

Use Azure Functions for scheduled work.

Use Container Apps, VMs, or AKS for longer-running workers.

---

## Scheduled runner vs. always-on worker

Do not confuse a scheduled cloud runner with an always-on process.

A scheduled runner works like this:

```text
Start
Run task
Exit
```

An always-on worker works like this:

```text
Start
Keep running
Listen for events
Stay connected
```

Serverless functions are usually best for the first pattern.

VMs, containers, and worker services are better for the second pattern.

---

## Cloud comparison

|Use case|Google Cloud|AWS|Azure|
|---|---|---|---|
|Scheduled HTTP ping|Cloud Scheduler + Cloud Run/function|EventBridge Scheduler + Lambda|Timer Trigger + Azure Functions|
|Keep app warm|Cloud Run minimum instances|Lambda Provisioned Concurrency|Azure Functions Premium prewarmed instances|
|Long-running worker|Cloud Run worker pools / Compute Engine / GKE|ECS / Fargate / EC2 / EKS|Container Apps / VM / AKS|
|Simple cron-like function|Cloud Scheduler + function|EventBridge + Lambda|Timer Trigger|
|Permanent connection|VM/container/worker pool|ECS/Fargate/EC2|Container Apps/VM|

---

## Recommendation

For this use case:

```text
I need to ping a server multiple times.
```

Use:

```text
Scheduler
   ↓
Serverless function
   ↓
HTTP request
```

That means:

```text
Google Cloud: Cloud Scheduler + Cloud Run/function
AWS: EventBridge Scheduler + Lambda
Azure: Timer Trigger + Azure Functions
```

For this use case:

```text
I need to keep a real connection alive forever.
```

Use:

```text
Google Cloud: Cloud Run worker pools, Compute Engine, or GKE
AWS: ECS, Fargate, EC2, or EKS
Azure: Container Apps, VM, or AKS
```

The simplest rule is:

```text
Scheduled pings = serverless
Always-on connection = VM/container/worker
```