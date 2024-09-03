By: Weng

Purpose of this guide is to get React Native installed on your system so you can code for web, ios, and android in one code base. Then we will test we can make some code changes and see the screen changed. For the syntax, it is a steep learning curve which will be covered by another guide: [[_PRIMER - React Native - Concepts]]

###  **Somewhat Required Skills:**
- **React esp useState, useEffect forms, props. Otherwise you’ll be learning it at the same time with React Native**
- **NextJS routes are going to be used in React Native but it’s easy to learn during React Native if you haven’t learned it yet**

---

### **Get an idea**

What is React Native

Do not have to follow these tutorials. You can jump around to get an idea

- Quick Concepts: [https://www.youtube.com/watch?v=gvkqT_Uoahw](https://www.youtube.com/watch?v=gvkqT_Uoahw)

- 2023 - 2.25 hours - Job app: [https://www.youtube.com/watch?v=mJ3bGvy0WAY&t=651s](https://www.youtube.com/watch?v=mJ3bGvy0WAY&t=651s)
  
```
00:00 Learn React Native basics and build a job search app with Expo
08:40 React Native has popular components such as Text, View, and Touchable Opacity
1:58:52 Fully functional job search app with pagination and job details page
2:06:20 An introduction to React Native and developing a mobile application
23:30 Setting up the initial layout with a navigation bar
31:12 Create a mobile app layout with a navigation bar and welcome section
46:54 Created layout and list for popular jobs
54:37 Creating a custom useFetch hook with dynamic API fetching
1:10:21 Implementing nearby job list with use fetch function
1:18:07 Implement UI for job details page
1:34:16 Create a company detail page with job tabs
1:42:34 Dynamic display of job tab content
Crafted by Merlin AI.
```


- 2024 - 4.5 hours - Share AI generated videos app (with Auth and picture uploading): [https://youtu.be/ZBCUegTZF7M](https://youtu.be/ZBCUegTZF7M)

---

### Setup React Native

Requirements:

- Node
- Android Studio
- XCode
- XCode command line tools

Basic instructions at:
[https://docs.expo.dev/router/installation/](https://docs.expo.dev/router/installation/)  


Or follow my guide which is more complete and covers edge cases during installation. My guide will also continue with React Native syntax. Continuing my guide:

```
npx create-expo-app@latest  
```
^ default comes with router. If you want to deconstructingly what you want to install, refer to Manual Installation at

[https://docs.expo.dev/router/installation/](https://docs.expo.dev/router/installation/)


```
npx expo start
```


### Setup Web and Virtual Devices

1. You'll see:
```
ASCII of QR Code  
  
› Press s │ switch to development build  
  
› Press a │ open Android  
› Press i │ open iOS simulator  
› Press w │ open web  
  
› Press j │ open debugger  
› Press r │ reload app  
› Press m │ toggle menu  
› Press o │ open project code in your editor
```

2. Check opening on web. Press 'w'


3. Check android simulator (a) and ios simulator (i)

#### Checks
##### **Checkpoint: Starting a device fails saying “too many open files”**
Error is when running android or web:
```
Error: EMFILE: too many open files, watch
    at FSEvent.FSWatcher._handle.onchange (node:internal/fs/watchers:207:21)
```

Check 1 - Do you have watchman?
Check if watchman installed. Depending on your OS package installer, check like:
```
brew list watchman
```

Then install like (depending on your OS package installer):
```
brew update
brew install watchman
```

Troubleshooting - Installed watchman under M1 M2 Apple Silicon chips and still fails to run?
You may need to ensure that you're running commands under the correct architecture.
```
arch -arm64 brew install watchman
```

Check 2 - May be a node version problem
Remove node_modules folder, then run npm install 

Theoretical but doesn’t work: Match node and watchman whats compatible.
brew list watchman  get version or date. Then match date as close to node releases
https://nodejs.org/en/about/previous-releases. You can consider installing nvm and using it to manage your node version (usually downgrading node because of expo or its dependencies or watchman not having caught up). You can modify a .nvmrc


##### Checkpoint: Starting a device fails talking about metro runtime

Error after pressing ‘w’ etc looks like:
```
It looks like you're trying to use web support but don't have the required dependencies installed.

Please install @expo/metro-runtime@~3.2.3 by running:
npx expo install @expo/metro-runtime
```

Theoretically should work but doesn’t: Installing it globally wouldn’t fix this permanently
```
npx install -g @expo/metro-runtime@~3.2.3
```

So just follow the instructions of:
```
npx expo install @expo/metro-runtime
```

If the above two errors happens with every new project you start, then you may need to create a script called with alias in your shell’s profile. Perhaps a script that removes node_modules, then runs `npm install`  then runs `npx expo install @expo/metro-runtime`

##### **Checkpoint: Web works but iOS failing?**

**Do you have XCode Command Line Tools (for iOS)?**
```
xcode-select --install
```

Web works but iOS still failing? (Tried previous fix)

1. Update the `React Native Xcode build script` with this line: `export PATH=/opt/homebrew/bin:$PATH` so xCode could find `watchman` (Could happen on a M1 MacBook Pro).
2. React Native Xcode build script location: `./node_modules/react-native/scripts/react-native-xcode.sh`  
    
3. If still fails, add the `export PATH` command in front of the build script call

##### **Checkpoint: Web works but Android failing?**


[https://docs.expo.dev/workflow/android-studio-emulator](https://docs.expo.dev/workflow/android-studio-emulator)  

Basically, Android Studio → Tools → SDK Manager → Languages & Frameworks: Android SDK → SDK Tools → Select the Android Emulator

![](https://i.imgur.com/xSmTpOk.png)
Copy the path and export as a path variable: `export ANDROID_HOME=$HOME/Library/Android/sdk`

Setup ANDROID_HOME path. May want to setup in your bash_profile or equivalent then source or restart the terminal.

  
Make sure to setup the android emulator too

On the Android Studio main screen (File → Close Project), access Virtual Device Manager.
![](https://i.imgur.com/wLVbnDb.png)


Click the Create device button.----Under Select Hardware, choose the type of hardware you'd like to emulate. We recommend testing against a variety of devices, but if you're unsure where to start, the newest device in the Pixel line could be a good choice.----On next, select an OS version to load on the emulator (probably one of the system images in the Recommended tab), and download the image.


Web works but android still failing? (Tried previous fix)
cd android and ./gradlew clean before trying

#### Explore how to open Developer Menu on the difference virtual devices.

Working on iOS Simulator:  
It’s CMD+d to open the developer menu (only if keyboard is connected with CMD+shift+K)
![](https://i.imgur.com/jFTdJUm.png)


Working on Android Simulator:

It’s CMD+m or Ctrl+m to open developer menu. You’ll briefly see three dots which represents a three finger press (sneak peak: that’s how you’ll open the developer menu on the physical device)

![](https://i.imgur.com/ud8ZjKS.png)

### Setup Synchronizing to physical phones

Check synchronizing to a physical android and physical ios simulator (where applicable)

Either QRCode or opening the app Expo Go on the same server (will list your server as being active and selectable)

  
Synchronization requirements:
- Setup your physical phone (Android and/or iPhone):
	- Install app “Expo Go” on physical phone
	- Sign up for a “Expo Go” ccount if dont have an account
- Setup your terminal
	- Run `expo login` . Login with account as prompted.
- Make sure phone and computer on the same wireless


#### METHOD QRCode or Expo Go App:

Check the terminal of `npx expo start` 

Is the QR code white? Or is it green and broken up?

Bad:
![](https://i.imgur.com/Ug3WZFo.png)


Good:
![](https://i.imgur.com/5RABv8F.png)


There’s no known solution that seems to work. Most solutions are to check your terminal settings or to reinstall expo or make sure there’s no conflicting global expo vs local expo. Try using terminal vs using VS Code’s terminal. If those solutions dont work, synchronize to the physical phone in the other way.

If QR Code is good, you can follow the instruction at the QR Code regarding scanning with camera or opening Expo App to scan

#### METHOD APP:

Having ran `npx expo start` , open Expo Go on your physical phone. Make sure your development computer and the physical phone are both on the same wireless network. Make sure VPN set to OFF.

  
#### AFTER SUCCESS ONTO A PHYSICAL PHONE

Explore how to open Expo Go options.

Explore opening Developer Options:

- You can three finger long press on the screen

Pressing r on the terminal can also refresh the physical phone’s


---

### Setup Developer Experience

Lets improve developer experience before we do any coding

#### SNIPPETS

A common practice is typing `rnfe`  (react native functional expression) in VS code and pressing tab would expand to the full boilerplate of react native.

Get ES7+ React/Redux/React-Native snippets (by dsznajder)


Common ones are
- `rnfe`
- `rxreducer`
  
More at:
[https://github.com/r5n-dev/vscode-react-javascript-snippets/blob/master/docs/Snippets.md](https://github.com/r5n-dev/vscode-react-javascript-snippets/blob/master/docs/Snippets.md)

#### MORE SNIPPETS

Add our owns

CMD+SHIFT+P: Configure Snippets

You can name it: React Native Overrides

And it’s located at `~/Library/Application Support/Code/User/snippets/`

```
"rnt": {  
		"scope": "javascript,typescript",  
		"prefix": "rnt",  
		"body": [  
			"const { findRenderedComponentWithType } = require('react-dom/test-utils');",  
			"",  
			"findRenderedComponentWithType"  
		],  
		"description": "React Native Override: Normally rntw which autocompletes React test code. Backed up to rnt."  
	},  
	"rntw": {  
	"scope": "javascript,typescript",  
	"prefix": "rntw",  
	"body": [  
		"import { View, Text } from 'react-native';",  
		"import { NativeWindStyleSheet } from 'nativewind';",  
		"",  
		"NativeWindStyleSheet.setOutput({",  
		"  default: \"native\",",  
		"});",  
		"",  
		"export default function App() {",  
		"  return (",  
		"    <View className=\"bg-red-300 flex-1 justify-center items-center\">",  
		"      <Text>Universal React with Expo</Text>",  
		"    </View>",  
		"  );",  
		"}"  
	],  
	"description": "React Native Override: Autocompletes React with NativeWind and TaildwindCSS"  
	}
```

#### #### EMMET EXPAND SINGLE LINE

So something like View>Text  or View>Text{Hello World!}  can expand
CMD+SHIFT+P for:
\>User Settings (JSON)

Add:
```
    "emmet.syntaxProfiles": {  
        "jsx": {  
            "inline_break": 1  
        },  
        "tsx": {  
            "inline_break": 1  
        }  
    },
```

Note this would not work for .js files and you probably wouldn’t want that unless you’re exclusively doing jsx for all future js projects in your VS Code. Maybe you can setup a way to trigger it on and off! Or setup build scripts for cli aliases in your appropriate shell profile to create `.vscode/settings.json`  with js off or on, which creates project level user settings that override global user settings

So you can expand `View>Text{Hello World}`  or `View.mt-4`

---

## Check code changes can show instantly

**Now lets test that you can make changes and have them show in the devices / virtual devices**

Check point so far: You can run on simulated ios, simulated android, web. You can run on synchronized physical ios and physical android (whichever applicable to you). 

Let’s test if changing the code will show changes in the webpage

Go to ./app/(tabs)/index.tsx

See if changing “Welcome!” to having more exclamations like “Welcome!!” will be reflected on the webpage. 

Note the first ever change is going to take a while because Expo has to install some additional dependencies for hotloading. All future changes will be instant.

---

## Wrap up

If works then great! Let’s move forward to creating an app. This starter code generated may be too involved for beginners. There are example starter codes like 

npx create-expo --example blank

React Native is not a platform you can just learn while “winging it” like javascript. Go through the Mastery Levels folder for an accelerated learning