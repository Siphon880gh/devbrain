This lesson will simplify the number of components on the canvas. This is NOT best practice but allows us to practice hard coding and adding control fields in canvas. The best practice for If/Else is the previous lesson.

From the previous lesson you either have (depending if you went further):
![[Pasted image 20250210010448.png]]

Or
![[Pasted image 20250210012147.png]]


---

We will simplify all this into:
![[Pasted image 20250210013249.png]]

The Conditional Message is a custom component that will spit out a predetermined message for true or another  predetermined message for false.

We will add control fields to make it clear what those messages are while in canvas mode:
![[Pasted image 20250210013353.png]]

---

The custom component "Conditional Message"'s code is:
```
from langflow.custom import Component  
from langflow.inputs import MessageInput  
from langflow.schema import Message  
  
class ConditionalMessageComponent(Component):  
    display_name = "Conditional Message"  
    description = "Outputs specific messages based on a condition."  
  
    inputs = [  
        MessageInput(  
            name="input_message",  
            display_name="Input Message",  
            info="The incoming message to evaluate.",  
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
        input_text = self.input_message.text  
        # Define your condition here  
        if input_text == "TEST":  
            output_text = "TRUE - They matched."  
        else:  
            output_text = "FALSE - They did not match."  
        return Message(text=output_text)
```


Reading the code, you'll see that:
- This custom component on the canvas would receive a previous message (your Text Input) and can pipe to another component that receives messages (In this case, Chat Output)
- The message is produced by comparing the previous message to whether it's "TEST" at if `input_text == "TEST"`
	- We know the comparison is to the previous message because `input_text` is assigned `self.input_message.text`, which is the Text Input (first component):
	  ![[Pasted image 20250210013720.png]]
- We hardcoded “TEST” and as long as our input_text matches it, it’ll be true, otherwise false.
- And notice the two possible output_text based on if the texts matched - those are hard coded as well.

Back at the canvas, make sure "Text Input" is set to "TEST":
![[Pasted image 20250210013249.png]]

We will expect this to pass (true). Run the flow, then check the Message log at Chat Output component. You should get:
![[Pasted image 20250210013807.png]]

---

This will work fine but for your future Langflow convenience, you may want to add controls on the actual component card in the canvas so you can edit the values without going into code.

Upgrade the "Conditional Message" custom component's code to:
```
from langflow.custom import Component  
from langflow.inputs import StrInput, MessageInput  
from langflow.schema import Message  
  
class ConditionalMessageComponent(Component):  
    display_name = "Conditional Message"  
    description = "Outputs specific messages based on a condition."  
  
    inputs = [  
        MessageInput(  
            name="input_message",  
            display_name="Input Message",  
            info="The incoming message to evaluate.",  
        ),  
        StrInput(  
            name="match_text",  
            display_name="Match Text",  
            info="The text to match against the input message.",  
        ),  
        StrInput(  
            name="true_message",  
            display_name="True Message",  
            info="The message to output if the input matches the match text.",  
        ),  
        StrInput(  
            name="false_message",  
            display_name="False Message",  
            info="The message to output if the input does not match the match text.",  
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
        input_text = self.input_message.text  
        match_text = self.match_text or "TEST"  
        true_message = self.true_message or "TRUE - They matched."  
        false_message = self.false_message or "FALSE - They did not match."  
  
        if input_text == match_text:  
            output_text = true_message  
        else:  
            output_text = false_message  
  
        return Message(text=output_text)
```

Seeing the code difference:
- Notice that under `inputs = [` we added more control fields. These control fields represented the old code's important variables (what we're matching against, what's the message for true, what's the message for false)
- At the message processing (`process_message`), notice what those variables used to be, we now reference the control fields. We also perform a check if the control field has a value, otherwise we set to the default value (Eg. `true_message = self.true_message or "TRUE - They matched."`)

Your final canvas will look like:
![[Pasted image 20250210014144.png]]