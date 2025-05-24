For the React setups: [[Mixed Web Server - Reverse Proxied CRA React app]]

For the JS manipulations of links (that can be on top of React): [[_REFERENCE - Frontend sourcing, hrefing, and js locationing after migrating to a server with base url]]

---

React Router:

When you run on the server, the npm run script needs to only run the server/server.js. when served, that built may have problems if there’s react routes. This is the solution:

```
function App() {
	const basepath = process.env.REACT_APP_REACT_ROUTER_BASEPATH || '/';
	return (
		<Router basename={basepath}>
			<Switch>
				<Route exact path="/" component={HomePage} />
				<Route path="/about" component={AboutPage} />
				{/* Other routes */}
			</Switch>
		</Router>
	);
}
```

So then you have to modify client/.env. Make sure to rebuild the client/build

^ Note the env variable name must be preceded REACT_APP_ . In a Create React App (CRA) project automatically brings in .env variables without the need to manually import dotenv. However, only variables prefixed with REACT_APP_ are included in the React app's build process.