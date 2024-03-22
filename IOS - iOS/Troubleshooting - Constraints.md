
Constraint problems causing UIViews to not show?
Not  all errors show  up  on  the side panel  of scenes. Normally at the left panel of scenes you'll see a right arrow next to the scene name (remember scene is the same as view controller here). The arrow is usually yellow or red. You click that arrow and follow suggestions to fix constraints. 

But that's not there and you still have constraint problems? You may need another view of the constraints. Click the 3d  layer icon. In the 3d  view,  rotate/pan  until you have  a clear look  at the UIView whose constraints you suspect are troublesome. Right click that UIView ->  Reveal in Debug Navigator. Now on the left panel, you see all the classes both inherited and further downstream (like for UIView controls you designed) in a hierarchical navigator. Find the UIView class of interest and see if there's a purple triangle with exclamation mark  instead (instead of an arrow)

If you want yet others view of the constraints to find troublesome constraints that the AI cannot find (sometimes the human brain is better), there are two views where they lay it out for you to analyze and even be able to edit them:
a.) Where the scene side panel is at, UIViews with constraints will have a "constraints" item you can expand. You can highlight an individual constraint and press Enter, allowing you to edit the constraint directly in their language. Please keep in mind for their language, things like width less than or equal to 300 is not simply <=300; they use the actual underlined left angle bracket.
b.) The second view is in the Inspector panel. Make sure the  correct UIView whose constraints you are interested in - is selected. At the inspector panel, it's the size tab. Scroll to the bottom for all constraints. You can click Edit on a constraint. There you can select Less than or equal to in a dropdown, instead of copying and pasting the symbols ≤ and ≥. But actually, clicking Edit only lets you edit the basics - you should always double click for more finer options.

The inspector panel also lets you easily delete individual constraints. Select the constraint and press Backspace on your keyboard
