At the Looping branch, each item is actually piped through the "Loop" branch. The "Done" branch runs only after the "Loop" branches are run for as many iterations as there are inputs. When the workflow is not running, it may not be clear that it's actually 1 item being piped in for 3 times. It seems to follow the same convention of how many items are piped in and piped out as if it's any other node

![[Pasted image 20250611012503.png]]

However, if you actually run the workflow, you'll watch that they became 1 item labels, then 2 item labels, then 3 items label, especially with a Wait node (otherwise it goes too fast for you to notice the number incrementing):
![[Pasted image 20250611012817.png]]
 
![[Pasted image 20250611012831.png]]
  ![[Pasted image 20250611012843.png]]
