You can have enhanced error and tracing, especially for git errors that are described too vague or if git just hangs without telling you the exact error

For example, when commiting, try this:
```
GIT_TRACE=1 git commit -m "testing"
```
And if that fails, try GIT_TRACE2=1
```
GIT_TRACE2=1 git commit -m "testing"
```
