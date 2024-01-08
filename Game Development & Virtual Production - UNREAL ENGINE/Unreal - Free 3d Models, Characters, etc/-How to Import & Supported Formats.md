
## Supported Formats

To upload a 3D model into Unreal Engine, the most commonly used formats are:  


 
1. Blend file (.Blend)
**REQUIRES EXTRA STEPS**: Open (not import) in Blender. Then export back out to an Unreal compatible format, like FBX


2. DAE (aka  Collada): COLLADA, also known as DAE (Digital Asset Exchange), is an XML-based format designed to enhance interoperability among various 3D graphics applications in the interactive industry, although not directly with Unreal Engine. The flexibility and detail of DAE come with a bit of overhead. Simple models might end up with more data than necessary, making other formats like gITF/GLB more efficient for basic needs.
**REQUIRES EXTRA STEPS**: Import in Blender (as Collada), then export back out to an Unreal compatible format, like FBX

3. **FBX (.fbx):** This is a widely supported and versatile format that works well with Unreal Engine. It supports mesh data, material attributes, and animations, making it a preferred choice for many developers.


4. **GLB:** This is the binary version of the gITF format, which includes everything in a single file, making it more streamlined and commonly used for web applications. There could be several versions of GLB offered at sketchfab depending on high resolution vs low resolution.

5. **gITF (.gltf/.glb):** GL Transmission Format is a compact format for the efficient transmission and loading of 3D scenes and models by applications. Unreal Engine can import GLTF files as static or skeletal meshes.
  
6. **OBJ (.obj):** A simple data-format that represents 3D geometry alone — namely, the position of each vertex, the UV position of each texture coordinate vertex, vertex normals, and the faces that make each polygon. It's a universally accepted format and is compatible with many 3D graphics applications, including Unreal Engine. However, it doesn't support animations or complex scene hierarchies like some other formats. It's best used for simple models or static assets where texture and geometry are the main concerns. When including OBJ in your considerations, remember that while it's widely compatible and great for straightforward geometry, it lacks the advanced features of formats like FBX or USD.


7. **USD (Universal Scene Description, .usd, .usda, .usdc):** Unreal Engine supports USD, which is useful for scene description and can encapsulate a comprehensive range of complex scene data. This format is beneficial for large-scale projects and collaborative workflows.
	**REQUIRES EXTRA STEPS:** Enable the USD Importer at Edit->Plugins, then restart Unreal Editor; Now your Content Drawer can import USD* files. Alternately, you could import in Blender, then export back out to an Unreal compatible format, like FBX. More information on the USD Importer plugin: [https://docs.unrealengine.com/4.27/en-US/WorkingWithContent/USD/USDinUE4/](https://docs.unrealengine.com/4.27/en-US/WorkingWithContent/USD/USDinUE4/)


Summary:
When choosing a format, consider what you need to transfer. FBX is great for detailed models and animations, USD is excellent for complex and scalable project structures, and gITF/GLB are good for efficient transmission, DAE for compatibility between other 3D software (but not unreal), OBJ is excellant for small static files without rigging or animations. Check your model's specifics and your project requirements to choose the most suitable format.


---

**I have a ready to import unreal file (fbx, glb, glTF, obj, etc). How to import into unreal?**


Importing an FBX file into Unreal Engine is a straightforward process. Here's a step-by-step guide to help you through it:

  
1. **Open Unreal Engine:**
   - Launch the Unreal Engine application and open your project.

2. **Prepare for Import:**
   - Ensure your FBX file is ready and ideally, organized in a way that makes sense for your project (e.g., textures located in the same folder).

3. **Importing the FBX:**
   - In the Unreal Engine Editor, navigate to the **Content Browser**.
   - Right-click in the area where you want to import the FBX file and select **Import to /game/...** or simply click the **Import** button.
   - Browse to the location of your FBX file, select it, and click **Open**.
  

4. **Set Import Options:**

   - A dialog will appear with several import options. Here you can adjust settings that affect how your FBX file is imported. This includes mesh options, material options, and more.

     - **Mesh**: Includes options for importing meshes.
     - **Animation**: If your FBX contains animation data, you can import it here.
     - **Materials and Textures**: Decide if you want to import materials and textures embedded in the FBX file.
   - Review these options and adjust according to your needs. If you're unsure, you can leave the defaults and adjust later.


5. **Import:**
   - Once you're happy with the settings, click the **Import** button. Unreal Engine will process the file and import your FBX model into your project.
  

6. **Review the Imported Assets:**
   - After import, your new assets will appear in the Content Browser. Click on them to view them in the editor.
   - Check the mesh, textures, and animations to ensure they've been imported correctly.


7. **Place the Model in the Scene:**
   - To add your imported model to your scene, simply drag it from the Content Browser into the viewport.


8. **Adjust and Save:**
   - Make any necessary adjustments to the model's position, rotation, or scale.
   - Save your project to keep the changes.


Remember, depending on the complexity of your FBX file and the specifics of your project, you might need to adjust import settings or do additional setup, especially for materials and animations. If you encounter any issues, consult the Unreal Engine documentation or community forums for more detailed guidance and troubleshooting tips.

[https://chat.openai.com/c/2e2eec32-566b-40d5-b4f3-094147d24469](https://chat.openai.com/c/2e2eec32-566b-40d5-b4f3-094147d24469)


---

## Walkthrough Importing

Let's say we are importing from sketchfab

I created a free account at
[https://sketchfab.com/](https://sketchfab.com/)

I searched for "detective" then ticked on "Downloadable"
![](https://i.imgur.com/MU2qvuW.png)

There are some that have a $ at top right. I only download those without the $.

When I'm at a model's page, I look for this under the model picture:
![](https://i.imgur.com/DFsyVUF.png)


Then I'm presented with different file formats. I chose FBX

Over at Unreal Engine, I opened Content Drawer, then I import to game

I import the fbx files and png files (textures)

The content drawer shows a skeletal mesh. 
![](https://i.imgur.com/HF9EzJP.png)


I drop it into the map and noticed it's uncolored. Next I have to set the materials.


The pngs need to be saved as materials. From the Content Drawer, I right click the png files and go to "Create Material" (Notice is first option):
![](https://i.imgur.com/YBzX8i9.png)

Then you can drop this material into the material slot (Details) of the character mesh or the character in the editor viewport.