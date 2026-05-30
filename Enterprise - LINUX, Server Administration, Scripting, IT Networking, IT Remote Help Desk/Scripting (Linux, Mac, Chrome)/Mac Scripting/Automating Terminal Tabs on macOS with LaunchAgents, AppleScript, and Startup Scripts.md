A common macOS automation workflow is automatically opening Terminal on login, running one command, then opening additional tabs that launch other services a few seconds later.

This is especially useful for:

- Local development environments
- AI agent systems
- Background workers
- Docker stacks
- Queue processors
- Reverse proxies
- Monitoring scripts
- Long-running development servers

For example:

- Tab 1 → frontend server
- Tab 2 → API backend
- Tab 3 → worker process
- Tab 4 → LiteLLM or Ollama
- Tab 5 → OpenClaw gateway or TUI

macOS can do this reliably using:

- LaunchAgents
- Shell scripts
- AppleScript
- Terminal automation

---

## **Understanding the Components**

### **LaunchAgent**

A LaunchAgent is a macOS background automation process managed by `launchd`.

LaunchAgents:

- Run automatically at login
- Run with your user permissions
- Can interact with GUI apps like Terminal
- Are configured with `.plist` XML files

Typical location:

~/Library/LaunchAgents/

---

## **The Core Problem**

Terminal itself can easily open:

- a new window
- run a command

But opening:

- a new tab
- in the same Terminal window
- after a delay
- while automatically running another command

usually requires AppleScript.

  

A simple way to test macOS Terminal automation is to create a startup script that opens Terminal, runs a command in the first tab, waits a couple of seconds, opens a new tab, runs another command, and repeats.

Before wiring this into a real development workflow, it is smart to test with harmless commands like:

echo "Tab 1"
echo "Tab 2"
echo "Tab 3"

That way, you can confirm the tab-opening behavior works before replacing the test commands with real services like `npm run dev`, `python app.py`, `docker compose up`, or queue workers.

---

## Example Goal

The test automation should do this:

Open Terminal
Tab 1: echo "Tab 1"
Wait 2 seconds
Tab 2: echo "Tab 2"
Wait 2 seconds
Tab 3: echo "Tab 3"

This confirms that:

Terminal opens correctly
AppleScript can control Terminal
New tabs are being created
Commands are running in the correct tabs
Delays are working
macOS permissions are configured

---

## Create the Test Startup Script

Create folder:
```
cd ~
mkdir .startup-scripts
cd .startup-scripts
```


Create file:
```
vi ~/.startup-scripts/test-terminal-tabs.sh
```


Paste this:
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

## Give macOS time to finish loading the GUI after login
sleep 10

/usr/bin/osascript <<'APPLESCRIPT'

tell application "Terminal"
    activate

    do script "echo 'Tab 1'"

    delay 2

    tell application "System Events"
        keystroke "t" using command down
    end tell

    delay 0.5

    do script "echo 'Tab 2'" in selected tab of front window

    delay 2

    tell application "System Events"
        keystroke "t" using command down
    end tell

    delay 0.5

    do script "echo 'Tab 3'" in selected tab of front window

end tell

APPLESCRIPT

echo "osascript exit code: $?"
echo "Finished at: $(date)"
```

Save and exit.

Make the script executable:
```
chmod +x ~/.startup-scripts/test-terminal-tabs.sh
```


Run it manually first:
```
~/.startup-scripts/test-terminal-tabs.sh
```

^ While running manually, it may ask accessibility and permission questions. Make sure to accept them. Once you give permission, it won't bug you again on the next rerun.

Expected result:
1. Terminal opens
2. First tab prints: Tab 1
3. Second tab opens and prints: Tab 2
4. Third tab opens and prints: Tab 3

---

## Why AppleScript Uses a Keyboard Shortcut

This part:
```
tell application "System Events"
    keystroke "t" using command down
end tell
```

means AppleScript is simulating:

Cmd + T

That is the normal keyboard shortcut for opening a new tab in the same terminal window.

Terminal can run commands with AppleScript, but opening a new tab in the same window is easiest by using `System Events` to press the keyboard shortcut.


---

## Why the Delays Are Included

These delays matter:
- delay 2
- delay 0.5

The `delay 2` gives time between launching each tab.

The `delay 0.5` gives Terminal a moment to finish creating the new tab before the script runs the next command inside it.

Without these delays, commands may run in the wrong tab or Terminal may not be ready yet.

**Reworded:**

Without delays:
- tabs may open too fast
- Terminal may not finish initializing
- commands can execute in the wrong tab
- race conditions occur

Typical delays:
- `delay 0.5` → wait for tab creation
- `delay 2` → allow service startup

These values can vary depending on:
- Mac performance
- Terminal startup time
- number of applications launching at login

---

## Add It to macOS Login with a LaunchAgent

To run this automatically when logging into macOS, create a LaunchAgent.

Create the plist file:
```
vi ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

Paste this, replacing `YOUR_USERNAME` with the actual macOS username:
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
        <string>/Users/wengffung/.startup-scripts/test-terminal-tabs.sh</string>
    </array>

    <key>RunAtLoad</key>
    <true/>

</dict>
</plist>
```

Load it:
```
launchctl load ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

Btw - You can Unload it later:
```
launchctl unload ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```


Btw - If you try to load it again when it hasn’t been unloaded, you get this error:
```
Load failed: 5: Input/output error

Try running `launchctl bootstrap` as root for richer errors.
```


**Next**, adjust the permissions of the playlist file:
```
chmod 644 ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

**Next**, validate this playlist with:
```
plutil -lint ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```


---

## Add some permissions (Set 1 of 2)

Because this script uses `System Events` to press `Cmd + T`, macOS may ask for Accessibility permission.

Go to:

System Settings
→ Privacy & Security
→ Accessibility

Common items that may need permission:
```
Terminal
Script Editor
osascript
```

^ Terminal and Script Editor are in `Applications/Utilities/` . You might not see "osascript", then you can skip that for now.

Usually this approval is only **needed once**. After that, future logins should run the automation without prompting again.

This is only one group of permissions. The other group of permissions are easier to just accept as you're running the startup script

---

## Test by running startup script

Restart the computer and see if they open.

You can see logs at
```
vi $HOME/Library/Logs/test-terminal-tabs.log
```


### Permission Set 2

You're making sure to set permissions for shell to run in background (even if we're running foreground here), bash accessing terminal, bash accessing system events, bash control computer using accessibility features

Despite the notification at the top right:
![[Pasted image 20260526192455.png]]

A terminal should actually open is the foreground. Regardless, go ahead and click the notification so you can enable it as background (in case your app will be background process later on)
![[Pasted image 20260526192511.png]]
^ `test-terminal-tabs.sh`  is under General → Login Items & Extensions → Section “App Background Activity”

You may be asked to set permissions - make sure to accept:
![[Pasted image 20260526192527.png]]

![[Pasted image 20260526192532.png]]

![[Pasted image 20260526192540.png]]

![[Pasted image 20260526192546.png]]

Note after accepting these permissions as they're rolling in, the terminal might not open. Restart the computer again to see the terminal appear.

### Do I need to accept permissions each time the system starts up?

Usually this approval is only **needed once**. After that, future logins should run the automation without prompting again.

macOS may ask again if:
- The script is moved or renamed
- The command is launched by a different app
- macOS resets privacy permissions
- Terminal is replaced with iTerm2
- A macOS update changes security approvals

In most stable setups:
- one-time approval is enough



---
## Where to go from here - Example Use Case - Replacing the Test Echo Commands

Once the echo test works, replace this:
```
do script "echo 'Tab 1'"
```

with a real command:
```
do script "cd ~/my-project && npm run dev"
```

Example real workflow:
```
do script "cd ~/frontend && npm run dev"
```

```
do script "cd ~/backend && python app.py" in selected tab of front window
```

```
do script "cd ~/worker && php artisan queue:work" in selected tab of front window
```

---
## **Common Real-World Developer Setup**

Example automated boot workflow:

Tab 1 → Next.js frontend
Tab 2 → Flask API
Tab 3 → queue worker
Tab 4 → Ollama
Tab 5 → LiteLLM proxy
Tab 6 → OpenClaw gateway
Tab 7 → monitoring/log tail

This creates an almost “workspace restore” environment immediately after login.

  

---

## **Troubleshooting**

### **Tabs open but commands run in wrong tab**

Increase delays:

delay 1

---

### **Script works manually but not at login**

Possible causes:

- GUI not ready yet
- Terminal launches before login finishes

Add startup delay in shell:

sleep 10

before running `osascript`.

---

### **Accessibility prompt keeps returning**

Try:

- removing and re-adding Terminal in Accessibility
- rebooting macOS
- avoiding moving the script path

---

### **LaunchAgent not loading**

Validate plist:

plutil ~/Library/LaunchAgents/com.user.terminalstartup.plist

---
## **Final Thoughts**

macOS automation becomes extremely powerful once LaunchAgents and AppleScript are combined.

With relatively little scripting, it is possible to build:
- fully automated development environments
- AI agent startup systems
- local infrastructure orchestration
- persistent monitoring workspaces
- multi-service bootstrapping workflows

The combination of:
- `launchd`
- shell scripting
- AppleScript
- Terminal automation

essentially turns macOS into a lightweight developer orchestration platform.

---

## Scaling Across Many Macs (MDM)

Manual TCC approvals (Accessibility, AppleEvents, Full Disk Access) do not scale. For fleet deployment:

- Deploy the LaunchAgent plist and script via Jamf policy — see [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- Pre-approve permissions with a PPPC profile — see [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]
- Extended walkthrough: [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]]

Prefer running services directly under `launchd` instead of Terminal tab automation when building a fleet baseline — fewer TCC dependencies.

---

## Related

- [[Loading and Unloading LaunchAgents with launchctl]]
- [[Why Shell Scripts With AppleScript Start With osascript Heredoc]]
- [[__ PRIMER - Apple Device Management and MDM]]
- [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]
