NOTE: Bower is deprecated. It's kept here for archival purposes. Refer to [[Bower deprecated]]

### **Quick Guide to Bower.js**

Bower is a **package manager for the web** that was popular for managing front-end dependencies like JavaScript and CSS libraries. However, it has been **deprecated** in favor of modern tools like npm and Yarn. If you still need to use Bower, here’s a quick guide:

---

## **1. Install Bower**

Bower requires **Node.js** and **npm**. Install it globally using:
```
npm install -g bower
```

Check if Bower is installed:
```
bower -v
```

---

## **2. Initialize a Bower Project**

Navigate to your project directory and run:
```
bower init
```

It will ask for project details and generate a `bower.json` file, similar to `package.json`.

---

## **3. Install a Package**

Use `bower install` to fetch libraries:
```
bower install jquery --save
```

- The `--save` flag adds the dependency to `bower.json`.
- By default, files are stored in the `bower_components/` directory.

---

## **4. Install Multiple Dependencies**

Add dependencies directly to `bower.json`:
```
{  
  "dependencies": {  
    "jquery": "^3.6.0",  
    "bootstrap": "^5.0.0"  
  }  
}  
```

Then, install all dependencies:
```
bower install
```

---

## **5. Search for Packages**

Find available libraries using:
```
bower search bootstrap
```

---

## **6. Uninstall a Package**

To remove a package:
```
bower uninstall jquery --save
```

---

## **7. Update Dependencies**

To update all installed packages:
```
bower update
```

---

## **8. Specify a Custom Install Directory**

By default, Bower installs to `bower_components/`. You can change this by creating a `.bowerrc` file:
```
{  
  "directory": "vendor/"  
}  
```

---

## **9. Use Installed Packages in HTML**

After installation, include the dependencies in your project:
```
<script src="bower_components/jquery/dist/jquery.min.js"></script>  
```

---

## **10. Why Bower is Deprecated?**

- The front-end ecosystem has shifted to using `npm` and `yarn`.
- Most libraries are now published via `npm`.
- Bower officially recommends using **Yarn, Webpack, or npm** instead.