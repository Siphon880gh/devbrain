## Fast Stats

### Downside
As of 4/2026: Fly.io uses usage-based billing, but **it does not offer a strict hard spending cap**—you’ll be charged if you exceed the free allowance. You can mitigate risk by monitoring usage and setting alerts, but you can’t enforce a true “stop at $X” limit.

### Domain support

You can attach your own domain (e.g. `yourapp.com`) to your app, then point your DNS to Fly using A/AAAA or CNAME records, and Fly will **automatically handle HTTPS certificates (Let’s Encrypt)**. You can use your own domain just like any production app, not just the default `*.fly.dev` URL.

---

## What Fly.io Is

Fly.io is a **Platform as a Service (PaaS)** that lets you deploy full-stack applications close to users around the world.

👉 [Fly.io official site](https://fly.io/?utm_source=chatgpt.com)

**PaaS = you deploy code, the platform handles infrastructure**

That means:

- No server setup
    
- No OS management
    
- No manual scaling configuration
    
- No networking headaches
    

You push your app → Fly runs it on global infrastructure.

---

## Why Developers Like Fly.io

Fly sits in an interesting middle ground:

- More control than static hosts like Netlify
    
- Less infrastructure burden than raw cloud like AWS
    

You get:

- Real servers (VMs, not just serverless functions)
    
- Global deployment (run apps near users)
    
- Docker-based workflow (very dev-friendly)
    
- Persistent volumes (for stateful apps)
    

---

## Free Tier (What You Actually Get)

Fly.io has a **generous but not unlimited free allowance**:

- **Compute**
    
    - Up to **3 small VMs (256MB RAM each)**
        
- **Storage**
    
    - **3GB persistent volume storage**
        
- **Billing**
    
    - Free as long as you stay within limits
        
    - **Credit card required after ~7 days**
        
- **Usage model**
    
    - Pay only if you exceed free resources
        

💡 Apps can scale down or sleep when idle, helping keep usage within free limits.

---

## What You Can Host (By Level)

### 1. Simple Apps (Fits fully in free tier)

**Examples:**

- Personal portfolio site
    
- Marketing website with backend
    
- Small REST API (Node.js, Flask, PHP)
    
- Internal tools (admin dashboards)
    

**Stack examples:**

- `Node.js + Express`
    
- `Python + FastAPI`
    
- `PHP + Laravel`
    

---

### 2. Full-Stack Apps (Still free or low cost)

**Examples:**

- SaaS MVP
    
- Auth + API + database app
    
- Real estate app (like your video listings idea)
    
- CRUD dashboards with login
    

**Stack examples:**

- `Next.js (App Router) + API routes`
    
- `React frontend + Node backend`
    
- `Postgres running on Fly volumes`
    

💡 You can run:

- Backend API on one machine
    
- Worker/cron job on another
    
- Database on a volume
    

---

### 3. Real-Time / Stateful Apps

**Examples:**

- WebSocket apps (chat, live dashboards)
    
- Multiplayer or collaborative tools
    
- Queue workers / background jobs
    

Fly is strong here because:

- It runs **long-lived processes**
    
- Not limited like serverless timeouts
    

---

### 4. Globally Distributed Apps

**Examples:**

- Low-latency APIs
    
- Edge-like deployments
    
- Geo-aware services
    

Fly lets you:

- Deploy the same app to multiple regions
    
- Route users to the nearest instance
    

---

## How It Works (Dev Workflow)

Typical flow:

1. Install CLI:
    
    ```bash
    brew install flyctl
    ```
    
2. Launch app:
    
    ```bash
    fly launch
    ```
    
3. Deploy:
    
    ```bash
    fly deploy
    ```
    

Behind the scenes:

- Builds a Docker image
    
- Deploys to Fly VMs (“Machines”)
    
- Exposes via global Anycast network
    

---

## Key Concepts

- **Machines** → lightweight VMs running your app
    
- **Volumes** → persistent disk (for DB/files)
    
- **Regions** → deploy near users globally
    
- **Services** → HTTP/TCP routing layer
    

---

## When to Use Fly.io

Use Fly if you want:

✅ Full backend control (not just serverless)  
✅ Simple deployment without DevOps overhead  
✅ Global apps with low latency  
✅ Docker-based workflows  
✅ Cheap MVP infrastructure

---

## When NOT to Use It

Skip Fly if you need:

❌ Fully managed DB (like Firebase/Supabase out of the box)  
❌ Pure frontend hosting (Netlify/Vercel simpler)  
❌ Enterprise AWS-level ecosystem

---

## Quick Positioning

- **Fly.io** → Full-stack PaaS with real servers
    
- **Heroku** → Similar concept, less global edge focus
    
- **Vercel/Netlify** → Frontend-first + serverless
    
- **AWS/GCP** → Maximum control, more complexity
    

---

## TL;DR

Fly.io is:

> A developer-friendly PaaS where you deploy full-stack apps (with real servers) globally, without managing infrastructure — and you can run surprisingly capable apps within the free tier.

---

If you want, I can tailor this specifically to your stack (Next.js + Supabase + n8n style workflows) or show a real deployment architecture.