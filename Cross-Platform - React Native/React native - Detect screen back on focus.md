
Import:
```
import { useFocusEffect } from '@react-navigation/native';
```

This is NOT inside an useEffect. But place before return:
```
  useFocusEffect(
    useCallback(() => {
      console.log('Screen is focused');
      return () => {
        // Code to run when the screen is unfocused
        console.log('Screen is unfocused');
      };
    })
  );
```