Detect textedit user input, etc: You have to add delegate with two steps (Storyboard dragging and coding)

Storyboard dragging: https://www.youtube.com/watch?v=jxTEzf1EY08
￼
![](https://i.imgur.com/hLRZdLA.png)

Coding: https://www.youtube.com/watch?v=jxTEzf1EY08

NOTE: Next step questionable if needed at all
textView.delegate = self;
// view controller aka self will be receiving messages that textview is sending/delegating such as overridden textViewDidChange(..)

Then try to override functions like:
```
    internal func textViewDidChange(_ textView: UITextView) {
        let countInt = userInput.text!.count
        let countStr = String(countInt);
        if(countInt<60) {
            charLimit.textColor = UIColor.black;
            charLimit.text = "(" + countStr + "/60)";
            lastTextEntered = userInput.text!;
        } else if(countInt==60) {
            charLimit.textColor = UIColor.red;
            charLimit.text = "(60/60)";
            lastTextEntered = userInput.text!;
        } else if(countInt>60) {
            charLimit.textColor = UIColor.red;
            charLimit.text = "(60/60)";
            userInput.text = lastTextEntered;
        }
    }
```

For background color, it's: 
```
            btnNext.isEnabled = true
            btnNext.setTitleColor(UIColor.lightGray, for:.normal)
            btnNext.backgroundColor = UIColor.white
```
