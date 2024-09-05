
EF REFRESHERS: EASILY FORGOTTEN REFRESHERS

This guide is assuming you already have done some projects in this language/framework, but that there are certain concepts that you will forget with time and lack of use because of its complexity. You come here if you haven't done React Native in a while and is in need of a quick refresher. 

This guide covers the complex and easily forgotten. Then you can cover fundamentals at the primers and challenges if they've unstuck from your head during the time away from React Native.

---

### Quick List

- Know the different routing systems at [[_PRIMER - React Native - Concepts on Navigation]]
- We should know that stacking is not required for routes. But if you stack, they are routes (eg. React Navigation's `<StackNavigator>`)
- Know navigate vs push. Look for keypoint at [[_REFERENCES - React Native - Stack manipulation]]
- Stack replace, etc easy to forget because syntax is different between libraries: [[_REFERENCES - React Native - Stack manipulation]]
  
- React Router Native is to be avoided. See [[_WARNING - Skip using React Router Native]]
- React Router Native can be confused with Expo Router. See differences in --example boilerplate names:
	- with-react-router ← Installs the react router native, which is NOT a recommended routing system. Use expo router or react navigation instead
	- with-router ← Is expo router that uses url routes which are configured based off the file structure at app/. you can wrap with expo router’s Stack if you want the routes to navigate then stack.
	  
- Run boilerplate code from `npx create-expo APP --example __`. Those examples found at:
  https://github.com/expo/examples
  Those boilerplate code might conflict with your computer. If you get these errors you have to fix the error for each boilerplate you generate: [[React Native zTroubleshooting - Watchman or metro-runtime error]]

- For tailwind you have a few choices. May tailwind libraries will have you call functions inside the style attribute, but Nativewind will allow you to use classNames like a regular React app or plain HTML webpage. Nativewind has been conflicting in Aug 2028 and needed some workarounds
	- This makes sure that web works (web would fail to show tailwind if more than one class in className):
		```
		import { View, Text } from 'react-native';  
		import { NativeWindStyleSheet } from "nativewind";  {/* Fixes web */}
		  
		{/* Fixes web */}
		NativeWindStyleSheet.setOutput({  
		  default: "native",  
		});  
		  
		export default function App() {  
		  return (  
		    <View className="flex-1 items-center justify-center">  
		      <Text>Universal React with Expo1</Text>  
		    </View>  
		  );  
		}
		```
	- In addition, you may need to lock tailwind to 3.3.2. Your package.json: `"tailwindcss": "3.3.2"`