

# How it works

react-scripts will insert the <src src='...bundled.min.js' automatically into <body> at index.html (react-scripts also run the build tools required to transform React JSX syntax into plain JavaScript programmatically)

# JSX

JSX is a mix of javascript with HTML/XML styled tags (which has opening and closing <> pairs and attributes). The HTML/XML styled tags can be a mix of HTML tags and React components (which you define as a function and return JSX).

When mixing javascript expressions (if statements, function calls) or variables into attributes, you must escape the HTML/XML with curly brackets { } . So to recap, you escape with {} when:
-javascript expression
-variables into attributes

## Limitations of JSX

Must use className for class attribute.

DOM traversal then direct assignment of attributes, text, html, not allowed. React could reset the DOM on rerenders

# Creating a JSX project

npx create-react-app <Your app name>

npm run build

npm run start

Explanation: npx executes node packages that can directly be executable, and in this case receiving your app name; then it creates a folder of the same name, and pulls in boilerplate code such as src/, public/ etc
Your building will create a /build tool that index.html in public uses. Start will open the website on your browser

# Deploying React app to Github Pages

Refer to [[Deploy React to Github Pages]]