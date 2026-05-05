
pushState lets you change the url without refreshing the page. User is able to go back and forward on the Navigator and the url would change but the webpage DOM doesn't change.

if you want the webpage DOM to change, use popState event to control the DOM based on the `history.state` (more on this soon).

you can also access any variables you passed into pushState. The variable is part of the state tied to that url. It's accessible with:
`history.state`

Notice that the history.state does not change key name when your variable that you passed in has a different variable name from state. It's always "history.state"

Any variables in the global state remains unchanged between navigating back/forth or pushState. Only one that changes is the history.state. If you do not need to pass any variables that have states tied to the url, then you can pass in {} in place of a variable, like: `history.pushState({}, "Site Title", url)`

If you want to retain the site title, you can: `history.pushState({}, document.head.title, url);`


```
<body>
    <div class="state-view">Q1</div>
    <button>Test</button>
    <script>
    var stateView = document.querySelector('.state-view');
    var button = document.querySelector('button');
    console.log(window.location.hash);

    var state = {
            page: 0,
            perPage: 10
        };
    button.addEventListener('click', function() {
        state.page++;
        var title = 'Q'+state.page;
        var url = 'sandbox.html#q' + state.page;
        history.pushState(state, title, url);
        stateView.innerHTML = 'Q' + state.page;
        document.head.title = 'Q'+state.page;
        console.log(state.page);
    }); 
    </script>
</body>
```


---


popstate lets you detect when the url changed because the user clicked back or forth, and then you can also access history.state if you had passed variables (snapshotted values)

```
window.addEventListener('popstate', function(event) {
    if (event.state) {
        // For example, if your state object has a property 'page'
        // that determines which page content to show:
        switch(event.state.page) {
            case 'homepage':
                // code to display the homepage
                break;
            case 'contact':
                // code to display the contact page
                break;
            // ... handle other cases ...
        }
    }
});
```