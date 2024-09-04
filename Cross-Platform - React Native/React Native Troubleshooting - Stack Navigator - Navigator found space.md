
Error:
```
A navigator can only contain 'Screen', 'Group' or 'React.Fragment' as its direct children (found ' '). This can happen if you passed 'undefined'. You likely forgot to export your component from the file it's defined in, or mixed up default import and named import when importing.
```

See that the components you're importing had been exported.

See that you didn't mix up default import and named import:
```
import { TabOneScreen } from './screens/TabOneScreen'
import { TabTwoScreen } from './screens/TabTwoScreen'
```
Vs
```
import TabOneScreen from './screens/TabOneScreen'
import TabTwoScreen from './screens/TabTwoScreen'
```