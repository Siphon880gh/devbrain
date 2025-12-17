
You search cards for "Capture". It will list "Multiple Choices" card.  Searching for "Multiple" or "Choice" won't work because of the [[Annoying UI Quirk - Search for Capture Instead of Choice]].

When entering the question, you don't need a separate Text Card because the Multiple Choices Card has a question field.

Here is designing the Multiple Choices Card:
![[Pasted image 20250518222026.png]]

Here's how it looks in the Chat Emulator:
![[Pasted image 20250518222256.png]]

---

Multiple Choices card seems too much like the Single Choices card?

Yes, you can only click one choice! Both Multiple Choices and Single Choices cards are functionally the same when it comes to clicking a choice (Until Botpress improves the UI, but this is still case as of 5/2025)

But had you mentioned your multiple selections instead of clicking a selection, then you the system will recognize your SATA (Select all that applied):
![[Pasted image 20250519022215.png]]

If you configured the Multiple Choices card to save a variable: It'll parse the user's message and save those multiple choices as a variable. Then a Text card can output that variable to the user's chat, which in effect outputs the multiple choices:
![[Pasted image 20250519022314.png]]

**FYI - Under the hood:**
- When outputting the user’s response to the chat, Botpress returns a string that concatenates the selected choices from an array into a comma separated string value.
- If a user replies in natural language instead of clicking buttons, Botpress uses a small built-in AI service called _Duckling_ to extract their choices. This process doesn’t consume AI credits (unlike ChatGPT-powered features).

Because of this behavior, you might prefer to encourage users to _type out_ their answers instead of clicking options—especially when you want to capture multiple items. For example, you could rephrase your prompt to say:
> “What are your two favorite colors from this list?”

In this case, you can use a **Raw Input** card, which only displays the question and expects users to type their answer. It will still correctly detect and store their selections.


---


The selection buttons are replaced with a dropdown if there too many choices. In this example, we've added an "Other" option, which is an option too many, so it became a dropdown:

![[Pasted image 20250519041607.png]]
