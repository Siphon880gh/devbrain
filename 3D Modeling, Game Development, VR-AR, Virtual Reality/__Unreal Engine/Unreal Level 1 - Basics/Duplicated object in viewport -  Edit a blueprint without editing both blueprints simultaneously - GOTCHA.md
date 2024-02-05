Duplicated object in viewport. They are both blueprints. But when you edit one blueprint, it simultaneously edits the same changes to the other blueprint.

Why? When you duplicate an object across the viewport, it’s still the same blueprint class for both objects. This means if you change one blueprint’s nodes (event graph) or viewport, you’re changing both objects simultaneously.

To fix this, it’s an unintuitive workflow but duplicate the Blueprint like so:
![](https://i.imgur.com/FIiEEuq.png)

You may want to rename the duplicated blueprint class because it’ll get confusing with the model name and the blueprint name. I renamed it from “Quin_Feet_Blueprint1” to “Quin_Feelt_BlueprintNext”


Then reassign the class for the duplicate object.  Right click the duplicated object in Outliner → Replace Selected Actor with → (Then select your new duplicated blueprint)
![](https://i.imgur.com/SpdBadp.png)

You can confirm that the Types no longer match:
![](https://i.imgur.com/uegFqPu.png)
