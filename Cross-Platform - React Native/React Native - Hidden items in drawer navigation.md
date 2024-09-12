
Review: Drawer Navigation is the slide in menu from a hamburger mobile icon

The proper way to hide a menu item in the drawer navigation is:
```
<Drawer.Screen name="Screen Not Found" component={ZNotFoundScreen} 
	options={{
		drawerItemStyle: { display: 'none' }, // Hides it from the drawer
}}/>
```