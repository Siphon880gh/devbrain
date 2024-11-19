When creating a full stack React app:

React uses the browser's native ES modules
import __ from "__"
export default...

Node uses CommonJS modules:
const __  = require("__");
module.exports = ...

Either one, when going relative path to a file, precede with "./"