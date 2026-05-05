# Google Cloud for Beginners — Curriculum

A self-paced learning path for Google Cloud Platform (GCP), written in plain language with small, focused lessons. Each lesson is a single Markdown file. Folders group related topics.

> **You are here:** `00 - Getting Started / 1. Signing Up for a Google Cloud Account`

---

## Progress Tracker

Legend:

```text
[x] = done
[>] = in progress / current lesson
[ ] = not started yet
```

### 00 — Getting Started

```text
[ ] 1. Signing Up for a Google Cloud Account (Free Trial + $300 Credit)
[ ] 2. How Google Cloud Pricing Works (Pay-As-You-Go, Always-Free Tier, Pricing Calculator)
[ ] 3. Installing the Google Cloud SDK (gcloud CLI) and VS Code Extensions
[ ] 4. Tour of the Google Cloud Console
[ ] 5. Projects, Organizations, and Folders — How GCP Structures Resources
[ ] 6. Setting Budgets, Billing Alerts, and Quotas
```

### 01 — Storage

```text
[ ] 1. GCP Storage Model — Projects, Buckets, Objects, and gs:// URIs
[ ] 2. GCS Access Control — Uniform vs Fine-Grained, IAM, and Signed URLs
[ ] 3. Uploading and Downloading Objects (Console, gcloud CLI, Client Libraries)
[ ] 4. Storage Classes (Standard, Nearline, Coldline, Archive) and Lifecycle Rules
[ ] 5. Other Storage Options — Filestore, Persistent Disk, Cloud Storage FUSE
[ ] 6. Securing Buckets (Bucket Policies, VPC Service Controls, CMEK)
```

### 02 — Compute

```text
[ ] 1. Choosing the Right Compute Service (Cloud Run vs Functions vs Compute Engine vs GKE)
[ ] 2. Cloud Run — Deploy Containerized Apps Without Managing Servers
[ ] 3. Cloud Functions — Event-Driven Serverless Functions
[ ] 4. Compute Engine — Virtual Machines When You Need Full Control
[ ] 5. Google Kubernetes Engine (GKE) Overview
[ ] 6. App Engine — Fully Managed Web Apps (When to Use It)
```

### 03 — Databases

```text
[ ] 1. Choosing a Database (Cloud SQL vs Firestore vs Spanner vs Bigtable vs AlloyDB)
[ ] 2. Cloud SQL Basics (PostgreSQL / MySQL / SQL Server)
[ ] 3. Firestore Basics (Serverless NoSQL Document Store)
[ ] 4. Cloud Spanner Basics (Globally Distributed Relational Database)
[ ] 5. Bigtable Basics (Wide-Column Store for Large-Scale Workloads)
[ ] 6. AlloyDB Basics (PostgreSQL-Compatible, High-Performance OLTP+OLAP)
[ ] 7. Connection Security (Cloud SQL Auth Proxy, Private IP, IAM Auth)
```

### 04 — Messaging and Async

```text
[ ] 1. Cloud Pub/Sub — Publish-Subscribe Messaging at Scale
[ ] 2. Cloud Tasks — Managed Task Queues for Async Work
[ ] 3. Cloud Scheduler — Managed Cron Jobs
[ ] 4. Eventarc — Event-Driven Architectures on GCP
```

### 05 — Networking

```text
[ ] 1. VPC Networks, Subnets, and Firewall Rules
[ ] 2. External IPs, Cloud DNS, and Custom Domains
[ ] 3. Cloud Load Balancing, Cloud Armor, and Cloud CDN (Overview)
[ ] 4. Cloud NAT and Private Google Access
```

### 06 — Identity and Security

```text
[ ] 1. Google Cloud IAM — Projects, Roles, and Principals
[ ] 2. Service Accounts — GCP's Answer to Managed Identities
[ ] 3. Workload Identity Federation (No More Downloading Key Files)
[ ] 4. Secret Manager for Secrets and API Keys
[ ] 5. Organization Policies and Security Command Center (Overview)
```

### 07 — DevOps and Tooling

```text
[ ] 1. gcloud CLI Cheat Sheet
[ ] 2. Terraform for Google Cloud (Infrastructure as Code)
[ ] 3. Cloud Build — CI/CD Pipelines on GCP
[ ] 4. Cloud Deploy — Managed Continuous Delivery
[ ] 5. Artifact Registry — Container and Package Registry
```

### 08 — Monitoring and Diagnostics

```text
[ ] 1. Cloud Monitoring — Metrics, Dashboards, and Uptime Checks
[ ] 2. Cloud Logging and Log Explorer
[ ] 3. Cloud Trace and Error Reporting
[ ] 4. Cloud Profiler (Overview) — Note: Cloud Debugger Was Deprecated in 2023
```

### 09 — AI and Machine Learning (Overview)

```text
[ ] 1. Vertex AI Platform — What It Is and When You Need It
[ ] 2. Pre-Trained APIs (Vision, Speech, Translation, Natural Language)
[ ] 3. Using Generative AI Models via Vertex AI (Gemini)
```

### 10 — Local Emulation and Low-Cost Development

```text
[ ] 1. Why Emulate Locally (Save Money, Faster Iteration, Offline Dev)
[ ] 2. Firebase Local Emulator Suite — Firestore, Auth, Functions, Pub/Sub, Storage
[ ] 3. Cloud Pub/Sub Emulator (Standalone via gcloud)
[ ] 4. Cloud Spanner Emulator (Docker or gcloud)
[ ] 5. Cloud Bigtable Emulator (gcloud)
[ ] 6. Cloud Datastore Emulator (gcloud)
[ ] 7. fake-gcs-server — Local Cloud Storage Emulator (Docker)
[ ] 8. Functions Framework — Run Cloud Functions on Your Laptop
[ ] 9. BigQuery Emulator (bigquery-emulator via Docker)
[ ] 10. Cheap-as-Possible Cloud Setup When Emulators Are Not Enough
[ ] 11. Cleanup Scripts and Habits to Keep the Bill Near $0
```

---

## Suggested Folder Layout

```text
Google Cloud/
├── README.md                             (this file)
├── 00 - Getting Started/
│   ├── 1. Signing Up.md
│   ├── 2. Pricing and Free Tier.md
│   ├── 3. Installing gcloud SDK and Tools.md
│   ├── 4. Tour of the Cloud Console.md
│   ├── 5. Projects, Organizations, and Folders.md
│   └── 6. Budgets and Billing Alerts.md
├── 01 - Storage/
├── 02 - Compute/
├── 03 - Databases/
├── 04 - Messaging and Async/
├── 05 - Networking/
├── 06 - Identity and Security/
├── 07 - DevOps and Tooling/
├── 08 - Monitoring and Diagnostics/
├── 09 - AI and Machine Learning/
└── 10 - Local Emulation and Low-Cost Development/
```

---

## How to Sign Up for Google Cloud

The full lesson lives in `00 - Getting Started / 1. Signing Up.md`. Quick version:

### Steps

```text
1. Go to https://cloud.google.com/free
2. Click "Get started for free"
3. Sign in with a Google account (Gmail or Google Workspace)
   - If you do not have one, create a free Google account first
4. Agree to the terms of service
5. Set up a billing account:
   - Enter a credit or debit card (used for identity verification and post-trial charges)
   - You will NOT be charged during the free trial without explicitly upgrading
6. Land in the Google Cloud Console at https://console.cloud.google.com
7. A default project is created for you — rename it or create a clean one
```

### What you get with a new free Google Cloud account

```text
- $300 USD credit, valid for 90 days — usable across nearly all GCP services
- Always-free tier products (no expiry, within monthly limits):
    Cloud Functions          2 million invocations/month
    Cloud Run                2 million requests/month
    Cloud Storage            5 GB-months of Standard storage (US regions only)
    Compute Engine           1 non-preemptible e2-micro VM (us-west1, us-central1,
                               us-east1 only) + 30 GB HDD persistent disk
    BigQuery                 1 TB of query processing/month + 10 GB storage
    Cloud Firestore          1 GB storage, 50K reads, 20K writes, 20K deletes/day
    Cloud Pub/Sub            10 GB messages/month
    Cloud Build              120 build-minutes/day
    Artifact Registry        0.5 GB storage/month
    Secret Manager           6 active secret versions, 10K access ops/month
```

> Limits change. Always check the current always-free list:
> https://cloud.google.com/free/docs/free-cloud-features

### Important: avoiding surprise charges at signup

```text
- Your free trial ends when you exhaust $300 credit OR 90 days pass, whichever comes first
- After the trial you are NOT automatically charged — GCP asks you to manually upgrade
- Once you upgrade to a paid account, services can accrue charges
- Set a budget alert immediately (Billing → Budgets & alerts → Create budget)
- The single most reliable safeguard is to delete unused projects:
      gcloud projects delete PROJECT_ID
  Deleting a project deletes all resources inside it and stops all billing for it
```

---

## How Much Could It Cost?

GCP bills per resource, per second (for VMs), or per request/GB. These are realistic order-of-magnitude figures for a learner project.

> Prices are approximate and change. Always check the GCP Pricing Calculator:
> https://cloud.google.com/products/calculator

### Things that are free or near-free

```text
Service                              Approximate cost for a learner
-----------------------------------  ------------------------------------------
Google Cloud account (signup)        $0
Project (created)                    $0 (just a container for resources)
Cloud Storage (a few MBs)            Pennies per month
Cloud Functions (Consumption)        2M free invocations/month
Cloud Run (Consumption)              2M requests/month free
App Engine (free tier F1 instance)   $0 within daily limits
Cloud Firestore                      Generous always-free reads/writes/day
BigQuery queries (< 1 TB)            $0/month
Compute Engine e2-micro               $0 (1 VM in us-west1/us-central1/us-east1)
Cloud Build                          120 build-minutes/day free
Secret Manager                       10K access ops/month free
Cloud DNS (managed zone)             ~$0.20/zone/month
```

### Things that can rack up a bill quickly

```text
Service                              Why it can hurt
-----------------------------------  -------------------------------------------
Compute Engine VMs (left running)    Charged per second even when idle
GKE node pools                       Every node is a billable Compute Engine VM;
                                       $0.10/hr management fee per cluster (one
                                       free zonal cluster per billing account)
Cloud SQL instances                  Charged per hour even with no connections
Cloud Spanner                        $0.90/node/hr (Standard edition) — expensive
                                       for experiments; fractional nodes (100 PU
                                       min) can reduce cost
Persistent Disk (SSD)                Per-GB/month whether attached or not
Cloud NAT                            Per-hour gateway fee plus per-GB charge
Cloud Load Balancing                 Per-hour forwarding rule fee plus traffic
Egress / outbound bandwidth          Free within GCP zones; inter-region and
                                       internet egress charged per GB
Cloud Armor                          Per-policy/per-rule monthly fee
```

### Realistic monthly bills

```text
- Hello-world static site on Cloud Storage + Cloud CDN:   $0 – $1
- Personal blog on Cloud Run (scale to zero):             $0 – $1
- Small API on Cloud Functions + Firestore:               $0 – $2
- e2-micro VM running 24/7 (us-central1):                 $0 (always-free)
- e2-small VM running 24/7:                               ~$12 – $18/month
- Cloud SQL (db-f1-micro) running 24/7:                   ~$10 – $15/month
- Single GKE cluster with 2 small nodes:                  ~$50 – $100/month
- Cloud Spanner (1 node Standard edition, always-on):      ~$650/month
```

The biggest beginner mistake is **leaving Cloud SQL and Compute Engine instances running**. Always stop or delete them when a lesson is done.

---

## Local Emulation — Learning GCP Without Paying

GCP has first-class emulators for most of its major services. You can build and test apps entirely on your laptop, then deploy to the cloud only when ready. Full lessons live in `10 - Local Emulation and Low-Cost Development/`. Quick reference:

### Free local emulators

```text
Service                  Local emulator                               Cost
-----------------------  -------------------------------------------  ----
Firestore / Datastore    Firebase Local Emulator Suite (Node.js)       Free
Cloud Functions (1st/2nd gen)  Functions Framework (Node/Python/Go/Java) Free
Cloud Pub/Sub            Cloud Pub/Sub Emulator (gcloud component)     Free
Cloud Spanner            Cloud Spanner Emulator (gcloud or Docker)     Free
Cloud Bigtable           Cloud Bigtable Emulator (gcloud component)    Free
Cloud Datastore          Cloud Datastore Emulator (gcloud component)   Free
Cloud Storage            fake-gcs-server (Docker)                      Free
BigQuery                 bigquery-emulator (Docker)                    Free
Firebase Auth / Hosting  Firebase Local Emulator Suite                 Free
```

### Quick-start commands

```bash
# Firebase Local Emulator Suite — Firestore, Auth, Functions, Pub/Sub, Storage
npm install -g firebase-tools
firebase login
firebase init emulators        # choose which emulators to enable
firebase emulators:start       # UI available at http://localhost:4000

# Cloud Pub/Sub Emulator (via gcloud component)
gcloud components install pubsub-emulator
gcloud beta emulators pubsub start --project=my-local-project --host-port=localhost:8085
# In your app, set the env variable so the SDK finds the emulator:
export PUBSUB_EMULATOR_HOST=localhost:8085

# Cloud Spanner Emulator (Docker)
docker run -d --name spanner-emulator \
  -p 9010:9010 -p 9020:9020 \
  gcr.io/cloud-spanner-emulator/emulator
export SPANNER_EMULATOR_HOST=localhost:9010

# Cloud Bigtable Emulator (via gcloud component)
gcloud components install bigtable
gcloud beta emulators bigtable start
export BIGTABLE_EMULATOR_HOST=localhost:8086

# Cloud Datastore Emulator (via gcloud component)
gcloud components install cloud-datastore-emulator
gcloud beta emulators datastore start --project=my-local-project
# gcloud prints the env vars to set — copy and export them

# fake-gcs-server — local Cloud Storage on port 4443
docker run -d --name fake-gcs \
  -p 4443:4443 \
  fsouza/fake-gcs-server \
  -scheme http -port 4443
# Point your client at http://localhost:4443/storage/v1/

# Functions Framework — run a Cloud Function locally (Node.js example)
npm install @google-cloud/functions-framework
npx functions-framework --target=myFunctionName --port=8080
# HTTP: curl http://localhost:8080

# BigQuery Emulator (Docker)
docker run -it -p 9050:9050 -p 9060:9060 \
  ghcr.io/goccy/bigquery-emulator:latest \
  --project=my-local-project --dataset=my-dataset
export BIGQUERY_EMULATOR_HOST=localhost:9050
```

### Connecting your code to GCP emulators

Most GCP client libraries respect environment variables to redirect traffic to a local emulator:

```text
Emulator              Environment variable                  Value
--------------------  ------------------------------------  -------------------------
Pub/Sub               PUBSUB_EMULATOR_HOST                 localhost:8085
Spanner               SPANNER_EMULATOR_HOST                localhost:9010
Bigtable              BIGTABLE_EMULATOR_HOST               localhost:8086
Datastore / Firestore DATASTORE_EMULATOR_HOST              localhost:8081
                      FIRESTORE_EMULATOR_HOST              localhost:8080
BigQuery              BIGQUERY_EMULATOR_HOST               localhost:9050
```

When using Firebase Local Emulator Suite, point your Firebase SDK at the emulator host in code:

```javascript
// JavaScript / Node.js
import { initializeApp } from "firebase/app";
import { getFirestore, connectFirestoreEmulator } from "firebase/firestore";

const app = initializeApp({ projectId: "my-local-project" });
const db = getFirestore(app);
connectFirestoreEmulator(db, "localhost", 8080);
```

### When you do need the cloud — keep the bill tiny

Some things cannot be fully emulated (Cloud IAM real policies, Workload Identity, Cloud Armor, managed SSL certificates, actual Cloud DNS). For those:

```text
1. Use always-free or Consumption-based services whenever they exist
   (Cloud Run, Cloud Functions, Firestore, Cloud Storage, BigQuery < 1 TB).
2. Use the smallest SKU that works (e2-micro VM, db-f1-micro SQL, 100-PU Spanner instance).
3. Put EVERYTHING for one experiment in ONE GCP project.
4. When done, delete the project:
       gcloud projects delete PROJECT_ID
5. Set a monthly budget alert at $1, $5, $20 — whatever your comfort level is.
6. Stop Compute Engine VMs when not in use:
       gcloud compute instances stop INSTANCE_NAME --zone=ZONE
   (Unlike Azure "stop", GCP "stop" does deallocate the VM — no hourly charge.)
7. Stop or delete Cloud SQL instances between lessons:
       gcloud sql instances patch INSTANCE_NAME --activation-policy=NEVER
   Or delete outright:
       gcloud sql instances delete INSTANCE_NAME
8. Avoid services with per-hour base fees unless actively needed
   (Cloud Spanner, Cloud NAT, Cloud Armor, Cloud Load Balancing forwarding rules).
```

### Practical workflow

```text
1. Build and test locally with Firebase Emulator Suite + Functions Framework.
2. Deploy to a Cloud Run (scale-to-zero) or Cloud Functions service for staging.
3. Add a budget alert at $5/month so you get warned early.
4. Delete the GCP project when the lesson is done.
```

---

## How to Use This Curriculum

```text
1. Start at the top of the Progress Tracker.
2. Read the lesson file end-to-end.
3. Try the commands or Console steps yourself.
4. Mark the lesson [x] in this file when finished.
5. Move the [>] marker to the next lesson.
```

Lessons are intentionally short and standalone, so you can jump around once you have finished `00 - Getting Started` and `01 - Storage`.
