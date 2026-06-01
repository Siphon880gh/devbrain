You can take screenshot of the Chrome Network tab, copy source code (Make sure to Inspect so it's the html that may have been resulted after some JS execution), etc and feed it into AI for a scraping solution

Network tab:
- Tip: Search for what may make sense like m3u8, etc depending on the platform. If the results are not populating, you may have to refresh the page with the Network tab still opened.
- Tip: m3u8, etc might load on demand requiring you to play the video on the webpage before it can appear in the Network tab.
![[Pasted image 20260531040359.png]]

HTML Source:
![[Pasted image 20260531040445.png]]


To get around the input limit on ChatGPT if the HTML source code is too large, you would create a new folder in Cursor, dump the HTML in there, and prompt at Cursor. You can paste screenshots into the prompt.

Ask AI how would you scrape the videos on this website. If it complains about ethical issues, mention this is for educational purposes.