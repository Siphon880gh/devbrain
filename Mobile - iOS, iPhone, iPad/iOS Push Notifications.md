

### Terms:
- APN: Apple Push Notification service
- aps-environment: APS stands for Apple Push Service

### Requirement:

**Enable Automatic Management**: In Xcode, under your target's "Signing & Capabilities" tab, you can enable "Automatically manage signing". With this enabled, Xcode automatically manages your certificates and provisioning profiles.

-  If you dont Enable Automatic Management, then you would have to download the APN certificate .cert file from Apple Developer Portal, double click it to install in keychain access; and also at Apple Developer Portal, you'd have to set the provisioning profile to include push notification entitlement then download the profile, then double click the profile to import into XCode; and at the project in XCode, you'd need to manually select the appropriate signing certificate and provisioning profile under Signing & Capabilities for each relevant configuration - debug, release, etc? Not to mention, you have to manage this every time a certificate or profile expires or a new device needs to be added


## General Instructions

Certainly! Here's a comprehensive and integrated guide that includes all the necessary steps for registering your app with APNs and preparing it for submission to the App Store:

1. **Enable Push Notifications in Your App ID**:
   - Log in to the [Apple Developer Portal](https://developer.apple.com/).
   - Navigate to "Certificates, Identifiers & Profiles" and select "Identifiers".
   - Find your app's App ID and click on it.
   - Check the "Push Notifications" box under the App Services section to enable it.
   - Save the changes.

2. **Update Your Xcode Project**:
   - Open your project in Xcode.
   - Select your app target and go to the "Signing & Capabilities" tab.
   - Click the "+ Capability" button and add the "Push Notifications" capability. This should automatically add the 'aps-environment' entitlement to your app.
	   - Note: The `aps-environment` entitlement can have two values—`development` or `production`. When you're developing and testing your app, you use the `development` value. This connects your app to the APNs sandbox environment. When your app is ready for release and distributed via the App Store, it should use the `production` value, connecting to the APNs production environment. The value (`development` or `production`) is determined by the type of provisioning profile used—development profiles set this to `development`, and App Store distribution profiles set it to `production`.

3. **Implement APNs Registration Code in Your App**:
   - In your app's code, import `UserNotifications` and request authorization for notifications. Then, register for remote notifications:
     ```swift
     import UserNotifications

     UNUserNotificationCenter.current().requestAuthorization(options: [.alert, .sound, .badge]) { granted, error in
         print("Permission granted: \(granted)")
         guard granted else { return }
         getNotificationSettings()
     }

     func getNotificationSettings() {
         UNUserNotificationCenter.current().getNotificationSettings { settings in
             print("Notification settings: \(settings)")
             guard settings.authorizationStatus == .authorized else { return }
             DispatchQueue.main.async {
                 UIApplication.shared.registerForRemoteNotifications()
             }
         }
     }
     ```
   - Implement the `didRegisterForRemoteNotificationsWithDeviceToken` method to handle the successful registration and retrieve the device token.

4. **Regenerate Provisioning Profiles**:
   - If you've made changes to your App ID, you'll need to regenerate your provisioning profiles.
   - Go back to the Apple Developer Portal, navigate to "Certificates, Identifiers & Profiles", and under "Provisioning Profiles", regenerate your profiles.
   - Download and install the new provisioning profiles in Xcode.

5. **Build and Archive**:
   - Build your project again in Xcode, ensuring you're using the updated provisioning profile.
   - Archive your app for distribution.

6. **Resubmit to App Store Connect**:
   - Upload the new binary to App Store Connect either via Xcode or using the Application Loader tool.
   - Wait for the review process to complete.

By following these detailed steps, you'll ensure that your app is properly configured for push notifications and ready for submission to the App Store.


More details
https://developer.apple.com/documentation/usernotifications/registering-your-app-with-apns


---


You can manage push notifications at the push notifications dashboard:

https://icloud.developer.apple.com/dashboard/notifications

![](ifmSQmQ.png)
