
This guide is assuming you already have done some projects in this language/framework, but that there are certain concepts that you will forget with time and lack of use because of its complexity. You come here if you haven't done React Native in a while and is in need of a quick refresher. 

This guide covers the complex and easily forgotten. Then you can cover fundamentals at the primers and challenges if they've unstuck from your head during the time away from React Native.

---

### Quick List

- Know the different routing systems at [[_PRIMER - React Native - Concepts on Navigation]]
- We should know that stacking is not required for routes. But if you stack, they are routes (eg. React Navigation's `<StackNavigator>`)
- React Router Native is to be avoided. See [[_WARNING - Skip using React Router Native]]
- React Router Native can be confused with Expo Router. See differences in --example boilerplate names:
	- with-react-router ← Installs the react router native, which is NOT a recommended routing system. Use expo router or react navigation instead
	- with-router ← Is expo router that uses url routes which are configured based off the file structure at app/. you can wrap with expo router’s Stack if you want the routes to navigate then stack.
- Run boilerplate code from `npx create-expo APP --example __`. Those examples found at:
  https://github.com/expo/examples