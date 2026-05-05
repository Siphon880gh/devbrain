Especially if you're using git, you likely added ".env" to your .gitignore file. So for migration purposes, you may want an .env_EXAMPLE file to be included in your app

Then when you run `make install`, you can have it copy `.env_EXAMPLE` as `.env` then echo to remind the DevOps developer to adjust the .env file to the new server.

For information on how to use Makefile: [[Makefile - PRIMER]]