We are testing if “TEST1” matches “TEST” using the If/Else component (which is found inside the category Logic).

Let's construct this:
![[Pasted image 20250210010448.png]]

Start with a blank template.

Add these components:
- "Text Input" is found in "Inputs" components category
- "If-Else" is found in "Logic" components category
- "Chat Output" x2 are found in "Outputs" components category


The two Override Message's are custom components. Add custom component button is at the bottom left:
![[Pasted image 20250210010621.png]]
Use this code which will add the logic for the pipe in and out and also design the card onto the canvas:
```
from langflow.custom import Component
from langflow.inputs import StrInput, BoolInput, MessageInput
from langflow.schema import Message


class ConditionalMessageComponent(Component):
    display_name = "Override Message"
    description = "Override or use previous message."

    inputs = [
        MessageInput(
            name="input_message",
            display_name="Input Message",
            info="The incoming message to evaluate.",
            required=False,  # Optional input
        ),
        StrInput(
            name="override_text",
            display_name="Override Text",
            info="Custom text to display if override is enabled.",
            required=False,  # Optional override input
        ),
        BoolInput(
            name="override_enabled",
            display_name="Enable Override",
            info="Enable this to use the override text instead of the previous message.",
            required=False,  # Optional toggle
        ),
    ]

    outputs = [
        Output(
            display_name="Output Message",
            name="output_message",
            method="process_message",
        ),
    ]

    def process_message(self) -> Message:
        # Get input values
        input_text = self.input_message.text if self.input_message else ""
        override_text = self.override_text or ""
        override_enabled = self.override_enabled

        # Determine final output message
        if override_enabled and override_text:
            output_text = override_text  # Use override text if enabled and provided
        elif input_text:
            output_text = input_text  # Use previous component's message if available
        else:
            output_text = ""  # Default to blank text

        return Message(text=output_text)

```


Final result should be this after you filled in some values and connect some cards
![[Pasted image 20250210010448.png]]
Text Input: "TEST2"
If-else Match Text: "TEST"
If-else Operator: "equals"
Override Message (if true): "True - Was a match"
Override Message (if false): "False - Not a match"

When several chat outputs possible, you generally click play on all the chat outputs. Usually if you drag and drop components in columns, you click play on all the components on the right most column, so click these two play buttons:
![[Pasted image 20250210010923.png]]

After running, a way to quickly see which branch executed is to hover mouse over to compare timestamps:
![[Pasted image 20250210010943.png]]

![[Pasted image 20250210010953.png]]

A much older time or “Execution blocked” means that branch didn’t run:
![[Pasted image 20250210011006.png]]

And if you checked the Messages Log of the ran Chat Output:
![[Pasted image 20250210011039.png]]

The Chat Output that didn't run - their message logs is either empty or the message button is unclickable

**Conclusion**
The false branch ran because TEST1 not equals TEST

---

**MORE**

Open Playground

Notice you're not allowed to type into it because you didn't have a "Chat Input" at the canvas. You're only allowed to run the flow. And that's fine. Let's run it:
![[Pasted image 20250210011516.png]]

![[Pasted image 20250210011559.png]]


---


**EVEN MORE**

Let's customize the response's name color and icon color.
- Green chat icon / name if MATCHED
- Red chat icon / name if UNMATCHED

Open Controls for either Chat Output
![[Pasted image 20250210011654.png]]

We can set the color for background color, icon, and text color. We can tick on "Show" in order to see the fields at the canvas. Typing in colors make it active in the Playground (does not require "Show" to be ticked on)
![[Pasted image 20250210011834.png]]

You want to set "green" on the true branch and "red" on the false branch

Now the canvas look like:
![[Pasted image 20250210012147.png]]

"Run" in the playground again should get you:
![[Pasted image 20250210012208.png]]

---

**Challenge**

Change Text Input to "TEST" so that the match will pass. The green icon/text should appear in Playground when you run the flow.