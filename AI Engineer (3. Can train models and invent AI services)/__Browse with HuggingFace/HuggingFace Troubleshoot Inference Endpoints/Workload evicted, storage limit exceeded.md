You try to start an Inference Endpoint (aka Dedicated) but you got this error:
```
Workload evicted, storage limit exceeded
```

![[Pasted image 20250219193809.png]]

Go to Settings and change the storage space to a higher tier. In this example, we were using 2GB when the error is hit. Here I'm upgrading to 4gb (despite the storage limit error recommending 8G!)
![[Pasted image 20250219193856.png]]

Here's how you can estimate the GB
Bump up to the next storage tier or
Estimate the total file size from the "Files and versions" tab.


Then click Resume or Retry