> Note: This is true as of June 2025. 
 
Cloning websites with **Lovable** is surprisingly effective — you can usually get about 80% accuracy. However, because Lovable relies on **screenshots**, dynamic elements like animations often require extra prompting.

Here’s a step-by-step guide:

---

### 🧰 Prerequisites

1. Make sure you have the **“Awesome Screenshot”** Chrome extension installed.
2. Create a free account at [https://lovable.dev/](https://lovable.dev/)

> [!note] Free Tier and Pricing Info  
> ![[Pasted image 20250615033541.png]]

As of **June 2025**, a free account gives you **5 credits per day**. Each credit corresponds to one request.

---

### 📸 Step 1: Capture the Website

Go to the website you want to clone. Using **Awesome Screenshot**, take a **full-page screenshot**.

<center>Open Chrome Extension to the tab "Capture" and select the action button "Full Page":</center>


![[Pasted image 20250615033607.png]]  
<center>On the next panel page, make sure to click "Download" to get the full screenshot of the webpage:</center>

![[Pasted image 20250615033618.png]]

---

### 📤 Step 2: Upload to Lovable

Upload your full-page screenshot into Lovable with this prompt:

```
Clone this website
```

Make sure the **model** is set to **Google**.

> [!note] File Too Large?  
> If the screenshot file is too big, open it in Photoshop and go to:  
> **File → Export → Save for Web**  
> Try reducing the resolution slightly if needed.

---

### ✅ Step 3: Review and Refine

After a few minutes, Lovable will generate the cloned layout. Review the output carefully. You can **continue prompting in the same chat** to refine it.

---

### 🎨 Step 4: Add Animations (Optional)

Lovable does a good job with assuming basic effects, such as hover effects on links. But if the original site had more custom effects (**animations, transitions, or parallax**), you’ll likely need to add them manually.

Here’s an example of a follow-up prompt:

```
Add parallax scrolling effect to the hero background image as well as the top layer images at 90% speed
```

> [!note] Recommended: Enhance with Custom Effects  
> Take inspiration from the original site or go further. Add smooth transitions, animations, or scroll effects to enhance interactivity.

