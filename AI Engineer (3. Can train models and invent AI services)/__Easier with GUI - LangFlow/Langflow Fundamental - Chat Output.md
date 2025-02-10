The Chat Output component - you need it

Otherwise, **if** no Chat Output component (Here the pipeline ends with the OpenAI model):
![[Pasted image 20250209192351.png]]


... **then** the Playground would return empty:
![[Pasted image 20250209192316.png]]

Also, that Model component’s “Message” button does NOT keep a record of previous outputs, but a Chat Output component does.

**Quantities**
- You are allowed to have more than one chat **output** in the canvas because of possible chat outputs based on if/else etc
- But you can only have one chat **input** on the canvas. This is what the user types into Playground.

