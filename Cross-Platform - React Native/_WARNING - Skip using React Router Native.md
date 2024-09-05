

React router native is relative url routes configured in code and does not support stack on phones. On web, it naturally supports stacking (navigating back) because it’s in the nature of the original react router to work with History API (to go back as well as forth, which is better than stacking because it can go forward). The documentation has code like `<Link push href="/feed">Login</Link>` which is meant for web.

There has been enthusiastic users who created libraries to wrap mobile stack support for react router native and it usually involves encapsulating the routes with their library’s provided Stack component
For v4 https://github.com/Traviskn/react-router-native-stack
For v5 early https://github.com/Taymindis/react-router-native-animate-stack

However react router native keeps updating their code and breaking the contributors’ stack support and then the contributors either abandon or archive their code.  At most on 9/2024, v5 no longer works with the most recent v5 expo because of Expo removing support for ViewPropTypes.style. You would have to go directly into node_modules folder for react-router-native-animate-stack/lib/AnimatedStack.js to replace that. Not worth the hassle when you could just use expo-router (url routes defined by file structure) or Stack Navigator (named routes). Mobile apps dont have address bars where you see the url route anyways so react router native doesn’t make sense.