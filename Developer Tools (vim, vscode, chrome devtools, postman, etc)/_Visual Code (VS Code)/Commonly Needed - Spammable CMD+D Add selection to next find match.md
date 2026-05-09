Lets say you have an array of objects with identical keys in the same order.

You want to move a property up one line.

Before:
![[Pasted image 20250609011428.png]]

After (Email field now moved above username field):
![[Pasted image 20250609011448.png]]

You could achieve this using regex find and substitute:
```
(.*\n)(.*"b_key".*\n)  
  
$2$1
```

However that's not as intuitive as using the CMD+D or CTRL+D shortcut key

Select email key:
![[Pasted image 20250609011808.png]]

Then press CMD+D or CTRL+D. You'll notice on the right side where the scrollbar is, a horizontal white stripe appears. Spam the CMD+D or CRL+D to select the other emails.
![[Pasted image 20250609012236.png]]


You may not see the selections, but all the same keywords are being highlighted off the screen too:
![[Pasted image 20250609011428.png]]

You're spamming the CMD+D. And as you spam the shortcut keys, there are more horizontal lines added to the right scrollbar:
![[Pasted image 20250609011001.png]]


You think you're done. But opps, let's say you had started this shortcut spamming from the second object. Looking on the right scroll bar, you see we missed the first object. Pressing CMD+D or CTRL+D will loop back to add the first matches from the top of the document. So spam a bit more.
![[Pasted image 20250609011128.png]]

Once all instances are added to the selection:
![[Pasted image 20250609011209.png]]

Then perform your text manipulation. In our case, we want to move the email line up in every single object, so press OPT+Up (On Mac).

You'll get the desired result of moving all email lines from below username lines to above them:

![[Pasted image 20250609011448.png]]
