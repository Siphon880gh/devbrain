
Status: Work in progress. Please come back later



We will make the Chatbot more specialized.

![[Pasted image 20250209214202.png]]






Prompt is the system instructions (System instructions shape how the model, Eg. You are a {ROLE/EXPERTISE}... Eg. respond only to questions about... Eg. response only in json). It is NOT optional. In the programming world, the system instructions are hidden from the user.

1. Let’s have prompt in the Prompt component say:
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




You get a table from opening "Message" at "Chat Output". Notice the response is in that field. Double click the field to expand:
![[Pasted image 20250209202835.png]]


![[Pasted image 20250209202845.png]]


---

## Another way to run the flow is through Playground

You also could have chatted with your “bot” by going into Playground instead of clicking Play on the farthest right component:
![[Pasted image 20250209202925.png]]

![[Pasted image 20250209202932.png]]