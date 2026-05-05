Issue: Slow storyboard:

Make sure enough hard drive space.

Update to latest iOS. Update to latest XCode.

XCode > Preferrences... > Navigation > Navigation Style -> Open in Place
XCode > File > Workplace Settings > Select Build System as New Build System (Default)

Editor -> Canvas -> Device Bezels -> Disabled

Resolved all auto layout issues (at main storyboard canvas,'s left side panel that lists all the scenes, look for any yellow or red right arrows right of the scene name. If there are, click them and make the recommended layout fixes (For example, suggested constraints, etc)

Mixo.xcodeproj -> Show Packaged Contents -> Delete xcuserdata
Mixo.xcodeproj -> Show Packaged Contents -> Nested .xocodeproj -> Show Packaged Contents -> Delete xcworkspace 

Removed Mixo Test and Mixo UI Test

Edit Podfile so Firebase pods are at the bottom of all other pods. Removed Mixo Test from Pod file. Then removed /Pods and Podfile.lock. Run `pod install`

Delete Derived data with: `rm -rf ~/Library/Developer/Xcode/DerivedData`

Restart XCode and build it again.
