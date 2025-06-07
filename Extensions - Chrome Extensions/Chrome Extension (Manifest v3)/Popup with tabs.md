
Popup Tabbars?
There's no tab bar component or anything from Chrome extension. It's all CSS and HTML.

![[Pasted image 20250318220914.png]]

---

Here's one implementation:
![[Pasted image 20250321195228.png]]

popup.html:
```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup</title>
    <link rel="stylesheet" href="popup.css">
</head>

<body>

    <div class="tab-bar">
        <div class="tab active" data-tab="menu1">Basic</div>
        <div class="tab" data-tab="menu2">Advanced</div>
    </div>

    <div class="menu-container">
        <div class="menu active" id="menu1">
            <div class="menu-item">Option 1</div>
            <div class="menu-item">Option 2</div>
            <div class="menu-separator"></div>
            <div class="menu-item">Settings</div>
            <div class="menu-item">About</div>
        </div>

        <div class="menu" id="menu2">
            <div class="menu-item">Advanced Option A</div>
            <div class="menu-item">Advanced Option B</div>
            <div class="menu-separator"></div>
            <div class="menu-item">Developer Tools</div>
        </div>
    </div>

    <script src="popup.js"></script>
</body>

</html>
```

popup.css:
```
/* -----------------------------------------
   Base Styles
------------------------------------------ */

body {
    font-family: 'Roboto', Arial, sans-serif;
    font-size: 13px;
    color: #3c4043;
    background: #fff;
    margin: 0;
    padding: 8px;
    min-width: 200px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }
  
  /* -----------------------------------------
     Tab Navigation
  ------------------------------------------ */
  
  .tab-bar {
    display: flex;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }
  
  .tab {
    flex: 1;
    text-align: center;
    padding: 6px 0;
    cursor: pointer;
    font-weight: 500;
    border-radius: 4px 4px 0 0;
    color: #5f6368;
  }
  
  .tab.active {
    background: #e8eaed;
    color: #202124;
  }
  
  /* -----------------------------------------
     Menu Containers
  ------------------------------------------ */
  
  .menu-container {
    display: flex;
    flex-direction: column;
  }
  
  .menu {
    display: none;
  }
  
  .menu.active {
    display: block;
  }
  
  /* -----------------------------------------
     Menu Items
  ------------------------------------------ */
  
  .menu-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .menu-item:hover {
    background: rgba(0, 0, 0, 0.1);
  }
  
  .menu-separator {
    height: 1px;
    margin: 6px 0;
    background: rgba(0, 0, 0, 0.1);
  }
  
  /* -----------------------------------------
     Dark Mode Overrides
  ------------------------------------------ */
  
  @media (prefers-color-scheme: dark) {
    body {
      background: #202124;
      color: #e8eaed;
    }
  
    .menu-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }
  
    .tab-bar {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
  
    .tab {
      color: #9aa0a6;
    }
  
    .tab.active {
      background: #3c4043;
      color: #e8eaed;
    }
  }
  
```

popup.js (for tab interaction):
```
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tab');
  const menus = document.querySelectorAll('.menu');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Remove "active" from all tabs and menus
      tabs.forEach(t => t.classList.remove('active'));
      menus.forEach(m => m.classList.remove('active'));

      // Activate clicked tab
      tab.classList.add('active');

      // Show the corresponding menu
      const targetId = tab.dataset.tab;
      const targetMenu = document.getElementById(targetId);
      if (targetMenu) {
        targetMenu.classList.add('active');
      }
    });
  });
});
```