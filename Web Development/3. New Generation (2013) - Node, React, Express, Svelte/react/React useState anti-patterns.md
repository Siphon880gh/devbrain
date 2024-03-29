
Don't have useState subscribe/publish HTML strings that contain other useState variables. That HTML string's useState variables won't be re-rendered on changes.

Don't have functions that return DOM's that have useState subscriptions from higher up DOM's. It would not rerender on state changes of the nested DOM's. Instead, pass and receive variables as props. You can even pass the useState variable and setter as props.