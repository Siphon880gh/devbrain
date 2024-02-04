
Learned from:
https://www.youtube.com/shorts/N9pMg45OyYk
https://www.youtube.com/watch?v=19MMl8PfyeQ

---

## Setup Blender (if haven't) 

Texture Painting module has limited creative features. Recommend you connect your picture editing software to Blender!

Gimp, Krita or Photoshop
Edit → Preferences → File Paths → Applications
Save Preferences

---

## Setup Viewport

Make sure you show materials/textures
![](https://i.imgur.com/2IfxoOf.png)

And go into “Texture Paint” module. NOT to be confused with Texture Paint mode. Texture Paint Module:
![](https://i.imgur.com/xBa5p2g.png)

Then select the main texture image belonging to the model
![](https://i.imgur.com/59kkfyk.png)

Now you can paint onto the skin/material/texture in an external software. In the Texture Paint module, go to Image → Edit Externally:
![](https://i.imgur.com/HYyPmTW.png)

---


If you try to edit externally and you get this error: `Image is packed, unpack before editing`, 

Go to Edit → Unpack → Create... (you’ll have more than one option, choose the option that has a directory file path that’s easy to remember)

Image → Replace → Choose the file created from the previous action (recall the directory file path)

Now you can try again:
Image → Edit Externally

---

## Do Photoshop Edits

Suggestions: You can add tattoos to a character’s nude skin. You’d search for a “Nordic tattoo transparent” or “Dragon tattoo”. 

- On Google Images you can Tools → Color → Transparent. You can Right-Click → “Copy” off the image while in Google Images. 
- Then paste into Photoshop. Just modify the skin where it would go, and save.


Suggestion: From your photoshop, you can save different skin png’s with different tattoos. And in Blender Texture Paint module, you go “Image → Open” to select another image file. Once you opened another skin png, it’ll be available for selection at

![](https://i.imgur.com/fKIPcNy.png)

And to have that skin updated on the model, you have to Image → Reload, or Opt+R

---

## Reconnect Photoshop's Save back to Blender
After you’re done editing the skin in your external picture software, you’ll replace the same file. If you’re forced to override the file (in the case of Photoshop Export, for PNG...) you’ll need to recall the correct directory file path because you're replacing the file there. If you’ve forgotten it, go into Blender’s Texture Paint module, then go into Image → Save As. Copy that folder path in the file browse dialogue. Do not actually save.

## Dont see the new texture paint in Blender?

Click “Image Texture" panel into focus and press **OPT+R** to reload the image (ALT+R if on windows). Or you can reload by going to Image -> Reload. Simultaneously, you'll see the model updated with the newest skin

## Still dont see the new texture paint in Blender?

Nuance:
This here:
![](https://i.imgur.com/ALwdW9O.png)

Is the texture for the material set for your mesh part here:
![](https://i.imgur.com/uPDmuAT.png)

So those two must match. If they don't then what you see in the Texture Paint module won't be the same as on the actual model in the viewport. Your options are to select another "Texture Image" at "Base Color":
![](https://i.imgur.com/wAaFh9p.png)

Or your other option is to Replace at Texture Paint module.

---

## Export into Unreal

Make sure to pack all texture images in Texture Paint module. That's Image -> Pack.

^Why: You want to ensure that all the associated texture files are correctly included with the FBX file. This is for the future when Blender's FBX exporter supports exporting materials. It does not currently in Q4 2023: https://blender.stackexchange.com/questions/264033/exporting-texture-with-fbx-doesnt-work


Then export as FBX. Make sure your "Path Mode" is "Copy" so the texture images are included.

At Unreal when you import by drag and dropping the FBX file, it'll ask import options. Make sure under Material, your "Search Location" is "All Assets".  Make sure to click "Import All"

If you're having problems with the new skin loading:
- See if there's a **Texture** file in the Content Drawer after importing. Then create material out of them by right clicking the file in the Content Drawer -> Create Material. Then you can drag and drop into the material slot.
- If no Texture file, then import the **png**'s from Blender model folder into Unreal. Then create material out of them by right clicking the file in the Content Drawer -> Create Material. Then you can drag and drop into the material slot.