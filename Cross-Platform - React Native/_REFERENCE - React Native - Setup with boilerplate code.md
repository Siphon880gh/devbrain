
Are you at the right place?
This is assuming you're already familiar with all the Primer guides (aka Get Started) and you want quick ways to setup React Native from their boilerplate

---

**Many boilerplates with different expo - react-native setups**
[https://github.com/expo/examples](https://github.com/expo/examples)

You generate the boilerplate in the terminal based off the folders at Github:
```
npx create-expo --example ___
```

Fill in the blank:
- with-react-router
- [with-router-menus](https://github.com/expo/examples/tree/master/with-router-menus "with-router-menus")

- with-native-wind
- [with-router-tailwind](https://github.com/expo/examples/tree/master/with-router-tailwind "with-router-tailwind")
- [with-tailwindcss](https://github.com/expo/examples/tree/master/with-tailwindcss "with-tailwindcss")
  
```
NativeWind classes  
https://www.nativewind.dev/v4/overview/
```

- blank
- with-nativewind
	- tailwind className
- with-styled-components
- with-react-native-elements
	- ui library: substitute components for the default plain components at react-native
	- MODULARITY: You could just install afterwards too with npm!
- with-native-base
	- ui library: substitute components for the default plain components at react-native AND react-navigation
	- See: `import { Container, Header, Title, Left, Icon, Right, Button, Body, Content,Text, Card, CardItem } from "native-base";`
	- Also utility styling easy with attributes
	```
	<Button full rounded dark
	```
	- NativeBase is now: gluestack-ui
	  - NativeBase is now: gluestack-ui  
	    [https://nativebase.io/](https://nativebase.io/)  
	    [https://gluestack.io/](https://gluestack.io/)  
	    But `npx create-expo APP --example with-native-base` stills works as of Aug 2028.

- navigation
	- name-based routes in Stack navigator, mixed with bottom tabs
- [with-tab-navigation](https://github.com/expo/examples/tree/master/with-tab-navigation "with-tab-navigation")

Misc with features:
- [with-maps](https://github.com/expo/examples/tree/master/with-maps "with-maps")  
- with-pdf
- with-openai
- [with-google-vision](https://github.com/expo/examples/tree/master/with-google-vision "with-google-vision")

---

Their boilerplate might fail because of conflicts with current node version. They have node_modules included. It might complain about watchman, then complains about metro-runtime. If you run into these errors, obligatory refer to [[React Native zTroubleshooting - Watchman or metro-runtime error]]