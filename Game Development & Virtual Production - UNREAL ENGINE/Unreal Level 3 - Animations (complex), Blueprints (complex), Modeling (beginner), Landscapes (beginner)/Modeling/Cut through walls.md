1. Add Cube
2. Resize to where you want to cut through the wall (imagine the cube is a hot melting material that will cut through anything it overlaps)

![](https://i.imgur.com/EtQXVSz.jpg)


3. Model → Boolean → Difference A-B or B-A (Play around)
4. Accept

![](https://i.imgur.com/5ZY1o57.png)

^ Note on UE 4, the option is named MeshBool at the side panel

The white cube that doesn’t intersect with the wall will still be invisible. Cut them out:

1. Modeling -> Model -> Poly Group Edit
2. Select remaining white cube and press delete on keyboard
3. Accept
![](https://i.imgur.com/8kZkgET.png)


![](https://i.imgur.com/6Bk5YeT.png)


---

If that doesn't work for your specific case, you will want to use Plane Cut which allows you to cut through with a rectangle.