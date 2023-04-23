## Express-Handlebars Basics

Handlebars is a templating engine for the backend so HTML is dynamically generated before sending to the client. Besides being fast, this also has SEO advantaged because the content is already generated for the robots to scrape. The other advantage is that you make your project easier to read for other developers or at a later time when you forget how your code flows, by adapting a MVC pattern with Express-Handlebars. Read the lesson on MVC paradigm.

The specific handlebars we are using is actually express-handlebars because it was designed to work with express through their routes and the conventional `res.send(..)` but instead if `res.render(..)`. You can continue parsing requests or looking up database which will help generate personalized content on the webpage.

For what is Express? Quick review on Express: It is an API you use in node js script that lets you run an Express server listening at an arbitary port for client requests with different methods and routes. Depending on the particular method and route, the Express will send a response back to the client. That response can be, among other types of data: Raw text, json, or webpage files. You can send raw text consisting of HTML code, and the client's javascript can choose to insert text or HTML onto the DOM. With Express-Handlebars, you send a response of HTML text that the client's web browser renders.

Packages you need:
```
npm install --save express
npm install --save express-handlebars
```

The design philosophy is ./views/layouts/main.handlebars will be the main layout. Think of this as the conventional website design where you have header, footer, logos, menu. Then the body content changes based on what the user clicks from the menu. Those body content are HTML stored in .handlebars files at ./views/ (Notice outside of /layouts). The file hierarchy, main.handlebars filename, and .handlebars file extension are all important for handlebars to work. Visual Code also recognizes .handlebars so can do syntax linting for you, which is nice.

So you want the file hierarchy to be:
```
views/layouts/main.handlebars
views/main.handlebars
```

Start the engine with
```
app.engine("handlebars", hbs.engine);
app.set("view engine", "handlebars");
```

So your example code could be:
```
const express = require("express");
const app = express();
const exhbs = require("express-handlebars");
const hbs = exhbs.create();

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.engine("handlebars", hbs.engine);
app.set("view engine", "handlebars");

app.get("/", (req, res) => {
    res.render("homepage");
    // res.status(200).send("Sample welcome text").end();
});
```

Contents of ./views/layouts/main.handlebars:
```
Hello, you reached main.handlebars. Body follows:
<p>
{{{body}}}
</p>
```

- So why is it triple curley brackets when handlebars is popularly known for its double curley bracket expression? I'm guessing {{..}} changes html symbols to character entities like < becomes &lt; as a default behavior to minimizes code injection hacks. But sometimes it's necessary to retain <,>, etc like in this case when you are loading a view into main.handlebars, so then the triple Curley brackets is necessary preventing HTML symbols from converting to character entities

Contents of ./views/homepage.handlebars:
```
Hello you reached homepage.handlebars.<br/>
```

That is the basics of Express-Handlebars, but controlling the template can get more complicated than that. You have built-in and custom helpers that help transform the data that gets passed to the templates or to iterate through an array of data. And you have partials that are micropieces of the template. Refer to the appropriate lessons.

Handlebars come in many flavors. This version of handlebars is meant to work with Express responses so it sends the HTML as a resonse to the client's web browser. Make sure to read the right documentation. The documentation is at: https://www.npmjs.com/package/express-handlebars
