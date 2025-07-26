Let's walk through this example prompt to make ChatGPT Agent create a Google Sheet in your Google account:
```
Help me create a Google Sheet that charts the previous FED interest rates

Prompt me to login to Google Sheet when ready
```

Agent mode is on:
![[Pasted image 20250726015112.png]]

Thinking → Setting up virtual desktop → Searching for Fed interest rate data → Scrolling to view more → Exploring datasets for Fed interest rate → Scrolling for table → Opening FEDRate Dataset → Gathering FOMC targets → Parsing FOMC dataset

When it's almost ready, the chat looks like this:
![[Pasted image 20250726015146.png]]

At some point, ChatGPT Agent downloaded some datasets into the virtual desktop. The next logical step is to import into Google Sheet. So it's ready to produces a Log in button while temporarily hiding the virtual desktop under "Worked for 2 minutes":
![[Pasted image 20250726015158.png]]



That automatically resumes the virtual desktop but giving you access. Your job is to login:
![[Pasted image 20250726015259.png]]

Still does verification though:
![[Pasted image 20250726015345.png]]

When ready (next user agent actions are not related to authentication), go ahead and relinquish control:
![[Pasted image 20250726015502.png]]

It needs a bit of hand holding though - it asks what you've done with the virtual desktop:
![[Pasted image 20250726015520.png]]

ChatGPT AI takes over Google Sheet from where you last left off:
- It clicks to open a new Google Sheet. Top of the virtual desktop explains in a few words what it's doing:
  ![[Pasted image 20250726015600.png]]
- Then the virtual desktop shows the Google Sheet that's under your account:
  ![[Pasted image 20250726015717.png]]


It will attempt to import the dataset directly from the website it remembered browsing:
- It imports by using the IMPORTHTML formula:
  ![[Pasted image 20250726020001.png]]
Unfortunately it failed, so it tries other ways:
- The more sensible way it should have started with first is to import the downloaded file
![[Pasted image 20250726020203.png]]

Some time passes... it failed to import the tsv. It now goes to download the csv file:
- It'll know to click the "Allow":
  ![[Pasted image 20250726020340.png]]

Attempting to import in the csv file:
![[Pasted image 20250726020430.png]]

Continues to explain it's importing:
![[Pasted image 20250726020451.png]]

  

Took 5 mins to get to that point:
- It asks are you sure you want to import. You will reply "Yes"
![[Pasted image 20250726020507.png]]

After importing, it'll work on restructuring the data and explaining its process:
![[Pasted image 20250726020534.png]]

And it'll even create the chart if appropriate to do so:
![[Pasted image 20250726020559.png]]

Then ChatGPT Agent responds in usual chat text format that the job is done.

I visited my google sheets (https://sheets.google.com) directly to confirm. I saw that the AI created this file in there:
- I collapsed rows 2-64 for demonstration purposes here
  ![[Pasted image 20250726020659.png]]

---

Discussion:

This is just the early release of ChatGPT Agent. I imagine over time it may supplement or even replace office job workers.