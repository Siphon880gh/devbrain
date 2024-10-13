Dev iOS Primer (XCode 13)
By Weng

Somethings you will learn:
- How to navigate and build an app
- Auto layout and constraints
- Connecting storyboard scenes to view controller class code
- Ui view outlet into variables at view controller class code

**How to use**: Recommend you open a screen-persistent Table of Contents so you can navigate this document more easily.

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

## Setup new project v1

Refer to:
[https://www.raywenderlich.com/5055364-ios-storyboards-getting-started](https://www.raywenderlich.com/5055364-ios-storyboards-getting-started)

This is for creating a storyboard based app. iOS apps can be swift UI or storyboard or XIB. You are not limited, however, you can have a storyboard app that mixes in swift UI screens with the proper coding.

### Hierarchy:

The user can navigate your iOS app through multiple screens. When editing those screens, you have the choice of editing a flow of screens called scenes on a storyboard, or the choice of working on each individual scene as XIB files that have to string to each other (older way of doing things).

The storyboard's scenes are each a screen the user gets to see. You can drag and drop ui controls right onto these scenes/screens. But to code how the screen handles user and data viewing behavior, you edit the scene's file that is actually code that creates a view controller class. Scenes are the visual representation whereas the view controller are the code representation. 

Each view controller is an instance of "UIViewController" or its subclasses. The code is in Objective C / Swift because Apple chose to make the transition of coding language less painful. But the file extension is .swift

The storyboard that you see is handled with a storyboard file. That storyboard file reaches out to the .swift files it'll represent as scenes connected to each other.

The left most side panel is the Project navigator to navigate view controller / scene / swift files,  XIB files, storyboard files, or various types of files including .plist (property list holding onto your settings). 

Inside the storyboard panel, the left subpanel is the Document Outline (think of it as a outline of storyboard screens and their elements). The Document Outline shows all the items you have inside the open storyboard file, as well as any view controller and any of the controls it includes.

### Project requirements

The project must be set to an initial storyboard at {Project} -(at Project navigator) > Targets:{Project} -> General -> Deployment Info -> Main Interface {Set this dropdown)

Then the storyboard must have an initial view controller to present.

Select View Controller -> Attributes Inspection panel -> View Controller section -> Is Initial View Controller (tick checkbox}

### Designing

Create a storyboard in Project Navigator: + New File -> User Interface: Storyboard

Create a Scene / Screen / View Controller in storyboard (Press + at top right for Object Library then search for View Controller). Decorate that screen with other objects (Text View, Label, Button, etc)

- The view controller / scene requires that a storyboard ID and the module must be chosen (your project name). If it doesn't let you select your project name, then you may need to tick 'Inherit Module from Target'. Otherwise, if you don't have both requirements met, then when you try to render it programmatically or instantiate view controller, it'll complain it can't find a scene with that identifier or it'll do a vague SIGABORT error.

Optionally: You may make the screen have programmable elements to it. Like dynamically changing a text, setting up touched down handlers (instead of segues directly from a button to a screen within Storyboard UI Builder).

1. Create a Swift file in the Project Navigator.
2. Use this template:

```
import Foundation
import UIKit


@available(iOS 13.0, *)
	class TestDrivenVC: UIViewController
	{
		override func viewDidLoad() {
			super.viewDidLoad()
		}
	}
```

  
3. You can make buttons and other elements programmable by capturing them as variables in the code, aka outlets. Or by capturing their clicking etc interactions, aka actions.
    
4. Just CMD+drag from storyboard to the code inside the class (as class attributes). Notice you can select Outlet or Action when you released the mouse for buttons, but only outlets for text. The type of element will determine that possibility.  

5. Then you can add interaction / dynamic coding like this:  


```
import Foundation
import UIKit

class TestDrivenVC: UIViewController
{
	@IBOutlet weak var label1: UILabel!
	@IBOutlet weak var TV1: UITextView!
	@IBOutlet weak var TV2: UITextView!
	@IBOutlet weak var TV3: UITextView!
	
	override func viewDidLoad() {
		super.viewDidLoad()
		TV1.text = "Changed Text"
	}
}
```


---

## Setup new project v2

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

![](https://i.imgur.com/YPjxDWm.png)



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


### Clip to bounds, scale to fill, aspect fit, aspect fill

In Xcode, which is Apple's integrated development environment (IDE) for macOS, you have various options to control how your user interface elements are displayed and interact with each other. Here, we'll discuss the "Clip to bounds" option in the Inspector's Attributes panel and the concepts of "Scale to fill," "Aspect Fit," and "Aspect Fill" in the context of view scaling.

#### Clip to Bounds:

- **What it is:** The "Clip to bounds" option in Xcode's Inspector's Attributes panel is used to determine whether subviews are clipped to the bounds of the view they are contained within.
- **How it works:** When you enable "Clip to bounds" for a view, any of its subviews that extend beyond the edges of the parent view will be clipped, meaning they won't be visible outside the parent view's boundaries. If this option is disabled, subviews can render outside the parent view's bounds.
- **Use cases:** This is particularly useful when you want to create a neatly contained UI where subviews should not overlap or extend beyond the designated areas. For instance, it's crucial when applying rounded corners or when you only want to show a specific portion of a larger subview.
- Two approaches:
	- Approach Coding
		
		You can do it by one line code
		
		```swift
		superView.clipsToBounds = true 
		```
		
		`superView` is view that your `innerView` added on that OR
		
	- Approach Storyboard
		- You can also find out this property from storyBoard too.
		- Select your `superView` and check on **Clip Subviews
		- ![](https://i.imgur.com/43YKZGL.png)


#### View Scaling Options - Scale to Fill, Aspect Fit, Aspect Fill:

These options determine how a view's content is scaled to fit the bounds of the view itself. They are essential for handling different aspect ratios or sizes of content.

1. **Scale to Fill (`scaledToFill()` in SwiftUI):**
   - Content is scaled to completely fill the view. This may result in the content being stretched or squashed if the aspect ratios do not match.
   - Useful when you want the content to cover the entire area of the view, without any empty spaces, even if that means the content's aspect ratio is not preserved.

2. **Aspect Fit:**
   - Content is scaled to fit the view's bounds while maintaining its aspect ratio. This might leave empty spaces (padding) if the aspect ratios do not match.
   - Ideal when preserving the original aspect ratio of the content is crucial, and you don't mind having some empty space in the view.

3. **Aspect Fill:**
   - Content is scaled to fill the view while maintaining its aspect ratio. Unlike Aspect Fit, Aspect Fill ensures there are no empty spaces, but this might result in some parts of the content being clipped.
   - This is useful when you want to ensure that the content completely fills the view, but you also want to maintain the content's aspect ratio.

Understanding and using these options effectively can help you create user interfaces that are visually appealing and function well across different device sizes and orientations.

Concept Diagram:
![](https://i.imgur.com/QZsc6ct.png)

Mode:
![](https://i.imgur.com/kcx7qQC.png)

---

## Hugging and Compression Resistance
Hugging doesn't wanna grow out (move out)
Compression resistance don't wanna be compressed
￼
![](https://i.imgur.com/31muA2a.png)

1. **"Hugging doesn't wanna grow out (move out)":** This likely refers to the Content Hugging Priority in Auto Layout. Content Hugging Priority is a metric that tells the system how much a view resists growing larger than its intrinsic content size. In simpler terms, if a view has a high Content Hugging Priority, it does not want to stretch or grow out beyond the size necessary to display its content. For example, if you have a label with some text, and the label's content hugging is set to a high value, the label will prefer to stay just big enough to fit its text and will resist efforts to stretch it larger.
    
2. **"Compression resistance don't wanna be compressed":** This refers to the Compression Resistance Priority in Auto Layout. Compression Resistance Priority is a metric that tells the system how much a view resists being made smaller than its intrinsic content size. A view with a high Compression Resistance Priority does not want to be squished or compressed to a size smaller than what is required to display its content. For instance, if a button has a high Compression Resistance Priority, the system will try to avoid shrinking the button to a point where its content (like text or image) is distorted or cut off.

![](https://i.imgur.com/E4bjekd.png)


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

### Title app icon  
Change title of app that appears on home screen  
  
Open Info.plist. If does not show up on the File Navigator, open in Finder to look for it inside your project folder, then Open with XCode.  
  
You can connect to a physical iPad/iPhone, then delete app on home screen and see when it installs a new build rather the file name is changed  
  
If the above fails, then you change Product Name, and Bundle Display Name here  
[https://stackoverflow.com/questions/238980/how-to-change-the-name-of-an-ios-app](https://stackoverflow.com/questions/238980/how-to-change-the-name-of-an-ios-app)  
And change schema here:  
[https://stackoverflow.com/questions/16416092/how-to-change-the-name-of-the-active-scheme-in-xcode](https://stackoverflow.com/questions/16416092/how-to-change-the-name-of-the-active-scheme-in-xcode)


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

## Set button text programmatically


### Set text for Plain Button

The setTitle()method will work for titles that are "Plain" as defined in the button's Attributes inspector.

You can have the text weight and style at "for"
- .normal
- .highlighted
- .disabled
- .selected
- .focused
- .application
- .reserved
  
```
btn.setTitle("Temperament Definitions", for: .normal)

lb.text = "hi"
```

 
### Attributed Title

The setTitle()method has no effect on a button's title if it's configured as "Attributed" in the Attributes inspector. To manage this situation, first get the attributed title from the button, then set the value.

```
@IBAction func button(sender: UIButton) {
	let attributedTitle = sender.attributedTitle(for: .normal)
	attributedTitle?.setValue("buttonName", forKey: "string")
	sender.setAttributedTitle(attributedTitle, for: .normal)
}
```

---


## Coding - Objective C, Swift, Get version of Swift


Objective-C and Swift are two primary programming languages used for iOS development within Apple's Xcode IDE. Here's a brief history comparing the two:

### Objective-C
1. **Introduction**: Developed in the early 1980s by Brad Cox and Tom Love at StepStone Corporation, Objective-C was adopted by NeXT (Steve Jobs' company after leaving Apple) for its NeXTSTEP operating system.
2. **Apple Adoption**: Apple acquired NeXT in 1996, bringing Objective-C into its ecosystem. It became the standard for macOS and later iOS development.
3. **Features**: Objective-C is a superset of C with object-oriented capabilities and dynamic runtime. It was widely used for building robust and complex applications.
4. **Xcode Integration**: Objective-C was fully integrated into Xcode, Apple's IDE, providing a comprehensive suite of tools for iOS and macOS development.

### Swift
1. **Introduction**: Apple introduced Swift in 2014 as a modern, fast, and type-safe programming language designed to replace Objective-C for iOS and macOS development.
2. **Design Goals**: Swift was created to be more intuitive and easier to learn than Objective-C, with features like optional types, closures, and generics, aiming for safer, more concise code.
3. **Swift and Xcode**: Swift was integrated into Xcode, offering advanced features like playgrounds for interactive coding and improved compiler and debugger tools.
4. **Evolution**: Swift has rapidly evolved, with Apple and the open-source community introducing regular updates and improvements. It has become the recommended language for new iOS and macOS applications.

### Transition from Objective-C to Swift
- **Coexistence**: Developers can use both Objective-C and Swift in the same project, allowing for gradual migration rather than a complete rewrite.
- **Community Adoption**: Swift's adoption has grown rapidly among developers due to its modern syntax, safety features, and performance improvements over Objective-C.
- **Future**: While Objective-C is still supported, Swift is clearly the future of iOS and macOS development, with Apple and developers actively investing in its ecosystem.

In summary, the transition from Objective-C to Swift in iOS development within Xcode marks a significant shift towards a more modern, safe, and developer-friendly language, reflecting the evolving needs of the platform and its developers.


### Get Version of Swift
You should know what version of swift your project is using before looking for answers at stackoverflow:

Project first item in Navigator -> Build Settings -> Swift Compiler - Language

As of 2022, latest Swift is Swift 5.


---

## Coding - Foundation Library

### TLDR
- It's a library you need to import, unless you're using UIKit or AppKit which imports it internally
- Has functionalities of iOS you expect
- Originally in Objective C but now bridges to Swift too
- Foundation is associated with classes that are prefixed with "NS"

### Foundation Importing, When to

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

### Foundation classes and methods

Here's an overview of some notable classes and their methods from the Foundation framework:

1. **NSString**
    
    - `length`: Returns the number of characters in the string.
    - `substringFromIndex:`: Returns a substring starting from the specified index.
    - `stringByAppendingString:`: Appends a string to the receiver.
2. **NSArray**
    
    - `count`: Returns the number of objects in the array.
    - `objectAtIndex:`: Returns the object located at the specified index.
    - `arrayByAddingObject:`: Returns a new array that is the result of adding a given object to the receiver.
3. **NSDictionary**
    
    - `objectForKey:`: Returns the value associated with a given key.
    - `allKeys`: Returns an array containing the dictionary’s keys.
    - `allValues`: Returns an array containing the dictionary’s values.
4. **NSNumber**
    
    - `numberWithInt:`, `numberWithFloat:`, etc.: Creates and returns an NSNumber object containing a given value, treating it as a specified C data type.
    - `intValue`, `floatValue`, etc.: Returns the value of the receiver as a native C data type.
5. **NSDate**
    
    - `date`: Returns the current date and time.
    - `timeIntervalSince1970`: Returns the interval between the receiver and the first instant of 1 January 1970, GMT.
    - `dateByAddingTimeInterval:`: Returns a new date object that is a given number of seconds later than the receiver.
6. **NSFileManager**
    
    - `defaultManager`: Returns the shared file manager object for the process.
    - `fileExistsAtPath:`: Returns a Boolean value that indicates whether a file or directory exists at a specified path.
    - `createDirectoryAtPath:withIntermediateDirectories:attributes:error:`: Creates a directory at the specified path.
7. **NSUserDefaults**
    
    - `standardUserDefaults`: Returns the shared defaults object.
    - `objectForKey:`: Returns the object associated with the specified key.
    - `setObject:forKey:`: Sets the value of the specified default key.
8. **NSNotificationCenter**
    
    - `defaultCenter`: Returns the process’s default notification center.
    - `addObserver:selector:name:object:`: Adds an observer for a notification.
    - `postNotificationName:object:`: Posts a given notification to the receiver.
9. **NSPredicate**
    
    - `predicateWithFormat:`: Returns a new predicate formed by parsing a predicate format string.
    - `evaluateWithObject:`: Returns a Boolean value that indicates whether a specified object matches the conditions specified by the predicate.
10. **NSJSONSerialization**
    
    - `dataWithJSONObject:options:error:`: Returns JSON data from a Foundation object.
    - `JSONObjectWithData:options:error:`: Returns a Foundation object from given JSON data.

These classes and methods provide a glimpse into the capabilities of the Foundation framework, which offers extensive functionality for handling common tasks in app development on Apple's platforms.

### History of NS and Foundation

People may get confused why NS is associated with Foundation.

The "NS" prefix in the Foundation framework's classes stands for "NeXTSTEP," which is a historical reference to the NeXTSTEP operating system. NeXTSTEP was developed by NeXT, a company founded by Steve Jobs after he left Apple in the mid-1980s. The NeXTSTEP operating system is significant because it introduced many advanced features and concepts in software development, which were ahead of its time.

When Apple acquired NeXT in 1996, it brought not only Steve Jobs back to the company but also NeXTSTEP's technology, which became the foundation for macOS (originally Mac OS X). The Foundation framework in macOS and its subsequent variations for iOS, watchOS, and tvOS, inherited the NeXTSTEP's class prefixes as a nod to its origins.

The "NS" prefix is now synonymous with the core set of Objective-C classes that provide basic programmatic interfaces, which are part of the Foundation framework. Even though the framework is called Foundation, the "NS" prefix remains as a historical artifact, reflecting the rich lineage and evolution of Apple's operating systems and development frameworks.

---


## Coding - Comments

In Swift, you can add a comment in the middle of a line using the double forward slash `//`. Everything following `//` on the same line is treated as a comment and is not executed as code. Here's how you can include a comment in the middle of a line:

```swift
var sum = 15 + 27 // This is an inline comment
```

In this example, `// This is an inline comment` is a comment that does not affect the execution of the code. The code `var sum = 15 + 27` will execute normally, and the part following `//` is simply ignored by the compiler.

## Coding - Swift specific logic

A lot of coding logic in other languages share with Swift, however Swift has some unique concepts.

Optionals is part of Swift's broader strategy to ensure code safety and clarity, particularly when dealing with values that might or might not contain values.


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

#### Side effect: Comparison Not operator should not be confused with Unwrapping operator
When doing a comparison Not operator, you need the spacing:
```
user_pic !== "Incomplete"
```
Otherwise it may think you are unwrapping an optional, and it could error that it can't build (especially here where it's a hard coded string that doesn't need unwrapping).


### Optional Binding with `if let`

Swift, Apple's powerful programming language designed for iOS, macOS, and beyond, introduces several features aimed at improving code safety and readability. One such feature is optional binding, particularly using the `if let` syntax. This construct is pivotal in dealing with optionals—a fundamental aspect of Swift that allows variables to lack a value. Let's delve into how `if let` enhances code safety and clarity, especially in the context of handling asynchronous data, such as responses from API calls.

#### The Basics of Optionals in Swift

Before exploring `if let`, it's crucial to understand optionals in Swift. An optional in Swift is a type that can hold either a value or `nil`, indicating the absence of a value. This concept is essential for error handling and for scenarios where a value may or may not be present. However, working with optionals can be tricky; attempting to access an optional's value directly when it's `nil` can lead to runtime errors. Here's where `if let` comes into play.

#### Unwrapping Optionals Safely with `if let`

The `if let` syntax provides a safe way to "unwrap" an optional's value, i.e., to access its value if it exists. This process is called optional binding. Here's a simple example:

```swift
var optionalNumber: Int? = 10

if let number = optionalNumber {
    print("The number is \(number).")
} else {
    print("The optional was nil.")
}
```

In this snippet, `optionalNumber` is an optional integer that holds a value of 10. The `if let` statement checks if `optionalNumber` has a value and, if so, assigns it to a new constant `number`. The code within the block executes only if the optional contains a value.

#### Practical Example: Fetching API Data

Optional binding shines in scenarios involving asynchronous operations, such as fetching data from an API. Let's consider a function that fetches user data from an API:

```swift
func fetchUserData(completion: @escaping ([String: Any]?) -> Void) {
    // Assume this function fetches data and returns a dictionary
    let userData: [String: Any]? = ["name": "John Doe", "age": 30]
    completion(userData)
}
```

When using `fetchUserData`, you might want to handle the returned data safely:

```swift
fetchUserData { response in
    if let response = response {
        print("User name: \(response["name"] ?? "Unknown")")
        print("User age: \(response["age"] ?? "Unknown")")
    } else {
        print("No data received.")
    }
}
```

In this example, `fetchUserData` passes a dictionary to its completion handler. The dictionary is an optional, as the data fetching might fail, resulting in `nil`. The `if let` statement within the closure checks if `response` holds a value. If it does, the code block executes, allowing you to safely access `response`'s data.


The `if let` syntax in Swift is a testament to the language's emphasis on safety and clarity. By safely unwrapping optionals, developers can avoid common pitfalls associated with null values, thereby writing more robust and error-free code. In the realm of asynchronous programming and API interactions, `if let` proves particularly useful, ensuring that applications handle data gracefully and efficiently.


### Optional Binding with guard let

The `guard let` statement is similar to `if let` in that it unwraps an optional. However, it differs in its flow control: `guard let` is designed to exit the current scope (e.g., a function or loop) if the optional is `nil`. This is particularly useful for early exits in a function where you need certain conditions to be met to proceed further.

Here's a basic example of `guard let`:

```swift
func processUser(id: Int?) {
    guard let userId = id else {
        print("Invalid user ID")
        return
    }

    // At this point, userId is a non-optional Int
    print("Processing user with ID \(userId)")
}

processUser(id: nil)    // Outputs: "Invalid user ID"
processUser(id: 12345)  // Outputs: "Processing user with ID 12345"
```

In this example, if `id` is `nil`, the function prints an error message and exits. If `id` has a value, the code continues executing beyond the `guard` statement.

### Nil Coalescing Operator

The nil coalescing operator `??` provides a concise way to provide a default value for an optional if it contains `nil`. This is similar to JS' ternary operator for a null falsey value

```swift
let optionalNumber: Int? = nil
let number = optionalNumber ?? 10  // number is 10 if optionalNumber is nil
```

### Optional Chaining

Optional chaining allows you to call properties, methods, and subscripts on an optional that might currently be `nil`. If the optional is `nil`, the entire expression returns `nil`. This is the same concept as JS' optional chaining.

```swift
let optionalString: String? = "Hello"
let count = optionalString?.count  // count is of type Int?
```


---

## Coding - Functions


```
func aspectRatio(_ aspectRatio: CGFloat?, contentMode: ContentMode) -> some View {
    // ...
}
```

But note usually you can't indicate any return type at a top level (outside of classes).


---


## Coding - For loop 

### For loop - with a range
```
for index in 1...5 {
    print("\(index) times 5 is \(index * 5)")
}
```

### For loop - with an array

```
import Foundation

var arr = Array(["a", "b", "c"])

for i in 0...arr.count-1 {
    print(arr[i])
}
```

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


### Var syntax with or without strict typing

In Swift, you declare variables with `var` keyword and you have the option of being strict with the type (Type Safety):

```
var objPlayer = Player()
var e:Employee = Employee()
```

The syntax is similar to javascript or typescript.

### Dictionary that's mutable and accepts any typed value for string keys

```
var response: [String: Any] = [:]
```




---

## Coding - Get character from string at index


In most programming languages, you get the character from the string at an index with: input[3]

But not in Swift:
```
let input = "Swift Tutorials"
let char = input[input.index(input.startIndex, offsetBy: 3)] // f
```

https://www.simpleswiftguide.com/get-character-from-string-using-its-index-in-swift/


---
  
## Coding - String interpolation

For example, if you have a variable `index` with a value of 5, and you use the following code:

```swift
let index = 5
print("We are at index: \(index)") 
```

The output will be:

```
We are at index: 5
```


The syntax you've used, `\(index)`, is an example of string interpolation in Swift. In Swift, string interpolation is a way to construct a new String value from a mix of constants, variables, literals, and expressions by including their values inside a string literal. Each item that you insert into the string literal is wrapped in a pair of parentheses, prefixed by a backslash.

This feature is particularly useful for creating descriptive messages or for combining static and dynamic content in a single string. String interpolation is a concept that's common in many programming languages like template literal in js and fstrings in python

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

## Coding - Class property vs method


Review property vs method in classes. This is similar concepts in other languages like javascript.


## Coding - Global Variables, Singleton

#### Global Variable
To create global variables that are accessible anywhere in your app, you can simply declare them outside of any class or structure in a Swift file. These variables will then be accessible from any part of your application. However, it's important to note that using global variables extensively is generally discouraged in software design due to potential issues with maintainability, testing, and debugging.

The variables can be in any swift file, so you could use a Helpers.swift

Here's how you can declare a global variable:

```swift
// Global variable
var globalString: String = "Hello, World!"

// A global constant
let globalConstant: Int = 42

// Accessing the global variable from anywhere in the app
func printGlobalString() {
    print(globalString)  // Outputs: Hello, World!
}
```

When you declare `globalString` and `globalConstant` outside of any class, struct, or enum, they become globally accessible. You can read and modify `globalString` from any part of your app. Similarly, `globalConstant` can be accessed anywhere, but since it's a constant, its value cannot be changed once set.

While global variables provide a quick and straightforward way to share data, it's often better to consider alternatives like singletons, dependency injection, or data passing mechanisms (such as through initializer or function parameters) to maintain a clear structure and flow in your application, enhancing its readability and testability.

#### Singleton Pattern

To have more organization when it comes to global variables, you generally create a class whose member values are accessible anywhere in your app, in what is called a singleton pattern. A singleton class ensures that there's only one instance of the class throughout your application, providing a global access point to its properties and methods.

Here's a basic example of how you can implement a singleton in Swift:

```swift
class MySingleton {
    static let shared = MySingleton()

    var property: String = ""

    private init() {
        // Private initialization to ensure just one instance is created.
    }
}

// Accessing the singleton and its property
MySingleton.shared.property = "Hello, World!"
print(MySingleton.shared.property)
```

The `static` keyword is crucial in creating a singleton class in Swift. It allows the class to have a static property that holds the singleton instance. Here's a breakdown of how it works in the context of a singleton:

1. **Static Property**: The `static let shared = MySingleton()` line declares a static property called `shared`. Being static means this property belongs to the class itself, not to any instance of the class. Therefore, it's shared across all instances and accessible directly through the class, not through a specific instance.
    
2. **Private Initializer**: The `private init()` ensures that no other part of your code can create an instance of the singleton class. This restriction is essential to enforce the singleton pattern, ensuring that only one instance of the class exists throughout the application's lifecycle.
    

The combination of a `static` property to hold the instance and a `private` initializer to prevent external instantiation ensures that your class adheres to the singleton pattern, providing a single, globally accessible point of access to its instance and its properties/methods.

### Namespaces with struct
And you can have "collections" of global variables like this:
```
struct Creational {
    static var myName: String?
}
```

To be accessed via `Creational.myName` and can check for nil with `if(Creational.myName==nill)

Other programming languages have a formal syntax for namespaces to avoid global functions and variables and to keep the global namespace clean. Swift does not have this pattern but we mimic it with structures.


### Namespaces with mutable dictionary

Place this in a swift file outside of any classes:

```
var globalContainer: [String: Any] = [:]
```

Explanation:
```
- `[String: Any]`: This is the type of the variable. It's a dictionary where the keys are of type `String` and the values are of type `Any`. `String` is a basic data type in Swift representing text, and `Any` is a special type in Swift that can represent an instance of any type at all, including function types and optional types.
    
- `= [:]`: This initializes the `response` variable with an empty dictionary. The `[:]` syntax is shorthand for creating an empty dictionary.
```



---


## Coding - Programmatically affecting ui controls


Programmatically with controls. 
- Basically you need to add controls to view controller code. 
- First setup dual screens in XCode so you can control-drag to code. 
- Dragging will fail unless you meet requirement: Add Class attribute at the screen and that class is selected to the View Controlled class which was created as a new Swift file under View Controllers folder. 
- Hold CTRL key and drag the UI (the UI must be a button etc, textview DOES NOT have an action capability) to the proper swift file's code onto an empty line to create a new variable aka outlet (if you want a click handler instead, select action). The option to select outlet or action appears when you let go of the mouse  Ctrl drag: https://youtu.be/mr7pJB2eyK4?t=578 Confirming: https://youtu.be/mr7pJB2eyK4?t=525


---

## Coding - Generate views with forEach  
  
If using for loop to generate views procedurally, you cannot use regular for loops. Must be:  
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
