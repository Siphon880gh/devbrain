
Material properties or Mesh properties, selecting a part of the model is additive:

For Material Properties, notice I have Skirt highlighted. I had hit "Select" button for Head, then Skirt. But both skirt and head vertexes get selected in viewport, rather than the latest selection - Skirt:
![](https://i.imgur.com/HWCAbxB.png)


For Vertex Properties, notice I have the vertex group "forearm.R" highlighted. I had hit "Select" button for hand.R, then "forearm.R". But both forearm and hand vertexes get selected in view port, rathar than the latest selection - forearm.R.

![](https://i.imgur.com/sk3TRi7.png)


The best practice is to Deselect when you're done with a Material slot selection or a Vertex Group selection. When you forgot what was selected, you can try "Deselect" on the most likely ones or Deselect for every single one of them until the vertexes are all deselected at the viewport, or - click an empty area on the viewport to remove all vertex selections.