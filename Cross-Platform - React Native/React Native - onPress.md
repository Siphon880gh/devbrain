
```
import React from 'react';  
import { TouchableOpacity, Text } from 'react-native';  
  
const MyButton = () => {  
  return (  
    <TouchableOpacity onPress={() => alert('Button pressed!')}>  
      <Text>Press Me</Text>  
    </TouchableOpacity>  
  );  
};  
  
export default MyButton;
```


You can set the onPress on the custom button:  

```
<MyButton onPress={ ()=>{alert('hi!'); }></MyButton>
```

  
Note: Test the above on web. iOS and Android does not support `alert`. They use `Alert.aert`
