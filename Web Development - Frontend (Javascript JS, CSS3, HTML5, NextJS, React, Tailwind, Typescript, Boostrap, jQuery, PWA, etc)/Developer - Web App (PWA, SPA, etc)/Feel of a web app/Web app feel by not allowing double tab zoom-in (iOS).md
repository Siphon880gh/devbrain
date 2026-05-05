We can prevent double-tap zoom on iOS by adding a meta tag and some touch-action CSS. Here's how:  

```javascript:index.php

// Add this meta tag in the head section

<head>

    // ... existing head content ...

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

  

<style>

    /* Add these CSS rules */

    * {

        touch-action: manipulation;

        -webkit-touch-callout: none;

        -webkit-user-select: none;

        user-select: none;

    }

  

    /* Keep text selection enabled for textarea */

    #textarea {

        -webkit-user-select: text;

        user-select: text;

    }

  

    /* ... rest of existing styles ... */

</style>

```

  

  

This combination will:

1. The meta tag prevents zooming on iOS

2. `touch-action: manipulation` prevents double-tap zoom while keeping scrolling and single-tap behaviors

3. The user-select properties prevent text selection which can interfere with touch interactions

4. We specifically re-enable text selection for the textarea

  

These changes should prevent the zoom behavior while maintaining normal touch functionality.