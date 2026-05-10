`yq` is a lightweight, flexible command-line tool for working with YAML data. Think of it as `sed` or `awk` but for YAML — it lets you read, filter, update, and transform structured config files efficiently. It can also handle JSON, which makes it handy when moving between both formats.

**Installation for local development and testing before deploying:**
- **macOS**: `brew install yq`
- **Windows**: `choco install yq`

**Installation likely for production server:**
- **Ubuntu/Debian**: `sudo apt install yq`
- **RedHat/CentOS**: `sudo yum install yq`

This tool is especially useful for backend systems where settings are stored in YAML files. For example, if an app uses YAML-based config files, `yq` gives you a fast CLI way to inspect values, change keys, or patch configs during setup, deployment, and troubleshooting.