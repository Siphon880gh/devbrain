You'd want to install yq.

Pipe the yaml output to yq for a prettified output with tabs etc:

```
cat config.yaml | yq
```


**Came included?**
Most systems don't come with yq. For example on Debian 12, you install with `sudo install yq`.