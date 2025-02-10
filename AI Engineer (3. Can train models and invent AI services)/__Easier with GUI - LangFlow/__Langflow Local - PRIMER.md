
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

Going back to the canvas:
![[Pasted image 20250209202100.png]]

Lets do a quick orientation:
- Chat Input is the user prompt
- Prompt is the system instructions (System instructions shape how the model, Eg. You are a {ROLE/EXPERTISE}... Eg. respond only to questions about... Eg. response only in json). It is NOT optional. In the programming world, the system instructions are hidden from the user.

## Learn with: Basic Prompting

Now let's begin using it. 
1. Make sure to add an Open API Key to OpenAI model component
2. Let’s have prompt in the Prompt component say:
	```
	You are an expert historian in US affairs and events and cultures.
	```

> [!note] Prompt variables?
> That’s optional  
  > You are an expert historian in {Country} affairs and events and cultures.  
  > It just makes future iterations with slightly different system instructions easier in your workflow, because it creates a field for you to configure the component:
  > ![[Pasted image 20250209202420.png]]
  

3. For the User Input component, let's try:
	```
	Give me summary of what happened on 12/31/2012
	```

Here's what we have so far (Prompt variables optional):
![[Pasted image 20250209202536.png]]

Then click the play button at the Chat Output (farthest right):
![[Pasted image 20250209202631.png]]

---

## Seeing the Response

To review the chat outputs in this round and all previous rounds, at the Chat Output components, click “Message”
![[Pasted image 20250209202642.png]]

You get a table from opening "Message" at "Chat Output". Notice the response is in that field. Double click the field to expand:
![[Pasted image 20250209202835.png]]


![[Pasted image 20250209202845.png]]

---

## In retrospect, another way to run the flow

You also could have chatted with your “bot” by going into Playground instead of clicking Play on the farthest right component:
![[Pasted image 20250209202925.png]]

![[Pasted image 20250209202932.png]]