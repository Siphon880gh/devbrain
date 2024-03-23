- Created new app
		https://appstoreconnect.apple.com/apps
		=> My Apps
		=> + New App (Not App Bundle because that's a combo of apps for a discount thing, and not bundle ID related)


- And the SKU?*

	Adapted Solution: "Every time I have to enter the SKU I use the App identifier (e.g. com.mycompany.myappname) because this is already unique." -> com.mycompany.myappname.ios
	
	*SKU:  (A unique ID for your app that is not visible on the App Store.)
	(SKU stands for Stock-keeping Unit. It's more for inventory tracking purpose.
	The purpose of having an SKU is so that you can tie the app sales to whatever internal SKU number that your accounting is using.)
	
	Changing the app icon in appstoreconnect? It'll update with the archived app's icon from XCode
	Proof: https://developer.apple.com/forums/thread/129485

- Keep in mind about changing the Bundle ID after the fact
	- Changing the bundle ID in your app effectively creates a new app from the perspective of App Store Connect and the App Store. Here's a brief overview of the implications and steps you should take:
	- **Losing Access to Testers**: Changing the bundle ID means that your existing TestFlight testers and any app data tied to the previous bundle ID won't carry over to the new app. You'll need to invite testers to the new app record in TestFlight.
	- **Starting Fresh on the App Store**: Since the new bundle ID is treated as a new app, it will have its own presence on the App Store. This means starting from scratch with reviews, ratings, and download statistics.
	- **Updating Your App's Code and Configurations**: Ensure that any internal references to the bundle ID in your code or configuration files are updated to reflect the new ID. This includes updating any services or APIs that rely on the bundle ID. Refer to [[Updating app's code and configuration to reflect a new Bundle ID]]
	- **Resubmitting to App Store Connect**: With the new bundle ID, you'll go through the process of submitting your app as if it were a new submission. This includes filling out app information, uploading screenshots, and setting up metadata.