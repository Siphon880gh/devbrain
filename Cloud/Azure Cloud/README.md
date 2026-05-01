# Azure for Beginners — Curriculum

A self-paced learning path for Azure, written in plain language with small, focused lessons. Each lesson is a single Markdown file. Folders group related topics.

> **You are here:** `01 - Storage / 2. Azure Blob Storage Access — Public, Private, and SAS URLs`

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
[ ] 1. Signing Up for an Azure Account (Free Tier + $200 Credit)
[ ] 2. How Azure Pricing Works (Pay-As-You-Go, Free Services, Calculators)
[ ] 3. Installing the Azure CLI, VS Code Extensions, and Azure PowerShell
[ ] 4. Tour of the Azure Portal
[ ] 5. Setting Spending Limits, Budgets, and Cost Alerts
```

### 01 — Storage

```text
[ ] 1. Azure Cloud Accounts, Storage Accounts, Containers, Blobs, and URIs
[ ] 2. Azure Blob Storage Access — Public, Private, and SAS URLs
[ ] 3. Uploading and Downloading Blobs (Portal, CLI, SDK)
[ ] 4. Access Tiers (Hot, Cool, Cold, Archive) and Lifecycle Rules
[ ] 5. Azure Files, Queues, and Tables (When to Use Each)
[ ] 6. Securing Storage Accounts (Keys, Entra ID, Private Endpoints)
```

### 02 — Compute

```text
[ ] 1. Choosing the Right Compute Service (App Service vs Functions vs VMs vs Container Apps)
[ ] 2. Azure App Service — Hosting a Website
[ ] 3. Azure Functions — Serverless Basics
[ ] 4. Virtual Machines — When You Need a Full OS
[ ] 5. Azure Container Apps and AKS Overview
```

### 03 — Databases

```text
[ ] 1. Choosing a Database (SQL vs Cosmos DB vs PostgreSQL vs MySQL)
[ ] 2. Azure SQL Database Basics
[ ] 3. Azure Cosmos DB Basics
[ ] 4. Connection Strings, Firewalls, and Private Access
```

### 04 — Networking

```text
[ ] 1. Virtual Networks, Subnets, and NSGs
[ ] 2. Public IPs, Custom Domains, and Azure DNS
[ ] 3. Application Gateway, Front Door, and Load Balancers (Overview)
```

### 05 — Identity and Security

```text
[ ] 1. Microsoft Entra ID (Formerly Azure AD)
[ ] 2. Role-Based Access Control (RBAC) and Built-in Roles
[ ] 3. Managed Identities (No More Stored Secrets)
[ ] 4. Azure Key Vault for Secrets, Keys, and Certificates
```

### 06 — DevOps and Tooling

```text
[ ] 1. Azure CLI Cheat Sheet
[ ] 2. ARM, Bicep, and Terraform (Infrastructure as Code)
[ ] 3. GitHub Actions for Azure Deployments
[ ] 4. Azure DevOps Pipelines (Brief Intro)
```

### 07 — Monitoring and Diagnostics

```text
[ ] 1. Azure Monitor and Log Analytics
[ ] 2. Application Insights for App Telemetry
[ ] 3. Reading the Activity Log and Diagnosing Failures
```

### 08 — Local Emulation and Low-Cost Development

```text
[ ] 1. Why Emulate Locally (Save Money, Faster Iteration, Offline Dev)
[ ] 2. Azurite — Free Local Emulator for Blob, Queue, and Table Storage
[ ] 3. Azure Functions Core Tools — Run Functions on Your Laptop
[ ] 4. Cosmos DB Emulator — Free Local Cosmos DB
[ ] 5. Azure SQL Edge / SQL Server in Docker — Local SQL
[ ] 6. Cheap-as-Possible Cloud Setup When Emulators Are Not Enough
[ ] 7. Cleanup Scripts and Habits to Keep the Bill Near $0
```

---

## Suggested Folder Layout

The repo currently has flat files. As more lessons are added, group them by topic. Suggested structure:

```text
Azure Cloud/
├── README.md                             (this file)
├── 00 - Getting Started/
│   ├── 1. Signing Up.md
│   ├── 2. Pricing and Free Tier.md
│   ├── 3. Installing Azure CLI and Tools.md
│   ├── 4. Tour of the Azure Portal.md
│   └── 5. Budgets and Cost Alerts.md
├── 01 - Storage/
│   ├── 1. Azure Cloud Accounts, Storage Accounts, Containers, Blobs, and URIs.md
│   ├── 2. Azure Blob Storage Access — Public, Private, and SAS URLs.md
│   └── ...
├── 02 - Compute/
├── 03 - Databases/
├── 04 - Networking/
├── 05 - Identity and Security/
├── 06 - DevOps and Tooling/
├── 07 - Monitoring and Diagnostics/
└── 08 - Local Emulation and Low-Cost Development/
```

Both Storage lessons 1 and 2 now live in `01 - Storage/`. New lessons for `00 - Getting Started/` and the rest of `01 - Storage/` are filled in alongside them.

---

## How to Sign Up for Azure

This is the short, no-fluff version. The full lesson lives in `00 - Getting Started / 1. Signing Up.md`.

### Steps

```text
1. Go to https://azure.microsoft.com/free
2. Click "Start free"
3. Sign in with a Microsoft account (Outlook, Hotmail, Live, or work email)
   - If you do not have one, create a free Microsoft account first
4. Verify your identity:
   - Phone number (SMS or call)
   - Credit or debit card (used for ID, not charged during free period)
5. Agree to the subscription agreement
6. Land in the Azure Portal at https://portal.azure.com
```

### What you get with a new free Azure account

```text
- $200 USD credit, valid for 30 days
- 12 months of "free tier" access to popular services
  (limited monthly amounts of App Service, Linux VMs, Blob Storage, SQL DB, etc.)
- 25+ services that are always free within set monthly limits
  (Azure Functions, App Service free tier F1, Cosmos DB free tier,
   Static Web Apps free, App Configuration free, etc.)
```

> Limits change. Always check the current free services list:
> https://azure.microsoft.com/free/free-account-faq

### Important: avoiding surprise charges at signup

```text
- The default subscription type after the free month is "Pay-As-You-Go"
- That can charge your card if you exceed free amounts
- To stay safe, switch to a "Free Trial" or "Azure for Students" subscription
  if eligible — these have spending limits enabled
- Set a budget alert immediately (Cost Management + Billing → Budgets)
```

---

## How Much Could It Cost?

There is no single number — Azure bills per resource, per hour or per request. But these are realistic order-of-magnitude figures for a small learner project.

> Prices are approximate and change. Always check the Azure Pricing Calculator:
> https://azure.microsoft.com/pricing/calculator

### Things that are free or near-free

```text
Service                         Approximate cost for a learner
----------------------------    -----------------------------------
Azure account (signup)          $0
Resource group                  $0 (just a label)
Storage account (created)       $0 (only data stored is billed)
Blob Storage (a few MBs)        Pennies per month
Azure Functions (consumption)   1M free executions/month
Static Web Apps (free tier)     $0 for personal sites
App Service Free (F1) plan      $0 (limited CPU/RAM, no custom domain SSL)
Cosmos DB free tier             400 RU/s and 5 GB free per account
SQL Database (free offer)       100,000 vCore seconds + 32 GB / month
Azure Key Vault                 Pennies per month for a few secrets
Microsoft Entra ID Free         $0 for basic identity features
```

### Things that can rack up a bill quickly

```text
Service                              Why it can hurt
----------------------------------   -----------------------------------------
Virtual Machines (left running)      Charged per hour even when idle
Azure Kubernetes Service (AKS)       Node VMs run 24/7
Azure Bastion                        Hourly charge, even when not connecting
Public IP addresses (Standard)       Small hourly fee per IP, adds up
Premium storage / SSD disks          Higher per-GB rate
Azure SQL Database (non-free tier)   Paid per vCore-hour
Application Gateway, Front Door      Hourly base fee plus traffic
Egress / outbound bandwidth          Free up to 100 GB/month, then per-GB
```

### Realistic monthly bills

```text
- Hello-world static site on Static Web Apps:        $0
- Personal blog on App Service Free + Blob Storage:  $0 - $1
- Small API on Functions Consumption + Cosmos free:  $0 - $2
- Small Linux B1s VM running 24/7:                   ~$8 - $15/month
- Single AKS cluster with 2 small nodes:             ~$60 - $120/month
- Idle Application Gateway you forgot about:         ~$20+/month
```

The biggest beginner mistake is **leaving things running**. Build, test, then **delete the resource group** when done. Deleting a resource group deletes everything inside it.

---

## Local Emulation — Learning Azure Without Paying

You can build and test most Azure apps on your laptop with no Azure account at all, then deploy to the cloud only when you are ready. Full lessons live in `08 - Local Emulation and Low-Cost Development/`. Quick reference:

### Free local emulators

```text
Service               Local emulator                    Cost
-------------------   -------------------------------   ----
Blob / Queue / Table  Azurite (npm, Docker, VS Code)    Free
Azure Functions       Azure Functions Core Tools        Free
Cosmos DB             Cosmos DB Emulator (Win/Linux/Mac) Free
SQL Database          Azure SQL Edge or SQL in Docker   Free
Event Hubs / Bus      Kafka or RabbitMQ in Docker       Free (not 1:1)
Storage Explorer      Azure Storage Explorer (desktop)  Free
```

### Quick-start commands

```bash
# Azurite — local Blob/Queue/Table on ports 10000/10001/10002
npm install -g azurite
azurite --silent --location ./azurite-data

# Azure Functions Core Tools
npm install -g azure-functions-core-tools@4 --unsafe-perm true
func init MyFuncProject --javascript
cd MyFuncProject && func new && func start

# Cosmos DB Emulator (Linux/macOS via Docker)
docker run -p 8081:8081 -p 10250-10255:10250-10255 \
  mcr.microsoft.com/cosmosdb/linux/azure-cosmos-emulator

# Azure SQL Edge (SQL Server compatible, runs on Apple Silicon)
docker run -e "ACCEPT_EULA=1" -e "MSSQL_SA_PASSWORD=YourStrong!Passw0rd" \
  -p 1433:1433 -d mcr.microsoft.com/azure-sql-edge
```

### Connecting your code to the emulator

The Azurite connection string is a published well-known constant:

```text
DefaultEndpointsProtocol=http;AccountName=devstoreaccount1;AccountKey=Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==;BlobEndpoint=http://127.0.0.1:10000/devstoreaccount1;
```

Use `UseDevelopmentStorage=true` in many SDKs as a shortcut.

### When you do need the cloud — keep the bill tiny

Some things cannot be fully emulated (Front Door, Entra ID, real DNS, managed identities, Application Gateway, Service Bus premium features). For those:

```text
1. Use the Free Tier whenever it exists (App Service F1, Functions Consumption,
   Cosmos free tier, Static Web Apps free, SQL serverless free offer).
2. Pick the smallest SKU that works (B1s VM, S0 SQL, Standard_LRS storage).
3. Put EVERYTHING for one experiment in ONE resource group.
4. When done, delete the resource group:
       az group delete --name rg-experiment-001 --yes --no-wait
5. Set a monthly budget alert at $1, $5, $20 — whatever your comfort level is.
6. Stop VMs when not in use:
       az vm deallocate --resource-group <rg> --name <vmName>
   (Note: "stop" alone still bills you; use "deallocate".)
7. Avoid services with hourly base fees unless you actively need them
   (Application Gateway, Front Door Premium, Bastion, AKS, Azure Firewall).
```

### Practical workflow

```text
1. Build and test locally with Azurite + Functions Core Tools.
2. Deploy to a free-tier App Service or Static Web App for staging.
3. Add a budget alert at $5/month so you get warned early.
4. Delete the resource group when the lesson is done.
```

---

## How to Use This Curriculum

```text
1. Start at the top of the Progress Tracker.
2. Read the lesson file end-to-end.
3. Try the commands or portal steps yourself.
4. Mark the lesson [x] in this file when finished.
5. Move the [>] marker to the next lesson.
```

Lessons are intentionally short and standalone, so you can jump around once you have finished `00 - Getting Started` and `01 - Storage`.
