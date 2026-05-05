Concepts at [[Job Queue]]

---

server.js that contacts n8n webhost which when finished will contact back server.js so the task can finish processing and refer to the next queued task:
```
const express = require('express');
const bodyParser = require('body-parser');
const { v4: uuidv4 } = require('uuid');
const EventEmitter = require('events');
const cors = require('cors');
require('dotenv').config();

const workTypes = {
  "scrape-deal": async (task) => {
    try {
      const response = await fetch("http://localhost:5678/webhook/....", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          ids: task.data.ids || [],
          webhookBaseUrl: "http://host.docker.internal:3001/webhook/",
          jobId: task.id
        })
      });
      
      const data = await response.json();
      console.log(`Task ${task.id} scrape-deal response:`, data);
      return data;
    } catch (error) {
      console.error(`Error processing scrape-deal task ${task.id}:`, error);
      throw error;
    }
  }
}

class TaskQueuer extends EventEmitter {
  constructor(batchSize = 10) {
    super();
    this.queue = [];
    this.processing = new Map();
    this.batchSize = batchSize;
    this.app = express();
    this.setupExpress();
  }

  setupExpress() {
    this.app.use(cors());
    this.app.use(bodyParser.json());

    // Endpoint to add tasks to the queue
    this.app.post('/queue', (req, res) => {
      const task = {
        id: uuidv4(),
        data: req.body,
        status: 'queued',
        timestamp: new Date()
      };
      this.queue.push(task);
      this.processQueue();
      res.json({ taskId: task.id, status: 'queued' });
    });

    // Webhook endpoint to mark tasks as complete
    this.app.post('/webhook/:taskId', (req, res) => {
      const { taskId } = req.params;
      const task = this.processing.get(taskId);
      
      if (task) {
        task.status = 'completed';
        task.completedAt = new Date();
        this.processing.delete(taskId);
        
        // Wait for cleanup before processing next batch
        const waitSeconds = parseInt(process.env.WAIT_FOR_CLEANUP_SECONDS) || 2;
        setTimeout(() => {
          this.processQueue(); // Process next batch if needed
        }, waitSeconds * 1000);
        
        res.json({ status: 'success', message: 'Task marked as complete' });
      } else {
        res.status(404).json({ status: 'error', message: 'Task not found' });
      }
    });

    // Endpoint to get task status
    this.app.get('/status/:taskId', (req, res) => {
      const { taskId } = req.params;
      const task = this.processing.get(taskId) || 
                   this.queue.find(t => t.id === taskId);
      
      if (task) {
        res.json(task);
      } else {
        res.status(404).json({ status: 'error', message: 'Task not found' });
      }
    });

    // Endpoint to get all tasks
    this.app.get('/tasks', (req, res) => {
      const allTasks = {
        processing: Array.from(this.processing.values()),
        queued: this.queue,
        stats: {
          processing: this.processing.size,
          queued: this.queue.length,
          batchSize: this.batchSize,
          availableSlots: this.batchSize - this.processing.size
        }
      };
      res.json(allTasks);
    });
  }

  processQueue() {
    while (this.processing.size < this.batchSize && this.queue.length > 0) {
      const task = this.queue.shift();
      task.status = 'processing';
      this.processing.set(task.id, task);
      
      // Process the task based on its type
      if (task.data.type && workTypes[task.data.type]) {
        workTypes[task.data.type](task)
          .catch(error => {
            console.error(`Error processing task ${task.id}:`, error);
            task.status = 'failed';
            task.error = error.message;
          });
      } else {
        console.error(`Unknown task type: ${task.data.type}`);
        task.status = 'failed';
        task.error = 'Unknown task type';
      }
      
      // Emit an event that the task is ready for processing
      this.emit('taskReady', task);
    }
  }

  start(port = process.env.PORT || 3001) {
    this.app.listen(port, () => {
      console.log(`Task queuer listening on port ${port}`);
    });
  }
}

module.exports = TaskQueuer;

// Example usage
if (require.main === module) {
  const queuer = new TaskQueuer(1); // Batch size of X
  
  // Example event handler
  queuer.on('taskReady', (task) => {
    console.log(`Processing task ${task.id}:`, task.data);
    // Here you would typically make an API call or perform some processing
    // The task will be marked as complete when the webhook is called
  });

  queuer.start();
} 
```


.env:
```
WAIT_FOR_CLEANUP_SECONDS=2
```