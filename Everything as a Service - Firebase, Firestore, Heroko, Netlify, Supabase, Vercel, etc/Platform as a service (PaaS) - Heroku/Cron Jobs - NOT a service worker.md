You may think of introducing a service worker in Heroku by editing the Procfile with:
```
web: node server.js  
worker: node worker.js
```

Then having your worker.js be like:
```
import 'dotenv/config';  
import cron from 'node-cron';  
import fetch from 'node-fetch';  
  
let BASE_URL = process.env.SERVER_URL || 'http://localhost:3000';  
BASE_URL = BASE_URL.replace(/\/$/, '');   

// Runs every minute
cron.schedule('* * * * *', () => {  
  console.log('Timestamped at minute');  
  fetch(`${BASE_URL}/timestamps/`, {  
    method: 'POST'  
  });  
});
```

And your server.js be like:
```
import express from 'express';  
import fs from 'fs';  
import path from 'path';  
import { fileURLToPath } from 'url';  
  
const __filename = fileURLToPath(import.meta.url);  
const __dirname = path.dirname(__filename);  
  
const app = express();  
const port = process.env.PORT || 3000;  
  
// Middleware to parse JSON bodies  
app.use(express.json());  
  
// GET / - Basic server status  
app.get('/', (req, res) => {  
    res.json({ status: 'Server is running' });  
});  
  
// POST /timestamps/ - Record timestamp  
app.post('/timestamps/', (req, res) => {  
    const timestamp = new Date().toISOString();  
    const logFile = path.join(__dirname, 'timestamps.log');  
      
    fs.appendFile(logFile, timestamp + '\n', (err) => {  
        if (err) {  
            console.error('Error writing to log file:', err);  
            return res.status(500).json({ error: 'Failed to record timestamp' });  
        }  
        res.json({ message: 'Timestamp recorded', timestamp });  
    });  
});  
  
// GET /timestamps/ - List all timestamps  
app.get('/timestamps/', (req, res) => {  
    const logFile = path.join(__dirname, 'timestamps.log');  
      
    fs.readFile(logFile, 'utf8', (err, data) => {  
        if (err) {  
            if (err.code === 'ENOENT') {  
                return res.json({ message: 'No timestamps recorded yet', timestamps: [] });  
            }  
            console.error('Error reading log file:', err);  
            return res.status(500).json({ error: 'Failed to read timestamps' });  
        }  
          
        const timestamps = data.trim().split('\n').filter(Boolean);  
        res.json({ timestamps });  
    });  
});  
  
app.listen(port, () => {  
    console.log(`Server running on port ${port}`);  
}); 
```

And making sure you added a config variable of SERVER_URL to your app's url, excluding a trailing '/'.

---

🛑 This is not the best approach

If you're on an eco plan, your worker.js will shut down because of inactivity policies. You can, however have Heroku Scheduler wake up and run `worker.js` at appropriate times. Heroku Scheduler is designed for cron jobs on Heroku. Refer to [[Cron jobs - Heroku Scheduler]]

In that case, you **DO NOT** use worker.js' node-cron to schedule specific times using cron syntax (`* * * * *`). Just have worker.js be a normal script that runs the main executions (Making a POST request to timestamp). You would remove the worker.js entry from Procfile.

You might as well name worker.js something else, like timestamper.js and simplify its code to:
```
import 'dotenv/config';  
import fetch from 'node-fetch';  
  
let BASE_URL = process.env.SERVER_URL || 'http://localhost:3000';  
BASE_URL = BASE_URL.replace(/\/$/, '');  
  
fetch(`${BASE_URL}/timestamps/`, {  
	method: 'POST'  
});  
```