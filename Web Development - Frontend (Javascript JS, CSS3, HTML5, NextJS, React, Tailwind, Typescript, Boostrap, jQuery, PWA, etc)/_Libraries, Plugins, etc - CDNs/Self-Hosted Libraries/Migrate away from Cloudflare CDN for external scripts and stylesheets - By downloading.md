## Situation

As of February 2025, I noticed that resources like jquery.js and font-awesome.css from Cloudflare’s CDN could take up to 30 seconds to load on certain internet connections. However, when testing other pages with no cache, I didn’t experience any issues. Cloudflare status webpage showed it was all good to go. At the time, I was exploring internet cafes, and this led me to suspect that Cloudflare's CDN might be particularly sensitive to router configurations.

Bad IPv6 router settings could slow down js and css files delivered from Cloudflare CDN. I decided to migrate away from Cloudflare’s CDN so that users with misconfigured internet could still load my pages smoothly. 

The pages on bad connections are either white screens for a long time or it loads but the font-awesome icons don't load:
![[Pasted image 20250205013424.png]]

I had numerous apps that relied on cdnjs.cloudflare.com. Here is how to download the Cloudflare assets (when you're on a better internet or you're willing to wait) and just self-host it

## Instructions

Here this guide migrates you out of cloudflare. we took the approach of downloading the script/link sources directly and formulate placing them into `assets/vendors/library@version/*.min.css`
  
Search for `cdnjs.cloudflare.com` in your index:
![[Pasted image 20250205013549.png]]

And create such folders in this format:
![[Pasted image 20250205013610.png]]

Cmd click to open source files in new tab:
![[Pasted image 20250205013632.png]]

CMD+A → CMD+C:
![[Pasted image 20250205013646.png]]

Create file named similarly if not the same. Create at the navigator by right clicking the library folder → New File...:
![[Pasted image 20250205013658.png]]

Paste the contents into the new file

Then for each of the created min.css and min.js, right click to copy path and then update your html’s script src and link hrefs

![[Pasted image 20250205013726.png]]

And update replacing the cloudflare script src or link href at your html

However icon sets that rely on font characters like font awesome will be a problem:

CMD click and it’ll ask to create the folder/file structure webfonts/fa-solid..:
![[Pasted image 20250205013751.png]]


But note it created with the # hashtag so you have to rename that file. Just create one file using this approach then we know where to place the font family files. Opening the remote copy and copying the contents like we did for min.css or min.js is tedious here. So we pivot to another strategy when it comes to the many font files for icon libraries like FontFamily to work.

Github would be appropriate for you to find the webfonts. Font awesome made it easy at Github:
https://github.com/FortAwesome/Font-Awesome

Go to releases on the right then click your version. It’ll give you a zip to download

Expand Assets section:
![[Pasted image 20250205013806.png]]

Download web version:
![[Pasted image 20250205013908.png]]

Find the webfonts folder and replace appropriately in your source code