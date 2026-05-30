Under Video:
![[Pasted image 20251226001200.png]]

Switch to Edit Video:
![[Pasted image 20251226001126.png]]

Recommendation - Add Elements
- What are elements: One or more images of a subject or object you want to edit into the video. A frontal image is a must. But if you add more angle shots, there will be more fidelity
![[Pasted image 20251226001133.png]]

![[Pasted image 20251226001139.png]]

---

# How to Use Edit Video in Higgsfield

Higgsfield’s **Edit Video** feature transforms an existing short clip by re-rendering it under new visual rules. It is not a timeline editor. Instead of cutting, trimming, or layering footage, you describe how the video should change while preserving the original motion and timing.

## What Edit Video does

You upload a video clip between **3 and 10 seconds** long. This can be any clip, not only one created inside Higgsfield.

The uploaded video defines:

- camera movement
    
- subject motion
    
- timing of actions
    
- overall continuity
    

Your prompt tells the model what to change visually. The output is a transformed version of the same moment, not a sequence of manual edits.

## How to think about prompting

Strong prompts are clear about three things:

- what must stay the same
    
- what should change
    
- when the change happens
    

Example of a woman using her phone, swiping with finger:  
“Keep the subject and camera motion unchanged. Change the environment to nighttime. After the user swipes the screen, update what appears on the device screen, specifically __ __ __.”

  

Avoid timeline language such as “cut,” “trim,” “splice,” or “add a layer.” You are directing a re-render, not editing clips.

## When to use images

Images are optional. For many changes, you can simply describe them in the prompt.

Upload images only when you need tighter control, such as:

- a specific look for lighting or color mood
    
- a particular environment aesthetic the model keeps missing
    
- a screen style or graphic style you want closely matched
    

Images act as visual references to reduce guesswork.

  

In this way you could add a logo in the image by uploading the logo as an image. Let’s say in that example you wanted the logo to load on the phone screen before she swiped on the screen.

  

## What Elements are

**Elements** are defined objects or subjects that the model should recognize and keep consistent throughout the video.

When creating an element, you provide:

- a required frontal reference image
    
- optional additional angles
    
- a name
    
- a short description of key features
    

Elements are useful when you need:

- an object to keep the same shape across frames
    
- consistent appearance as the camera angle changes
    
- reliable reuse of a specific item or graphic
    

  

You can also use Elements to keep an AI-generated character consistent. Create several reference images of the character from different angles in another AI tool, then upload those images and save them as an Element in Higgsfield so the character stays stable across frames and camera angles.

  

## Referencing images and elements with @

Anything you upload—images or elements—can be referenced directly in your prompt using `@`.

Example:  
“After the user performs the action, replace the on-screen content with `@ui_style_reference` and keep the device consistent with `@device_element`.”

  

Using `@` reduces ambiguity and improves consistency.  
  

## A simple workflow

1. Upload a clean 3–10 second video
    
2. Write a prompt describing what stays the same, what changes, and when
    
3. Add images only if you need visual precision
    
4. Create elements for objects that must remain consistent
    
5. Reference uploads directly with `@`
    

## Key takeaway

Edit Video works best when you treat it as re-rendering a single moment under new visual rules. Use prompts for timing and intent, images for precision, and elements for continuity.