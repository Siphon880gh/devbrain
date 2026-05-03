Error "Extra inputs are not permitted"
Interpretation? It's a vague error

![[Pasted image 20250209192647.png]]

Just get rid of the default values for your Input controls (that appear on the component card in canvas)

For example, in this error you're encountering indicates that Pydantic's `StrInput` class does not accept a `default` parameter, leading to a validation error when it's provided. To resolve this issue, you can remove the `default` parameters from the `StrInput` field.

**But need default values**:
If you must have default values, you can handle default values within the `process_message` method.