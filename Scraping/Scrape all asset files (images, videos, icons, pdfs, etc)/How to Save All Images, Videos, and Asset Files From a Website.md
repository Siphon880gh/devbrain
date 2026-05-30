
> **Disclaimer:** This guide assumes you own the website you are trying to recreate and that you have lost access to the original codebase, hosting account, CMS, or developer files. Cloning someone else’s website without permission is unethical and may violate copyright, trademark, and other laws. Use this process only for websites you own or are authorized to rebuild.

Let's say you need to save the website’s media assets.

This includes:
- Images
- Videos
- GIFs
- Icons
- PDFs
- Audio files
- Background images
- Logos
- Downloadable documents

The goal is to avoid hotlinking files. Instead of pointing your website to those media assets' urls, you should preserve your own local copy of the assets and organize them inside your new project.

---

## Method 1: WordPress Media Export (You own the website)

If you own the website and it's on WordPress, refer to your WordPress media export notes: [[How to Save All Images, Videos, and Asset Files From a Wordpress Website You Own]]

The general idea is:
1. Export the WordPress media library.
2. Extract the direct media URLs.
3. Download those files into `old-version-assets/`.
4. Move selected final assets into your new website’s production asset folder.

This is often the cleanest method when you still have WordPress admin or hosting access.

---

## Method 2: Use a Browser Extension

For smaller websites, browser extensions can quickly detect and download visible media from a page.

Useful tools include:

- **Image downloader - Imageye**
    
- **All Assets Downloader**
    
- **Media Downloader**
    
- **Bulk Media Downloader**
    
- **DownThemAll!**
    

These tools can help download images, videos, audio files, PDFs, and other page assets.

This method works best when the assets are visible on the page. However, it may miss:

- Background images loaded through CSS
    
- Lazy-loaded images
    
- Media loaded after scrolling
    
- Videos loaded through scripts
    
- Assets hidden behind interactions
    
- Protected or streamed media
    

Use this method when you need a fast, simple way to grab page-level assets.

---

## Method 3: Use Website Mirroring Tools

If you need a more complete copy of the old website’s files, use a website mirroring tool.

Common options include:

- **HTTrack**
    
- **SiteSucker for Mac**
    
- **wget**
    

These tools can download pages, images, CSS files, JavaScript files, PDFs, and other linked resources.

Example `wget` command:

```bash
wget \
  --mirror \
  --convert-links \
  --adjust-extension \
  --page-requisites \
  --no-parent \
  --wait=1 \
  https://example.com/
```

This can help capture a more complete version of the site.

However, mirrored websites often need cleanup. The downloaded folder may include old HTML, duplicate files, tracking scripts, plugin files, and unnecessary code.

Use the mirrored copy as a reference archive, not necessarily as your final production codebase.

---

## Method 4: Use Chrome DevTools

For manually saving specific assets, use the browser’s developer tools.

Steps:

1. Open the old website in Chrome.
    
2. Right-click the page and choose **Inspect**.
    
3. Open the **Network** tab.
    
4. Filter by file type:
    
    - `Img`
        
    - `Media`
        
    - `Font`
        
    - `CSS`
        
    - `JS`
        
5. Refresh the page.
    
6. Click important asset URLs.
    
7. Open them in a new tab.
    
8. Save them into `old-version-assets/`.
    

This method is useful when you only need a few important files, such as:

- Logo
    
- Hero image
    
- Background video
    
- Custom icon
    
- PDF download
    
- Important service photo
    

DevTools is also helpful for finding assets that browser extensions miss, especially CSS background images and media loaded dynamically.

---

## Method 5: Check Hosting, Backups, FTP, or CMS Folders

If you still have hosting access, check the website’s file manager, cPanel, FTP, SFTP, or backups.

Common asset folders include:

```txt
/assets/
/images/
/img/
/media/
/uploads/
/files/
```

For WordPress sites, the most important folder is usually:

```txt
/wp-content/uploads/
```

If you can access the hosting file system, download the full media folder and place it inside:

```txt
old-version-assets/
```

This is often more reliable than scraping the public website because it may include original files that are no longer directly visible on the site.

---

## What to Do After Downloading the Assets

Once you have saved the media files, do not immediately dump everything into your new production site.

Instead, use this workflow:

1. Save all raw downloads in `old-version-assets/`.
    
2. Review and rename important files if needed.
    
3. Delete obvious duplicates or junk files.
    
4. Copy only the assets you need into your production folder.
    
5. Update the new website code to use local file paths.
    

For example:

```txt
public/images/logo.png
public/images/hero-background.jpg
public/images/service-photo-1.webp
```

Then your website code should reference local paths like:

```html
<img src="/images/logo.png" alt="Company logo">
```

instead of old remote URLs.

---

## Final Goal

By the end of this step, your project should have:

```txt
old-version/
old-version-assets/
public/images/
```

Use `old-version/` for the old website reference.

Use `old-version-assets/` as the raw archive of all saved media.

Use `public/images/` or your framework’s preferred asset folder for the final cleaned assets used by the rebuilt website.

This keeps your website rebuild organized, avoids hotlinking, preserves important media files, and gives an AI coding tool enough context to recreate the site accurately.