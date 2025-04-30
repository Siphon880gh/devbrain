
Everything related to row and columns in Salient's WPBakery Page Builder, specifically in the **Backend Editor**

**How to use**: Recommend you open a screen-persistent Table of Contents so you can navigate this document more easily.

---

## Add new row or column
![](ZOkDVg7.png)

- Red: Add new row to the final row. If had chosen an element besides row, it’ll add new row with that element
- Purple: Add new row after current row
- Green: Add new column after final column
- Orange: Add new content item at first position at current column

## Adjust number of columns, adjust column sizes including responsive settings

**Where we are at:**
Salient’s WPBakery Site Builder’s Backend Editor

When clicked column icons at a row, you can choose number of columns and their sizes by clicking the icons:
![](BJqkhCK.png)

Or if you had clicked Custom, you can type in the fraction size for each column.. and the number of fractions is the number of columns in a row (unless the sum of the fractions exceed 1, which would push those columns who are exceeding 1 into the next row):
![](qAL0tU6.png)

Eg.
1/4 + 1/2 + 1/4

![](8kp8VBy.png)

3/12 + 2/12 + 2/12 + 2/12 + 3/12
![](mRKvhHa.png)


![](LYpsQPf.png)


Desktop:
**1/4 + 1/2 + 1/4**

The responsive settings are in column settings → “Responsive Options” tab. You can hide or change the column size

Required knowledge: Where to access a column’s setting

Btw the settings are from top to bottom: lg, md, sm, xs
![](pGGkSgy.png)

Offsets and widths are these options:
![](aFnJxQz.png)
  

You should design mobile first then change the look on bigger devices at the column responsive settings here:
![](LuhsUJc.png)

### Reworded:

2:33 (create new column) and 3:40 (edit column setting’s responsiveness tab) at
https://www.youtube.com/watch?v=KuZa8_6VfIc


## Split a column into two columns

Create a row inside a cell, that way two columns in a column.

## Edit Spacing for row, column, or content block, including responsive settings

Salient’s WPBakery Site Builder - Spacing including responsive settings

For padding, margin, transform, content direction (vertical, horizontal), and text alignment, you go into the block’s settings (eg. Text block)
![](kzg0cpt.png)

![](hY3MKTM.png)

![](Pffp2pk.png)

Notice there are device icons which means you can modify their responsiveness settings too

## Edit settings for row, column, or content block

![](oDpaiQn.png)

- Gray’s pencil is Row setting
- White’s pencil is Column setting
- Green’s pencil is Content setting (eg. Text block, etc) and appears on mouse hover

![](L9SlEGI.png)

Sometimes the row settings and the column settings are dark gray pencil and light gray pencil:
![](DwFZ8Zs.png)

---

## Industry responsive column sizes

From the Backend Editor:
![](ECxijBe.png)
Column sizes at: 1/4 + 1/2 + 1/4

But it'd look compressed on iPad because of the 1/2 spaces on the left and the right. 
Mobile is fine because with the two 1/4 sized columns that are empty will be ignored while the 1/2 space will take up the entire mobile - This is Salient doing it.

![](RogADu0.png)

![](zhIbB1I.png)

  

Salient using WPBakery Page Builder designs mobile first (Proof: when adjusting responsive options, the mobile is based off the width you gave it)! But you still design on the WPBakery Page builder as if it were on desktop (Why: Have to do less margin and column work - designed 1/4 + 1/2 + 1/4 because the 1/4 cols are empty and the 1/2 col will fit a mobile 100%.)  
  

Therefore, good column settings for container margin style is:
- Desktop 6 cols - 1/2
- iPad 12 cols - 1/1

As discussed earlier, mobile will automatically 100% even though you designed 1/4 + 1/2 + 1/4 because the two 1/4 columns are empty and not taking up space, but the 1/2 col will fit a mobile 100%.