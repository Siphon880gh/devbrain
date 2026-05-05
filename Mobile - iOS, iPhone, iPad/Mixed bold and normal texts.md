

```
        let attributsNormal = [NSAttributedString.Key.font : UIFont.systemFont(ofSize: 17, weight: .regular)]
        let attributsBold = [NSAttributedString.Key.font : UIFont.systemFont(ofSize: 17, weight: .bold)]
        // -
        var attributedString = NSMutableAttributedString(string: "The ", attributes:attributsNormal)
        let boldStringPart = NSMutableAttributedString(string: "MixoType Engine ", attributes:attributsBold)
        var attributedString2 = NSMutableAttributedString(string: "is a self-guided tool designed to help you visualize and better understand who you are at your core.", attributes:attributsNormal)
        attributedString.append(boldStringPart)
        attributedString.append(attributedString2)
        tvInstructions.attributedText = attributedString
```

From:
https://stackoverflow.com/questions/28496093/making-text-bold-using-attributed-string-in-swift
