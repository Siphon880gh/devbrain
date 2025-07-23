

If you're using **WPBakery Page Builder**, you've probably seen column options like `1/2`, `1/3`, `1/4`—or even custom class names like `span3`, `span6`, etc.

Let’s demystify how this **row system** works.

![[Pasted image 20250723053455.png]]


Clicking Custom:
![[Pasted image 20250723053512.png]]
---

## 🎯 The Core Idea: Rows Add Up to 12

WPBakery’s grid system is based on the **12-column layout**, similar to Bootstrap. That means:

- Each row is **divided into 12 units**
    
- Your column widths just need to **add up to 12**
    

Think of it like Lego pieces. As long as your pieces total 12 "studs" in width, they’ll fit together in one row.

---

## ✅ Common Column Examples

|Layout Idea|Equivalent "Span" Classes|Description|
|---|---|---|
|`1/2 + 1/2`|`span6 + span6`|Two equal columns|
|`1/3 + 1/3 + 1/3`|`span4 + span4 + span4`|Three equal columns|
|`1/4 + 1/4 + 1/2`|`span3 + span3 + span6`|Two small, one large|
|`1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6`|`span2 + span2 + span2 + span2 + span2 + span2`|Six tiny blocks|

As long as your spans total 12, WPBakery will line them up in a single row.

---

## 🧠 Custom Layout Example:

Let’s say you want:

- Narrow on left
    
- Three even middle blocks
    
- Narrow on right
    

You could write:

```
span3 + span2 + span2 + span2 + span3
```

Why does this work?

- 3 + 2 + 2 + 2 + 3 = **12**
    
- Total = 12 units = fits perfectly in one row
    

---

## 🛠 Tips for Working with Rows

- Use **drag & drop** to adjust column widths in WPBakery if you're not coding directly.
    
- You can stack **multiple rows**, each with a new combination that totals 12.
    
- Use the **Responsive Options** in each column to hide/show elements on mobile, tablet, or desktop.
    

---

> [!note] Need Precise Control?  
> Use the **Custom CSS Class** field in the row or column settings to apply your own styles. This is great if you want to tweak padding, backgrounds, or breakpoints beyond what WPBakery offers.

---

## 🚀 Final Thoughts

WPBakery makes layout building more visual, but under the hood, it’s all about **rows that total 12**. Whether you're using fractions (`1/2`, `1/4`) or spans (`span6`, `span3`), the logic stays the same.

Stick to the “add up to 12” rule, and your layouts will stay clean, balanced, and responsive.
