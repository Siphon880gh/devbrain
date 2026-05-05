A self-paced learning path for Microsoft Fabric, written in plain language with small, focused lessons. Each lesson is a single Markdown file. Folders group related topics.

Microsoft Fabric is a **unified analytics platform** — it answers the question: "How do I ingest, transform, store, analyze, and visualize large datasets?"

The audience is data engineers, data scientists, BI analysts, and analytics architects. If you want to build web apps or REST APIs instead, see the Azure Cloud Infrastructure curriculum.

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
[ ] 1. What Microsoft Fabric Is and How It Fits Into the Microsoft Ecosystem
[ ] 2. Signing Up — Free Trial Capacity, Microsoft 365 License, and Power BI License
[ ] 3. How Fabric Pricing Works (Capacity Units, F-SKUs, OneLake Storage)
[ ] 4. Tour of app.fabric.microsoft.com — Workspaces, Items, and the Home Hub
[ ] 5. Installing the Fabric VS Code Extension and Developer Tools
[ ] 6. Setting Up a Fabric Workspace and Assigning a Capacity
```

### 01 — OneLake and Lakehouses

```text
[ ] 1. OneLake — One Copy of Data for All Fabric Workloads
[ ] 2. Creating a Lakehouse — the Central Storage Item in Fabric
[ ] 3. Files vs Tables in a Lakehouse (Unmanaged vs Delta-Managed)
[ ] 4. Delta Lake Format — Why Fabric Uses It and What It Gives You
[ ] 5. OneLake Shortcuts — Pointing at Azure Data Lake, S3, or Other Storage
[ ] 6. OneLake File Explorer — Browsing Your Lake From Windows Desktop
```

### 02 — Data Factory Pipelines

```text
[ ] 1. Pipelines vs Dataflows Gen2 — When to Use Each
[ ] 2. Creating Your First Data Pipeline — Copy Activity Basics
[ ] 3. Dataflows Gen2 — Low-Code Data Transformation With Power Query
[ ] 4. Pipeline Activities — ForEach, If Condition, Wait, Web, and Stored Proc
[ ] 5. Scheduling Pipelines and Setting Up Triggers
[ ] 6. Monitoring Pipeline Runs and Diagnosing Failures
```

### 03 — Spark and Data Engineering

```text
[ ] 1. Spark in Fabric — How Synapse Data Engineering Differs From Raw Spark
[ ] 2. Creating and Running Notebooks in Fabric
[ ] 3. PySpark Basics — Reading, Transforming, and Writing Delta Tables
[ ] 4. Spark Job Definitions — Running Scripts Without a Notebook UI
[ ] 5. Managing Environments — Libraries, Dependencies, and Runtime Versions
[ ] 6. Reading and Writing to OneLake From a Notebook
```

### 04 — Data Warehouse

```text
[ ] 1. Warehouse vs Lakehouse SQL Endpoint — Which to Use and Why
[ ] 2. Creating a Fabric Warehouse and Loading Data
[ ] 3. Writing Analytical SQL (T-SQL) in the Fabric Warehouse
[ ] 4. Cross-Database and Cross-Lakehouse Queries
[ ] 5. Views, Stored Procedures, and Functions in Fabric Warehouse
[ ] 6. Warehouse Performance — Statistics, Caching, and Query Patterns
```

### 05 — Data Science

```text
[ ] 1. ML Experiments in Fabric — Tracking Runs With MLflow
[ ] 2. Training Models in Notebooks and Saving Them to OneLake
[ ] 3. Fabric Models Item — Registering and Versioning Trained Models
[ ] 4. Connecting to OneLake Data From a Data Science Notebook
[ ] 5. Batch Scoring — Applying a Model to a Dataset at Scale
```

### 06 — Fabric Databases and Mirroring

```text
[ ] 1. SQL Database in Fabric — an OLTP Database Inside the Analytics Platform
[ ] 2. When to Use Fabric SQL Database vs Fabric Warehouse vs Lakehouse
[ ] 3. Mirrored Databases — Replicating Azure SQL, Cosmos DB, and Other Sources Into OneLake
[ ] 4. Open Mirroring — Building Custom Replication From Any Source
```

### 07 — Real-Time Intelligence

```text
[ ] 1. Eventstream — Ingesting Live Data From Event Hubs, Kafka, or Custom Sources
[ ] 2. KQL Databases — Storing and Querying Time-Series and Log Data
[ ] 3. KQL Basics — Writing Queries for Real-Time Data
[ ] 4. Real-Time Dashboards — Live-Updating Visuals Powered by KQL
[ ] 5. Activator — Triggering Alerts and Actions When Data Conditions Are Met
```

### 08 — Power BI and Reporting

```text
[ ] 1. Semantic Models — What They Are and Why Power BI Needs Them
[ ] 2. Creating Reports in the Fabric Power BI Experience
[ ] 3. DAX Basics — Calculated Columns, Measures, and Aggregations
[ ] 4. DirectLake Mode — Querying OneLake Without Importing Data
[ ] 5. Sharing Reports, Workspaces, and Apps With Business Users
[ ] 6. Row-Level Security (RLS) — Filtering Data by User Identity
```

### 09 — Identity, Security, and Governance

```text
[ ] 1. Workspace Roles — Admin, Member, Contributor, Viewer
[ ] 2. Fabric and Microsoft Entra ID — How Authentication Works
[ ] 3. Item-Level Permissions and Sharing Individual Items
[ ] 4. Microsoft Purview Integration — Data Catalog and Sensitivity Labels
[ ] 5. Private Links and Managed VNets for Fabric
```

### 10 — Copilot and AI in Fabric

```text
[ ] 1. What Copilot Can Do in Fabric — Capabilities by Workload
[ ] 2. Copilot in Notebooks — Code Generation, Debugging, and Explanation
[ ] 3. Copilot in Power BI — DAX Writing and Data Q&A
[ ] 4. AI Functions — Enriching Data With Built-In AI (Sentiment, Summarization, Translation)
[ ] 5. Data Agents — Natural Language Q&A Over Your Lakehouse and Warehouse Data
```

### 11 — Local Emulation and Low-Cost Development

```text
[ ] 1. What Can and Cannot Be Emulated Locally in Microsoft Fabric
[ ] 2. Power BI Desktop — Build and Test Reports Completely Offline
[ ] 3. PySpark Locally — Run Spark Notebooks Without a Fabric Capacity
[ ] 4. Delta Lake Locally — Read and Write Delta Tables From Your Laptop
[ ] 5. VS Code + Jupyter — Developing Fabric Notebooks Before Uploading
[ ] 6. Using the Free Fabric Trial Capacity When Local Is Not Enough
[ ] 7. Pausing and Resuming Fabric Capacity to Control Costs
```

---

## Suggested Folder Layout

```text
Microsoft Fabrics/
├── README.md                                    (this file)
├── 00 - Getting Started/
│   ├── 1. What Microsoft Fabric Is.md
│   ├── 2. Signing Up.md
│   ├── 3. Fabric Pricing and F-SKUs.md
│   ├── 4. Tour of app.fabric.microsoft.com.md
│   ├── 5. Developer Tools and VS Code Extension.md
│   └── 6. Workspaces and Capacities.md
├── 01 - OneLake and Lakehouses/
├── 02 - Data Factory Pipelines/
├── 03 - Spark and Data Engineering/
├── 04 - Data Warehouse/
├── 05 - Data Science/
├── 06 - Fabric Databases and Mirroring/
├── 07 - Real-Time Intelligence/
├── 08 - Power BI and Reporting/
├── 09 - Identity, Security, and Governance/
├── 10 - Copilot and AI in Fabric/
└── 11 - Local Emulation and Low-Cost Development/
```

---

## How to Sign Up for Microsoft Fabric

Full lesson lives in `00 - Getting Started / 2. Signing Up.md`.

### Steps

```text
1. Go to https://app.fabric.microsoft.com
2. Sign in with a Microsoft work or school account
   - Personal Microsoft accounts (Outlook, Hotmail) cannot enable Fabric
   - If you have a Microsoft 365 account, try signing in with that
3. If Fabric is not enabled on your tenant, an admin must turn it on at:
     app.fabric.microsoft.com → Settings (gear) → Admin portal → Tenant settings
     → "Users can create Fabric items" → Enabled
4. Start a 60-day free Fabric Trial capacity from the account menu:
     Top-right avatar → Start trial
5. Create a Workspace and assign the Trial capacity to it
6. You are ready — create a Lakehouse, Pipeline, or Notebook
```

### What you get with a free Fabric Trial

```text
- 60-day Fabric Trial capacity (F4 or F64 depending on eligibility;
  you may be able to upgrade from F4 to F64 during the trial)
- Access to all Fabric experiences: Data Engineering, Data Warehouse,
  Data Science, Real-Time Intelligence, Power BI, Activator
- Up to 1 TB of OneLake storage included
- Power BI Individual Trial license included (if you don't already have PPU)
- NOT included in trial: Copilot, Trusted Workspace Access, AI experiences
  (Data Agents, AI Functions), and Private Link
```

> Fabric Trial requires a work/school account on a Microsoft 365 tenant.
> Personal Outlook/Hotmail accounts do not qualify.
> Alternative: if you qualify, the Microsoft 365 Developer Program offers a
> renewable E5 sandbox tenant (requires Visual Studio subscription or partner status):
> https://developer.microsoft.com/microsoft-365/dev-program

### Options if you do not have a work tenant

```text
Option A — Microsoft 365 Developer Program
  Sign up at https://developer.microsoft.com/microsoft-365/dev-program
  Eligibility required: Visual Studio subscribers, Microsoft partner
  program members, or other qualifying criteria (not open to everyone)
  If eligible, get a renewable M365 E5 sandbox with 25 user licenses
  Enable Fabric on it and start a Fabric Trial from there

Option B — Power BI Desktop (local only, Windows)
  Download free at https://powerbi.microsoft.com/desktop
  Build and test Power BI reports entirely on your laptop
  Publish to Fabric only when you have a tenant available

Option C — Organizational tenant
  Ask your company or school IT admin to enable Fabric
  Request a Fabric Trial capacity assignment for your workspace
```

---

## How Much Could It Cost?

Fabric uses a **capacity-based billing model**, not per-resource like Azure Cloud Infrastructure. You purchase or trial a Fabric capacity (measured in Capacity Units, or CUs), and that capacity runs all your workloads.

> Prices are approximate and change. Check the Fabric pricing page:
> https://azure.microsoft.com/pricing/details/microsoft-fabric/

### Capacity SKUs (F-SKUs)

```text
SKU    Capacity Units    Approximate monthly cost (pay-as-you-go)
-----  ----------------  ------------------------------------------
F2     2 CUs             ~$262 / month
F4     4 CUs             ~$524 / month
F8     8 CUs             ~$1,048 / month
F16    16 CUs            ~$2,097 / month
F64    64 CUs            ~$8,388 / month
Trial  F4 or F64         Free for 60 days (1 TB OneLake storage included)
```

### Storage costs (OneLake)

```text
OneLake data stored        ~$0.023 per GB / month
OneLake data read          Very low (fractions of a cent per GB)
OneLake data written       Very low
```

For a small learner project with a few hundred MB of data, storage is essentially free.

### Things that are free or near-free

```text
Item / Action                           Approximate cost
--------------------------------------  ----------------------------
Fabric Trial capacity (60 days)         $0
Power BI Desktop (local app)            $0
OneLake storage (first few GB)          Pennies per month
Workspace creation                      $0
Paused Fabric capacity                  $0 (compute stops billing)
Power BI Free license (report viewing)  $0 per user
```

### Things that cost money

```text
Item                              Why it costs
--------------------------------  ------------------------------------------
Active Fabric capacity (F2+)      Billed per CU-hour while capacity is active
Power BI Premium Per User (PPU)   ~$20/user/month for premium sharing features
Entra ID (advanced)               Premium P1/P2 licenses for advanced IAM
OneLake storage at scale          Low per-GB rate, adds up at terabyte scale
Fabric capacity left running      Billed whether workloads run or not — pause it
```

### Realistic costs for a learner

```text
- Reading docs and watching demos:                 $0
- Local Power BI Desktop report development:       $0
- Local PySpark + Delta Lake experimentation:      $0
- Fabric Trial with full platform access:          $0 for 60 days
- Smallest paid capacity (F2) running 24/7:        ~$262/month
- Smallest paid capacity paused nights/weekends:   ~$60–$80/month estimate
```

**The biggest beginner mistake is leaving a Fabric capacity active 24/7 when you only work a few hours per day. Pause it when done.**

---

## Local Emulation — Learning Fabric Without Paying

Microsoft Fabric does not have a local emulator the way Azure Cloud Infrastructure has Azurite or the Cosmos DB Emulator. However, several major pieces can be developed and tested entirely on your laptop.

Full lessons live in `11 - Local Emulation and Low-Cost Development/`. Quick reference:

### What can be done locally

```text
Fabric Component              Local Alternative                         Fidelity
----------------------------  ----------------------------------------  --------
Power BI reports              Power BI Desktop (free, Windows only)     Near 1:1
PySpark notebooks             PySpark via pip (Python package)          High
Delta Lake read/write         delta-spark or deltalake Python package   High
Dataflow / Power Query logic  Power Query in Power BI Desktop           Near 1:1
KQL queries                   KQL in VS Code (Kusto extension)          Partial
Data pipelines                No local emulator — use Trial capacity    Low
Warehouse (T-SQL)             DuckDB or SQL Server Developer Edition    Partial
Semantic models (DAX)         Power BI Desktop with Import mode         Near 1:1
```

### Quick-start commands

```bash
# PySpark locally — install and launch a notebook
pip install pyspark jupyterlab
jupyter lab

# Delta Lake locally (Python)
pip install deltalake pandas pyarrow
python -c "
import pandas as pd
from deltalake.writer import write_deltalake
df = pd.DataFrame({'id': [1, 2], 'value': ['a', 'b']})
write_deltalake('/tmp/my-delta-table', df)
"

# Read a local Delta table
python -c "
from deltalake import DeltaTable
dt = DeltaTable('/tmp/my-delta-table')
print(dt.to_pandas())
"

# Power BI Desktop — download installer (Windows only)
# https://powerbi.microsoft.com/desktop
# No native Mac version. Mac users can use Windows App or a VM.
```

### KQL in VS Code (without Fabric)

```bash
# Install the Kusto (KQL) extension in VS Code
code --install-extension ms-kusto.kusto

# Write .kql files and test queries against a free
# Azure Data Explorer cluster (free cluster available):
# https://dataexplorer.azure.com/freecluster
```

### When you do need the Fabric Trial or paid capacity

```text
Things that have no useful local alternative:
- Data pipelines and their triggers
- OneLake Shortcuts pointing at live data sources
- DirectLake semantic models (requires actual OneLake)
- Real-Time Intelligence Eventstreams (live event ingestion)
- Activator alerts
- Fabric REST APIs and item creation/management
- Publishing reports to workspaces and sharing with users
```

For those, use the free 60-day Fabric Trial capacity.

### Keeping the bill low after the trial ends

```text
1. Pause the Fabric capacity whenever you stop working:
     Azure Portal → Fabric Capacities → [your capacity] → Pause
   Or via CLI:
     az fabric capacity suspend --resource-group <rg> --capacity-name <name>

2. Resume when you start again:
     az fabric capacity resume --resource-group <rg> --capacity-name <name>

3. Use the smallest capacity that works for your exercises (F2 is enough for learning).

4. Store data in OneLake — it is extremely cheap. The capacity (compute) is the cost driver.

5. Put your Fabric capacity in one resource group so you can track its cost in
   Azure Cost Management easily.

6. Set a budget alert in Azure Cost Management at $10 or $20/month so you are
   notified before costs grow.
```

### Practical workflow

```text
1. Develop Power BI reports locally in Power BI Desktop.
2. Develop PySpark transformations locally with pip install pyspark.
3. Test Delta Lake read/write logic locally with the deltalake Python package.
4. Start a Fabric Trial capacity when you need the full platform.
5. Build and test pipelines, lakehouses, and warehouses in the Trial workspace.
6. Pause the capacity when done for the day.
7. Delete trial items when the lesson is finished to keep OneLake storage clean.
```

---

## How to Use This Curriculum

```text
1. Start at the top of the Progress Tracker.
2. Read the lesson file end-to-end.
3. Try the steps yourself — in Power BI Desktop locally, or in a Trial workspace.
4. Mark the lesson [x] in this file when finished.
5. Move the [>] marker to the next lesson.
```

Lessons in `00 - Getting Started` and `01 - OneLake and Lakehouses` are prerequisites for everything else. After those, sections `02` through `10` can be explored in any order depending on your focus area.
