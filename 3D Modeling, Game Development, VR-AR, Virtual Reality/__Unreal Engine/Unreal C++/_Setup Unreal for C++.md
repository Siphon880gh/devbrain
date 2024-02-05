
Setup Editor:
UnrealEditor → Preferences → Source code → Select: Preferred Editor
“Set as Default”

Setup Per project:
Tools → New C++ Class
Because it needs to generate the files to have code to edit
From https://community.gamedev.tv/t/generate-visual-studio-code-project-grayed-out/152197

If that doesnt work, right click .uproject file → Generate XCode Project

If none of the above works (this is very finicky to OS / Unreal):
https://docs.unrealengine.com/5.0/en-US/setting-up-visual-studio-code-for-unreal-engine/


Now you can “Edit in C++” from Outliner → Component/Actor/etc → Details:
![](https://i.imgur.com/gN6iWnN.png)
