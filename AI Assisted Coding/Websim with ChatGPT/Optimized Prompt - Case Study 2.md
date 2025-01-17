Asked 4o to optimize:
```
You are good at writing AI prompts to generate web app design based off requirements.

Help me rewrite this into a prompt:
"""
I have a text box where a real estate enters their property description because it’s part of a bigger app that creates a real estate slide show. I’m only focusing on designing the real estate textbook at this web app screen.

User enters into multi line text box. I’d like a button that gives them opportunity to run AI rewrite to make the property description friendlier to a slideshow of photos. My backend will take care of that.

Real estate agent only has a few rewrites available which I’d like to set in the JavaScript based on their account details and my backend will report their limit based on their account tier

Once ran out of AI rewrites he can’t rewrite anymore and must click the Next button to go to next page in the web app. He could’ve clicked Next button without rewriting with AI too.
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

4o responds with:
```
**Web App Design Prompt:**

Design a web app interface for a real estate slideshow creation tool, focusing on the property description input feature.

**Key Features:**

1. **Multi-line Text Box for Property Descriptions:**
   - A text area where real estate agents can enter or edit property descriptions.
   - The text box should support multi-line input for detailed descriptions.

2. **AI Rewrite Functionality:**
   - Include a prominent button labeled "Rewrite with AI" that allows the user to improve their property description, making it more engaging and suitable for a photo slideshow. The button could have the recognizable AI icon from Font Awesome: fa-magic
   - Upon clicking the button:
     - The backend processes the AI rewrite.
     - The rewritten description replaces the original text in the text box (with a subtle confirmation/animation for feedback).
   - User can undo which will roll back text to a previous ai rewrite or the original text, and then that undo button becomes gray if can’t undo anymore. However, the ai rewrite will still be wasted. Perhaps have a redo button as well. The redo button grays out if user edits text or there isn’t anything to redo yet (user hasn’t clicked undo).

3. **Rewrite Usage Limits:**
   - Display the remaining number of AI rewrites available based on the user’s account tier.
   - If the limit is reached:
     - Disable the "Rewrite with AI" button.
     - Show a clear message (e.g., "AI rewrites exhausted for this session").
   - Allow users to proceed to the next step without requiring a rewrite.

4. **Next Step Navigation:**
   - A "Next" button that allows users to continue to the next page of the slideshow creation process, regardless of whether they used the AI rewrite feature.
   - Ensure the button remains accessible even when rewrite limits are reached.

**Design Considerations:**
- Keep the interface simple and user-friendly for real estate agents, with clear instructions and an intuitive layout.
- Provide subtle visual cues for the AI rewrite feature (e.g., loading spinner, success message).
- Ensure the account-based rewrite limit is clearly displayed but non-intrusive.

Focus on a professional, clean design that aligns with the real estate industry’s needs.
```

Websim responds with:
https://websim.ai/p/9tcr_gw1j69wc29bq08i