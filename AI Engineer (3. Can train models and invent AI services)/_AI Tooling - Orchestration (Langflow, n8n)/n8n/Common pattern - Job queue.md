In the context of:

The free tier of n8n doesn’t support concurrent connections, so you’ll need to process workflows one at a time. Here’s a streamlined approach:

1. **Single-job batch**  
    Configure your server’s job queue to a batch size of 1—only one task can be active at any given moment. Each queued task should include any POST-body data your n8n webhook needs.
    
2. **Trigger and completion hooks**
    
    - When a task becomes active, your server calls the n8n webhook to start the workflow.
        
    - At the end of the workflow, n8n sends a “completion” webhook back to your server so it knows the job has finished.
        
3. **Cleanup delay**  
    Before marking the task fully done, insert a short delay (e.g. 2 seconds) as “cleanup time.” Only after that pause should the queue dequeue and trigger the next n8n webhook. This ensures no overlapping connections on the free tier.