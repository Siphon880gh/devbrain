Review UV Editing Module Purposes

- Use Case: See which part of the texture image apply to which part of the model in the viewport
- Use Case: Reassign which parts of present or future texture image will apply to the body

Reworded: Reassign which part of texture image refers to which part of mesh

---

When you create a model, its vertexes will automatically be assigned to points in the texture map. Each point is designated (U,V), similar to (X,Y) in graphing

Proof:
I created a new blender project which by default gives you a cube. Without editing anything, I go into Edit Mode + UV Editing module. Then I selected one of the faces. The UV Editing module (which I prepped to have a blank canvas going to Image → New) shows which part of a future texture image refers to the highlighted face of the cube.

![](https://i.imgur.com/2GIzcBP.png)

![](https://i.imgur.com/22OsEKO.png)

  
And I can rearrange the texture image map where it’s expected to map over to the character’s skin


---

The UV Editing is only for changing which points on the texture image will apply to which part of the mesh. If you want to paintbrush colors into the texture map, you switch to Texture Paint. 

Texture Paint module will still show the vertexes corresponding to the selected vertexes from the viewport. Only difference is you cannot manipulate the UV texture vertexes, but you can manipulate the colors. Here I painted A on top of the cube with paintbrush tool inside Texture Paint module (NOT inside UV Editing module)

![](https://i.imgur.com/ZqSfWc3.png)

For more detailed instructions on paintbrushing into the model using the Texture Paint module, refer to: Text Paint - Paintbrush into the model

If you had it connected to Photoshop, etc (Edit → Preferences → File Paths → Applications):

---

The other use case is to reassign the UV texture images that correspond to the selected vertexes in the viewport. This can let you decide what arrangement of graphical elements in the texture map correspond to which part of the mesh/model

![](https://i.imgur.com/mjeCadN.png)

Here I have selected the vertexes in the UV Editing module and transformed them to match the top left of texture images. You use the same selection tool (like A for select all, like Circle Select), and transformation tools (like r/b/s, x/y/z).

![](https://i.imgur.com/vMeMket.png)

In this example, I gave myself more room to apply the texture image to other parts of the body other than the skirts.