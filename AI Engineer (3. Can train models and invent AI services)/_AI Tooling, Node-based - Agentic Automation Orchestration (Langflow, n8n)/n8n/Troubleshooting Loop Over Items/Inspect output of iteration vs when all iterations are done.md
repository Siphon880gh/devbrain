Lets go over this example workflow where you are getting all sales reports whose sales closing date is 7 days or less than today:
![[Pasted image 20250611025349.png]]

In order for this to be done, a Today value is calculated and kept at the same executive context so that the Loop node will have access to that previous node's input (the Today value)

When you double click into the date diff node, and then you execute the step - It will give you the output for 1 item:
![[Pasted image 20250611031300.png]]

No matter how many times you press it, likely it'll show the same output (Alice). This is because conceptually, you have clicked inside the Loop node of a current iteration.
- Only the first item (Alice)
  ![[Pasted image 20250611031505.png]]

But if you had clicked "Execute workflow" at the bottom of the canvas, THEN double click into the Loop node, you'll see all items:
![[Pasted image 20250611031407.png]]

- All items:
  ![[Pasted image 20250611031425.png]]
  
