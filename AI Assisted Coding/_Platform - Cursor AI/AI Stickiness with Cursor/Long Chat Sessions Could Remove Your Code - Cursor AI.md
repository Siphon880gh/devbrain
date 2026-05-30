After a long chat session, Cursor AI may cause problems by removing your code unintentionally

## Problem: Literally replaced your old code with “Rest of existing code”

**Example 1:**
![](kNeJfCN.png)

Prompt to get back:
The update photo button no longer works. I see that you literally added the comment "// Rest of existing text drawing code..." and "//Rest of exiting export code"

**Example 2:**
![](C4ggIJ0.png)

**Prompt** to get back:  
You've removed my code and instead have the comment "//Convert other functions similarly"  

But if it’s been erased a few prompts back, you have to undo. Worse case, you reset to an older commit.

---

## Problem: Removed code and doesn’t add comment either

![](sLufhhs.png)

In this case, it removed my event handler function, even though it’s still required on the new approaches that the AI recommended. There’s no comment such as “The rest of handleFileUpload” code like in the above problem. I only found out when testing the app as an user.

**Prompt** to get back:
What happened to my handleFileUpload code?