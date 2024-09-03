
Couldn't register the navigator. Have you wrapped your app with 'NavigationContainer'?

You are probably using some form of useNavigation.... .navigate("Named-Route"). You may need a `<NavigationContainer>` at the root of your app or wherever is appropriate.