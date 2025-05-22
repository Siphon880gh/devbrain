
For tailwind you have a few choices. Many tailwind libraries will have you call functions inside the style attribute, but Nativewind will allow you to use classNames as if this were a regular React app or plain HTML webpage. Nativewind has been conflicting in Aug 2028 and needed some workarounds

- Fixing it not allowing more than one class. You need to add the setOutput block (`/* Fixes web */`), otherwise on the web export or preview, you will not see tailwind styles applied unless you use one class to apply it.
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

- In addition, you may need to lock tailwind to 3.3.2. Your package.json: `"tailwindcss": "3.3.2"