
**The full text of the error you just encountered is:**
`**Element type is invalid: expected a string (for built-in components) or a class/function (for composite components) but got: object.**`


You probably forgotten to `export default` on one of the modules you imported, and that's why it's an invalid element type. As for the data types it complained of, that's just how React works internally.