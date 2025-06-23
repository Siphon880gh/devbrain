You may want to read all the documentations on the different Github Actions, in order to properly create your Github Action/Workflows.

The convention is to use a version number on an action, if exists:
eg. Partial workflow snippet:
```
jobs:
  test:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v3

    - name: Set up Node.js
      uses: actions/setup-node@v4
```

You'll find there's a version number after many versions. The reasoning why: [[Why Github Actions Are Versioned]]

---

Official Actions Documentation:
https://docs.github.com/en/actions

Actions for NodeJS:
https://docs.github.com/en/actions/use-cases-and-examples/building-and-testing/building-and-testing-nodejs

Specific Actions:
- Eg. Checkout action: https://github.com/actions/checkout - The documentation is in the Github Repo Readme
- **Change the URL at the final subpath depending on which action you want to read documentation for (At the Github Repo Readme)**