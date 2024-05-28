
Paste this code to a lone html file:
```
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Document</title>  
  
    <style>  
        html, body, nav {  
            padding: 0;  
            margin: 0;  
        }  
        nav {  
            position:sticky;  
            top:0;  
            left:0;  
            width:100vw;  
            height: 100px;  
            background-color: gray;  
            transition: background-color 800ms ease-in-out;  
        }  
        nav.active {  
            background-color: red;  
        }  
    </style>  
</head>  
<body>  
    <div class="container">  
        <nav>  
            <img src="https://placehold.co/100x100" alt="">  
        </nav>  
        <main>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
        </main>  
    </div>  
  
    <script>  
        window.addEventListener('scroll', function() {  
            const nav = document.querySelector('nav');  
            if (window.scrollY > 100) {  
                nav.classList.add('active');  
            } else {  
                nav.classList.remove('active');  
            }  
        });  
    </script>  
  
</body>  
</html>
```

---


This HTML document creates a simple web page with CSS styling and JavaScript functionality to demonstrate how a navigation bar can become sticky and change color (with transition animation) as the user scrolls down the page. Here’s a breakdown of the key elements and their roles in the code:

### HTML Structure
- **DOCTYPE and html tag**: The `<!DOCTYPE html>` declaration defines the document type and version of HTML. The `<html lang="en">` specifies that the content of the page is in English.
- **head section**: Contains meta tags and the title of the document. The meta tags set the character set to UTF-8 and configure the viewport to be responsive on different devices.
- **style tag**: Defines CSS for styling the HTML elements. Here, it styles the `html`, `body`, and `nav` tags to remove default padding and margins. It also styles the `nav` element to be sticky at the top of the page with a default background color of gray and a transition effect for changing the background color.
- **body section**: Contains the main content of the page. It includes:
  - **nav**: A navigation bar with an image placeholder. The `nav` is styled to be sticky, meaning it will stay at the top of the viewport as you scroll down.
  - **main**: A main content area filled with multiple line breaks (`<br/>`) to create enough content to scroll through.

### CSS Styling
- **Sticky Navigation**: The `nav` element has `position: sticky;` which keeps it at the top of the viewport even as you scroll down. `top: 0;` and `left: 0;` ensure it stays at the top left corner. `width: 100vw;` makes it as wide as the viewport. The `height` is set to 100px.
- **Color Transition**: There's a transition effect on the `background-color` property of the `nav`, taking 800 milliseconds and following an "ease-in-out" timing function. This creates a smooth change when the background color switches.
- **Active Class**: The `.active` class changes the `nav`'s background color to red.

### JavaScript Functionality
- **Scroll Event Listener**: The script listens for the scroll event on the window.
- **Functionality**: When the user scrolls, it checks the vertical scroll position with `window.scrollY`. If it's greater than 100 pixels, the `active` class is added to the `nav`, changing its background color to red. If the scroll position is less than or equal to 100 pixels, the `active` class is removed, returning the background color to gray.

This example is useful for understanding how to manipulate the DOM with JavaScript based on user interaction (scrolling in this case), and how CSS can be dynamically applied to create responsive and interactive web interfaces.