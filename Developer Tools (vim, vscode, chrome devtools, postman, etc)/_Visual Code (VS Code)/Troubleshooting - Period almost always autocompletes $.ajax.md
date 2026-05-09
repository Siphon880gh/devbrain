## Troubleshooting - Period almost always autocompletse $.ajax

First, tell Visual Code to place User Snippets above Global User Snippets in the autosuggestion dropdown popup.

Then add a "." user snippets that only returns "." at Configure User Snippets for javascript:
```
    "Override ajax suggestion": {
        "prefix": ".",
        "body": [
            ".$0"
        ]
    }
```