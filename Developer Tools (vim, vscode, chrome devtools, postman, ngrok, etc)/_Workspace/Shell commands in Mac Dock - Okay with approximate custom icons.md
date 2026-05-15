Sometimes you want an icon in the Mac's Dock that launches shell scripts. For example, you have a script to spin up n8n for local development. You don't want it running all the time in the background because of it affecting computer performance.

You are okay without it having an entirely custom icon. You do have a selection of icons and the ability to change it to a prefer color. If your use case is related to a brand like n8n which as a red foreground logo, you can approximately select an icon that looks similar to their logo.

Search using Mac's Spotlight (CMD+Space). And type "Shortcut":
![[Pasted image 20250617011755.png]]
Add new shortcut here:
![[Pasted image 20250617012148.png]]

Add a "Run Shell Script". Note if may ask you to enable scripting actions - and if it does ask you that, go ahead and press "Open Preferences" for an option to enable that:
![[Pasted image 20250617012224.png]]

Your script could be
- Adjust your script at `do script`:
```
osascript -e 'tell application "Terminal"
    activate
    do script "docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n"
end tell'
```

A more general example you can work with:
```
osascript -e 'tell application "Terminal"  
    activate  
    do script "echo Hello; ls -al ~; echo Done"  
end tell'
```

Back at the shortcuts home, right click your newly created item to change its icon:
![[Pasted image 20250617012659.png]]

You'll have some icon choices with color choices:
![[Pasted image 20250617012725.png]]

Once done, go ahead and add to your Dock:
![[Pasted image 20250617012820.png]]

Dock Result:
![[Pasted image 20250617012900.png]]

Note we named our item "Run Shell Script". You could name it something else. 

Clicking that icon for our example, opens the terminal:
![[Pasted image 20250617013001.png]]

Then I don't have to memorize the long terminal command each time.

---

## Library

n8n docker terminal run:
```
osascript -e 'tell application "Terminal"
    activate
    do script "docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n"
end tell'
```

ComfyUI python web app terminal run:
- Adjust the path to the locally cloned git repo
```
osascript -e 'tell application "Terminal"
    activate
    do script "cd /Users/wengffung/dev/web/comfyui && PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --verbose"
end tell'
```