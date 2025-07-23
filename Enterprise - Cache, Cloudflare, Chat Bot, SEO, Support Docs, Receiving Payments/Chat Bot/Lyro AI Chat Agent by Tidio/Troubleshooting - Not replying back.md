
If it's not immediately replying back when testing on your webpage, check these:
- Is it outside operational hours? Have you had operational hours disabled?
- Make sure the chat is ready to reply. It may say this message unless you overridden it in the options: "We typically reply within a few minutes":
  ![[Pasted image 20250722214504.png]]

---

It's possible you checked the chat at a time when it's not completely activated or integrated, per the instructions at [[_PRIMER - Lyro AI Chat Agent by Tidio]]. In that case, we may have bad cache:
- Clear cache at the wordpress level
- Clear cache at the web browser level. 
	- CMD+OPT+I, click and hold refresh icon, then drag down to "Empty Cache and Hard Reload"
- Clear local information (This may be absolutely required to fix the bad caching at a deeper level)
	- CMD+OPT+I
	- Select "Applications" tab
	- Open Local Storage, Session Storage, IndexedDB, and right click your domain name under each and click → Clear
	- Note: There's also cookies you can clear too for your specific website, but Lyro doesn't use that
	  
	  Screenshot (doesn't show all but shows Local Storage and Session Storage):
	  ![[Pasted image 20250722215000.png]]
