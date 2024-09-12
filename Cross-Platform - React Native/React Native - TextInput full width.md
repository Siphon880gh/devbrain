
Try setting the styling of TextInput to flex: 1 instead of getting the width. The Flex style will automatically fill your view and leave the padding blank.
```
<View style = {{ padding: 15 }}> <TextInput style = {{ flex: 1 }} /> </View>
```