# AWS for Beginners — Curriculum

A self-paced learning path for AWS, written in plain language with small, focused lessons. Each lesson is a single Markdown file. Folders group related topics.

> **You are here:** `00 - Getting Started / 1. Signing Up for an AWS Account`

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
[ ] 1. Signing Up for an AWS Account (Free Tier — 12 Months + Always-Free Services)
[ ] 2. How AWS Pricing Works (Pay-As-You-Go, Free Tier, Spot, Reserved, Savings Plans)
[ ] 3. Installing the AWS CLI, AWS Toolkit for VS Code, and SDKs
[ ] 4. Tour of the AWS Management Console and Regions
[ ] 5. Setting Billing Alerts, Budgets, and Cost Anomaly Detection
```

### 01 — Storage

```text
[ ] 1. S3 Concepts — Buckets, Objects, Keys, Regions, and URIs
[ ] 2. S3 Access — Public, Private, Pre-Signed URLs, Bucket Policies, and ACLs
[ ] 3. Uploading and Downloading Objects (Console, CLI, SDK)
[ ] 4. S3 Storage Classes (Standard, IA, Glacier Instant, Glacier Deep Archive) and Lifecycle Rules
[ ] 5. Other Storage Services — EBS, EFS, and S3 Glacier (When to Use Each)
[ ] 6. Securing S3 (IAM Policies, Bucket Policies, Block Public Access, Encryption)
```

### 02 — Compute

```text
[ ] 1. Choosing the Right Compute Service (EC2 vs Lambda vs Fargate vs Elastic Beanstalk vs App Runner)
[ ] 2. EC2 — Launching and Connecting to a Virtual Machine
[ ] 3. Lambda — Serverless Functions Basics
[ ] 4. Elastic Beanstalk — PaaS for Web Applications
[ ] 5. ECS and Fargate — Containers Without Managing Servers
[ ] 6. EKS Overview (Managed Kubernetes on AWS)
[ ] 7. App Runner — Simple Container Hosting Without Cluster Management
```

### 03 — Databases

```text
[ ] 1. Choosing a Database (RDS vs DynamoDB vs Aurora vs ElastiCache vs Redshift)
[ ] 2. RDS Basics (MySQL, PostgreSQL, MariaDB — Managed Relational DB)
[ ] 3. DynamoDB Basics (NoSQL — Key-Value and Document)
[ ] 4. Aurora Basics (MySQL/PostgreSQL-compatible, Serverless Option)
[ ] 5. Connection Strings, Security Groups, and VPC Access
```

### 04 — Networking

```text
[ ] 1. VPC, Subnets, Security Groups, NACLs, and Route Tables
[ ] 2. Route 53 — DNS, Hosted Zones, and Domain Registration
[ ] 3. Load Balancers — ALB, NLB, and When to Use Each
[ ] 4. CloudFront — CDN and Edge Caching
[ ] 5. API Gateway — HTTP and REST APIs in Front of Lambda or EC2
```

### 05 — Messaging and Integration

```text
[ ] 1. SQS — Simple Queue Service (Standard vs FIFO, Dead-Letter Queues)
[ ] 2. SNS — Simple Notification Service (Pub/Sub, Fan-Out Pattern)
[ ] 3. EventBridge — Event-Driven Architectures and Rules
[ ] 4. Step Functions — Orchestrating Workflows with State Machines
[ ] 5. When to Use SQS vs SNS vs EventBridge vs Step Functions
```

### 06 — Identity and Security

```text
[ ] 1. IAM — Users, Groups, Roles, Policies, and the Principle of Least Privilege
[ ] 2. IAM Roles for Services (EC2, Lambda, ECS — No Stored Credentials)
[ ] 3. Cognito — User Authentication and Authorization for Apps
[ ] 4. AWS Secrets Manager and SSM Parameter Store
[ ] 5. AWS KMS — Key Management and Encryption at Rest
[ ] 6. AWS Organizations and Service Control Policies (Multi-Account Overview)
```

### 07 — DevOps and Tooling

```text
[ ] 1. AWS CLI Cheat Sheet
[ ] 2. CloudFormation (Infrastructure as Code — YAML/JSON Templates)
[ ] 3. AWS CDK (Infrastructure as Code — TypeScript/Python/Java)
[ ] 4. Terraform with AWS
[ ] 5. CodePipeline, CodeBuild, and CodeDeploy (AWS Native CI/CD)
[ ] 6. GitHub Actions for AWS Deployments
```

### 08 — Monitoring and Diagnostics

```text
[ ] 1. CloudWatch Logs and Metrics — Observability Basics
[ ] 2. CloudWatch Alarms, Dashboards, and Log Insights
[ ] 3. CloudTrail — Audit Logs for Every API Call
[ ] 4. AWS X-Ray — Distributed Tracing for Serverless and Microservices
```

### 09 — Local Emulation and Low-Cost Development

```text
[ ] 1. Why Emulate Locally (Save Money, Faster Iteration, Offline Dev)
[ ] 2. LocalStack — Free Local Emulator for S3, Lambda, DynamoDB, SQS, SNS, and More
[ ] 3. AWS SAM CLI — Run Lambda and API Gateway on Your Laptop
[ ] 4. DynamoDB Local — Official Amazon DynamoDB Emulator
[ ] 5. LocalStack Paid Plans and Limits (What the Free Hobby Tier Cannot Emulate)
[ ] 6. Cheap-as-Possible Cloud Setup When Emulators Are Not Enough
[ ] 7. Cleanup Scripts and Habits to Keep the Bill Near $0
```

---

## Suggested Folder Layout

```text
AWS Cloud - Curriculum/
├── README.md                             (this file)
├── 00 - Getting Started/
│   ├── 1. Signing Up.md
│   ├── 2. Pricing and Free Tier.md
│   ├── 3. Installing AWS CLI and Tools.md
│   ├── 4. Tour of the AWS Console.md
│   └── 5. Budgets and Cost Alerts.md
├── 01 - Storage/
│   ├── 1. S3 Concepts — Buckets, Objects, Keys, and URIs.md
│   ├── 2. S3 Access — Public, Private, Pre-Signed URLs.md
│   └── ...
├── 02 - Compute/
├── 03 - Databases/
├── 04 - Networking/
├── 05 - Messaging and Integration/
├── 06 - Identity and Security/
├── 07 - DevOps and Tooling/
├── 08 - Monitoring and Diagnostics/
└── 09 - Local Emulation and Low-Cost Development/
```

---

## How to Sign Up for AWS

This is the short, no-fluff version. The full lesson lives in `00 - Getting Started / 1. Signing Up.md`.

### Steps

```text
1. Go to https://aws.amazon.com/free
2. Click "Create a Free Account"
3. Enter an email address and choose an account name
4. Set a root account password (keep this secure — treat it like a master key)
5. Choose "Personal" for account type
6. Enter contact information and verify your phone number
7. Enter a credit or debit card (used for ID and any charges beyond the free tier)
8. Select a Support plan — choose "Basic support" (free)
9. Land in the AWS Management Console at https://console.aws.amazon.com
10. Immediately create an IAM user or IAM Identity Center user for day-to-day use
    — never use the root account for regular work
```

### What you get with a new free AWS account

```text
Always Free (no expiry):
- Lambda: 1,000,000 requests/month and 400,000 GB-seconds compute
- DynamoDB: 25 GB storage, 25 WCU, 25 RCU
- CloudWatch: 10 custom metrics, 1,000,000 API requests, 5 GB log ingestion
- SNS: 1,000,000 publishes
- SQS: 1,000,000 requests
- S3 Glacier: 10 GB retrievals/month
- CodeBuild: 100 build minutes/month

Free for 12 months from signup:
- EC2: 750 hrs/month of t2.micro (or t3.micro in regions without t2.micro)
- S3: 5 GB Standard storage, 20,000 GET, 2,000 PUT requests/month
- RDS: 750 hrs/month of db.t2.micro or db.t3.micro, 20 GB storage
- CloudFront: 1 TB data transfer out, 10,000,000 HTTP/HTTPS requests/month
- Elastic Load Balancing: 750 hrs/month (ALB or CLB), 15 LCUs (ALB) or 15 GB data (CLB)
```

> Free tier limits change. Always check: https://aws.amazon.com/free

### Important: avoiding surprise charges at signup

```text
- The free tier is NOT a hard spending cap — you can still be charged
  if you go over any limit, even accidentally
- Set a billing alert immediately (Billing → Budgets → Create a budget)
- Enable Cost Anomaly Detection so AWS emails you if spending spikes
- Never leave EC2 instances, RDS instances, or NAT Gateways running
  when you are not actively using them — they bill by the hour
- Since Feb 2024, ALL public IPv4 addresses cost $0.005/hr (~$3.60/mo)
  — this applies to EC2, RDS, ELB, and any service with a public IP
- Elastic IPs that are NOT attached to a running instance are also charged
  ($0.005/hr) — always release them when done
```

---

## How Much Could It Cost?

There is no single number — AWS bills per resource, per hour, or per request. These are realistic order-of-magnitude figures for a small learner project.

> Prices are approximate and change. Always check the AWS Pricing Calculator:
> https://calculator.aws/

### Things that are free or near-free

```text
Service                              Approximate cost for a learner
----------------------------------   -----------------------------------
AWS account (signup)                 $0
IAM users, groups, roles             $0
S3 bucket (created, empty)           $0 (only stored data is billed)
S3 Standard (a few MBs)              Pennies per month
Lambda (consumption)                 1M free requests/month, always free
DynamoDB (free tier)                 25 GB + 25 WCU/RCU always free
CloudFront (first 12 months)         1 TB/month free
API Gateway (HTTP API)               ~$1 per million calls
Elastic Beanstalk                    $0 (you pay for underlying EC2/RDS)
CloudWatch basic monitoring          $0
CloudTrail (one trail, management)   $0
```

### Things that can rack up a bill quickly

```text
Service                              Why it can hurt
----------------------------------   -----------------------------------------
EC2 instances (left running)         Charged per hour, even when idle
RDS instances (left running)         Charged per hour, even with zero queries
NAT Gateway                          $0.045/hr base + $0.045/GB — adds up fast
Public IPv4 addresses (all)          $0.005/hr per IP (~$3.60/mo each) since Feb 2024
Elastic IPs (unattached)             Same $0.005/hr — release immediately when done
EKS cluster                          $0.10/hr cluster fee + node EC2 costs
Data transfer out (egress)           Free first 100 GB/month, then per-GB
ALB / NLB                            ~$0.0225/hr base + LCU/NLCU charges
Amazon Macie, GuardDuty              Per-GB analysis fees can spike with logs
RDS Multi-AZ                         Doubles the instance cost
S3 Intelligent-Tiering               Per-object monitoring fee for small objects
```

### Realistic monthly bills

```text
- Static site on S3 + CloudFront:                   $0 - $1
- Simple API on Lambda + DynamoDB free tier:         $0 - $2
- Personal project on EC2 t3.micro (12 months):      $0 (free tier)
- EC2 t3.micro after free tier expires:              ~$8 - $10/month
- RDS db.t3.micro (after 12-month free tier):        ~$13 - $15/month
- NAT Gateway running 24/7:                          ~$32 - $50/month
- EKS cluster with 2 small nodes:                   ~$70 - $130/month
- RDS Multi-AZ (left running accidentally):          ~$30+/month
```

The biggest beginner mistake is **leaving things running**. Build, test, then **terminate resources** when done. Use resource tags so you can find and delete everything from a single experiment.

---

## Local Emulation — Learning AWS Without Paying

You can build and test most AWS apps on your laptop with no AWS account at all, then deploy to the cloud only when ready. Full lessons live in `09 - Local Emulation and Low-Cost Development/`. Quick reference:

### Free local emulators

```text
Service                   Local emulator                          Cost
------------------------  --------------------------------------  ----
S3, SQS, SNS, Lambda,
DynamoDB, API Gateway,
CloudFormation, IAM,
Kinesis, SES, and more    LocalStack (Docker or pip)              Free (Hobby plan, requires signup)
Lambda + API Gateway       AWS SAM CLI (sam local)                 Free
DynamoDB                  DynamoDB Local (Docker, jar)            Free
S3 (basic)                Minio (S3-compatible, Docker)           Free
EventBridge local         LocalStack                              Free (Hobby plan)
Cognito (local mock)      Cognito Local (npm)                     Free (unofficial)
```

### Quick-start commands

```bash
# LocalStack — emulates most AWS services on port 4566
# As of 2026, a free account + auth token is required (even for the Hobby plan).
# Sign up at https://app.localstack.cloud and get your token.
docker run --rm -it \
  -p 4566:4566 \
  -p 4510-4559:4510-4559 \
  -e LOCALSTACK_AUTH_TOKEN=${LOCALSTACK_AUTH_TOKEN} \
  localstack/localstack

# Or install and run via pip
pip install localstack
localstack auth set-token <your-token>
localstack start

# Create an S3 bucket in LocalStack
aws s3 mb s3://my-test-bucket --endpoint-url http://localhost:4566

# List buckets
aws s3 ls --endpoint-url http://localhost:4566

# AWS SAM CLI — run Lambda functions and API Gateway locally
pip install aws-sam-cli
sam init --runtime nodejs20.x --name my-app
cd my-app
sam local invoke HelloWorldFunction
sam local start-api            # starts a local HTTP server on port 3000

# DynamoDB Local (official Amazon emulator via Docker)
docker run -p 8000:8000 amazon/dynamodb-local

# Create a table in DynamoDB Local
aws dynamodb create-table \
  --table-name MyTable \
  --attribute-definitions AttributeName=id,AttributeType=S \
  --key-schema AttributeName=id,KeyType=HASH \
  --billing-mode PAY_PER_REQUEST \
  --endpoint-url http://localhost:8000

# Minio — S3-compatible object storage
docker run -p 9000:9000 -p 9001:9001 \
  -e MINIO_ROOT_USER=minioadmin \
  -e MINIO_ROOT_PASSWORD=minioadmin \
  quay.io/minio/minio server /data --console-address ":9001"
```

### Connecting your code to LocalStack

Set dummy credentials (LocalStack accepts any value for AWS keys) and point the endpoint at localhost:

```bash
# In your shell or .env
export AWS_ACCESS_KEY_ID=test
export AWS_SECRET_ACCESS_KEY=test
export AWS_DEFAULT_REGION=us-east-1
export AWS_ENDPOINT_URL=http://localhost:4566
```

With the `AWS_ENDPOINT_URL` environment variable set, the AWS CLI and all official SDKs (Python boto3, Node.js `@aws-sdk/client-*`, Go, Java) automatically route to LocalStack without any code changes.

In Python:

```python
import boto3

s3 = boto3.client(
    "s3",
    endpoint_url="http://localhost:4566",
    aws_access_key_id="test",
    aws_secret_access_key="test",
    region_name="us-east-1",
)
```

### What LocalStack Hobby tier (free) can and cannot emulate

> LocalStack consolidated into a single image in 2026. A free Hobby plan
> (non-commercial) replaces the old community edition. Sign up at
> https://app.localstack.cloud to get an auth token.

```text
Fully supported (Hobby / free tier):
  S3, Lambda, DynamoDB, SQS, SNS, API Gateway (REST + HTTP),
  IAM, CloudFormation, CloudWatch Logs, EventBridge, Kinesis,
  SES, SSM Parameter Store, Secrets Manager, Route 53, STS,
  ECR, ECS (basic), Elasticsearch/OpenSearch (basic)

Requires a paid plan (Starter / Pro / Team):
  Cognito (full), RDS (full relational), ElastiCache, MSK (Kafka),
  AppSync, Transfer Family, WorkSpaces, WAF advanced features,
  cross-account IAM simulation
```

### When you do need the cloud — keep the bill tiny

Some services cannot be fully emulated locally (Cognito full auth flows, real ACM certificates, CloudFront distributions, real DNS, managed identities). For those:

```text
1. Use the Free Tier whenever it exists:
   Lambda (always free), DynamoDB (always free), S3 (first 12 months),
   EC2 t2/t3.micro (first 12 months), RDS t2/t3.micro (first 12 months).
2. Pick the smallest SKU — t3.micro EC2, db.t3.micro RDS, single-AZ.
3. Tag EVERYTHING for one experiment with the same tag (e.g. project=lesson-04).
4. When done, delete by tag using the Tag Editor or a CLI loop:
       aws resourcegroupstaggingapi get-resources \
         --tag-filters Key=project,Values=lesson-04 \
         --query 'ResourceTagMappingList[].ResourceARN'
5. Terminate EC2 instances (not just stop — terminate):
       aws ec2 terminate-instances --instance-ids i-xxxxxxxxxxxxxxxxx
6. Delete RDS instances with --skip-final-snapshot:
       aws rds delete-db-instance \
         --db-instance-identifier my-db \
         --skip-final-snapshot
7. Release Elastic IPs immediately after you no longer need them:
       aws ec2 release-address --allocation-id eipalloc-xxxxxxxxxxxxxxxxx
8. Avoid NAT Gateways unless strictly required — use VPC endpoints or
   public subnets for learning projects.
9. Set a monthly budget alert at $5 - $20 (your comfort level):
       AWS Console → Billing → Budgets → Create a budget
```

### Practical workflow

```text
1. Build and test locally with LocalStack + SAM CLI.
2. Deploy to the cloud only when testing real auth, DNS, or managed services.
3. Set a budget alert at $5/month so you get warned before things add up.
4. Terminate all resources (EC2, RDS, NAT GW) when the lesson is done.
5. Run a final check: AWS Console → Billing → Cost Explorer to confirm $0.
```

---

## How to Use This Curriculum

```text
1. Start at the top of the Progress Tracker.
2. Read the lesson file end-to-end.
3. Try the commands or console steps yourself.
4. Mark the lesson [x] in this file when finished.
5. Move the [>] marker to the next lesson.
```

Lessons are intentionally short and standalone, so you can jump around once you have finished `00 - Getting Started` and `01 - Storage`.
