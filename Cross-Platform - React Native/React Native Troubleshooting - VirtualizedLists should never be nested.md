
![](https://i.imgur.com/XFJT89q.png)


Just dont nest a FlatList inside a ScrollView OR

After React Native 0.71, if you have prop scrollEnabled={false} in the FlatList, the error should not show anymore, as changelog:

or you haev scrollView doing vertical and Flatlist doing horizontal and vice versa

Why: 
It became an error starting from RN 0.65. Anyway, you should be aware that when a FlatList is used inside a ScrollView, it fails to detect the screen size and thus cannot virtualize the items that should be 'off screen' rendering all of them immediately, which makes it even less performant than a regular map function, since it still has to create a view and add some logic. that's the reason the warning exists.

[https://stackoverflow.com/questions/58243680/react-native-another-virtualizedlist-backed-container](https://stackoverflow.com/questions/58243680/react-native-another-virtualizedlist-backed-container)