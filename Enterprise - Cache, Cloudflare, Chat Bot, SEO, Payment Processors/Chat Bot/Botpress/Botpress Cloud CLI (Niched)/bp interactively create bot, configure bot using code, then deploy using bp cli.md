
Purpose: bp interactively create bot, configure bot using code, then deploy using bp cli


---


You can interactively create a bot and configure its coding. Refer to:
https://botpress.com/docs/for-developers/sdk/bot/getting-started


Once you’ve made the necessary changes to your bot, you can **deploy it to Botpress Cloud**. Run the following command:
```bash
bp deploy --create-new-bot
```

You’ll be prompted for some information and confirmations. The `--create-new-bot` flag will create a new bot in your workspace. If you want to deploy to an existing bot, you can omit this flag. The CLI will prompt you for the bot in which you want to deploy.

After deploying, go to [the Dashboard](https://app.botpress.cloud/). You should see your bot listed there.