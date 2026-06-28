On a Mac Studio, a risk with OpenClaw could be a power outage. The system restarts but OpenClaw and all the other tech that are part of the OpenClaw stack needs to run too (eg. Ollama, LiteLLM, etc). 

You probably dont want all to run in the background or all in one shell (even with a tool like `concurrently` , that makes management hard). Instead you want to automate actually opening the terminal, opening multiple tabs, and at each tab you run the command for separate parts of the stack (Ollama, LiteLLM, etc) - as if you were to start the system manually. This way you see any problems right away and can manage it in the appropriate terminal tab.

This tutorial will give alternative approach at the end using iTerm2, but our primary approach would be with OAScript/AppleScript. For our primary approach, you will just drop in the scripts below.

## Requirement:
- Below is a bash script that loads from a LaunchAgent playlist. You would have to take care of permissions. 
- The full guide to setting up this architecture and the permissions is at [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]. 
- After successfully setting up a sample terminal tab opening on startup experience, then you **drop in these scripts below**.

## **Drop-In: Startup Script**

Example startup script:
```
#!/bin/bash

LOG="$HOME/Library/Logs/test-terminal-tabs.log"

exec >> "$LOG" 2>&1

echo ""
echo "=============================="
echo "Started at: $(date)"
echo "User: $(whoami)"
echo "HOME: $HOME"
echo "PATH: $PATH"
echo "=============================="

# Give macOS time to finish loading the GUI after login
sleep 10

/usr/bin/osascript <<'APPLESCRIPT'

on runInFrontTab(theCommand)
    tell application "Terminal"
        activate
        if (count of windows) > 0 then
            set miniaturized of front window to false
            set index of front window to 1
            do script theCommand in selected tab of front window
        else
            do script theCommand
        end if
    end tell
end runInFrontTab

my runInFrontTab("ollama serve")

delay 2

tell application "System Events"
    tell process "Terminal"
        set frontmost to true
        keystroke "t" using command down
    end tell
end tell

delay 0.5

tell application "Terminal"
    do script "litellm --config ~/litellm/config.yaml" in selected tab of front window
end tell

delay 2

tell application "System Events"
    tell process "Terminal"
        set frontmost to true
        keystroke "t" using command down
    end tell
end tell

delay 0.5

tell application "Terminal"
    do script "tailscale serve 4000" in selected tab of front window
end tell

delay 2

tell application "System Events"
    tell process "Terminal"
        set frontmost to true
        keystroke "t" using command down
    end tell
end tell

delay 0.5

tell application "Terminal"
    do script "openclaw gateway restart" in selected tab of front window
end tell

delay 2

tell application "System Events"
    tell process "Terminal"
        set frontmost to true
        keystroke "t" using command down
    end tell
end tell

delay 0.5

tell application "Terminal"
    do script "openclaw tui" in selected tab of front window
end tell

APPLESCRIPT

echo "osascript exit code: $?"
echo "Finished at: $(date)"
```

## **Drop in: LaunchAgent Configuration**

Example LaunchAgent:
```
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN"
"http://www.apple.com/DTDs/PropertyList-1.0.dtd">

<plist version="1.0">
<dict>

    <key>Label</key>
    <string>com.user.test-terminal-tabs</string>

    <key>ProgramArguments</key>
    <array>
        <string>/Users/YOUR_USERNAME/.startup-scripts/test-terminal-tabs.sh</string>
    </array>

    <key>RunAtLoad</key>
    <true/>

</dict>
</plist>
```

Save as:
```
~/Library/LaunchAgents/com.user.terminalstartup.plist
```

Load manually:
```
launchctl load ~/Library/LaunchAgents/com.user.terminalstartup.plist
```


Btw, to Unload it:
```
launchctl unload ~/Library/LaunchAgents/com.user.terminalstartup.plist
```


---

## **Alternative Approaches**

### **iTerm2**

iTerm2 has significantly better scripting support than Terminal.

It supports:

- native tab creation
- split panes
- session restoration
- startup profiles
- triggers
- Python scripting
- saved workspaces

For heavy automation setups, many developers prefer it over Terminal.

Official site:
https://iterm2.com/