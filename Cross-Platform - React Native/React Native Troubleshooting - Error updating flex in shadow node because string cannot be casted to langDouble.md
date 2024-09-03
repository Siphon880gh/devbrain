Error while updating property “flex” in shadow node of type: **RCTView**
java.lang.String cannot be casted to java.langDouble

![](https://i.imgur.com/tBr6JmF.png)

You probably have a 

    <View  
      style={{  
        flex: "1",  

As the root component. Change that to `flex: 1`