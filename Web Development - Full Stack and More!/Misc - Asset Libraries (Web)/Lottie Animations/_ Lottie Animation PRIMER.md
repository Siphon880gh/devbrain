## 💡 What is a Lottie Animation?

> “For the first time, designers can create and ship beautiful animations without needing engineers to recreate them.”  
> — [Airbnb Lottie Docs](https://airbnb.io/lottie/#/README)

AirBnB created Lottie. It was the work of engineers Brandon Withrow (iOS), Gabriel Peal (Android), and Leland Richardson (React Native) along with lead animator Salih Abdul-Karim at AirBnB that saw the creation of the first Lottie libraries to render the animations in different platforms. The initiative started as a way to allow rich animations from Adobe After Effects to run natively on iOS, Android, and React Native.

While Airbnb created the tech and open-sourced it in 2017, it was **[LottieFiles](https://lottiefiles.com)** — an independent platform — that **made it accessible to designers and developers globally**. LottieFiles provided a web-based previewer, marketplace, editor tools, and a growing ecosystem that brought attention to Lottie animations outside of Airbnb’s ecosystem.

----

**How to use**: Open the persistent Table of Contents.

---

# 🌟 Lottie Tools Overview & Tips

## 🎨 Main Tools

### [LottieFiles](https://lottiefiles.com/)

- **Free Plan:** Limited to **10 uploads/downloads total for life**
- **Pro Plan:** $19.99/month (billed **annually only** – no monthly option)
- **Main Benefits**: Editor that lets you quickly swap colors in on the fly and also has a library of animations you can search
- **Main Problem:** Lifetime limit
  
  ![[Pasted image 20250430015607.png]]


- **WORKAROUND (For productivity)**: If you are downloading from their free library, you have to first upload to your workspace, then you can download, which doesn't count against your 10 lifetime limits. But that's multiple steps - you can download directly from the free image by pasting the url into a Lottie downloader (Note doesn't work for premium assets):
  https://lottie-downloader.mihaiblaga.dev/
- **WORKAROUND**: If you change the colors of a free asset, it now becomes a custom asset that DOES cost towards the 10 lifetime credits. What you can do instead is download the free asset, then edit the colors with the various other methods discussed in this guide. Keep in mind this may go against their ToS so this is for educational purposes only.

### [LottieLab](https://lottielab.com/)

- **Free Plan:** Adds a watermark (bottom-right corner)
	- **WORKAROUND**: But for educational purposes only - you can use AI to remove the watermark with [[Lottie Animation - Google AI to remove watermark of Lottielab]]
- **Pro Plan:** $12/month (or $18 if billed monthly)

## Obsoleted:
Adobe After Effects: You can no longer use Bodymovin plugin to export as lottie in Adobe After Effects. Support has been lost. This remains true as of 4/2025.


---


## 🔄 Filetypes

Lottie animations are often in the form of .lottie or .json file extensions. You may need to know about this in order to successfully render on Wordpress or a website. Read more about at [[Lottie Animation File Type - Lottie, JSON]]

---

## 🔍 Finding Animations for Your Features

1. List your **challenges or features** into ChatGPT. Here's the prompt
	```
	Suggest lottie animation files for each of these _challenges/features_ on my webpage (you could link me to lottie files too or what to search on lottie):
	
	__list them from the webpage__
	```
1. Browse: [LottieFiles Featured Free](https://lottiefiles.com/featured-free-animations)
2. Find icons or styles that match. For tips on how to tell icons are of a similar style, refer to wengindustry.com/app/3dbrain/?open=Icon%20Set%20of%20Same%20Style
3. Edit to match brand colors
4. Save, download, and implement on your site

---
## 🎨 Editing Lottie Colors

### Editing Lottie Colors with Google AI

Google AI Studio’s Gemini 2.5 Pro Preview 03-25-25:  
[https://aistudio.google.com/prompts/new_chat](https://aistudio.google.com/prompts/new_chat)  

First attach the Lottie json file

Then prompt with (replace with your brand color HEX values):
```
Using these colors:  
    --primary-color: #******;  
    --secondary-color: #******;    
    --text-color: #***;  
    --heading-color: #******;  
  
  
Replace this lottie json file's colors.
```

### Editing Lottie Colors with LottieFiles

Find what you want on their public free animations.

Then click “Save to workspace to generate”:
![[Pasted image 20250430020337.png]]

Go modify the file at your workspace:
![[Pasted image 20250430020408.png]]

How? Open color palette at the border of the right sidebar
![[Pasted image 20250430020424.png]]


A productivity hack is to inspect a color palette that best matches your brand's colors:
![[Pasted image 20250430020507.png]]

Then you create a new palette by clicking the button:
![[Pasted image 20250430020644.png]]

However the palette accepts HEX:
![[Pasted image 20250430020634.png]]

Caveat: If you copy the inspected `rbg(r, g, b)` into the HEX value, it DOES convert to some HEX value, but that is the incorrect HEX!

Instead run this in the DevTools console to initiate a RBG to HEX converter:
```
function rgbToHex(r, g, b, a = 1) {  
  const toHex = (n) => {  
    const hex = Math.round(n).toString(16);  
    return hex.length === 1 ? '0' + hex : hex;  
  };  
  
  if (a >= 1) {  
    // Omit alpha if fully opaque  
    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;  
  } else {  
    // Include alpha if partially transparent  
    return `#${toHex(r)}${toHex(g)}${toHex(b)}${toHex(a * 255)}`;  
  }  
}
```


After initiation, you can use the converter in the DevTools console:
```
// Example usage:  
console.log(rgbToHex(255, 0, 0));            // Output: "#ff0000"  
console.log(rgbToHex(255, 0, 0, 0.5));        // Output: "#ff000080"
```


Make sure you add enough color swaps in the new palette:
![[Pasted image 20250430020841.png]]

After adjusting the HEX values for all the color swaps, you may click Save and come up with this (notice not red, blue, orange, white anymore):
![[Pasted image 20250430020908.png]]

Tip: You can get your website's brand colors by inspecting html element most of the time (if developer followed coding conventions), otherwise ask your developer:
![[Pasted image 20250430021027.png]]

### Editing Lottie Colors with LottieLab

1. Open your Lottie JSON file at https://www.lottielab.com/dashboard. You can sign up for free.
2. Swap out colors by clicking inside the HEX values (they're editable):
   
   A/B:
   ![[Pasted image 20250430013154.png]]
   
   B/B: Edit colors to swap them out -
   ![[Pasted image 20250430013252.png]]
   
4. Click **Export** (top-right)
5. From the export modal, you have two options for rendering on your Wordpress / website:
	1. Load the JSON CDN link (tab "JSON URL")
	2. Download (tab "Download Lottie")

	   ![[Pasted image 20250430013429.png]]

💡 Watermark will still appear on free plan  
- ⚠️ Removing watermark may violate their Terms of Service, but for educational purposes: [[Lottie Animation - Google AI to remove watermark of Lottielab]]

---

## 💻 Using Lottie in WordPress (Salient Theme)

### REQUIREMENT: Upload the lottie json file to the same server your website or Wordpress is at

1. Upload `animation.json` to your FTP (e.g., If Wordpress: `wp-content/uploads/lottie/`)

### Option 1: Use Once
1. If Wordpress:
	1. Use Salient’s **Lottie block** (via WPBakery backend editor)
	   ![[Pasted image 20250430020218.png]]
	2. Set:
	    - JSON URL
	    - Trigger Type: autoplay, play when visible, scroll position seek (animates forward or backward based on if you’re scrolling down or up), hover
	    - Loop, speed, etc.
	      
	      ![[Pasted image 20250430020234.png]]
2. If custom website: Use your preferred JS library or React library that loads Lottie JSON animation

---

### Option 2: Reuse via Elements (Wordpress)

There are two approaches

#### Reuse Approach: Element
1. Assign your animation to a block
2. Edit the animation element.
3. Click ⚙️ at the top right and select **Save as Element**
   ![[Pasted image 20250430014019.png]]
	In this example, we name the Element as "Lottie_Rocket":
	![[Pasted image 20250430014138.png]]
	
	
4. Now you can reuse it across your site when you press + at the Backend Editor and select "My Elements" tab:
   ![[Pasted image 20250430014107.png]]


#### Reuse Approach: Render via Class Name

1. Make a Lottie block invisible by giving it a render class (e.g., `.lottie-rocket`)
   
   A/B: Here -
   ![[Pasted image 20250430014254.png]]
   
   B/B: We can have the class as lottie-rocket. Notice we preceded with a dot because it allows for ID's too: `.lottie-rocket`:
   ![[Pasted image 20250430014345.png]]
   
2. Add this class elsewhere:
	- You can add to a text block's "Text" tab which has custom html and shortcode::
	```html
	<div class="lottie-rocket"></div>
	```
	
	For example, a text block at "Text" tab:
	```
	I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.  
    <div class="lottie-rocket"></div>
	```  
    
	- Or you can assign the class to an element, column, or row - even at one or multiple places:
	  ![[Pasted image 20250430014725.png]]
  
3. The animation will now render there!
