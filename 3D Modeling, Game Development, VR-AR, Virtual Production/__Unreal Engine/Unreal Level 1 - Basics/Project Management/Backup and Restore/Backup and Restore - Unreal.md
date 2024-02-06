
## More reason to backup:

- Unreal likes to crash then reverts back hours of work. 
- A common restore method: There is Saved/Autosaves folder with uasset files you can drop into their original location, however this is not known to work consistently.


## Backup with Zip

File → Zip Project


## Restore from ZIp

Unzip the zip file. If necessary: Rename the folder. Rename the uproject file inside.

Make sure to move to where your other projects’ folders are. (To find this location, Unreal open projects → Right click a project → Show in Finder)

Open Unreal and the restored project (No thumbnail? It’ll fix the thumbnail once you open the project).

Might ask you in a dialogue.. Modules missing.. would you like to rebuild now. > Choose yes.

Once in, make sure to: Build → Build All Levels

Play to test project integrity maintained.