
This is a quick and dirty way to debug on mobile where the DevTools console is not available but you need to inspect variables. Adapt to JS, React class component, or React functional component. You may need to cast to String if necessary.

Then in production, you would not have this problem with live viewers. You just add a URL query param v which you can use for busting cache too.

The more professional way is you can use browser tools to connect mobile use to the computer's DevTools console, and you can have a staging server. But this trick serves for quick and dirty when cut on time.

```    componentDidMount() {

        if(window.location.href.includes("v=")) {
            alert("1 " + document.body.clientWidth)
            alert("2 " + document.querySelector(".react-root").clientWidth)
            alert("3 " + document.querySelector(".wrapper").clientWidth)
            alert("4 " + document.querySelector(".sides").clientWidth)
            alert("5 " + document.querySelector(".side-c").clientWidth)
        }
    }

```