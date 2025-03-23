
There are two versions. One is the online version which is basically going on https://www.datastax.com/products/langflow, no setup required, and also free.

The other version is running the web gui locally on your computer. This tutorial covers the local web gui

## Setup LangFlow

Follow either setup instructions here
https://docs.langflow.org/get-started-installation
Or follow the below setup instructions

Install Langflow service + Python module + Local web gui all-in-one:
```
pip install langflow
```

Start langflow with:
```
python -m langflow run
```

> [!note] Error when starting langflow? BottlenecK?
> `UserWarning: Pandas requires version '1.3.6' or newer of 'bottleneck' (version '1.3.5' currently installed).`
> Upgrade bottleneck:
> 1. Open your terminal or command prompt.
> 2. Run the following command to upgrade bottleneck to the latest version:
>    `pip install --upgrade bottleneck`
> 3. This command will install the latest version of bottleneck, ensuring compatibility with pandas.

Visit in web browser locally like the terminal output recommends:
[http://127.0.0.1:7860](http://127.0.0.1:7860)


---

## Setup Project and Self-Orientation

Start a new Basic Prompting:
![[Pasted image 20250209202029.png]]

Chosen basic prompt, components are already dropped into the canva and connected for you. Take some time to recognize which categories they’re from at the left sidebar
![[Pasted image 20250209202100.png]]

![[Pasted image 20250209202046.png]]

Recommendation: Try to get familiar with all the components under each category. Some components you won't understand yet, and that's okay because it really depends on your knowledge of how AI works.


Know these shortcuts to make your life easier:  
- drag to pan
- cmd+drag to zoom
- More shortcuts are at [[_Langflow Commonly Needed - Shortcuts and Workflow]]

Going back to the canvas:
![[Pasted image 20250209202100.png]]

Lets do a quick orientation:
- Chat Input is:
	- You type what the user types when "asking ChatGPT", before clicking Play on the farthest right component (Chat Output)
	- Or you open Playground at the top right to start chatting, and the chat bot will go through this pipeline from Chat Input to Model to Chat Output
- Chat Output is:
	- When you run the flow in canvas mode by clicking the play button on Chat Output, the chat response is saved inside Message (you have to click to open)
	- Or you open Playground mode and this node represents that chat bot responding back to you after running this pipeline behind the hood to understand your prompt
- Prompt. This does not necessarily represent what the user types when "asking Chat GPT". If it were piped into Input, then yes it would, but it's piped into System Message. Prompt has basic prompt and can also create variables using the `{variable}` syntax when you're typing into the Template field. More details about prompt will be in level 2. We will get rid of prompt for level 1

## Learn with: Basic Prompting

Now let's begin using it. 
1. Make sure to add an Open API Key to OpenAI model component
2. Let's create a simple prompting that can ask OpenAI any factual information. This is without system instructions
3. Notice Prompt message is piped into System Message. For simplicity, this tutorial should not cover System Message. We'll cover System Message on level 2. So let's erase Prompt by selecting the Prompt component and pressing delete:
   
   Simplify the pipe for our beginner lesson:
   ![[Pasted image 20250209214038.png]]

4. For the User Input component, let's try:
	```
	How tall is Mt Everest?
	```

Here's what we have so far (Prompt variables optional):
![[Pasted image 20250209214656.png]]

Then click the play button at the Chat Output (farthest right):
![[Pasted image 20250209202631.png]]

---

## Seeing the Response

To review the chat outputs in this round and all previous rounds, at the Chat Output components, click “Message”
![[Pasted image 20250209202642.png]]

You get a table from opening "Message" at "Chat Output". Notice the response is in that field. Double click the field to expand:
![[Pasted image 20250209214758.png]]

![[Pasted image 20250209214820.png]]

---

## Another way to run the flow is through Playground

You also could have chatted with your “bot” by going into Playground instead of clicking Play on the farthest right component:
![[Pasted image 20250209202925.png]]

![[Pasted image 20250209214937.png]]

![[Pasted image 20250209214908.png]]