Why needed: You're implementing an app that uses an API service from Google Cloud Console, and you have to code in the API key. Or you're using a service that integrates with that API, and you have to enter the API key into some settings panel. 
- For example, n8n adding a community node `@bitovi/n8n-nodes-google-search` will help you perform google search using your Google Custom Search API key with a programmablesearchengine ID. That's covered in [[6.02 - Scrape google search results with bitovi google search node]]

At your project, go to Credentials to create a new API Key:
![[Pasted image 20250607031145.png]]

Specifically, you click "+ Create credentials" -> API Key:
![[Pasted image 20250607031239.png]]

Make sure to copy to a safe place:
![[Pasted image 20250607031402.png]]

You can see all the API keys created:
![[Pasted image 20250607031533.png]]

But notice there's an orange triangle warning icon. It says that you should restrict the API Key:
![[Pasted image 20250607031601.png]]

A common restriction is selecting which API service the key works with:
![[Pasted image 20250607031718.png]]