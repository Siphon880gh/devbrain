
Both live under the Microsoft Azure umbrella and share the same portal, billing, and identity system. But they solve completely different problems for completely different audiences.

---

## One-Line Distinction

```text
Azure Cloud Infrastructure  →  Build and run applications
Microsoft Fabric            →  Analyze and report on data
```

---

## What This Curriculum Covers: Azure Cloud Infrastructure

This curriculum is about **building and operating software** on Azure.

The audience is:

```text
- Software developers
- Backend engineers
- DevOps / platform engineers
- Full-stack developers deploying to the cloud
```

The core question it answers:

> "How do I host my app, API, database, and background jobs on Azure?"

Services covered:

| Category | Services |
|---|---|
| Compute | App Service, Azure Functions, Virtual Machines, Container Apps, AKS |
| Storage | Blob Storage, File Storage, Queue Storage, Table Storage |
| Databases | Azure SQL Database, PostgreSQL, MySQL, Cosmos DB |
| Networking | VNets, NSGs, DNS, Load Balancer, Application Gateway, Front Door |
| Identity | Microsoft Entra ID, RBAC, Managed Identity, Key Vault |
| DevOps | Azure CLI, Bicep, Terraform, GitHub Actions, Azure DevOps |
| Monitoring | Azure Monitor, Log Analytics, Application Insights |
| Local Dev | Azurite, Functions Core Tools, Cosmos DB Emulator, SQL Edge |

---

## What Microsoft Fabric Is

Microsoft Fabric is a **unified analytics platform** for working with large-scale data.

It was launched in 2023 and consolidates several previously separate Microsoft analytics products into one experience with a shared storage layer called **OneLake**.

The audience is:

```text
- Data engineers
- Data scientists
- Business intelligence (BI) analysts
- Analytics architects
```

The core question it answers:

> "How do I ingest, transform, store, analyze, and visualize large datasets?"

### Components of Microsoft Fabric

| Component | What It Does | Previous Product It Replaced/Unified |
|---|---|---|
| OneLake | Unified data lake storage layer for all Fabric items | Azure Data Lake Storage Gen2 |
| Data Factory | ETL pipelines — move and transform data | Azure Data Factory |
| Synapse Data Engineering | Spark-based data transformation (notebooks, jobs) | Azure Synapse Spark pools |
| Synapse Data Warehouse | SQL-based analytical data warehouse | Azure Synapse dedicated SQL pool |
| Synapse Data Science | ML model training and experimentation | Azure Machine Learning (partially) |
| Real-Time Intelligence | Stream processing and real-time analytics | Azure Stream Analytics / Event Hubs |
| Power BI | Business intelligence reports and dashboards | Power BI (unchanged) |
| Data Activator | Trigger alerts/actions when data conditions are met | New |

---

## Side-by-Side Comparison

| Dimension | Azure Cloud Infrastructure | Microsoft Fabric |
|---|---|---|
| Primary purpose | Run applications and services | Analyze and understand data |
| Who uses it | Software/DevOps engineers | Data engineers, data scientists, BI analysts |
| Core workload | Web apps, APIs, background jobs | ETL pipelines, data warehouses, ML, dashboards |
| Storage | Blob containers, SQL tables, Cosmos collections | OneLake (Delta/Parquet files), Warehouse tables |
| Query language | SQL, app-level code | SQL, KQL, Spark (PySpark / Scala), DAX (Power BI) |
| Compute model | Always-on or serverless per request | Spark clusters, SQL compute, dedicated capacity |
| Billing model | Pay-per-resource (per hour, per request) | Fabric capacity (F-SKUs: F2, F4, F8, etc.) |
| Output | A running application | Reports, dashboards, ML models, transformed datasets |
| Portal entry point | portal.azure.com | app.fabric.microsoft.com |

---

## Where They Overlap

The two are not completely separate — they can work together:

```text
1. Blob Storage / ADLS Gen2
   Azure Cloud Infrastructure uses Blob Storage for app file storage.
   Microsoft Fabric uses Blob Storage (via OneLake shortcuts) as its underlying lake.
   → The same storage account can serve both.

2. Microsoft Entra ID
   Both use the same identity platform for authentication and RBAC.
   Fabric workspace roles are built on top of Entra ID.

3. Azure Monitor
   Fabric workloads can emit logs/metrics to Azure Monitor.

4. Azure SQL Database
   An app's transactional SQL database (covered in this curriculum) can be
   mirrored into Fabric's Warehouse for analytics — without copying data.

5. Event Hubs / Kafka
   Azure Infrastructure can produce events (from an app) that Fabric's
   Real-Time Intelligence consumes for stream analytics.
```

A typical combined architecture:

```text
User → Web app (App Service)
     → Writes to Azure SQL Database   ← transactional, covered in this curriculum
                    ↓
             Fabric Mirroring
                    ↓
         Fabric Warehouse (OneLake)   ← analytical, Fabric territory
                    ↓
              Power BI report         ← business reporting
```

---

## Which Do You Need?

```text
"I want to build a web app, REST API, or background service."
  → This curriculum. Azure Cloud Infrastructure.

"I want to store and serve user files."
  → This curriculum. Blob Storage.

"I want to analyze log data or events from my app."
  → Start here (Application Insights, Log Analytics).
    Fabric becomes relevant when data volumes or cross-system queries grow large.

"I want to build dashboards and reports for business users."
  → Microsoft Fabric (Power BI is part of Fabric).

"I want to transform large volumes of raw data from multiple sources."
  → Microsoft Fabric (Data Factory pipelines, Spark notebooks).

"I want to train ML models on large datasets."
  → Microsoft Fabric (Data Science workloads) or Azure Machine Learning.

"I want to build a data warehouse for analytics."
  → Microsoft Fabric (Synapse Data Warehouse / Warehouse item).
```

---

## Learning Path Notes

This curriculum (the `Azure Cloud` vault) does not cover Microsoft Fabric.

If you finish this curriculum and want to continue into the data/analytics space, a natural next step is a separate **Microsoft Fabric** learning path, which would cover:

```text
1. OneLake and the Lakehouse concept
2. Data Factory pipelines in Fabric
3. Spark notebooks for data transformation
4. Fabric Warehouse (analytical SQL)
5. Power BI reports and semantic models
6. Real-Time Intelligence (event streams)
7. Fabric capacities and cost management
```

---

## Quick Reference: Which Portal?

| Task | Go To |
|---|---|
| Deploy a web app | portal.azure.com |
| Create a storage account | portal.azure.com |
| Spin up a VM | portal.azure.com |
| Set up a database for an app | portal.azure.com |
| Build an ETL pipeline | app.fabric.microsoft.com |
| Create a Power BI report | app.fabric.microsoft.com |
| Run a Spark transformation job | app.fabric.microsoft.com |
| Build a data warehouse | app.fabric.microsoft.com |
| Query logs from your app | portal.azure.com (Log Analytics) |
| Analyze business data at scale | app.fabric.microsoft.com |
