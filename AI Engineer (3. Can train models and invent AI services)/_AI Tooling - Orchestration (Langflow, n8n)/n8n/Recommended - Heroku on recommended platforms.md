
To run n8n with community nodes reliably, move to a platform that supports persistent storage:

| Platform              | Persistent Storage | Notes                                 |
| --------------------- | ------------------ | ------------------------------------- |
| **VPS/Dedicated**     | ✅ Yes             | Full control, great for custom setups |
| **AWS ECS/Lightsail** | ✅ Yes             | Scalable, ideal for production use    |
| **Fly.io**            | ✅ Yes             | Lightweight, supports volumes         |
| **Render.com**        | ✅ Yes             | Docker support + persistent disk      |
| **Railway.app**       | ✅ Yes             | Simple deployment, supports volumes   |

These platforms let your container retain installed nodes and other local changes even after restarts or redeploys.

---

If you do not have community nodes in the workflow, you can setup as Heroku. If you do add community nodes, you will run into these problems described in [[Recommended, Not - n8n on Heroku with community nodes]]