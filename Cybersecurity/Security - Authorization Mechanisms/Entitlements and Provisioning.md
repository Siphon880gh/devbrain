**What Are Entitlements (and How They Work per Device)**

Entitlements are like special permissions your app needs to use certain features—such as iCloud, push notifications, or Apple Pay. You list these in a file when building your app.

Some of these features require **per-device access**, meaning your app must be allowed to run on each specific device. That’s where **provisioning** comes in.

Provisioning is the process of telling Apple which devices can run your app and what permissions (entitlements) it needs. This is done through a **provisioning profile**, which links your app, your Apple developer account, and approved devices.

In short:

- **Entitlements** = What your app is allowed to do.
- **Some entitlements are per-device**, and won’t work unless the device is registered.
- **Provisioning** makes sure the app runs with the right permissions on the right devices.