Obsidian global css, custom css (add custom class per MD file via frontmatter), wider dataview output


Overview:
global css
custom css (add custom class per MD file via frontmatter)
wider dataview output


---

Manually

```
vi .obsidian/snippets/custom-test.css
```


```
.markdown-preview-view {  
        background-color:red !important;  
        font-size: 200% !important;  
}
```

Warning `body {}`  doesn’t work. It’s `.markdown-preview-view`  that works

If prefer a GUI
Install css editor. CMD+P

![](https://i.imgur.com/zMKecQd.png)

----

Settings → Appearance → CSS Snippets will show your custom-test.css and all css files you saved, that you can enable.

![](https://i.imgur.com/y7fF9WJ.png)

![](https://i.imgur.com/TjQQDw7.png)

---

CMD+OPT+I

Elements panel. Search for “markdown-preview-view”

![](https://i.imgur.com/QFacroi.png)

If you want to style only specific MD files, you can add frontmatter YAML that changes the HTML of that page by adding a custom css (Obsidian is HTML-CSS-JS CodeMirror app):

```
---  
cssClass: customTableStyle  
---
```


![](https://i.imgur.com/Zn1GoRF.png)

```
.customTableStyle {  
        background-color:red !important;  
        font-size: 200% !important;  
}
```

---

Wider dataview

.obsidian/snippets/wide-dataview.css:

Settings → Appearance

![](https://i.imgur.com/KD7kqGu.png)

![](https://i.imgur.com/6uE5Ucw.png)


-->

![](https://i.imgur.com/BprWgAE.png)

The snippet you want at .obsidian/snippets should be:

```
.wide-dataview .table-view-table {  
    font-size: 12px; /* Example: Adjust the font size */  
    max-width: unset !important; /* Example: Allow table to extend */  
}  
.wide-dataview .cm-sizer {  
   margin: 0 !important;  
}  
  
.wide-dataview .cm-content {  
  padding: 0 60px !important;  
  width: 100vw !important;  
  max-width: unset !important;  
}
```

--

No, the dataview output is read-only but you can go to the file by clicking the filename then adding the frontmatter fields, in this case:

```
---  
More-Descriptive:  
Specific-Enough:  
Measurable/Metrics:  
Achievable/Feasible/Realistic:  
Relevant:  
Time-Bound:  
EFFORT:  
IMPACT:  
force_rank:  
Summary:  
---
```

So it’s good practice to have a template you can copy and paste, next to the Dataview output

![](https://i.imgur.com/rkmMe0G.png)
