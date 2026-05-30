
**Problem**:

Although Google AI Studio can sync to GitHub, downloading GitHub synced files won't work because google ai studio corrupts those files (won't view normally in web browser) when they use their own formatting. It's a bug as of Jan 2026. However downloading codebase zip directly in Google AI studio, it will reformat it to proper Jpg and png that can be viewed. 

Another concern - Not all image exist in the code files. Some link to remote stock services which is risky if they change their url. You want to self-host the images yourself, so you imagine an alternative is to manually download all images and videos by right clicking -> Save as, or going into inspect for the URL to download from. This would be too tedious.

You see a deploy button at the top right. You would be able to host the website directly. But that locks you into the Google Project website system where there’s a free tier that’s a bit limited, and you'll start getting charged for traffic. You thought about Github Pages but then realize the images are corrupted (in Google AI Studio only format) at Github's side, so that won't work.

---

**Requirement**:
- You also have Cursor IDE (can be free plan) or equivalent (eg. Windsurf). Free plan is sufficient.
- You have your own hosting server that you can upload files too and access them via URL, eg. https://example.com/hosted/CLIENT_NAME/some_image.jpg

**TL;DR:**
You use Google AI Studio to generate a list of image and video URLs, then grab Cursor IDE on the free plan and tell it to download those files for you. After that, have Cursor lay out a simple swap plan for updating your Google AI Studio project to replace the original URLs with your newly hosted ones. Upload the images/videos to your hosting server so the new URLs are real and accessible, then go back to Google AI Studio and tell it to replace the old image/video URLs in the website code with the new hosted URLs by following that swap plan.

**Solution:**
This is a solution that addresses both concerns.

Create a document of downloadable image and video URLs by prompting Google AI Studio:
```
List URLS of all image and videos in one file images.csv. Full URLs if possible. The headers can be:  
"""
Section, Description, URL, newURL  
"""  
  
Leave newURL column empty. User will fill them in later.
```

>[!note] Google AI Studio caveats
> If you’re using Google AI Studio, keep in mind it often edits parts of your app/site you didn’t ask it to touch. It’s kind of a dice roll: it may “simplify” the UI, finish features it assumes an app like this needs, while increasing the chance it accidentally delete a bunch of unrelated lines because it did too much at once. Watch the code view while it’s generating—new/changed files show up as it goes. If you notice it starting to modify other code without your permission after images.csv is generated, immediately copy the images.csv output to your clipboard and cancel the generation. If you're unlucky (again, it's a dice roll): it’ll churn through a bunch of unwanted code changes first and only generate images.csv at the very end.


AI might generate an `images.csv` that looks like:
```
Section,Description,URL,newURL
Hero,Homepage Hero Image,https://example.com/assets/images/hero-homepage.jpg,
Collection,Featured Product Image 01,https://picsum.photos/id/338/600/800,
Collection,Featured Product Image 02,https://picsum.photos/id/334/600/800,
Collection,Featured Product Image 03,https://picsum.photos/id/447/600/800,
Collection,Featured Product Image 04,https://picsum.photos/id/177/600/800,
Collection,Featured Product Image 05,https://picsum.photos/id/325/600/800,
Muse,Brand Inspiration Visual,https://picsum.photos/id/342/800/1200,
About,About Section Background,https://picsum.photos/id/250/900/1200,
About,Logo / Signature Mark,https://picsum.photos/id/65/300/150,
Visit,Location Highlight Image (Square),https://picsum.photos/id/1036/800/800,
```

Perfect. Now you're going to ask AI to download all those images then give you a new URL once you host those images by uploading to FTP etc.

Copy the `images.csv` to a blank folder, then open that folder in Cursor IDE.

Create a `downloader.js` (which we will equip AI with the ability to use in order to download the images file):
```
const fs = require('fs');  
const path = require('path');  
const https = require('https');  
const http = require('http');  
const url = require('url');  
  
const imageUrl = process.argv[2];  
  
if (!imageUrl) {  
  console.error('Usage: node downloader.js <image-url>');  
  process.exit(1);  
}  
  
const imagesDir = path.join(__dirname, 'images');  
  
if (!fs.existsSync(imagesDir)) {  
  fs.mkdirSync(imagesDir, { recursive: true });  
  console.log('Created images/ directory');  
}  
  
const mimeToExt = {  
  'image/jpeg': '.jpg',  
  'image/png': '.png',  
  'image/gif': '.gif',  
  'image/webp': '.webp',  
  'image/svg+xml': '.svg',  
  'image/bmp': '.bmp',  
  'image/tiff': '.tiff',  
  'image/x-icon': '.ico',  
  'image/avif': '.avif'  
};  
  
const parsedUrl = url.parse(imageUrl);  
const baseFilename = path.basename(parsedUrl.pathname) || 'image';  
const hasExtension = /\.(jpg|jpeg|png|gif|webp|svg|bmp|tiff|ico|avif)$/i.test(baseFilename);  
  
const protocol = parsedUrl.protocol === 'https:' ? https : http;  
  
console.log(`Downloading: ${imageUrl}`);  
  
protocol.get(imageUrl, (response) => {  
  if (response.statusCode >= 300 && response.statusCode < 400 && response.headers.location) {  
    // Handle redirects  
    process.argv[2] = response.headers.location;  
    require('./downloader.js');  
    return;  
  }  
  
  if (response.statusCode !== 200) {  
    console.error(`Failed to download: HTTP ${response.statusCode}`);  
    process.exit(1);  
  }  
  
  // Determine filename with extension  
  let filename = baseFilename;  
  if (!hasExtension) {  
    const contentType = response.headers['content-type'];  
    const ext = mimeToExt[contentType?.split(';')[0]] || '.jpg';  
    filename = baseFilename + ext;  
  }  
    
  const filepath = path.join(imagesDir, filename);  
  console.log(`Saving to: ${filepath}`);  
    
  const file = fs.createWriteStream(filepath);  
  response.pipe(file);  
  
  file.on('finish', () => {  
    file.close();  
    console.log('Download complete!');  
  });  
    
  file.on('error', (err) => {  
    fs.unlink(filepath, () => {});  
    console.error(`Error writing file: ${err.message}`);  
    process.exit(1);  
  });  
}).on('error', (err) => {  
  console.error(`Error: ${err.message}`);  
  process.exit(1);  
});
```

At Cursor IDE or equivalent, ask it to download images according to `images.csv` using a prompt
- Make sure to set the **base URL** to wherever you’ll host the images remotely at the prompt.
- We will have Cursor **download every image URL** using `downloader.js` into a local folder named `images/`.
- Cursor will update the `images.csv` with the new hosted absolute pathed URL
- Use the prompt:

```bash
Using downloader.js, download all urls into images/ using downloader.js cli. The command signature is:  
"""  
node downloader.js https://example.com/photo.jpg  
"""  
  
Then update the newUrl with relative URL to images/ with base url https://wengindustries.com/hosted/WEBSITE_NAME
```

Example newly modified images.csv:
```
Section,Description,URL,newURL
Hero,Homepage Hero Image,https://example.com/assets/images/hero-homepage.jpg,https://wengindustries.com/hosted/WEBSITE_NAME/homepage-hero-image.jpg
Collection,Featured Product Image 01,https://picsum.photos/id/338/600/800,https://wengindustries.com/hosted/WEBSITE_NAME/featured-product-image-01.jpg
Collection,Featured Product Image 02,https://picsum.photos/id/334/600/800,https://wengindustries.com/hosted/WEBSITE_NAME/featured-product-image-02.jpg
Collection,Featured Product Image 03,https://picsum.photos/id/447/600/800,https://wengindustries.com/hosted/WEBSITE_NAME/featured-product-image-03.jpg
Collection,Featured Product Image 04,https://picsum.photos/id/177/600/800,https://wengindustries.com/hosted/WEBSITE_NAME/featured-product-image-04.jpg
Collection,Featured Product Image 05,https://picsum.photos/id/325/600/800,https://wengindustries.com/hosted/WEBSITE_NAME/featured-product-image-05.jpg
Muse,Brand Inspiration Visual,https://picsum.photos/id/342/800/1200,https://wengindustries.com/hosted/WEBSITE_NAME/brand-inspiration-visual.jpg
About,About Section Background,https://picsum.photos/id/250/900/1200,https://wengindustries.com/hosted/WEBSITE_NAME/about-section-background.jpg
About,Logo / Signature Mark,https://picsum.photos/id/65/300/150,https://wengindustries.com/hosted/WEBSITE_NAME/logo-signature-mark.jpg
Visit,Location Highlight Image (Square),https://picsum.photos/id/1036/800/800,https://wengindustries.com/hosted/WEBSITE_NAME/location-highlight-image-square.jpg
```

And you should have an `images/` folder full of downloaded images.

We are so close, but not done yet. Only a few more steps:
1. Upload the images to your hosting server (in my case, wengindustries.com) such that the newURL's can be visited showing images.
2. Copy the updated `images.csv` to Google AI Studio. Then prompt Google AI Studio to look at the newUrl and swap them into the website. Here's the prompt:
```
I'm hosting the images/videos elsewhere. Update the URLs to the images and videos with the newURL from images.csv
```

You now have a Google AI Studio website that uses images from your own hosting server. Naturally the next steps is to download the website code and then host it. If your server does not support Typescript-React-Tailwind with Vite builder, you can convert the project into a html-js-css self contained and deployable html files with minimal asset files. Refer to [[Convert project to html-js-css self contained and deployable minimum files (Google AI Studio, Lovable)]]