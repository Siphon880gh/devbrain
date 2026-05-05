If you hit version conflicts in a package.json, you can leverage Google to figure out the version that works.

If you already have a specific version of one package, you can use **Google search operators** to find examples of compatible setups. For instance:

```
inurl:package.json "next" AROUND(1) "14.0.3" "tailwind"
```

This tells Google to look for URLs containing `package.json` that include:

- an exact version of the main package (`"next" "14.0.3"`)
- the second package by name (`"tailwind"`)

Open the search result to view the package.json. Confirm that the version of the main repo matches what you search. Then find out what version is the secondary package. If this is a couple that involves other dependencies, find out the other dependencies' versions too on the same found package.json.

You don’t want to limit yourself to GitHub only — there are other platforms hosting repos too. The formula is: search for `package.json` files with the specific version of your main package plus the other package name. The idea is to see which version of the second package shows up as compatible.

If you’re not locked into a specific version of either package, first pick a stable release of the main package from its repo (avoid betas). It’s also safer to use a version that isn’t brand new, in case compatibility info with the other package hasn’t surfaced on Google yet.