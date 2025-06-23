You may hear these words thrown around in other software dev teams if you're not working directly with Jenkins, CircleCI, Github Actions, or CI/CD.

### **Jenkins**

- **What it is:** An **automation server** for **CI/CD (Continuous Integration / Continuous Deployment)**.
    
- **Used for:** Automating tasks like building, testing, and deploying your code.
    
- **Relation to GitHub:**
    
    - Jenkins can **connect to GitHub** to trigger builds when code is pushed.
    - GitHub Actions (built-in to GitHub) is a **newer alternative** to Jenkins, offering native CI/CD workflows.
        
- **Compare with GitHub Actions:**
    - Jenkins is **self-hosted and plugin-heavy** (more customizable).
    - GitHub Actions is **cloud-native and tightly integrated** with GitHub — easier to set up for smaller teams.
        
### **CircleCI**

- **What it is:** A **cloud-based CI/CD platform** for automating software delivery.
    
- **Used for:** Fast builds, parallel testing, and deployment pipelines.
    
- **GitHub integration:** Tight GitHub and GitHub Enterprise support.
    
- **Pros:** Focused on **performance and speed**, great caching and parallelism tools. **Docker-friendly**.
    
- **Cons:** Some advanced features require paid tiers; YAML config can be verbose.