
## 📦 Lottie is a ZIP Archive that has JSON inside

`.lottie` files are just ZIP archives that include:
- `animation.json` (the main Lottie file)
- Optional assets like images or fonts
- The animation.json would likely point to the assets using relative path

## 📑 JSON File with or without images

**Converting it to a zip file then unarchiving, if the animation has images:**
![[Pasted image 20250430005141.png]]

Then your Lottie animation is actually a combination of coordinates/vectors from json file AND images that are loaded and transformed along with the vector animation. To prove it, let's see what happens when you load the json Lottie animation with the image files deleted (Here a rotating swirl):
![[Pasted image 20250430005956.png]]

And restoring the image files:
![[Pasted image 20250430010146.png]]

**Converting it to a zip file then unarchiving, if the animation has no images:**
![[Pasted image 20250430005228.png]]

Then your Lottie animation is actually only coordinates/vectors from json file (unless you have base64 string images inside json file).

### 🔄 Wordpress / Website Loading .json file

1. Rename `.lottie` → `.zip`
2. Unzip the file
3. Look for `animation.json` (not `manifest.json`

If the JSON includes image references like:

```json
{ "p": "image.png", "u": "", ... }
```

- `"p"` is the filename
- `"u": ""` means the images should be in the **same folder** as the JSON

If there are images that the Lottie animation refers to, to use in your Wordpress (Salient element -> Lottie animation) or website (use JS or React libraries), you would have to keep the image file locations relatively to the animation.json

- `"u": "images/"` means the images should be in a folder named "**images**" where the JSON file is at.

---

## 🛠 Wordpress / Website: Troubleshooting Broken Images

1. Check browser **DevTools > Network tab**
2. If images fail to load, update the `"u"` value in JSON to an absolute path:
    ```json
    "u": "https://yourdomain.com/path/to/images/"
    ```
3. Stay on the **same domain** to avoid CORS issues
4. Still not working? You can troubleshoot with DevTools Network tab, because maybe Wordpress or your website or your server is rewriting the URL to something else! Then you can adjust u value accordingly (keep in mind you can still use relative ../ or ../../ to go up folder(s) if using relative "u" values instead of absolute "u" values)
   ![[Pasted image 20250430010637.png]]
   
   ^ In this example, my WordPress site automatically generated a slug based on the page name, which caused the animation to load images from the wrong URL. Since the `"u"` value in the Lottie JSON was ignored, the image path was treated as relative to the current page URL. As a result, it tried to load the image from: `domain.ai/webpage-tab-name/cxF7...png` as you can see from the DevTools Network panel above.
   
5. Still not working? Embed the image as a **Base64 string**:

```json
"p": "data:image/png;base64,iVBOR..."
```

You may need to use this online converter to upload your image and get the raw base64 string:
🧰 [Convert image to base64](https://www.base64-image.de/)
