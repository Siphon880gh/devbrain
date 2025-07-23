Bunch of flows on the same workflow that you're testing?

For each flow, set the trigger to Schedule Trigger with the entire workflow inactive. The Schedule Triggers won't run anyways since you're still developing/testing with the workflow inactive (you have to manually run the tirggers).  
  
![[Pasted image 20250606231559.png]]


Manual trigger is not a good choice for multiple flows because you can only have on on the workflow page. Add anymore and you run into this error:
![[Pasted image 20250606231740.png]]