
If you duplicate on the level, actually both actors share the same blueprint event graph. Editing one actor's blueprints will affect the second actor's blueprints

You want the duplicated blueprint actor to have their own blueprint event graph.

If you want duplicate objects that have their own variations of nodes, you’ll want to create different blueprints in content drawer (maybe duplicate a blueprint with right clicking it → duplicate), then drag and drop the new blueprint from content drawer into the level viewport

![](https://i.imgur.com/ylLn7lP.png)

![](https://i.imgur.com/QwS1oAQ.png)
