We can leverage both websim and chatgpt to create basic app layouts and website layouts. It can make more aesthetic looking layouts than ChatGPT. As of 1/2025, their model is fine tuned to app and website layouts.

Although web sim does generate javascript, their javascript is often limited in complexity, and you may find the generated layout missing user interaction logic.

This tutorial will give a series of prompts to generate the website layout with the best prompt, and to have AI transform the generated website code to a code that AI likes to work with and is easier for you to plug into a MVC or OOP codebase. For this tutorial, we are not using React although generating React layouts is perfectly acceptable.

How to use: Navigate using table of contents at the top right

---

```toc
```

## ChatGPT Models Used

Preferred model for optimizing code: 4o. 
- Not o1. It actually thinks “too much” and doesn’t optimize your prompt well.
Preferred model for conforming generating website/web app to your theme's css variable: o1
Preferred model for converting the code into tailwind: 4o
- Not o1 because it does too much and introduces problems in the solution


---

## I. Optimized website or web app prompt

1. Brainstorm the prompt. What your app or website does, what industry or use case is it for, how it behaves, what the user can get out of it or what call of action you want the user to be led to. In addition, you may specify the styling.
	- Note that if it’s a specific subcategory of website, say that instead: Eg. “Landing page”
2. Ask ChatGPT to optimize your prompt for website generation:
```
You are good at writing AI prompts to generate web app design based on requirements.

Help me rewrite this into a prompt:
"""
{DESCRIBE what your app or website does.. etc.. etc}
"""

Here’s an example output from you that was satisfactory in a previous chat:
"""
Web App Design Prompt:

Design a web application for creating videos from property listing photos, such as those found on Redfin or Zillow.

Key Features:
Progressive Disclosure Flow:

Users are presented with two options to provide property photos:
Enter a URL of a property listing.
Upload photos directly from their device.
URL Entry Option:

When the user selects "Enter a URL," they are shown a text field to input the URL of a property listing (e.g., from Redfin or Zillow).
After entering the URL, the app automatically fetches the photos from the listing and populates an uploading interface.
Photo Upload Option:

If the user selects "Upload Photos," they are directed to an uploading interface.
The interface supports:
Drag-and-drop functionality for uploading multiple images.
A traditional "Click to Upload" button.
Consistent Upload Interface:

Regardless of the method (URL or direct upload), the user is presented with a unified interface for reviewing, rearranging, or removing the selected photos before proceeding.
Focus on creating a clean, intuitive user interface that ensures seamless transitions between steps while keeping the experience simple and engaging
"""
```

---

## II. Vet Generative Prompt, then Transform into Markdown for WebSim

The optimized generative prompt that ChatGPT produced has your app/website requirements. You want to make sure ChatGPT got it right. And you can optimize the prompt even further by converting it into Markdown: in this format, the prompt can become more meaningful to websim ai.  
  

1. First check if the requirements that ChatGPT produced are correct. If it’s not correct, you can either or both:
	- Copy to a text file and add/change lines
	- Chat with the AI to perfect the requirements

2. Then tell ChatGPT it’s good. And say "Please change into markdown format".

---

## III. WebSim into base-less local code

1. Copy the optimized generative prompt that includes requirements in Markdown format.
2. Signup/Login and paste the prompt into: [https://websim.ai/](https://websim.ai/p/l9wsb3bs1u_20ubk4mo8/1)  
3. After generation is done, download or copy the generated code. Copying is from opening “View Source”:
   ![](https://i.imgur.com/PInniTx.png)
4. Get rid of any `<base>` tag in your code. It could become problematic when you host your website or incorporate it into your code base.
5. See if you can open the code on a local browser.



---

## IV. Conform to your theme's CSS variables

Skip this major step if you don't have CSS variables in your project. 

Is your code generation intended to be incorporated into the rest of your code? And do you have have css variables with your own primary, secondary, text, etc? Use o1 model. Prompt with both `<style>` block AND `<body>`  markup (**exclude** script block) to softly conform to the rest of your app:

You want to give instructions such as having your own variable names or using classes in the html markdown if the websim generated code was:
```
:root {
    --primary: #2C5282;
    --secondary: #4299E1;
    --success: #48BB78;
    --warning: #ECC94B;
    --danger: #F56565;
    --background: #F7FAFC;
    --text: #2D3748;
}
```

PROMPT (ChatGPT o1 advanced) - Adjust the prompt accordingly to your codebase and the generated code:
```
Help rewrite this style block and html markup so that it uses my own brand’s classes and css variable’s in the rest of my code (Not provided).
  
At the style block:  
- Please get rid of css variable definitions. If they have these css variables please change them to the other css variable:
- --primary should be --primary-color,
- --secondary should be --primary-color-tinted,
- Please get rid of css variables --warning, --danger, and --background and hardcode their color values into the css.
- Please get rid of --text variable but don’t hard code the color value. I have my own --text value that fits my brand.

At the html markup, replace or add classes where applicable with my brand classes:
"""
h2-brand
textcolor-brand
textcolor-brand-contrasted
bgcolor-brand
bgcolor-brand-secondary
gcolor-brand-contrasted
btn-danger
btn-light
btn-dark
btn-brand-primary
btn-brand-secondary
btn-brand-tertiary
"""

My style block and html markup are:
"""
{YOUR STYLE BLOCK AND BODY BLOCK}
"""
```


---

## V. Transform Code to AI Friendly and Developer Friendly - Tailwind

Convert to tailwind using ChatGPT Model 4o (Do NOT use o1 because it does too much and introduces problems in the solution)

Make sure to adjust the prompt to fit your theme's classes so that they do not get atomized into tailwind classes (which makes changing your theme colors NOT be reflected in your new code). Even if it's the same chat thread as the prompt above where you first introduced the class names, you can't trust the AI to retain it. If you're not using theme css variables, then omit that part of the prompt.

If using the same chat thread as the above prompt, you would change the model from o1 to 4o in the middle of the chat.
![](https://i.imgur.com/gzME6N1.png)


1. Prompt ChatGPT 4o to convert to tailwind, which is friendly to developers and to further AI transformation prompts in the future.
   
PROMPT:
```
Convert to tailwind. Do not give solutions that require custom Tailwind configuration (So no tailwind.config.js). 

Please do not add tailwind classes that has square brackets like "text-[var(--gray-800)]" and "h-[14rem]". We can use inline style attribute if that's the case. If there are any square bracket classes, replace them with inline style attribute.

Leave alone my branding classes and custom css variables.

My branding classes are:
"""
h2-brand  
textcolor-brand  
textcolor-brand-contrasted  
bgcolor-brand  
bgcolor-brand-secondary  
gcolor-brand-contrasted  
btn-danger  
btn-light  
btn-dark  
btn-brand-primary  
btn-brand-secondary  
btn-brand-tertiary
"""

Here’s my style block and html markup:
"""
{YOUR STYLE BLOCK AND BODY BLOCK}
"""

```

2. Double check that the AI did not introduce tailwind.config.js type classes and JIT classes like "text-[var(--gray-800)]" and "h-[14rem]". Just chat with the AI to remove them. Worse case, you implement the css properties and remove the classes in question.
	1. BUT - If you're okay with doing extra work, then you can keep the square bracket classes.
3. Make sure to add tailwind loading into the code. You could use their tailwind .js file which could cause FOUC unless you perform further development and tooling. Or you could add the css file from version 2 (which is missing some tailwind classes):
```
<link href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
```

For a full list of missing classes from tailwind v2, refer to [[Tailwind v2 missing classes from Tailwind v3]]
