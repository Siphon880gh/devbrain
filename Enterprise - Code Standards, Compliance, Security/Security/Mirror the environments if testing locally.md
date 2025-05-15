If you're testing security of your app or server setup locally before pushing them online, you MUST make sure that the environments absolutely match.

Besides OS, there's also the interpreter version. Let's say we're using PHP. Then you run `php --version` on both local and remote to see if the major versions are different. Example php versions that are okay:
- local: 8.3.10
- remote: 8.3.12

It's recommended that you test where the application will be live. Sometimes this is not always feasible, so you may compromise by building out test scripts for security locally, then you can trigger those test scripts when pushed online.