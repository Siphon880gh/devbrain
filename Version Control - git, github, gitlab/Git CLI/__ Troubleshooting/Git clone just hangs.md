Troubleshooting git clone just hangs:

Increase the verbosity/logs:
```
GIT_TRACE=1 GIT_CURL_VERBOSE=1 git clone --verbose https://github.com/ORG_OR_USER/REPO_NAME
```

Then read the output or paste the output to AI to ask why the git clone is hanging. The prompt can be:
```
Git clone freezes. This is the tracing report:
{paste terminal output}
```