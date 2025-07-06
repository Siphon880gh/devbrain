The free plan does **not** support concurrent executions. If you trigger two workflows at the same time, one may fail.

Additionally, triggering a workflow immediately after it finishes can cause issues—wait a few seconds before triggering again. Otherwise, some workflows may fail (you could have multiple consecutive workflows fail). If you have a script that triggers workflow one at a time (for example, on your local machine or a VPS/dedicated server that makes a request across the internet to the workflow's webhook URL), you need to add a few seconds between each trigger.

The paid plan **does** support concurrency, with the entry-level tier allowing up to **five** simultaneous connections.