
You ask ChatGPT 4o to optimize this prompt into a web app generative prompt
```
You are good at writing AI prompts to generate web app design based on requirements.  
  
Help rewrite this into an AI prompt:  
"""  
This is a web app.  
  
Based off of desired dimensions of width and height, user sees a canvas that allows them to design their End Card as a video project asset. When they finish designing the end card, it gets converted into base64 url string, which I already have a function that will allow user to download based off the base 64 url string or fetch POST to a video creating script.  
  
In terms of what shows up in the canvas that designs the End Card: User can upload their own graphic or choose from a few available graphics (which are base64 url strings which could be plain black card or plain white card). If user uploads their own image, if the dimensions do not match the desired dimensions, the canvas automatically center the image and have sidebars that are zoomed blurred background of the graphic (instead of black bars).    
  
User can add and drag text inputs into position then start typing on top of the canvas. They will be limited to five lines. The user can resize any text input which resizes the font size (or they can choose a font size and the text input will resize accordingly), and they can choose from a limited set of fonts that are often already part of web browser.   
  
A button can be pressed to convert the canvas into a base64 string like an image.  
"""  
  
Here’s an example output from you that was satisfactory in a previous chat:  
"""  
Web App Design Prompt:  
  
Design a web application for creating videos from property listing photos, such as those found on Redfin or Zillow.  
  
Key Features:  
Progressive Disclosure Flow:  
  
Users are presented with two options to provide property photos:  
Enter a URL of a property listing.  
Upload photos directly from their device.  
URL Entry Option:  
  
When the user selects "Enter a URL," they are shown a text field to input the URL of a property listing (e.g., from Redfin or Zillow).  
After entering the URL, the app automatically fetches the photos from the listing and populates an uploading interface.  
Photo Upload Option:  
  
If the user selects "Upload Photos," they are directed to an uploading interface.  
The interface supports:  
Drag-and-drop functionality for uploading multiple images.  
A traditional "Click to Upload" button.  
Consistent Upload Interface:  
  
Regardless of the method (URL or direct upload), the user is presented with a unified interface for reviewing, rearranging, or removing the selected photos before proceeding.  
Focus on creating a clean, intuitive user interface that ensures seamless transitions between steps while keeping the experience simple and engaging.  
"""
```

ChatGPT 4o responds. You make sure it's markdown:
```
**Web App Design Prompt:**

Design a web application for creating and customizing video project assets, specifically focused on designing End Cards.

### Key Features:

1. **Canvas-Based Design Interface:**
    

- Javascript has desired dimensions (width and height) to init and generate a canvas.
- The canvas serves as the workspace for designing the End Card.

3. **Graphic Upload and Selection:**
    

- Users can upload their own images or choose from preloaded graphics (e.g., plain black or white cards provided as base64 URL strings).
- If the uploaded image does not match the specified dimensions, the app:

- Automatically centers the image.
- Creates zoomed, blurred background sidebars to fill the canvas instead of leaving black bars.

5. **Text Editing Tools:**
    

- Users can:

- Add and drag text boxes to any position on the canvas.
- Type directly within the text boxes, limited to five text boxes.
- Resize text boxes, which dynamically adjusts the font size.
- Alternatively, set a font size, and the text box adjusts accordingly.

- A selection of common web-safe fonts is available for user customization.

7. **Export Functionality:**
    

- Users can press a button to convert their final canvas design into a base64-encoded URL string.
- This base64 string can be:

- Downloaded directly by the user.
- Sent via a POST request to an external video creation script for integration into video projects.

### Design Goals:

- Ensure an intuitive, user-friendly interface that encourages creativity.
- Provide seamless handling of image uploads and resizing to match the specified dimensions.
- Make text editing flexible yet straightforward, with clear controls for positioning, resizing, and font selection.
- Emphasize smooth performance during canvas interactions, ensuring real-time updates as users customize their designs.
```