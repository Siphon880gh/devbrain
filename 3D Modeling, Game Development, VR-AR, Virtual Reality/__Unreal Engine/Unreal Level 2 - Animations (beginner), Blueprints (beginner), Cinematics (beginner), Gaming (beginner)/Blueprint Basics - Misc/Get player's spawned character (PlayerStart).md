
If PlayerStart is spawning a character, and you need to reference that spawned character in Blueprint event graph

You're usually referencing the spawned character in the Blueprint as an actor. Use the node "Get player pawn". That will usually work for most actor inputs because pawn can be interchangeable with actor in most cases. However, if that fails, you can try "Get Actor of Class" (make sure you don't accidentally select "Get All Actors of Class")

Otherwise, go into World Settings->Selected Game Mode→ Default Pawn Class
...to get the name of the class for you to do the node “Get Actor of Class”

If you don't have World Settings, go to Windows -> World Settings

World Settings. Look at bottom of this screenshot:
![](https://i.imgur.com/6cM5ANk.png)
![6cM5ANk.png](https://i.imgur.com/6cM5ANk.png)

You have to expand "Selected GameMode":
![](https://i.imgur.com/IoBhelz.png)

Unreal 5.3 has a glitch where searching for "Default Pawn Class" or "DefaultPawnClass" doesn't show the option so you have to manually expand the section.

That's the name of the class for "Get Actor of Class". You can get the full name easily by jumping into the Content Drawer. Click the folder with magnifying icon button:
![](https://i.imgur.com/D4rX6ML.png)
