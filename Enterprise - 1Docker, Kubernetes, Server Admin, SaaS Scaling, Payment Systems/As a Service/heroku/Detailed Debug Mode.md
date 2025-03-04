Your `heroku logs --tail` show logging at a basic level. To increase details of your bugs/logs:

\>>
To enable detailed errors for a Heroku application, you can set the `HEROKU_DEBUG` environment variable to `1`. This will instruct Heroku to display detailed error information in the response.

To set the environment variable, you can use the Heroku CLI or the Heroku Dashboard. Here's how to do it using the Heroku CLI:

1. Open a terminal or command prompt.
2. Log in to your Heroku account using the CLI by running the following command and following the prompts:

   ```
   heroku login
   ```

3. Navigate to your Heroku application's directory by using the `cd` command. For example:

   ```
   cd /path/to/your/app
   ```

4. Set the `HEROKU_DEBUG` environment variable by running the following command:

   ```
   heroku config:set HEROKU_DEBUG=1
   ```

5. Verify that the environment variable has been set correctly by running:

   ```
   heroku config:get HEROKU_DEBUG
   ```

   It should output `1` if the variable is set correctly.

After enabling detailed errors, when an error occurs in your Heroku application, the detailed error information should be displayed in the response to help with debugging. Keep in mind that this should only be enabled during development or debugging, as detailed error messages can potentially expose sensitive information to users.

-