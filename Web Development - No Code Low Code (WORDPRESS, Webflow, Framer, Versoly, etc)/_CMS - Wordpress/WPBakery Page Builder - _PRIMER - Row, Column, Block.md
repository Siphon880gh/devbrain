## Rows

Here all the rows are collapsed except one:
![[Pasted image 20250723054755.png]]
- 👀 A row is associated with having rearrange, column grids, and add buttons on the top left of the row and collapse/pencil/duplicate/delete buttons at the top right.
- Note that a WPBakery row can have lines of columns if the columns wrap over (more on this in the next section)

You **a**dd a **r**ow by pressing:
ar 1 of 2:
- Press PLUS
![[Pasted image 20250723065045.png]]
ar 2 of 2:
- Press Row:
  ![[Pasted image 20250723065128.png]]

**A**lternately, you could also **a**dd a **r**ow by:
Aar 1 of 2:
- Press the PLUS at the very bottom of the WPBakery Site Builder:
  ![[Pasted image 20250723065236.png]]
Aar 2 of 2:
- Press Row:
  ![[Pasted image 20250723065128.png]]

You can **edit** row settings at the pencil at the top right of a row:
![[Pasted image 20250724043321.png]]

Zoomed out, you see it's at the top right of the row:
![[Pasted image 20250724043649.png]]

---

Row controls is also where you change the column distributions:
![[Pasted image 20250724044701.png]]
-->
![[Pasted image 20250724044735.png]]

If you add more columns than the distribution allocates, that column will just wrap over to the next line but remains inside the row.

For more details on row grids: [[WPBakery Page Builder - Row Column Divisible System]]
For more details on wrapping columns inside the row: [[WPBakery Page Builder - Row Can Wrap Columns]]

---

Rows can collapse if there's too much information on the WPBakery and it's overstimulating you:
Here all the rows are collapsed except one:
![[Pasted image 20250723054755.png]]

You can rearrange rows on the webpage layout:
![[Pasted image 20250724045009.png]]
- You would click and drag to below/above another row.

---


Row settings can notably allow you to:
- Add background image to the entire section on the webpage
- Add spacing above/below the row
- Row can let you set the grid layout of the columns
- Save as template

---

You can save a **row as a template** inside Row Settings:
![[Pasted image 20250724043514.png]]

You can load a saved template at the top left of the WPBakery Page Builder:
![[Pasted image 20250724043539.png]]

Zoomed out, the top of the WPBakery Page Builder is:
![[Pasted image 20250724043740.png]]

Btw, that's also where you can undo or redo changes to the website layout from adding row/column/elements.

---

If editing in Frontend Editor, the row buttons collapsed will appear when hovering mouse over the row. You have to expand the row buttons to access crucial buttons such as editing the row:
![[Pasted image 20250724044434.png]]

---


## Columns

Add an empty column by pressing the Plus at the row:
![[Pasted image 20250723065426.png]]

Here is an empty column that's wrapped to the next line in the same row. It's NOT a new row:
![[Pasted image 20250723053816.png]]
- 👀 A rectangular area that doesn't have the collapse/pencil/duplicate/delete buttons nearby means it's a column that wrapped over to the next line or that it's just a column belonging in a row. 
- 👀 Wrapped over columns belong to the same row. But the row is not designed to look like a gray container of all the columns (notice a white gap between "Get Your Package Now" column and the empty wrapped column below it)
- More info at: [[WPBakery Page Builder - Row Can Wrap Columns]]

To edit the settings of a column, you click the pencil icon that's NOT associated with a row:
![[Pasted image 20250723065641.png]]
- Note you are not clicking the cancel at the top right, which is associated with the row
- 👀 The pencil icon of a column is always at the center of some rectangular area

You may often need to edit spacing and borders at columns:
![[Pasted image 20250729232514.png]]

---


Although it appears you can save the column as an **element** which is basically a template, it could be quirky and not worth it for your theme (go test it). For sure it's not compatible with Impeka theme (tested loading in the column element from the Builder add button, tested loading it in from the row's add button, and tested loading in from a column's add button).

In the element settings, for example, here for the column called `_Saved_Column`:
![[Pasted image 20250730021830.png]]

Let's say you saved it as `_Saved_Column`, then you can add the same column when at the "Add Element" modal. You're adding element -> "My elements" or searching the element name directly:
![[Pasted image 20250730022647.png]]

If your theme is incompatible with column elements, the builder will look glitchy:
![[Pasted image 20250730022739.png]]


---

## Block aka Element

Going back to this screenshot:
![[Pasted image 20250723053816.png]]
- There is a text block in column 1. It has CSS Animation and its text is "Get Your Package Now!"
- Column 2 is empty, carrying no blocks. It has a plus symbol for you to add a block directly inside the column
- This modal appears. Note if you choose to add a Row, it'll add a row to the bottom of the site builder. Otherwise choosing another element or block will fill in that empty column.
  ![[Pasted image 20250723070432.png]]
  
  Or if it's an empty column that's not the final column:


**Another way to add** a block in the column is to click the Plus at the bottom of the column:
![[Pasted image 20250724033841.png]]
Note the Plus icon may display a **tooltip** reading "Prepend to this column", but clicking it actually appends the block, not prepends it. The element would be added at the bottom of the container inside.


You can **edit** a block only if you **hover your mouse over the block/element**, and edit option appears
- Mouse not hovered:
  ![[Pasted image 20250723070655.png]]
- Mouse hovered:
  ![[Pasted image 20250723070731.png]]


Some elements are **container-type or collection-type elements** that have their own edit pencil icon that doesn't need your mouse hover to be accessed:
![[Pasted image 20250724034409.png]]

---


You can save the block/element as an **element** which is basically a template. In the element settings, for example, here for the block called Button Group:
![[Pasted image 20250727184403.png]]

Let's say you saved it as `_Stacked_Buttons`, then you can add the same element settings/content at another column when at the "Add Element" modal. You're adding element -> "My elements" or searching the element name directly:
![[Pasted image 20250727184555.png]]

---

## Assigning class and IDs for styling

Only works for rows or columns, but not elements/blocks.