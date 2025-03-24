Error: Could not establish connection. Receiving end does not exist.

![[Pasted image 20250323181837.png]]

Why?
You ran sendMessage, but there’s no onMessage addEventListener

But if you already have an onMessage addEventListener, the sendMessage may be sending to the wrong tab! In memory, there's the chrome extension code running at specific tabs (especially active tab).