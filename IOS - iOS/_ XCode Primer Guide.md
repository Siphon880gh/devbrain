Dev iOS Primer (XCode 13)
By Weng

Somethings you will learn:
- How to navigate and build an app
- Auto layout and constraints
- Connecting storyboard scenes to view controller class code
- Ui view outlet into variables at view controller class code

Table of Contents:
```toc
```

Self note - Used for copying and pasting symbols in the tutorial:
≥ ≤


---

## Interface Builder

Aka UI Builder

Xcode includes a tool called Interface Builder, which is sometimes referred to as the UI Builder. This tool allows developers to design their app's user interface visually. Within Interface Builder, you have the option to use either Storyboards or XIB files to lay out your user interfaces:

### Storyboards

- Allow you to design multiple screens (view controllers) within a single file, showing the flow and transition between these screens.
- Useful for visualizing the overall flow and navigation of your app.

### XIB Files

- Used to design individual screens or reusable UI components.
- Ideal for creating views that can be reused across different parts of your app or in multiple apps.


Both Storyboards and XIB files offer a drag-and-drop interface for arranging UI elements, setting up constraints for Auto Layout, and configuring properties of UI components. You can also establish connections between your UI elements and the corresponding Swift or Objective-C code, enabling interactive and dynamic behaviors.

---

## Setup new project

You can unselect/select UI and  Project unit tests at beginning

At the main storyboard,  you click + then add a  view  controller.  

Assign an ID, would be best the same name as the storyboard name on the left side panel Navigator (for example, ContactMe). With the ID, now you can open the scene/screen in your app.

Next you may want to add gesture recognizers / actions / logic into the screen. Then you'll want to create a swift file (File -> New File -> Swift). Name it after the storyboard ID but add the letters "VC" afterwards (For example, ContactMeVC). The class file needs a class named after the filename and extended from UIViewController.

Now add the same class name to the scene board where you previously had added the ID. It will let you add the class now.

The scene board that is the initial controller... there's a tickbox you need to tick: Is Initial View Controller

Now generally how you switch between scenes in the app is this:
```
        let profileScene1NVC = mainSB.instantiateViewController(withIdentifier: "ProfileScene1NVC") as! ProfileScene1NVC
        self.present(profileScene1NVC, animated:true, completion:nil)
```

And it's dependent on mainSB. Recommend saving this variable app globally and available at all view controllers as:... Keep in my the name is based on the storyboard name in the Project Side Navigator (left side panel):
```
	let mainSB : UIStoryboard = UIStoryboard(name: "Main", bundle:.main)
```

@ Fundamental:: Have one view same width as an outer width:
You can edit as so:
￼

![](https://i.imgur.com/32bXsVU.png)


## UI Storyboard setups
- LaunchScreen.storyboard is the splash screen when the app is still being loaded into iOS memory
- Main.storyboard is the rest of your screens

## Constraints

### Aspect Ratio Constraint
In iOS development using Xcode, the aspect ratio constraint is used to maintain a consistent ratio of width to height (or height to width) for a UI element, regardless of the overall screen size or other layout changes. This is particularly useful in responsive design, where you want certain elements to scale proportionally across different device sizes and orientations.

For example, if you have an image view and you want to ensure that it always maintains a 16:9 ratio (common for video content), you would set an aspect ratio constraint of 16:9 on the image view. This means that no matter how the layout changes, the image view will adjust its size to maintain this ratio, preventing it from becoming distorted.

Storyboard UI Builder  -> Aspect ratio constraint
CTRL drag an UI view to itself, then click "Aspect Ratio" on the popup menu


## Proportional Height/Width Constraints
Storyboard UI Builder  -> Proportional height/width constraint
Have a view inside another view on the UI builder. Have the inner UI view smaller than the parent for now. Then CTRL drag the child UI view onto the parent UI view's empty space. Click Equal Widths or Equal Heights.

Later at the Inspector Panel, you can adjust the constant and/or multiplier (gs) which allows you to set it proportionally other than 100% width or height.


### Scene Navigator directly editing the constraints

Edit the Constraints directly in the scene navigator but they're not in order? Just Filter at the bottom of navigator by the View name. Instead of typing the name though, you can press Enter on a control in the scene navigator, then CMD+C to start copying/pasting, then paste to Filter. To clear Filter easily, press Escape key.

Btw, from the scene navigator's constraints, you can add more programming elements to the constraints like math/percentages:
```
herotlc.width = 0.15 × width + 2.25
```


￼![](https://i.imgur.com/RtYeHcR.png)



Remember height and width don't show up as constraints in Scene navigator (poor design decision by Apple), and you're often working with one X position and width OR one Y position and height. Show width or height by opening inspector on the control selected in the scene navigator and opening the Size inspector to the right. 

WARNING: Sometimes editing the constraints directly in Scene navigator doesn't affect the actual constraints - then you'll have to go to Size inspector instead.

￼![](https://i.imgur.com/UtMgMYW.png)


When resolving conflicting constraints in the scene navigator, it may ask you to delete constraints. Before the modal that lets you choose which constraints to delete, you can click the constraints under Conflicting Constraints, and it'll highlight the control/element/view on the scene


---

## Safety Guides

UI builder has a Top Layout Guide and Bottom Layout Guide that you can click in the UI navigator, and it'll show a blue line where they recommend UI controls do not past (unless you absolutely need to - acting like a header or footer on the screen but keep in mind ios phones have rounded corner screens which would cut off your content).

---

## Layering
### Scene Navigator order of layers:
Everything going down on the scene navigator will be on top on the phone (because Top Layout Guide and Bottom Layout Guide are the two top items that you can place on top of visually).

![](https://i.imgur.com/kxwrwki.png)


### Layering controls on top of one another

Image is covering button and label so you need to drag image below the other two.

￼![](https://i.imgur.com/94zfDEq.png)

More info: https://stackoverflow.com/questions/31748602/how-to-make-my-image-behind-my-labels



---


@Fundamental

Class property vs method

@Fundamental
Character at an index in string
Does not work: input[3]

Correct solution (Swift likes to overcomplicate everything):
```
let input = "Swift Tutorials"
let char = input[input.index(input.startIndex, offsetBy: 3)]
```

https://www.simpleswiftguide.com/get-character-from-string-using-its-index-in-swift/

  
  
@ Fundamentals  
  
for loop generating views cannot use regular for loops. Must be:  
```  
ForEach((0...persons.count-1), id:\.self) {  
```  
  
forEach doesn't use index as iterator. It uses $0:  
```  
ForEach((0...responses!.count-1), id:\.self) {  
let _ = print("Iterator \($0)");  
Row.init($0)  
}  
```  
  
Otherwise you get this error:  
Closure containing control flow statement cannot be used with result builder 'ViewBuilder'

@ Convention

Helpers group/folder any class with variables you want to use globally. Can have class with static member variables and static member methods.

@ Fundamental

Lv 1- Basic:
```
for index in 1...5 {
    print("\(index) times 5 is \(index * 5)")
}
```

Lv 2- With array:

```
import Foundation

var arr = Array(["a", "b", "c"])

for i in 0...arr.count-1 {
    print(arr[i])
}
```

Lv2 - Alternate. Using default iterator index:
```
```
import Foundation

var arr = Array(["a", "b", "c"])

for i in 0...arr.count-1 {
    print(arr[index])
    print("We are at index: \(index)")
}
```
```

Lv 3- With array but no more than 2 elements:
```
for i in 0...min(arr.count-1,2-1) {
    print(arr[i])
}
```

And you can have "collections" of global variables like this:
```
struct Creational {
    static var myName: String?
}
```

To be accessed via `Creational.myName` and can check for nil with `if(Creational.myName==nill)

@ Essential - Dictionary that's global and mutable anywhere

```
var response: [String: Any] = [:]
```

@ Test Swift syntax at:
http://online.swiftplayground.run/

--

@ Fundamental func:


```
func aspectRatio(_ aspectRatio: CGFloat?, contentMode: ContentMode) -> some View {
    // ...
}
```

But note usually you can't indicate any return type at a top level (outside of classes.


@ Fundamental debugging:

print(variable or message)

you can still print to console inside anywhere with a view with:
let _ = print(geo2.frame(in: .local).width);

Yes many things in SwiftUI seems like a workaround or a hack:
https://stackoverflow.com/questions/56517813/how-to-print-to-xcode-console-in-swiftui


--


What version Swift?
You should know what version of swift your project is using before looking for answers at stackoverflow:
Project first item in Navigator -> Build Settings -> Swift Compiler - Language

As of 2022, latest Swift is Swift 5.

--

Some features when you build will warn you need a certain version. Change version at two places

Target 
￼
![](https://i.imgur.com/6Dqv6RY.png)


Project -
￼
![](https://i.imgur.com/YBN8T3g.png)

--

Debugging:
print("Shows up in console in XCode")

--

## Launch Screen

In Xcode, configuring the launch screen for your iOS app is crucial for providing a smooth and branded first impression when users open your app. You have correctly outlined two primary methods to set up or modify the launch screen in Xcode:

1. **Using the Info.plist for a Simple Static Launch Screen:**
   - Navigate to the top-level project in the Xcode Project Navigator.
   - Select your target and then go to the "Info" tab.
   - Here, you can specify basic settings for your launch screen using keys like `UILaunchStoryboardName` (to specify the launch screen storyboard) or `UILaunchImages` (to define static launch images).
   - This approach is straightforward but is generally more limited compared to using a storyboard, as it's more suited for static images and doesn't allow for much customization or dynamic content.

2. **Creating and Using a LaunchScreen.storyboard:**
   - Choose File > New > File (or press CMD+N) to create a new file.
   - Select "Launch Screen" from the user interface section. This will create a `LaunchScreen.storyboard` file.
   - You can now design your launch screen using the Interface Builder. This method allows for more flexibility compared to the Info.plist method. You can add various UI elements, arrange them as needed, and even apply constraints for different screen sizes.
   - After creating and customizing your `LaunchScreen.storyboard`, ensure that it is selected as the launch screen file in your app target's settings. You typically set this in the "General" tab of your target settings under "App Icons and Launch Images" by specifying the `LaunchScreen.storyboard` in the "Launch Screen File" field.

Using a storyboard for your launch screen is the recommended approach, especially for apps that require more than a simple static image. It offers the flexibility to create a more dynamic and adaptive launch experience that can accommodate different devices and screen sizes, enhancing the overall user experience.

---
## Set Images
### Set images wizardly

Drag image file to navigator; where the swift and storyboard files are listed. XCode will make a copy into your project folder.

Click Assets.xcassets. In imagesets navigator, click +


Drag an image file from the Files Navigator into 1x or 2x or 3x etc. (may require two windows)

Now you can select an image from the side panel in an UIImage

### Set images programmatically

Eg. where ivMixoState.image is an outlet/variable to an UIImage on storyboard:
```
ivMixoState.image = UIImage(named: "L _ MixoType Engine - Collections Section Intro Graphic")
```

## Set text

btn.setTitle("Temperament Definitions", for: .normal)
// ^ Other states are .normal, .highlighted, .disabled, .selected, .focused, .application, .reserved


lb.text = "hi"



---


## Coding Logic

### Optionals and Unwrapping
In Swift, optionals are a powerful feature that allow variables to hold either a value or `nil`, indicating the absence of a value. You're correct that a variable is made optional by appending a `?` to its type. When you want to access the value of an optional, you must safely unwrap it because the optional might contain `nil` rather than an actual value.

There are several ways to unwrap an optional in Swift:

1. **Force Unwrapping:** You can use the `!` operator to forcefully unwrap an optional. This approach should be used with caution because if the optional is `nil` when it's forcefully unwrapped, your program will crash. Example:
   ```swift
   var optionalNumber: Int? = 5
   let number = optionalNumber!
   ```

2. **Optional Binding:** You can use `if let` or `guard let` to safely unwrap an optional. This approach is preferred because it checks for `nil` and only executes the code block if there's a non-`nil` value. Example:
   ```swift
   var optionalNumber: Int? = 5
   if let number = optionalNumber {
       print("There is a number: \(number)")
   } else {
       print("The optional is nil.")
   }
   ```

3. **Nil Coalescing Operator (`??`):** This operator provides a default value for the optional if it is `nil`. It's a succinct way to handle `nil` values while unwrapping. Example:
   ```swift
   var optionalNumber: Int? = nil
   let number = optionalNumber ?? 0  // number is 0 if optionalNumber is nil
   ```

4. **Optional Chaining:** This is a way to query an optional within a chain of properties, methods, and subscripts where the entire chain fails gracefully if the optional is `nil`. Example:
   ```swift
   var optionalString: String? = "Hello"
   let count = optionalString?.count  // count is an optional Int
   ```

Using optionals and unwrapping them properly is crucial for writing safe and robust Swift code, helping to prevent runtime crashes due to `nil` values.

### Side effect: Comparison Not operator should not be confused with Unwrapping operator
When doing a comparison Not operator, you need the spacing:
```
user_pic !== "Incomplete"
```
Otherwise it may think you are unwrapping an optional, and it could error that it can't build (especially here where it's a hard coded string that doesn't need unwrapping).

---

## Coding - Foundation

TLDR:
- It's a library you need to import, unless you're using UIKit or AppKit which imports it internally
- Has functionalities of iOS you expect
- Originally in Objective C but now bridges to Swift too

To use Foundation in your Swift code in Xcode, you typically need to import it explicitly at the top of your Swift source files. The Foundation framework provides a base layer of functionality for iOS and macOS apps, including data handling, time calculation, regular expressions, and more.

Here's how you can import Foundation into your Swift file:

```swift
import Foundation
```

You just need to add this line at the top of your Swift file. After importing Foundation, you can use its classes and functions throughout your file.

However, if you're working within a UIViewController subclass or another UIKit/AppKit class, you might see `import UIKit` or `import AppKit` instead of `import Foundation`. Since UIKit and AppKit import Foundation internally, you don't need to import Foundation explicitly if you've already imported UIKit or AppKit.

Another functionality of the Foundation framework is bridging Objective-C types to Swift types, facilitating interoperability between the two languages. This is especially important because Foundation is largely built with Objective-C and provides a wide range of functionalities that are essential for iOS and macOS development.

Here are some key points about how Foundation facilitates the interaction between Objective-C and Swift:

1. **Objective-C Bridging**: Swift has built-in bridging for many Foundation classes. For example, when you use `NSString` in Swift, it is automatically bridged to Swift's `String` type. Similarly, `NSArray` is bridged to `Array`, `NSDictionary` to `Dictionary`, and so on. This bridging is seamless, allowing you to use Objective-C classes as if they were native Swift types in many cases. They're called bridged data types.

2. **Nullability Annotations**: Foundation and other Objective-C frameworks have been updated with nullability annotations (`nullable`, `nonnull`, `null_resettable`) to provide more information about pointer nullability to Swift. This helps Swift in enforcing its strict type safety and optional handling.

3. **Type Aliases**: Swift provides type aliases for many Foundation types to make them more "Swifty". For example, `TimeInterval` in Swift is a type alias for `NSTimeInterval` in Objective-C.

4. **Extensions and Protocols**: Swift extends many Foundation classes and adopts Foundation protocols to make them more Swift-like. For example, Swift adds additional functionality to Foundation classes through extensions, and many Foundation protocols are adopted by Swift types to enhance interoperability.

5. **Generics**: Swift's use of generics with Foundation types like `NSArray` and `NSDictionary` allows for more type-safe collections, translating into Swift's `Array` and `Dictionary` with specific element types.

By importing Foundation in a Swift file, you not only get access to a wealth of useful functionalities but also a smoother interoperability experience when working with Objective-C codebases or utilizing Objective-C frameworks in Swift projects.

---

## Coding - Type Safety

Swift requires you to indicate the type of the variable you initialize which could lead to interesting problems. Lets look at how Typeof is used to solve these problems.

Typeof
- Why? When you're integrating a new API into your project, understanding the types it expects and returns is crucial for ensuring compatibility and functionality. By knowing the data types, you can properly interface with the API, pass the correct types, and handle the returned data appropriately.
```
let exampleVariable = "Hello, World!"
print(type(of: exampleVariable))
```
- Why? Sometimes, you may need to declare a variable without immediately assigning a value to it, especially if its value will be determined later in your code. Knowing the exact type of the value that will be assigned later is crucial for the variable's declaration. This is particularly important in Swift, where type safety is a key feature. You can have the type more dynamic:

```
// Assume futureValue is what you will eventually assign to your variable
let futureValue = getFutureValue() // This function is hypothetical
// Determine the type
let futureValueType = type(of: futureValue)

// Now you can declare your variable with the correct type
var myVariable: futureValueType

```



---

## Coding - Variables

In Swift, you declare variables with `var` keyword and you have the option of being strict with the type (Type Safety):

```
var objPlayer = Player()
var e:Employee = Employee()
```

The syntax is similar to javascript or typescript.

---

## Coding - Classes

### Classes are available globally
You don't need to explicitly import files in Swift as they are globally available through the project. If you want to access the methods or properties of Player class, you can directly make object of Player class in MainScene.Swift file and can access to it. e.g var objPlayer = Player()
https://stackoverflow.com/questions/35222044/swift-import-my-swift-class

You can be explicit about the type too (use the class name as a type):
var e:Employee = Employee()

### Instantializing Classes
You don't use new keyword like in other programming languages. Probably their philosophy is you're calling the constructor anyways

```
var objPlayer = Player()
```


---


## Coding - Programmatically affecting ui controls


Programmatically with controls. 
- Basically you need to add controls to view controller code. 
- First setup dual screens in XCode so you can control-drag to code. 
- Dragging will fail unless you meet requirement: Add Class attribute at the screen and that class is selected to the View Controlled class which was created as a new Swift file under View Controllers folder. 
- Hold CTRL key and drag the UI (the UI must be a button etc, textview DOES NOT have an action capability) to the proper swift file's code onto an empty line to create a new variable aka outlet (if you want a click handler instead, select action). The option to select outlet or action appears when you let go of the mouse  Ctrl drag: https://youtu.be/mr7pJB2eyK4?t=578 Confirming: https://youtu.be/mr7pJB2eyK4?t=525


---


& Blue safe area is wider than the simulator view so all the UIViews you add constraints for centering or relative to margins - they don't show up on your phone/simulator.

Safe area is glitched so when you add constraints relative to safe area margin or the center (at 0 relative to container), then the UI view may be clipped off from your phone screen. 
Disable the safe area and revert to constraints relative to Superview: Inspector -> First Tab -> Uncheck "Use Safe Area Layout Guides"

& Common error
 doesn't contain a view controller with identifier '...'' terminating with uncaught exception of type NSException

"I was having the same issue, but I could not find the "Identifier" field in the inspector. Instead, just set the field named "Storyboard ID" to what you would name the Identifier. This field can be found under the "Show the Identity inspector" tab in the inspector."


& Common error
this-class-is-not-key-value-coding-compliant-for-the-key

- Make sure UI View's name in storyboard mode matches the outlet variable name. If you renamed any UI View, it may not have recognized you renamed it (so recreate the UIView with your desired name)
https://becodable.com/this-class-is-not-key-value-coding-compliant-for-the-key/

- Check the Outlets Inspector on the right side (two icon tabs to the right of the Attributes Inspector tab and looks like an opened circle with a dot inside) and some will have exclamation marks. Fix the outlets with exclamation marks. But be careful it can't detect all problems and put an exclamation mark. Some may be old outlet variable names in code or old ui names in the ui navigator - those might not have exclamation marks - but you have to ex out / remove them.
    - You want to check the Outlets Inspector for the View that contains all the views, but also you might need to check the individual views (UIButton, UIImageView, etc)

￼![](https://i.imgur.com/l86mFZP.png)



& No keyboard screen on iOS simulator?
Is not your code. It was SHIFT+CMD+K that turned off the simulator keyboard and connected simulator input to your actual keyboard. Somehow Shift+CMD+K was triggered. Pressing CMD+K (without Shift) disconnects the actual keyboard and re-added simulator screen keyboard.

---

@ ESOTERIC

"Clip to bounds" option in Inspector -> Attributes
https://www.youtube.com/watch?v=356crJYlLBc

Inspector's Scale to fill, Aspect Fit, Aspect Fill https://developer.apple.com/documentation/swiftui/view/scaledtofill()
https://developer.apple.com/forums/thread/127418

# "this class is not key value coding-compliant for the key X" error?"
Right click every button/control that applies at a storyboard to look for a orange triangle/ exclamation
￼
![](https://i.imgur.com/FbnvZIK.png)


And also right click for the whole story board: 
￼
![](https://i.imgur.com/wkJDS0g.png)


From: https://stackoverflow.com/questions/3088059/xcode-how-to-fix-nsunknownkeyexception-reason-this-class-is-not-key-valu 
--

@ RARE

@ Issue: Slow storyboard:

Make sure enough hard drive space.

Update to latest iOS. Update to latest XCode.

XCode > Preferrences... > Navigation > Navigation Style -> Open in Place
XCode > File > Workplace Settings > Select Build System as New Build System (Default)

Editor -> Canvas -> Device Bezels -> Disabled

Resolved all auto layout issues (at main storyboard canvas,'s left side panel that lists all the scenes, look for any yellow or red right arrows right of the scene name. If there are, click them and make the recommended layout fixes (For example, suggested constraints, etc)

Mixo.xcodeproj -> Show Packaged Contents -> Delete xcuserdata
Mixo.xcodeproj -> Show Packaged Contents -> Nested .xocodeproj -> Show Packaged Contents -> Delete xcworkspace 

Removed Mixo Test and Mixo UI Test

Edit Podfile so Firebase pods are at the bottom of all other pods. Removed Mixo Test from Pod file. Then removed /Pods and Podfile.lock. Run `pod install`

Delete Derived data with: `rm -rf ~/Library/Developer/Xcode/DerivedData`

Restart XCode and build it again.


@ Fundamental
Convert Int to String

String(YourInt)

@ Fundamental

Passing data with InstantiateViewController / Pass data from screen to screen

Approach 1:
Start reading at [there is a lot of method to do this but you can use UserDefaults] from
https://stackoverflow.com/questions/70373999/swift-how-can-i-pass-the-calculation-result-to-another-screen

Approach 2:
Use global variables in /Helpers folder with some class / file you make (will be automatically global to the app as long as the class/file is in /Helpers)

@ Fundamental

Adding a child view to parent view VS presenting as a modal
Interpret starting at [The UIViewController.dismiss(animated:completion:) method is used]' from https://developer.apple.com/forums/thread/694366


@ Fundamental

Closing back to previous view on Modal (UI.present)
Interpret https://developer.apple.com/forums/thread/694366
 - Note on interpretation, he meant:
            self.dismiss(animated:true, completion: nil );

Closing back to parent view on child view closing (from self.addChild and self.view.addSubview)
Interpret https://developer.apple.com/forums/thread/694366

@ Troubleshooting


Error:
`let url = URL(string: urlRaw)!` complains about nil. It's just incorrect URL formatting, but XCode doesn't have the right error messages to let you know.

Error: xcode textview not showing

Untick "Scrolling Enabled"

It was scrolled to an empty part of the textview, even if you limit the width and height.

@ Troubleshooting

Opening storyboard from Project Navigator only opens it up in XML format

1. Right click the storyboard in project navigator and Open As -> "Interface Builder - Storyboard"
2. At the top right, there's an icon that toggles between code and UI Builder: 
￼

@ Troubleshooting
When instantiating a view controller / rendering, it complains that it can't find a scene with that identifier or gives a vague SIGABORT error.

> The view controller / scene requires that a storyboard ID and the module must be chosen (your project name). If it doesn't let you select your project name, then you may need to tick 'Inherit Module from Target'.


@ Troubleshooting

For variables, it's best to do this:
print("/****/ description");
print(yourVariable);

That way you can quickly see where your variable is in a mess of logs in XCode terminal. If still hard, then copy the terminal (Select all) into Visual Code or some editor for you to do CMD+F / CTRL+F search for /****/. If that's too many steps you can crash the terminal at that point of printing the variable with a `fatalError()`:

```
print("/****/ description");
print(yourVariable);
fatalError()
```

@ Troubleshooting

No such module __ when building or archiving in a Cocoa Pods project?
Opening xcodeproj instead of xcworkspace will cause an error like this..


---

Fundamental Hugging and Compression Resistance:
Hugging doesn't wanna grow out (move out)
Compression resistance don't wanna be compressed
￼
![](https://i.imgur.com/31muA2a.png)



---

Sharing on a git? gitignore these files:
1. Delete the Pods folder from your project
2. Delete the .xcworkspace file,
3. Delete the Podfile.lock file

Otherwise will complain can't read license files for Firestore, and other problems

--

Cocoa pod problems
1. Delete the Pods folder from your project
2. Delete the .xcworkspace file,
3. Delete the Podfile.lock file
pod cache clean --all 

---

Error: I'm also stuck on Installing gRPC-Core (1.28.2)

I resolved it by deleting all the cache related to gRPC at /Users/<user>/Library/Caches/CocoaPods/Pods/Release/ and ../Specs/Release/, and running pod install again.

Also: It is dowing grpc core and it's submodule and it will take time. The file size is greater than or around 1 GB. So sit back and relax. If you would like to learn more then you can read my article about the same problem and the solution.

Also: pod install --verbose
Because you'll at least see what's going on


---

Fundamental: Adjusting constraints after they've been set, within XCode
Sometimes changing the constraints in the Scene navigator panel on the left does not actually change it (you will see it's unchanged when you go to the element view -> properties on the right panel -> ruler icon).

--

Programmatically dismiss keyboard
            self.view.endEditing(true)


---

Fundamental: Loading images etc to a background thread so won't freeze the app


DispatchQueue.main.async {
// Your UI code here
}

Can work in your methods easily


@ Essential
Change title of app that appears on home screen

Open Info.plist. If does not show up on the File Navigator, open in Finder to look for it inside your project folder, then Open with XCode.

You can connect to a physical iPad/iPhone, then delete app on home screen and see when it installs a new build rather the file name is changed

If the above fails, then you change Product Name, and Bundle Display Name here
https://stackoverflow.com/questions/238980/how-to-change-the-name-of-an-ios-app
And change schema here:
https://stackoverflow.com/questions/16416092/how-to-change-the-name-of-the-active-scheme-in-xcode


@ Error: Signing for "Firebase..." requires a developer Team. 
Under same screen where there's an error, go to Signing -> Team -> Select your developer account.

You'll have to do this for all the other Firebase cocoapods that have the same error.

----

Swift Tutorials:

https://youtu.be/43UOxoOuAag

https://youtu.be/FcsY1YPBwzQ