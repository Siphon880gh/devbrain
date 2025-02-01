Warning: Free version will NOT respect  permissions. Even though on free, you can assign restrictive permissions to groups and assign users to those groups, your logged in members can STILL modify a dashboard or query, so the permissions fail silently. Free does hide the admin settings like you would expect so logged in members can’t invite or assign permissions unless they’re assigned as admin. Free does allow you to invite, creating accounts.
## Invitation

Yes you can invite team members and assign roles
![](DkTFSIG.png)


You can “invite” entering their first name, last name, and email, and assigning their group:
![](YfMM0Eo.png)

Then a temporary password is setup and they’re emailed (if you’ve setup email ability in Metabase):
![](biUBJ4N.png)

  

You can inform them the url to login (email and password), and remind them that they can change their password (depending if root path or subpath reverse proxied):
- Eg. [http://domain.tld:3500/](http://app.videolistings.ai:3500/)
- Eg. [http://domain.tld:3500/account/password](http://app.videolistings.ai:3500/account/password)
Or:
- Eg. [https://app.videolistings.ai/mb-admin](https://app.videolistings.ai/mb-admin)
- Eg. [https://app.videolistings.ai/mb-admin/account/password](https://app.videolistings.ai/mb-admin/account/password)


---

## Groups and Permissions


You can create custom groups:

![](4vL3KiW.png)

You can adjust permissions to databases per group:
![](k9SPRnW.png)

![](F53Wfup.png)


Please remember that on free version, these permissions can be set, but they won't take effect. This only works on Pro and Enterprise versions.


---
