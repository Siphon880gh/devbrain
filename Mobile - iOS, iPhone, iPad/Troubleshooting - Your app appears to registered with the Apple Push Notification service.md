
Error:
"Your app appears to register with the Apple Push Notification service, but the app signature's entitlements do not include the 'aps-environment' entitlement. If your app uses the Apple Push Notification service, make sure your App ID is enabled for Push Notification in the Provisioning Portal, and resubmit after signing your app with a Distribution provisioning profile that includes the 'aps-environment' entitlement. Xcode does not automatically copy the aps-environment entitlement from provisioning profiles at build time."

---

If you don't intend to have push notifications:

1. **Understanding the Message**: The warning indicates that your app is registering with APNs, but the 'aps-environment' entitlement is not present in your app's signature. This entitlement is necessary for apps that intend to use push notifications.
    
2. **Check Your Code**: Even though you're not using push notifications, make sure there's no code inadvertently registering your app with APNs. Look for any code that might be related to `UNUserNotificationCenter` or calls to `registerForRemoteNotifications`.
    
3. **App ID Configuration**: Log into your [Apple Developer Account](https://developer.apple.com/account/) and check your app's App ID configuration. Ensure that Push Notifications are turned off if you're not using them.
    
4. **Provisioning Profile**: If you had previously enabled push notifications or if your app's provisioning profile was set up with push notifications in mind, you might need to regenerate your provisioning profile. Make sure to create a provisioning profile without the push notifications service enabled.
    
5. **Xcode Project Settings**: Review your Xcode project settings to ensure they align with your intentions of not using push notifications. Xcode should not be set up to include the `aps-environment` entitlement if you're not using this service.
    
6. **Clean Build and Archive**: After making the necessary changes, perform a clean build in Xcode (Product > Clean Build Folder) and archive the app again (Product > Archive).
    
7. **Resubmit**: Once you've ensured that your app is not registering with APNs and the provisioning profiles are correctly set up, resubmit your app for review.

---

If you intend to have push notifications, refer to [[iOS Push Notifications]]