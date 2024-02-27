
Status: Cursorily

Make sure there are no n-gons. If there are n-gons you have to convert them into tris and quads

Background:
- Tris: Triangular faces
- Quads: 4 point faces


NOT good - this is an N-gon:
![](https://i.imgur.com/c8qmnox.png)

Better:
![](https://i.imgur.com/RXyF7rl.png)
  

Obligated: [https://youtube.com/shorts/qLBNRSbEvC4?si=2Ukg5CiJ4c6mGTVz](https://youtube.com/shorts/qLBNRSbEvC4?si=2Ukg5CiJ4c6mGTVz)



Why do this work:

Different programs triangulate an ngon in different ways. So if you UE4 triangulates a mesh differently from how your baking software did when you made a normal map, then that normal map will display wrong. Another reason is that if you wanted to import a mesh to zbrush and subdivide it, ngon's might not subdivide well. This is kind of moot now with all the tools zbrush has at it's disposal.

[https://polycount.com/discussion/192151/ue4-does-importing-ngons-save-on-performance-in-ue4-debate-with-my-colleague](https://polycount.com/discussion/192151/ue4-does-importing-ngons-save-on-performance-in-ue4-debate-with-my-colleague)