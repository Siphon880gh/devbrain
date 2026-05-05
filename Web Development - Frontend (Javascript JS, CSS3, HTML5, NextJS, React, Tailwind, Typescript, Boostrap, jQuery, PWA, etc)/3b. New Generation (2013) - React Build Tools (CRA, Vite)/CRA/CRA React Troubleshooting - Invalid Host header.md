
![](9Juct6R.png)

**SOLUTION 1**

For your `.env`  or `.env.development` :
```
HOST=mypublicdevhost.com
```

**SOLUTION 2**

Rather than editing the webpack config file, the easier way to disable the host check is by adding a `.env` file to your CRA React app folder where the package.json is and putting this:
```
DANGEROUSLY_DISABLE_HOST_CHECK=true
```

As the variable name implies, disabling it is insecure and is only _advisable_ to use only in dev environment.

From:
[https://stackoverflow.com/questions/43619644/i-am-getting-an-invalid-host-header-message-when-connecting-to-webpack-dev-ser](https://stackoverflow.com/questions/43619644/i-am-getting-an-invalid-host-header-message-when-connecting-to-webpack-dev-ser)