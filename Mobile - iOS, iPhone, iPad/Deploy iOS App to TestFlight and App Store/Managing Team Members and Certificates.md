## Managing Team Members

Inviting team members:
https://developer.apple.com/help/account/manage-your-team/invite-team-members

Deleting team members:
https://developer.apple.com/help/account/manage-your-team/delete-team-members
  
Yes, deleting a team member from your Apple Developer Program team can invalidate their ability to publish the app from their computer. When a team member is removed, they lose access to the certificates, provisioning profiles, and other resources associated with your team's Apple Developer account.


---
## Managing Certificates

### Apple Development Certificates

- **Purpose**: These certificates are used during the development phase of an app. They allow developers to install, run, and test the app on iOS devices.
- **Limitations**: Apps signed with a development certificate can only be installed on devices registered in the Apple Developer Program. They cannot be distributed on the App Store.
- **Environment**: These certificates are used in conjunction with development provisioning profiles, which also include information about the app and the devices on which it can be installed.

### Apple Distribution Certificates

- **Purpose**: Distribution certificates are used to distribute apps to users, either through the App Store or via Ad Hoc or enterprise distribution methods (as internal tools for employees).
- **Scope**: Unlike development certificates, distribution certificates **do not tie the app to specific devices.** They are used to sign the app before public release, ensuring that the app comes from a known source and has not been tampered with.
- **Environment**: Distribution certificates are used with distribution provisioning profiles, which do not include device-specific information. This allows the app to be installed on any device, subject to Apple's review and user acceptance.

### Apple Enterprise Certificate

- **Purpose**: The Enterprise Certificate is designed for large organizations to develop and distribute proprietary, in-house apps to their employees without going through the App Store.
- **Scope**: These certificates allow apps to be distributed internally within a company or organization. They're not meant for public distribution or for apps intended to be released on the App Store.
- **Distribution**: Apps can be distributed directly to employees via the organization's internal systems or a secure website, bypassing the App Store's review process.
- **Limitations**: Apps distributed with an Enterprise Certificate cannot be installed on devices outside the organization. There are also specific legal agreements that companies must adhere to, ensuring the apps are only used internally.
- **Account**: Requires a Apple Developer Enterprise Program account
  
  https://developer.apple.com/programs/enterprise/
  $299/yr


---

## Process of Certificates

Quoted from: https://help.apple.com/xcode/mac/current/#/dev3a05256b8

Xcode code signs your app during the build and archive process. If needed, Xcode requests a certificate and adds a signing certificate, the certificate with its public-private key pair, to your keychain. The certificate with the public key is added to your developer account.

Development certificates belong to individuals. In your developer account, the computer name is appended to the development certificate name (for example, Gita Kumar (Work Mac) where Work Mac is the computer name) so you can identify them.

Distribution certificates belong to the team but only the Account Holder or Admin role can create distribution certificates (if you’re enrolled as an individual, you are the Account Holder).

To share a signing certificate with another person on your team, export the signing certificate, and on the other person’s Mac, double-click the exported file to install the signing certificate in the keychain.

If you use different Mac computers for development or belong to multiple teams, you may want to manage signing certificates yourself. You maintain signing certificates using either Accounts preferences in Xcode or Keychain Access. You can create and revoke certificates using either Xcode or your developer account. If you enroll as an organization, your program role determines what tasks you can perform using these tools.

---

Manage your certificates here:
https://developer.apple.com/account