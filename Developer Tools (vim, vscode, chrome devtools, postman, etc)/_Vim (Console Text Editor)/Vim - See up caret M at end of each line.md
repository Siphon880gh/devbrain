
The ^M characters you see at the end of each line in the vi editor indicate that the file contains Windows-style line endings (CRLF, or Carriage Return and Line Feed) instead of the Unix/Linux-style line endings (LF only).

It’s harmless but if it’s annoying you, run vi command:
```
:%s/\r//g
```

This command will search for all carriage returns (\r) and replace them with nothing (removing them).