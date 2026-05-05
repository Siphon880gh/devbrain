In regards to their pricing table:
![[Pasted image 20250724032844.png]]

Their details field (where you normally list the features of a pricing tier or plan) is a single line text field:
![[Pasted image 20250724032926.png]]

Although you could hardcode multiple lines using `<br/>`, and they do render as multiple lines in this way, the next time you edit the Pricing Table column, it strips away the `<br/>` and you will likely accidentally overwrite them back into a single line:
![[Pasted image 20250724033028.png]]

You would have to add back in the `<br/>` each time you need to make a change to any part of the Pricing Table's column.

This is an annoying quirk of Impeka's Pricing Table. They will likely patch this in a future update.