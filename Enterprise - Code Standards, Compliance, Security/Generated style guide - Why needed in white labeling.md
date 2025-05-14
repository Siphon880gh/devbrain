Let’s say there’s white labeling in your product.

You swap out the branded css file based on which company user logins in (each company with their own colors). However because of a lack of quality control, their btn-danger or delete button is the same RED as their company primary color RED!

This is why you need page that shows all your components, texts, etc affected by styling classes which are configured in the brand css file (including css variables)

---

Let’s walk this through

You’re changing which css file loads based on what company logged in on your app. One company’s color is all red. There’s a .btn-danger that you overlooked, because as you can see, the button is red on the red card:

![](gOZuhyZ.png)

Your default for misc companies that you haven’t white labeled for or for any guest who didn’t sign up as a company (maybe a test trial), you have default colors and styling, which is usually your own company’s brand colors. The default btn-danger which is red may be from bootstrap css or inspired by bootstrap:
![](Uz4FkQt.png)

So that’s why the Delete button at the white labeled company has happened, because when you swapped out the branded css file and forgot that the company’s primary color is red (which means the dominant card has a red background) yet the btn-danger is red

If you had a generated style guide, you would see any buttons that dont look right! Well in this case, you would be thinking what if the card is a primary color, and we have a btn-danger in it. You can configure the css file to have a tinted version of red.

Here’s an example of a generated style guide:
![](CZks0uF.png)

---

Example css files that swap in at run time based on what company signs in

brand-the-company.css:
```
:root {  
  /* Colors */  
  --primary-color: #da3b34 !important;  
  --primary-color-tinted: #e3908c !important;  
  --primary-color-shaded: #79231e !important;  
  --primary-color-contrasted: white !important;  
  
  --primary-color-o10: rgba(218, 59, 52, 0.10) !important;  
  --primary-color-o20: rgba(218, 59, 52, 0.20) !important;  
  --primary-color-o30: rgba(218, 59, 52, 0.30) !important;  
  --primary-color-o75: rgba(218, 59, 52, 0.75) !important;  
  --primary-color-o80: rgba(218, 59, 52, 0.80) !important;  
  
  --main-background: url("./the-company-logo.jpg");  
  
  --heading-font: "Playfair Display", serif !important;  
  --body-font: Lato, sans-serif !important;  
  --text: black;  
}  
  
/* The rest... */  
  
.btn-danger {  
  color: white !important;  
  background-color: var(--primary-color-shaded) !important; /* INSTEAD OF: the typical red */  
  border-color: var(--primary-color-tinted) !important;  /* INSTEAD OF: the typical danger red */  
}  
.btn-danger:hover {  
  color: white !important;  
  border-color: var(--primary-color-tinted) !important;  /* INSTEAD OF: the typical danger red */  
  background-color: var(--primary-color-shaded) !important; /* INSTEAD OF: the typical red */  
}  
  
/* The rest... */
```

Then the default
brand-default-none.css:
```
:root {  
  --primary-color: #235583 !important;  
  --primary-color-tinted: #568AAF !important;  
  --primary-color-shaded: #15334f !important;  
  --primary-color-contrasted: white !important;  
  
  --primary-color-o10: rgba(35, 85, 132, 0.10) !important;  
  --primary-color-o20: rgba(35, 85, 132, 0.20) !important;  
  --primary-color-o30: rgba(35, 85, 132, 0.30) !important;  
  --primary-color-o75: rgba(35, 85, 132, 0.75) !important;  
  --primary-color-o80: rgba(35, 85, 132, 0.80) !important;  
    
  --main-background: url("./marketer-funnel-genius-logo.jpg");  
  
  --heading-font: Montserrat, sans-serif !important;  
  --body-font: 'Open Sans' !important;  
  --text: black;  
}  
  
/* The rest... */  
  
.btn-danger {  
  color: white !important;  
  background-color: rgba(239,68,68,1) !important;  
  border-color: rgba(239,68,68,1) !important;  
}  
.btn-danger:hover {  
  color: white !important;  
  background-color: rgba(239,68,68,1) !important;  
  border-color: rgba(239,68,68,1) !important;  
}  
  
/* The rest... */
```

When creating a new css file for a new company’s colors you want to white label, your VS Code shows the color swaps. That allows you to think about the rest of the styling classes for that branded css file:
![](TUJAL9s.png)

But you should STILL revisit the generated style guide in case you made a mistake!