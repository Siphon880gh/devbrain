
## Basics

**Setup**: Select the object you want to duplicate. At the Modifier setting (wrench icon), add an Array modifier.


![](https://i.imgur.com/P1ZXvrQ.png)


![](https://i.imgur.com/8nUGofZ.png)

Two requirements in order to see the duplicate(s):
- Fit Type. At a minimum you can set Fit Type to Fixed Count 2
- Offset. You must have at least one offset for duplicates to be visible in the viewport:
  ![](https://i.imgur.com/xNsk0IY.png)

You can increase the 1.0 number slightly if you don't like the duplicate and the original overlapping

---

## Details

**Fit Type:** How many times to duplicate the object
- Fixed Count: You can specify how many times it duplicates
- Fit Length: You can specify a particular distance that you want your array to cover. Blender will then automatically adjust the number of duplicates to fill that distance, based on the current offset settings.
- Fit Curve: Required - You need to add a Curve modifier after the Array modifier. Then at the Curve modifier, set the curve object to a Nebspath object. A Nebspath object was created with CTRL+A, then fine tuned in Edit Mode to have the curve you want. Refer to [[Create curved path for model to adopt]]


**Offset**: You can define the distance and direction between each copy. This offset can be set in three ways:

- **Relative Offset**: Uses the dimensions of the object to set the distance between copies.
- **Constant Offset**: Allows you to set a specific distance in Blender units between the copies, regardless of the object's size.
- **Object Offset**: Uses another object as a reference point for the offset, which can create complex and varied patterns.


---

## Optional - Merge

![](https://i.imgur.com/uBNq9z8.png)

**Merge and Caps**:

- If you want the vertices of adjacent copies to merge, enable the "Merge" option and adjust the distance threshold.
- For "Start Cap" and "End Cap", you can select objects from your scene to be placed at the beginning and end of your array. This is useful for framing or capping off your array with custom objects.

Reworded:
- **Merge**: If enabled, the vertices at the beginning and end of the array are merged based on a specified distance, which is useful for creating seamless objects.
- **Start Cap, End Cap**: You can specify objects to be used as the beginning and end of the array, allowing for more complex and detailed arrangements.

---

## Optional - Changing Axis of Duplicate

By adjusting distances at the other axes, you can change what axis the duplicates appear in

![](https://i.imgur.com/097xj2O.png)

![](https://i.imgur.com/HwIWBQu.png)

---

## Curved Path - Having duplicates follow a curve that you define

Refer to [[Create curved path for model to adopt]]