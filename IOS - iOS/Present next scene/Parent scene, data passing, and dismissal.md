

## Parent with child view or modal added

In the context of iOS development using Xcode, managing views and view controllers is a fundamental concept. When you're developing an iOS app, you often need to add new views to your app's interface or present information in a new context. This can be achieved in two primary ways: adding a child view to a parent view and presenting a view controller modally.

### Adding a Child View to a Parent View

When you add a child view to a parent view, you're essentially embedding a new view controller's view within the current view controller's view hierarchy. This is a common approach to construct complex user interfaces where multiple view controllers need to interact with each other within the same screen. Here's how it generally works:

1. **Create and Configure the Child View Controller**: You instantiate the child view controller and configure its properties and data.

2. **Add the Child View Controller to the Parent**: You inform the parent view controller about the new child view controller by calling the `addChildViewController(_:)` method.

3. **Add the Child View Controller's View**: You add the child view controller's view to the parent's view hierarchy, usually by using `addSubview(_:)` on the parent's view.

4. **Finalize the Addition**: You call `didMove(toParentViewController:)` on the child view controller to signal that the addition is complete.

This approach is non-disruptive, meaning the user can still interact with the remaining parts of the parent view that are not covered by the child view.

### Presenting a View Controller as a Modal

Presenting a view controller modally is a different approach. It's used to focus the user's attention on a new set of information or actions without maintaining a visible connection to the previous content. Here's the typical flow:

1. **Instantiate the View Controller**: You create an instance of the view controller that you want to present.

2. **Configure the Presentation Style**: You can configure how the view controller appears (e.g., full screen, as a sheet, etc.).

3. **Present the View Controller**: You call `present(_:animated:completion:)` on the current view controller, passing in the view controller to be presented.

The modal presentation takes over the entire screen (or part of it, depending on the style), blocking interaction with the underlying content until the modal is dismissed.

----

## Dismissing a View Controller

### Dismissing a Modal View Controller

When you present a view controller modally, it creates a new view hierarchy that is separate from the current view hierarchy. Dismissing a modal view controller involves calling `dismiss(animated:completion:)` on the presenting view controller (or the modal view controller itself, which will forward the request to the presenting view controller). This method removes the modal view controller from the screen and deallocates its resources if there are no other references to it.

**Example: Dismissing a Modal View Controller**

```swift
class ParentViewController: UIViewController {
    func presentModal() {
        let modalVC = ModalViewController()
        present(modalVC, animated: true, completion: nil)
    }

    func dismissModal() {
        dismiss(animated: true, completion: {
            print("Modal dismissed.")
        })
    }
}
```

### Removing a Child View Controller or a Modal

When you add a child view controller to a parent, you're embedding its view within the parent's view hierarchy and establishing a parent-child relationship in the view controller hierarchy. To properly remove a child view controller, you should reverse the steps you took to add it:

1. Inform the child view controller that it will be removed.
2. Remove the child view controller's view from its superview.
3. Call `removeFromParentViewController()` to remove the child view controller from its parent.

**Example: Removing a Child View Controller**

```swift
class ParentViewController: UIViewController {
    var childVC: ChildViewController?

    func addChildController() {
        let child = ChildViewController()
        addChild(child)
        view.addSubview(child.view)
        child.didMove(toParent: this)
        childVC = child
    }

    func removeChildController() {
        childVC?.willMove(toParent: nil)
        childVC?.view.removeFromSuperview()
        childVC?.removeFromParent()
    }
}
```

In summary, while `dismiss(animated:completion:)` is used for modal view controllers, a similar method isn't used for child view controllers. Instead, removing a child view controller involves explicitly managing the view and view controller hierarchies.

---


## Passing Data - Concept

Whether a child view or a modal view has access to variables from the parent view controller depends on how you structure your code and pass data between the view controllers. Here's a breakdown of how data access and sharing can be managed in both scenarios:

### Child View Controllers

When you add a child view controller to a parent view controller, the child can access the parent's variables if they are exposed appropriately. Since the child has a reference to its parent, it can access any properties or methods that are publicly available on the parent view controller. However, this access should be managed carefully to maintain good encapsulation practices. Here's how you might grant access:

- **Direct Access**: If the child view controller has a property or method that directly references the parent, it can access any public or internal properties of the parent. For example, if you have a `parentViewController` property in the child that is set when the child is added, the child can use this property to access the parent's variables.

- **Delegation**: Another cleaner and more decoupled way is to use delegation. The parent view controller can conform to a protocol, and the child view controller can have a delegate property of that protocol type. Through this delegate, the child can communicate with the parent or access the necessary data without having direct access to the parent's entire interface.

### Modal View Controllers

In the case of modal view controllers, the presented view controller does not have a direct reference to the presenter view controller by default. However, you can explicitly pass data or references between the two:

- **Pass Data Before Presentation**: Before presenting the modal view controller, the parent can set properties on the modal view controller to pass data. This is typically done after instantiation but before presentation.

- **Delegation**: Similar to the child view scenario, you can use a delegation pattern. The presenting view controller can conform to a protocol that the presented (modal) view controller defines. Before presenting the modal, you assign the presenting view controller as the delegate. This way, the modal can communicate back to the presenting view controller.

- **Completion Handlers**: For modal view controllers, you can also use completion handlers to return data when the modal is dismissed. The presenting view controller can define a completion block when presenting the modal, and the modal can execute this block with any relevant data before or during its dismissal.

- **Unwind Segues**: In Storyboards, you can use unwind segues to pass data back to the presenting view controller when a modal is dismissed.

In both child view and modal scenarios, while there is a mechanism to access or transfer data between the parent and the child or modal, it's essential to design these interactions thoughtfully to maintain a clear separation of concerns and encapsulation within your app's architecture.

---

## Passing Data - Implementation

Let's provide some concrete examples in Swift to illustrate how a child view controller and a modal view controller can access or receive data from their parent view controller.

### Child View Controllers

#### Direct Access

In this example, the child view controller has a direct reference to the parent view controller and accesses a variable from the parent.

**ParentViewController.swift:**

```swift
class ParentViewController: UIViewController {
    var parentVariable = "Hello from Parent"

    func addChildController() {
        let childVC = ChildViewController()
        childVC.parentVC = self  // Passing reference of parent to the child
        addChild(childVC)
        view.addSubview(childVC.view)
        childVC.didMove(toParent: self)
    }
}

```

**ChildViewController.swift:**

```swift
class ChildViewController: UIViewController {
    weak var parentVC: ParentViewController?

    func accessParentVariable() {
        if let message = parentVC?.parentVariable {
            print(message)  // Outputs: Hello from Parent
        }
    }
}
```

#### Delegation

Here, we use delegation to allow the child to communicate with the parent without directly accessing its properties.

**ParentViewController.swift:**

```swift
protocol ChildViewControllerDelegate: AnyObject {
    func getParentVariable() -> String
}

class ParentViewController: UIViewController, ChildViewControllerDelegate {
    var parentVariable = "Hello from Parent"

    func addChildController() {
        let childVC = ChildViewController()
        childVC.delegate = self
        addChild(childVC)
        view.addSubview(childVC.view)
        childVC.didMove(toParent: self)
    }

    func getParentVariable() -> String {
        return parentVariable
    }
}
```

**ChildViewController.swift:**

```swift
class ChildViewController: UIViewController {
    weak var delegate: ChildViewControllerDelegate?

    func useDelegate() {
        if let message = delegate?.getParentVariable() {
            print(message)  // Outputs: Hello from Parent
        }
    }
}
```

### Modal View Controllers

#### Pass Data Before Presentation

Here, the parent view controller passes data to the modal view controller before presenting it.

**ParentViewController.swift:**

```swift
class ParentViewController: UIViewController {
    var parentVariable = "Hello from Parent"

    func presentModal() {
        let modalVC = ModalViewController()
        modalVC.receivedData = parentVariable  // Passing data to the modal
        present(modalVC, animated: true, completion: nil)
    }
}
```

**ModalViewController.swift:**

```swift
class ModalViewController: UIViewController {
    var receivedData: String?

    override func viewDidLoad() {
        super.viewDidLoad()
        if let data = receivedData {
            print(data)  // Outputs: Hello from Parent
        }
    }
}
```

#### Using Delegation

The parent view controller acts as a delegate for the modal view controller to provide data or perform actions.

**ParentViewController.swift:**

```swift
protocol ModalViewControllerDelegate: AnyObject {
    func getParentVariable() -> String
}

class ParentViewController: UIViewController, ModalViewControllerDelegate {
    var parentVariable = "Hello from Parent"

    func presentModal() {
        let modalVC = ModalViewController()
        modalVC.delegate = self
        present(modalVC, animated: true, completion: nil)
    }

    func getParentVariable() -> String {
        return parentVariable
    }
}
```

**ModalViewController.swift:**

```swift
class ModalViewController: UIViewController {
    weak var delegate: ModalViewControllerDelegate?

    func useDelegate() {
        if let message = delegate?.getParentVariable() {
            print(message)  // Outputs: Hello from Parent
        }
    }
}
```

These examples illustrate how a child view controller and a modal view controller can access data from their parent view controller using different methods, ensuring a clear separation of concerns and encapsulation within the app's architecture.