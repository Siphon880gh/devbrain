
## Rows at builder, Lines at website

If you want to add a new row in WPBakery but on the webpage you want the new row to belong in the same section, then you may want to adjust the two row's styles so that the first row has some margin at the top but 0 margin at the bottom, and the second row has 0 margin at the top and some margin at the bottom. To the visitor, it just looks like rows in the same section.

Note if you must have background image, then this won't work because only one of the WPBakery rows will have the image background. In this case, just create a new column that wraps over in the same WPBakery row, per [[WPBakery Page Builder - Row Can Wrap Columns]], so that both "rows" to the visitor are in the same section (that section is a WPBakery row) and that section has a background image.

---

## Outer row contains inner row, if there is any inner row

Outer row vs inner row:
- Outer row settings can control for full width or not. It's usually where you set the background image for the entire section
- Inner row can control gap between columns

Inner row may not always exists inside outer rows.

Outer row (see mouse cursor over pencil icon):
![[Pasted image 20250728062424.png]]

Inner row (see mouse cursor over pencil icon):
![[Pasted image 20250728062431.png]]

Notice indentation level of the row controls can help you identify outer row (blue line aligned) from inner row (red line aligned):
![[Pasted image 20250728062847.png]]