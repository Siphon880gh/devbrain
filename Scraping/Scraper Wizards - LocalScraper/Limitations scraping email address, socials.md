
Say you have domain names in a sites.txt that gets loaded into Local Scraper.

Some websites will have no emails and/or socials scraped because it might be on a separate page (Like Contact Us or About)

You may have to look at your csv and manually navigate to the website. You may have to pay VAs for this. Or you can program puppeteer to look for buttons or links with the word contact or about, navigate to that link, then re-attempt to parse email and socials in code. Or you can grab the URL after navigating to that link, then you run another round of Email Finder on Local Scraper on the new urls.

And when you go into contact info, you might get a contact form. The final resort is you check View source for “mailto:” on the contact form for the email address if the contact form works by opening your email app and prefilling the send mail, but that’s unlikely. Whats more likely is the email is in the backend and the contact form requests the backend, effectively hiding their email address. 

Failing email address, you could also click their socials if the webpage has and see if you can reach out. And IG sometimes people post their email at the profile page at the top where the short bio usually is. And you can directly message them too on socials to see if that works.