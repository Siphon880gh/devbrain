Say you have a node that runs for each item in the input. 

That could be costly if it's a community node that connects to a third party service that charges you by the credit.

You are still developing the logic in n8n and don't need it to run for every item at inputs. Go to the node's Settings and tick on "Execute Once". 

![[Pasted image 20250606230314.png]]

**Caveat**: You may want to record in your project management tool that you've enabled Execute Once. At production, you have to disable the "Execute Once" so that your workflow works for all inputs as expected.