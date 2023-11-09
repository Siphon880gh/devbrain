Dev iOS Primer (XCode 13)

Fundamentals
Starting
Auto layout and constraints
Connecting storyboard scenes to view controller class code
Ui view outlet into variables at view controller class code

≥ ≤


--

@ Fundamental links that open in phone's web browser
``` 
@IBAction func joinLinkTapped(_ sender: Any) {
        guard let url = URL(string: "https://mixo.vip/mentorship") else { return }
        UIApplication.shared.openURL(url)
    } 
```

Fundamental: Figuring out the data type.
- Why? Useful for probing a new API you are trying to adapt
- Why? Sometimes forced to create a variable with a specific type that you will use at a later implementation but you don't know what that specific type is so you'll do type(of:) on that implementation, so that you know how to initialize the variable.
print(type(of:))


@ Fundamental:  Storyboard UI Builder  -> Aspect ratio constraint
CTRL drag an UI view to itself, then click "Aspect Ratio" on the popup menu

@ Fundamental:  Storyboard UI Builder  -> Proportional height/width constraint
Have a view inside another view on the UI builder. Have the inner UI view smaller than the parent for now. Then CTRL drag the child UI view onto the parent UI view's empty space. Click Equal Widths or Equal Heights.

Later at the Inspector Panel, you can adjust the constant and/or multiplier (gs) which allows you to set it proportionally other than 100% width or height.


@ Fundamental
If main storyboard file not showing up, open Info.plist in XCode, and:
Main storyboard file base name => Main
Main on the right is whatever storyboard name (no file extension)


# When duplicating a scene board
Click a scene board by its title bar. Then CMD+C, CMD+V. Then it might look like it's not duplicated but you can look at the Document Outline to see a new scene was created. Then drag and drop the scene board elsewhere because it was on top of the older scene board. There will be an error that two view controllers have the same storyboard identifier. Go to the Identity Inspector and change the Storyboard ID to an appropriate name. Change the class name too after you create a VC swift file with the right class name.

OBSOLETE way: In Document Outline, select the scene board (entire scene board at root level of document outline). CMD+C
Click an empty area in the storyboard (can even be another storyboard), and CMD + V. You might have to drag it back into place on the storyboard visually



@ Fundamental
When doing not operator, be careful. You should add spacing:
```
user_pic !== "Incomplete"
```
Otherwise it may think you are unwrapping a value which is probably not an optional (especially if you hard coded a string), then it errors and can't build

@ Essential
Changing string to url encoded
```
let urlMessage = message!.addingPercentEncoding(withAllowedCharacters: .urlHostAllowed)
```


@Fundamental
Terminology:
In Swift, variables that may or may not have values could end with ? which makes it an OPTIONAL. But when assigning value to another variable or displaying it to the screen, you would UNWRAP the optional.

@ Fundamental

Run code when the view loads because user navigated back then forward (by tapping modal background). 
```
    override func viewWillAppear(_ animated: Bool) {
        //..
    }
```

Otherwise if it's loaded by clicking a button or programmatically like usual, use viewDidLoad

@ Essential [Common]
Trims spaces and newlines on both ends of the string
```
let cleanedPassword = txtPassword.text!.trimmingCharacters(in: .whitespacesAndNewlines)
```

@ Fundamental
Rendering next scene as a modal (with previous screen dimmed in background behind the modal) ```
        let profileScene1NVC = mainSB.instantiateViewController(withIdentifier: "ProfileScene1NVC") as! ProfileScene1NVC
        self.present(profileScene1NVC, animated:true, completion:nil)
```

^Keep in mind the previous screen is still in memory! It could lead to memory leak and crashes on low spec phones if you chain a bunch of screens this way


Rendering next scene over entire screen aka root view controller
```
        let profileScene1NVC = mainSB.instantiateViewController(withIdentifier: "ProfileScene1NVC") as! ProfileScene1NVC
        
        view.window?.rootViewController = profileScene1NVC
        view.window?.makeKeyAndVisible()
```




@ Workflow Setup

# Workflow problem: I am wasting a huge amount of time sifting through garbage that looks like this
2016-10-18 06:26:49.455995 Lunch[1559:32097] subsystem: com.apple.UIKit, category: HIDEventFiltered, enable_level: 0, persist_level: 0, default_ttl: 0, info_ttl: 0, debug_ttl: 0, generate_symptoms: 0, enable_oversize: 1, privacy_setting: 2, enable_private_data: 0 2016-10-18 06:26:49.458682 Lunch[1559:32097] subsystem: com.apple.UIKit, category:

Solution:

Product -> Scheme ->
￼![](https://i.imgur.com/kUcbKeD.png)


@ Essential

Changing height after it's been loaded. You need to turn off autosizing mask (so the phone doesn't take over the laying out) AND then add a height anchor.
Also: Changing constraints after it's been loaded. Useful if detecting device and readjusting the layout dynamically

Near end of ViewDidLoad:
```
        profilePicView.translatesAutoresizingMaskIntoConstraints = false;
        profilePicView.heightAnchor.constraint(equalToConstant: 100).isActive = true;
    	redView.leftAnchor.constraint(equalTo: view.leftAnchor, constant: 20).isActive = true
        labelY.centerYAnchor.constraint(equalTo: userMixoView.centerYAnchor, constant: 200).isActive = true
        userMixoView.topAnchor.constraint(equalTo: profilePicView.bottomAnchor, constant: 100).isActive = true;
```

And you determine screen width with:
```
         let screenRect = UIScreen.main.bounds
         let screenWidth = screenRect.size.width
         let screenHeight = screenRect.size.height
```

@ Fundamental

Reference:
CMD+SHIFT+0  
Zoom in / out
CMD+SHIFT +/-


@ Essential (Common workflow)
Edit the Constraints directly in the scene navigator but they're not in order? Just Filter at the bottom of navigator by the View name. Instead of typing the name though, you can press Enter on a control in the scene navigator, then CMD+C to start copying/pasting, then paste to Filter. To clear Filter easily, press Escape key.

Btw, from the scene navigator's constraints, you can add more programming elements to the constraints like math/percentages:
```
herotlc.width = 0.15 × width + 2.25
```


￼![](https://i.imgur.com/RtYeHcR.png)



Remember height and width don't show up as restraints in Scene navigator (poor design decision by Apple), and you're often working with one X position and width <OR> one Y position and height. Show width or height by opening inspector on the control selected in the scene navigator and opening the Size inspector to the right. 

WARNING: Sometimes editing the constraints directly in Scene navigator doesn't affect the actual constraints - then you'll have to go to Size inspector instead.

￼![](https://i.imgur.com/UtMgMYW.png)


When resolving conflicting constraints in the scene navigator, it may ask you to delete constraints. Before the modal that lets you choose which constraints to delete, you can click the constraints under Conflicting Constraints, and it'll highlight the control/element/view on the scene

@ Essential
Launching screen. Two options you have: (UNTESTED)
Top level project -> Target -> Info -> Launch screen
Or, create New File -> Launch Screen -> LaunchScreen.storyboard

@ Fundamental
iOS doesnt automatically dismiss keyboard when the "Done" at bottom right of keyboard is pressed

You have to delegate the textfield to its own methods then override its event handler:
```
    override func viewDidLoad() {
        super.viewDidLoad()
//...
        self.txtPassword.delegate = self
	}


    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        self.view.endEditing(true)
        return false
    }
```

The endEditing makes the keyboard go away        


@ Fundamental
You have to import foundation in your code for Swift. Reason: When importing Foundation (or anything else like Cocoa or UIKit that will import it implicitly) Swift automatically converts some Objective-C types to Swift types, and some Swift types to Objective-C types, and a number of data types in Swift and Objective-C can be used interchangeably. Data types that are convertible or can be used interchangeably are referred to as bridged data types.

@ Fundamental
Layering:
Everything going down on the scene navigator will be on top on the phone (because Top Layout Guide and Bottom Layout Guide are the two top items that you can place on top of visually).

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


@ Fundamental

# Deploying to Apple Store
https://www.raywenderlich.com/10868372-testflight-tutorial-ios-beta-testing


@ Fundamentals

for loop generating views cannot use regular  for loops. Must  be:
```
                    ForEach((0...persons.count-1), id:\.self) {
```

forEach doesn't  use index as iterator. It uses   $0:
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

# Detect textedit user input, etc: You have to add delegate with two steps (Storyboard dragging and coding)

Storyboard dragging: https://www.youtube.com/watch?v=jxTEzf1EY08
￼
![](https://i.imgur.com/NfraOXo.png)
![](https://i.imgur.com/HesSFi3.png)

￼
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


    - -

You don't need to explicitly import files in Swift as they are globally available through the project. If you want to access the methods or properties of Player class, you can directly make object of Player class in MainScene.Swift file and can access to it. e.g var objPlayer = Player(
https://stackoverflow.com/questions/35222044/swift-import-my-swift-class

var e:Employee = Employee()
https://youtu.be/43UOxoOuAag

https://youtu.be/FcsY1YPBwzQ

--

@Fundamentals

UI builder has a Top Layout Guide and Bottom Layout Guide that you can click in the UI navigator, and it'll show a blue line where they recommend UI controls do not pass (unless you absolutely need to - acting like a header or footer on the screen but keep in mind ios phones have rounded corner screens which would cut off your content).

Programmatically with controls. 
- Basically you need to add controls to view controller code. 
- First setup dual screens in XCode so you can control-drag to code. 
- Dragging will fail unless you meet requirement: Add Class attribute at the screen and that class is selected to the View Controlled class which was created as a new Swift file under View Controllers folder. 
- Hold CTRL key and drag the UI (the UI must be a button etc, textview DOES NOT have an action capability) to the proper swift file's code onto an empty line to create a new variable aka outlet (if you want a click handler instead, select action). The option to select outlet or action appears when you let go of the mouse  Ctrl drag: https://youtu.be/mr7pJB2eyK4?t=578 Confirming: https://youtu.be/mr7pJB2eyK4?t=525

Have control (ie button) open next screen. 
- Basically you stay in the WYSIWYG Storyboard UI and create "segues" between button to screen
- To create a segue between view controllers in the same storyboard file, Control-click an appropriate element in the first view controller and drag to the target view controller. The starting point of a segue must be a view or object with a defined action, such as a control, bar button item, or gesture recognizer. You can also create segues from cell-based views such as tables and collection views.
https://developer.apple.com/library/archive/featuredarticles/ViewControllerPGforiPhoneOS/UsingSegues.html

Adding Cocoa Pod controls to the Storyboard. It's not going to be listed when you click the + Library icon. So add the view, then go to side panel to change CLASS to the cocoa pod class, then the new options will appear for the cocoa pod control for you to customize it.

Constraint problems causing UIViews to not show?
Not  all errors show  up  on  the side panel  of scenes. Normally at the left panel of scenes you'll see a right arrow next to the scene name (remember scene is the same as view controller here). The arrow is usually yellow or red. You click that arrow and follow suggestions to fix constraints. 

But that's not there and you still have constraint problems? You may need another view of the constraints. Click the 3d  layer icon. In the 3d  view,  rotate/pan  until you have  a clear look  at the UIView whose constraints you suspect are troublesome. Right click that UIView ->  Reveal in Debug Navigator. Now on the left panel, you see all the classes both inherited and further downstream (like for UIView controls you designed) in a hierarchical navigator. Find the UIView class of interest and see if there's a purple triangle with exclamation mark  instead (instead of an arrow)

If you want yet others view of the constraints to find troublesome constraints that the AI cannot find (sometimes the human brain is better), there are two views where they lay it out for you to analyze and even be able to edit them:
a.) Where the scene side panel is at, UIViews with constraints will have a "constraints" item you can expand. You can highlight an individual constraint and press Enter, allowing you to edit the constraint directly in their language. Please keep in mind for their language, things like width less than or equal to 300 is not simply <=300; they use the actual underlined left angle bracket.
b.) The second view is in the Inspector panel. Make sure the  correct UIView whose constraints you are interested in - is selected. At the inspector panel, it's the size tab. Scroll to the bottom for all constraints. You can click Edit on a constraint. There you can select Less than or equal to in a dropdown, instead of copying and pasting the symbols ≤ and ≥. But actually, clicking Edit only lets you edit the basics - you should always double click for more finer options.

The inspector panel also lets you easily delete individual constraints. Select the constraint and press Backspace on your keyboard


---

# Segueways
Another way to have onclick button to another screen that's easier is doing it in the Storyboards themselves, called segueways:

Creating a segueway between a button to the next view controller:
￼
￼![](https://i.imgur.com/sLpkKDR.png)


![](https://i.imgur.com/6tbAP5p.png)



--

@Layering controls on top of one another

Image is covering button and label so you need to drag image below the other two.

￼![](https://i.imgur.com/94zfDEq.png)

More info: https://stackoverflow.com/questions/31748602/how-to-make-my-image-behind-my-labels


--

# Set images wizardly

Drag image file to navigator; where the swift and storyboard files are listed. XCode will make a copy into your project folder.

Click Assets.xcassets. In imagesets navigator, click +


Drag an image file from the Files Navigator into 1x or 2x or 3x etc. (may require two windows)

Now you can select an image from the side panel in an UIImage

# Set images programmatically

Eg. where ivMixoState.image is an outlet/variable to an UIImage on storyboard:
```
ivMixoState.image = UIImage(named: "L _ MixoType Engine - Collections Section Intro Graphic")
```

# Set text:

btn.setTitle("Temperament Definitions", for: .normal)
// ^ Other states are .normal, .highlighted, .disabled, .selected, .focused, .application, .reserved


lb.text = "hi"

# Change screen programmatically with:
```
        let mixoScene1VC = mainSB.instantiateViewController(withIdentifier: "MixoScene1VC") as! MixoScene1VC
        self.present(mixoScene1VC, animated:true, completion:nil)
```

But also make sure ViewController.vc has the Main storyboard pointed to (look into the File Navigator, eg. Main.storyboard) ```
	let mainSB : UIStoryboard = UIStoryboard(name: "Main", bundle:.main)
```

# Setup new project

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


# Modal Popup

There are a few ways to do this. An easy way is to create a new storyboard. Then a new scene board in it.

Go to the properties of the actual scene board (not a view controller), and select Presentation -> "Over Full Screen" (default was Automatic). 
^A good "Transition Style" for modal popup is "Cross Dissolve"
^In addition, there's a tickbox you need to tick: Is Initial View Controller

Now when designing the scene board, create another view inside the main view. And this inner view should be the smaller view that is constrained by centering horizontally and centering vertically, and constrained with fixed height and fixed width.

In addition, at the outer view, you should go to its properties and select a gray background color. Then customize that gray background color and by clicking Custom, now you can select opacity down to 20%.

Set the outer view at the Size Inspector -> Layout -> Autresizing mask. Then at the inner view, set the Size Inspector -> Layout -> Inferred (Constraints), and also at the inner view you want to adjust the X/Y/width/height to make a small modal over a gray background effect (Recommend offsetting Y, but keep in mind all constraints to the bottom of the margin will need to be offset by negative values to push them back into view)

You can have a button dismiss that "modal"
```
    @IBAction func returner(_ sender: Any) {
        dismiss(animated: true);
    }
```

# Debugging

Add breakpoints by clicking number of line. Breakpoint pauses as you reach there at the simulator.

Make breakpoints trigger only when a variable/condition met:
￼
![](https://i.imgur.com/TcidZRk.png)


When paused at a breakpoint, debugging panel shows all variables. Add more variables by right clicking - > Add expression -> Type variable name 
Gs. Can condition too?


--

@ ESSENTIALS

# private and fileprivate

Control flow - private and fileprivate variables

These two forms of access control are similar, but there are two differences.

If you mark something fileprivate it can be read anywhere in the same file it was declared – even outside the type [hence namesake fileprivate, as in private to file] On the other hand, a private property can only be read inside the type that declared it, or inside extensions to that type that were created in the same file. In practice you’re likely to see private used significantly more than fileprivate.

If you want a let variable that's also fileprivate, you code it as:L
```
fileprviate let someVariable = ...
```


# Slide down menu collapsible/expandable

You have to hide the menu and set the height constraint to 0 or some value (to collapse or to expand). Autolayout will take care of the other UI's placement. You can have a stackview with buttons and for divider - you can use a very small height view with darkgray background.  Select the height constraint from the Interface builder and take an outlet of it. So, when you want to change the height of the view you can use the below code

￼![](https://i.imgur.com/9O9GJhp.png)


yourHeightConstraintOutlet.constant = someValue
yourView.layoutIfNeeded()

It is helpful when you are setting the constraints programmatically. It updates constraints for the view. For more detail click here.

From: https://stackoverflow.com/questions/42669554/how-to-update-the-constant-height-constraint-of-a-uiview-programmatically


# Image background not clipping in button

Go to Attribute Inspector and set View -> Content Mode -> Scale to Fill   OR:
    ImageBn.imageView?.contentMode = .scaleAspectFit
    ImageBn.setImage(chosenImage, for: .normal)

Have your button "type" set to custom from the Attribute Inspector

# Mixing objective c to swift:
￼
![](https://i.imgur.com/w1bpDHg.png)

    @objc func update() {
        // Something cool
    }

# UI Storyboard setups
- LaunchScreen.storyboard is the splash screen when the app is still being loaded into iOS memory
- Main.storyboard is the rest of your screens

# Constraint error about equal but also equal plus? Change the constraint in Inspector -> Ruler to less than or equal to.

# Want text view to stretch/shrink the height depending on text content? Disable scrolling in properties ("Scrolling Enabled"). Not well documented by Apple. But reasoning:
https://stackoverflow.com/questions/38714272/how-to-make-uitextview-height-dynamic-according-to-text-length
https://stackoverflow.com/questions/16868117/uitextview-that-expands-to-text-using-auto-layout/65861960#65861960

# Mixed bold and normal texts

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


# Multiline Placeholder text
Look into the Cocoa Pod KMPlaceholderTextView

Then add a view and change the Class to KMPlaceholderTextView in the side panel

Then the placeholder option appears in the side panel


Divider line using special character:
 ⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯⎯

Multiple simulated screens of a storyboard, with different devices each:
Look for that overlapping circles icon: https://developer.apple.com/library/archive/documentation/ToolsLanguages/Conceptual/Xcode_Overview/UsingtheWorkspaceToolbar.html#//apple_ref/doc/uid/TP40010215-CH29-SW1 And follow instructions from "To achieve multiple live previewing of different screens":
https://www.twilio.com/blog/2018/05/xcode-auto-layout-swift-ios.html

Font awesome icons
Remember two styles - solid vs regular
https://medium.com/@umairhassanbaig/ios-how-to-use-font-awesome-in-xcode-project-b8ef255973a3

Get the web font then either the solid or regular set depending on your icon. At the cheat sheet, you'll want to copy from the solid or regular tab
https://fontawesome.com/v5/cheatsheet

     -

Make the simulated screen bigger/wider in Storyboard:
You can turn on ability to resize the scenes in the canvas by making it Freeform instead of Fixed: Click first orange icon above the scene -> Inspector panel shows up on the right -> View Controller -> Size tab -> Stimulated Size -> Freeform -> Resize the actual scene in the canvas by dragging.
But then the insid view doesn't fill up the canvas, so next, in the Inspector panel -> Attributes tab -> Simualted Metrics -> Size: -> Secondary.

     -

Editor errors
Try deleting Derived folder
```
rm -rf ~/Library/Developer/Xcode/DerivedData
```

(DerivedData is a folder located in ~/Library/Developer/Xcode/DerivedData by default. ... It's the location where Xcode stores all kinds of intermediate build results, generated indexes, etc.)

--

& Blue safe area is wider than the simulator view so all the UIViews you add constraints for centering or relative to margins - they don't show up on your phone/simulator.

Safe area is glitched so when you add constraits relative to safe area margin or the center (at 0 relative to container), then the UI view may be clipped off from your phone screen. 
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
