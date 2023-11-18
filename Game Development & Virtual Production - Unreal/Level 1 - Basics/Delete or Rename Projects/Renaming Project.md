
Why: 
- You may have to tidy up your project list with Unreal Editor.
- Renaming your project is a tremendous task in Unreal. They haven’t made a good UI for renaming projects as of Q3 2023.

Some quick ground rules:
No spaces allowed. No hyphen - allowed. You may use _ underscore in the filename
Filename cannot be longer than 20 characters. It’ll open in editor and you’ll receive a warning that somethings will not save properly.


You must do all these steps
In Unreal Project Browser, right click file → Show in Finder. 

Rename the .uproject file
Eg. “IndoorShootingRange.uproject” → “Indoor_Shooting_Range.uproject”

At config/DefaultEngine.ini, update or add. You may want to text search for it first
[URL]
GameName=Indoor_Shooting_Range

Back out to the folder containing all the above files and folders (.uproject file, config/DefaultEngine.ini file). That folder needs to be renamed.
Eg. “IndoorShootingRange” => “Indoor_Shooting_Range”

If there is thumbnail, rename that thumbnail file too. If no thumbnail, it’s because you haven’t set a custom thumbnail for the project browser and it automatically generates one for you

Restart the Unreal Editor Browser to have the correct name in browser. Open the project.

Rename in project settings, this time there’s no restriction on character length and types of character:
Edit -> Project Settings 
Search for: “Project Name” 
About -> Project Name

---

Prepared from:
https://youtu.be/HzQhO8nxeI8?t=84
https://www.youtube.com/watch?v=azz5XvrTWz8
