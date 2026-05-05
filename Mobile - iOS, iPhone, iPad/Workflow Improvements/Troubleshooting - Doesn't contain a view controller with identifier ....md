
Common error: 
Doesn't contain a view controller with identifier '...'' terminating with uncaught exception of type NSException

"I was having the same issue, but I could not find the "Identifier" field in the inspector. Instead, just set the field named "Storyboard ID" to what you would name the Identifier. This field can be found under the "Show the Identity inspector" tab in the inspector."

---

The error you're encountering in Xcode, "Doesn't contain a view controller with identifier '...'' terminating with uncaught exception of type NSException," typically occurs when there's a mismatch or absence of the view controller identifier in your storyboard. This identifier is crucial for your code to be able to reference and instantiate the correct view controller.

When you face this issue, the solution is often related to setting the correct identifier in your storyboard. Here's a step-by-step guide to resolve this:

1. **Open Your Storyboard**: First, you need to open the storyboard file where your view controller is defined.

2. **Select Your View Controller**: In the storyboard, click on the view controller that you're trying to reference in your code.

3. **Access the Identity Inspector**: With the view controller selected, open the Identity Inspector. You can do this by clicking on the icon that looks like a small ID card, usually located at the top-right section of Xcode, or you can press the shortcut `Option + Command + 3`.

4. **Set the Storyboard ID**: In the Identity Inspector, there's a field named "Storyboard ID". This is what your error message refers to as the identifier. Set this field to the identifier you're using in your code to reference this view controller. Ensure that this ID is unique within the storyboard.

5. **Consistency Check**: Make sure the identifier you set in the Storyboard ID field matches exactly what you're using in your code. This includes checking for any typos or case sensitivity issues.

6. **Use the Identifier in Code**: When instantiating your view controller in code, use the same identifier you've set in the Storyboard ID field. For instance, if you're using a UIStoryboard to instantiate the view controller, ensure the identifier matches.

7. **Build and Run**: After making these changes, build and run your project again to see if the issue is resolved.

This process should help you resolve the error by ensuring that there's a direct and correct mapping between the view controller in your storyboard and the identifier you're using in your code. If the issue persists, double-check the consistency of your identifiers and ensure there are no typos or mismatches.

---

Certainly! Let's go through a concrete example where we'll set up a storyboard identifier and reference it in the code to instantiate a view controller.

### Storyboard Setup

1. **Open your storyboard**: Let's say it's `Main.storyboard`.
  
2. **Select the View Controller**: Click on the view controller that you want to reference. This view controller might be intended to show details of an item, for example.

3. **Open the Identity Inspector**: Access the Identity Inspector by clicking on the icon resembling an ID card, or use `Option + Command + 3`.

4. **Set the Storyboard ID**: In the Identity Inspector, find the field labeled "Storyboard ID" and set it to a unique identifier, such as `DetailViewController`.

![Storyboard ID Field](https://developer.apple.com/library/archive/documentation/ToolsLanguages/Conceptual/Xcode_Overview/Art/6_identityinspector_2x.png)

### Code Implementation

Now, let's use this identifier in the code to instantiate `DetailViewController`.

Assume you have a segue or an action where you want to programmatically transition to `DetailViewController`. You can instantiate it using the storyboard ID you just set:

```swift
if let detailViewController = storyboard?.instantiateViewController(withIdentifier: "DetailViewController") as? DetailViewController {
    // Now you can push this view controller onto the navigation stack, present it modally, or customize it before displaying
    navigationController?.pushViewController(detailViewController, animated: true)
}
```

In this code:

- `instantiateViewController(withIdentifier:)` method is used to instantiate the view controller with the identifier we set in the storyboard.
- We cast it to `DetailViewController` to ensure we can interact with its properties and methods.
- Finally, we push the `detailViewController` onto the navigation stack. You could also present it modally or add it as a child view controller, depending on your needs.

By setting the "Storyboard ID" in the storyboard and referencing it in the code like this, you bridge the storyboard UI with your Swift code, enabling dynamic instantiation and navigation between view controllers.