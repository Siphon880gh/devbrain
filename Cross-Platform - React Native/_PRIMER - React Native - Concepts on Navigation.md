Why its own note instead of being in Concepts note:
Navigation concepts such like how to go from screen to screen can be done in various ways from React Navigator using name routes and defining them in code of a Stack Navigator / Tabs Navigator / Drawer Navigator, to Expo-Router using url routes and defining them with a file structure at app/ (based off of Next.JS of the React Web ecosystem). There is also React-Router-Native (an offshoot of the React-Router-DOM of the React Web ecosystem). It deserves its own note.

---

The user being able to navigate from screen to screen is important unless you’re making an one-page app. And how navigation works can be very complex for the beginner developer.   

After reading this, you should know concept wise: React Navigation (can be enhanced with NativeBase Navigation) vs React Router Native vs Expo Router.

Also after reading this, you should know at a concept level there’s the default React-Native Navigation components: Stack Navigator, Tab Navigator, Drawer Navigator, Bottom Tab Navigator.

You should also know from reading that, concept level the different ways of architecting multiple screens with react router native (hidden url based) or expo router (file-url based).

---

### Routing Libraries

When your app has multiple pages, the code isn’t simply opening the filename of the screen. Each page/screen has a unique way to call them so the app knows who to open. What you call them are the routes. React Native has multiple libraries to do just that. Depending on the library, how you name the route is different .

1. **React Navigation:**
	- The React Navigator uses named routes. Imagine an About page, and that would be the name “About” in `Tabs.Navigator>(Tabs.Screen[name=”...”]*N)`  or `Stack.Navigator>(Stack.Screen[name=”...”]*N).` Then your pressible whose onPress can open that page by calling its name route like `on Press={()=> { ()=>{ return useNavigation(); })().navigate(”ROUTE_NAME”) }}`
	- **Stack Navigator:** Allows you to navigate between different screens in a stack, where each screen can be pushed onto the stack and popped off. It’s similar to the way web pages work. For more information on how stack behaves and what the user experience is, refer to [[React Native Navigation - How Stack Navigator or the Stacking of Screens Work]]
	- **Tab Navigator:** Used for navigation between different tabs, each containing a different stack or set of screens.
	- **Drawer Navigator:** Provides a drawer that slides in from the side of the screen, allowing you to navigate between different screens.
	- **Bottom Tab Navigator:** Similar to Tab Navigator but places the tabs at the bottom of the screen.  
	- For more information on the tab bar, refer to [[3. Tab bar]]
		
		![](https://i.imgur.com/ie28FiP.png)
		^ [https://reactnavigation.org/](https://reactnavigation.org/)

	- **Optional: NativeBase Component Substitutions:**
		- This is a UI library that replaces the plain React Native default components as well as the **React Navigation** components to offer a more consistent design system across your app, with support for tabs, stacks, and other common navigation patterns.
		- NativeBase is now: gluestack-ui
			https://nativebase.io/
			https://gluestack.io/
			But `npx create-expo APP --example with-native-base` stills works as of Aug 2028


2. **React Router Native:**
	- The React Router Native uses url routes. Imagine an About page, and that would be the url “/about” instead of “About” in `Router>(Link[push][to="URL_ROUTE_TO_NAVIGATE_TO"]+Route[path="URL_ROUTE_TO_DEFINE"][component={COMPONENT_NAME}])` . Alternately you can programmatically visit the page with `(()=>{ return useHistory(); })().push` , `(()=>{ return useHistory(); })().replace` , etc. The mobile app does not have an address bar but this React Router Native is an offbranch of React Router Dom which meant to leverage the History API on web browsers. However it’s recommended you DO NOT use React Router Native because of shortcomings in the React Native cross-platform world. Refer to [[_WARNING - Skip using React Router Native]]


3. **Expo Router**
	- Expo Router uses url routes and instead of defining the url routes to the components in the code like in React Router Native, you define the routes based on the file and folder structure in /app. Having nested folders would mean having segmented paths in the route url. However, you could group similar descendants in a route group by naming a folder `(GROUP_NAME)`  which can help with tab navigator + expo router, and it can just help you keep your folder routes clean and tidy without affecting the url route.
	- Expo router are relative url routes configured by a file structure in app/. You can make certain routes belong to a stack by using expo router’s Stack
	- Note that although the routes are url-based, apps dont have address bars. This is really more of a convention and the idea that each screen on the app has a url or an uri that you can perform deep linking to on the internet anyways (yourapp://page1).

---

### Routes and Stacks

Using routes do not automatically mean it’s a stack that the user can swipe a screen away to pop it off and unwind to a previous screen, with animation and possibly sound effect, and depending on your config, a stacked screen could show a header with a left arrow button to pop off. 

Using a React Navigator's Stack Navigator, those screens defined there with named routes - those are routes that belong in a stack. The code is like `Var.Navigator>(Var.Screen[name="NAMED_ROUTE"]*N)`

For Expo Router, it's not automatically a stack for the routes you define. You have to encapsulate with Expo Router's Stack component. Syntax is `Var>(Var.Screen[name="NAMED_ROUTE"]*N)`. Notice no subcomponent `Var.Navigator` like in React Navigator's.

---

### Passing Data

Usually with traditional web url routes (node js, express, etc) you pass data between pages using url queries. In the case of React Navigation or Expo Router (syntax varies slightly with expo router being more pedantic having keys), we pass data in an object at the same navigate function call that opens a page based on its route. It doesn’t matter if the route it passes data to belongs to a stack or not. Pass The data is intercepted as props.params

---

### Challenges, Refer to

The Mastery Levels folder contains mini-apps that you can build towards mastering the basics of navigation. Also refer to React Native Navigation tutorials, eg. [[React Native Navigation - Stack Navigator (Expo-Router)]], [[React Native Navigation - Expo Router how file-url routing works]], etc.