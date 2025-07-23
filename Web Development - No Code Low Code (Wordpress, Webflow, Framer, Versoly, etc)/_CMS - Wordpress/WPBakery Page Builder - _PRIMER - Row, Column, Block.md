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

Row settings can notably allow you to:
- Add background image to the entire section on the webpage
- Add spacing above/below the row
- Row can let you set the grid layout of the columns

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

---

## Block aka Element

Going back to this screenshot:
![[Pasted image 20250723053816.png]]
- There is a text block in column 1. It has CSS Animation and its text is "Get Your Package Now!"
- Column 2 is empty, carrying no blocks. It has a plus symbol for you to add a block directly inside the column
- This modal appears. Note if you choose to add a Row, it'll add a row to the bottom of the site builder. Otherwise choosing another element or block will fill in that empty column.
  ![[Pasted image 20250723070432.png]]
  
  Or if it's an empty column that's not the final column:
  
You can edit a block only if you hover your mouse over the block, and edit option appears
- Mouse not hovered:
  ![[Pasted image 20250723070655.png]]
- Mouse hovered:
  ![[Pasted image 20250723070731.png]]


---

## Assigning class and IDs for styling

Only works for rows or columns, but not elements/blocks.