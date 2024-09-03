

### Default Components
import { Text, StyleSheet, Pressable } from 'react-native';

The page and the left sidebar has the components
https://reactnative.dev/docs/components-and-apis

**Challenge: Pick more components to implement**
[https://reactnative.dev/docs/components-and-apis](https://reactnative.dev/docs/components-and-apis)

---

### UI Libraries can replace default components

Note there are other UI libraries that have a better substitute for those components, and then it's a matter of importing from them instead of from 'react-native' at the top of the file.

For example, nativebase (now they rebranded as gluestack-ui) replaces various default components of react-native as well as replace default components of react-navigation: 
https://docs.nativebase.io/text#page-title -
```
import { Text } from 'native-base'
import { DrawerNavigator } from "react-navigation";
```
https://gluestack.io/ui/docs/components/text -
```
import { Text } from "@/components/ui/text"
```



Another example, react-native-elements can replace various default components of react-native: https://reactnativeelements.com/docs/components/text
```
import { Text } from '@rneui/themed';
```