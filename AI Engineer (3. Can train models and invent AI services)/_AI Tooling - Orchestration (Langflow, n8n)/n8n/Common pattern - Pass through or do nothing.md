Sometimes you need an additional node that does nothing to make your workflow looks nicer and easy to follow, for example, nodes running in parallel on separate branches (**USE CASE**).

Found under Core, or search "Do nothing":
![[Pasted image 20250606231854.png]]

Another **USE CASE** is for taking notes. Let's say you're taking notes on how the a Loop Over Items work - probably you will take a cropped screenshot to your notetaking app. It would be nice that only the relevant nodes are identifiable:

![[Pasted image 20250606232354.png]]

^ See how you can think conceptually that 3 items are being iterated through at this moment 
^ If you enter the `Do nothing node (Iteration)`, you can see the value is neither transformed nor discarded. Nothing happens to the value coming in or out of the node:
![[Pasted image 20250606232724.png]]

Then see how you know at this other moment, that all 3 items are finished being iterated through and all 3 items are now being sent to another node:
![[Pasted image 20250606232527.png]]

This brings up another point - your do nothing or pass through nodes should still be named appropriately. Here it was lazily renamed Iteration and All in parenthesis. We could have gotten rid of the "Do nothing node" naming, however I want to make a point what this node is.

---

Another node you can use besides "Do nothing" is "Filter"
