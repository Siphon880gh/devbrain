Aka Get Started

## The Role of Standards in Modern Software Development

In today’s fast-paced software development environment, standards are the backbone of quality, consistency, and scalability. They provide clear guidelines and frameworks for teams to build reliable and efficient software, empowering developers and platform engineers alike. Standards foster collaboration and ensure projects align with organizational goals, enabling teams to work with confidence and efficiency.

This article explores key software development standards, best practices, and tools to enhance your workflow and ensure success.

---

### What Are the Software Development Standards?

Software development standards are established guidelines that define best practices for creating software. They promote consistency, reliability, and efficiency across projects. Below are key categories of standards every DevOps professional should understand:

The Role of Standards in Modern Software Development
What Are the Software Development Standards?
1. **Tooling Standards**
	- 1.1 Code Standards
	- 1.2. **Lint and Prettier Configuration**
	- 1.3. **VS Code Settings**
		- **What to Include in Shared Settings**
		- **Best Practices for Sharing VS Code Settings**
	- 1.4. **Commit Message Guidelines**
	- 1.5 Branching and Merging Strategies
	- 1.6 **Testing Framework Standards**
		- Node.js
		- Python
		- Common Testing Standards
	- 1.6 Logging Standards
2. **Styling**
	- 2.1. **BEM, CSS Preprocessors, White-Labeling, Z-Index Conventions**
	- 2.2. **z-index Magnitudes and Layering**
3. **Responsive Design and Device Compatibility** 
	- 3.1. Embrace a Mobile-First Approach 
	- 3.2. Use Media Queries Strategically 
	- 3.3. iOS and Safari Quirks
	- 3.4. Avoiding JavaScript & HTML Quirks in Responsiveness 
	- 3.5. Testing Across Real Devices 
	- 3.6. Key Takeaways for Responsive Standards
4. **Code Design Standards**
	- 4.1 **Algorithms and Data Structures**
	- 4.2 **Design Patterns for Maintainable Code**
	- 4.3 **Object-Oriented Programming (OOP)**
	- 4.4 **JavaScript Modules**
	- 4.5 **MVC or Other Architectural Patterns**
	- 4.6 **State Management**
	- 4.7 **Module Initialization and Event Binding**
5. **Scaling Strategies**
	- 5.1 Fetch vs SSE vs WebSockets
	- 5.2. N-tier architecture
	- 5.3 Microservice architecture if needed
	- 5.4. Server level Scaling
	- 5.5. Consistent Environment
	- 5.6. Persistent Services
6. **Versioning and Caching**
	- 6.1 **Aligning Versioning with Git Commits**
	- 6.2 **Service Workers and PWA Versioning**
	- 6.3 **Cache-Busting in a PHP Application**
	- 6.4 **Aggressive Caching on iPad**:
	- 6.5 **Create React App (CRA) and Vite Hash Filenames**
	- 6.6 **Combining Git Versioning with Asset Hashing**
	- 6.7 **Key Takeaways for Versioning and Caching**
7. **Secure Coding Practices**
	- 7.1. CMS, Web Panels, etc
	- 7.2.Dot env
	- 7.3. Persistent Login
	- 7.4. Injection Prevention
	- 7.5. Passwordless SSH Root Access
	- 7.6. Ports and Reverse Proxy
	- 7.7 Error Handling Securely
	- 7.8. Handling Secrets
	- 7.9. Keep up to date on security practices

#### 1. **Tooling Standards**

##### 1.1 Code Standards
Readable and maintainable code begins with consistent formatting. Standards define indentation, naming conventions, and structure, streamlining collaboration and debugging.

- **Naming Conventions**: Adopt clear and consistent naming conventions for variables, functions, files, and classes (e.g., `camelCase` for JavaScript or `PascalCase` for React components).
- **Directory Structure**: Define a logical and scalable directory layout to organize files by functionality (e.g., `src/`, `tests/`, `components/`).
- JavaScript Commenting Guidelines: Commenting is vital for code maintainability and readability. Follow these guidelines:
	- **Purposeful Comments**: Add comments only where the intent of the code might not be immediately obvious. Avoid redundant comments that restate the code.
	- **Consistent Format**: Use block comments (`/* */`) for documentation and inline comments (`//`) sparingly for clarifications.
	- **JSDoc for Automation**: Use JSDoc to automate documentation generation and improve consistency. Example:

```javascript
/**
 * Calculates the area of a rectangle.
 * @param {number} width - The width of the rectangle.
 * @param {number} height - The height of the rectangle.
 * @returns {number} The area of the rectangle.
 */
function calculateArea(width, height) {
  return width * height;
}
```

- **Tooling**: Generate API documentation automatically with tools like **JSDoc** or **TypeDoc**.

##### 1.2. **Lint and Prettier Configuration**

- **Linting**: Use **ESLint** (JavaScript/TypeScript) or **Pylint** (Python) with a shared configuration to enforce coding standards.
- **Prettier**: Standardize code formatting with Prettier. Example `.prettierrc`:

```json
{
  "semi": true,
  "singleQuote": true,
  "trailingComma": "es5",
  "tabWidth": 2,
  "printWidth": 80
}
```

##### 1.3. **VS Code Settings**
###### **What to Include in Shared Settings**

1. **Workspace Settings:**
    - Language-specific configurations, like linting and formatting rules (`.vscode/settings.json`).
    - Excluded files/folders from search or Git.
2. **Extensions:**
    - Essential extensions for the project (e.g., Prettier, ESLint, Python, Live Server).
    - Use `.vscode/extensions.json` to define recommended extensions for the project.
3. **Code Formatting:**
    - Rules for indentation, trailing commas, quotes, line endings, etc.
    - Use tools like Prettier or ESLint for automation.
4. **Snippets:**
    - Shared code snippets for repetitive tasks or common code patterns.
5. **Keybindings (Optional):**
    - If the team prefers consistent shortcuts for common actions.

###### **Best Practices for Sharing VS Code Settings**

1. **Use a Repository for Settings:**
    - Store shared settings in the project repository under a `.vscode` folder.
    - Example:
        `.vscode/   settings.json   extensions.json`
        
2. **Automation:**
    - Use a setup script or documentation to guide team members in installing required extensions and applying settings.
3. **Enforce Style Rules:**
    - Use tools like `.editorconfig`, Prettier, or ESLint for consistent formatting across IDEs.
4. **Document Team Guidelines:**
    - Include a section in your project's README or internal documentation about how to set up the environment.
5. **Allow Some Flexibility:**
    - Recognize that some settings (like themes or fonts) may be personal preferences and don’t need to be standardized.

##### 1.4. **Commit Message Guidelines**

Use a consistent format for commit messages to improve readability and collaboration:

- **Format**: `type(scope): short description` (e.g., `feat(auth): add login form validation`).
- **Types**: Common types include `feat`, `fix`, `chore`, `docs`, `style`, and `test`.

##### 1.5 Branching and Merging Strategies
- **Branch Naming:**
    - Use descriptive branch names:
        - `feature/<feature-name>` for new features.
        - `bugfix/<bug-description>` for fixing bugs.
        - `hotfix/<hotfix-description>` for urgent production fixes.
        - `release/<version>` for preparing releases.
    - Example: `feature/add-login-api` or `bugfix/fix-404-error`.
- **Branching Model:**
    - Follow **Git Flow** or **Trunk-Based Development** depending on team size and deployment frequency.
        - **Git Flow:**
            - `main` for production-ready code.
            - `develop` for ongoing development.
            - Use feature branches merged into `develop`.
            - Merge to `main` via a release branch.
        - **Trunk-Based Development:**
            - Single `main` branch.
            - Short-lived feature branches merged back quickly.
- **Pull Request Standards:**
    - Require code reviews with at least one approver. That approver should not be the same person who pushed the code up.
    - Ensure PR descriptions are detailed and reference related issues.
    - Test coverage required before merging.
- **Merging:**
    - Use **rebase** for cleaner commit history in feature branches.
    - Use **merge commits** to preserve history when integrating into `main` or `develop`.

##### 1.6 **Testing Framework Standards**

###### Node.js

- **Frameworks:** Use `Jest` or `Mocha` + `Chai`.
- **Standards:**
    - Write unit tests for all critical functions and modules.
    - Include integration tests for API endpoints or critical workflows.
    - Use code coverage tools like `nyc` or Jest’s built-in coverage reports.
    - Example with Jest:
	```
	describe("User API", () => {
	  it("should return user data", async () => {
	    const response = await request(app).get("/api/user");
	    expect(response.status).toBe(200);
	    expect(response.body).toHaveProperty("name");
	  });
	});
	```
###### Python
- **Frameworks:** Use `pytest` for simplicity and scalability.
- **Standards:**
    - Test directory structure:
	```
	/tests
	  test_module1.py
	  test_module2.py
	```
        
    - Mock external dependencies using libraries like `unittest.mock` or `pytest-mock`.
    - Enforce code coverage with `pytest-cov`.
    - Example:
	```
	import pytest
	from app import get_user
	
	def test_get_user():
	    user = get_user(1)
	    assert user["id"] == 1
	    assert user["name"] == "John Doe"
	```

###### Common Testing Standards

- Automate tests with CI pipelines (e.g., GitHub Actions, CircleCI, Jenkins).
- Define test coverage thresholds (e.g., 80%+).
- Tag tests (`@slow`, `@fast`) for grouping and prioritization.

##### 1.6 Logging Standards

###### Node.js
- **Library:** Use `Winston` for logging. It is versatile, supports multiple transports, and provides log levels.
- **Standards:**
  - Configure log levels (e.g., `error`, `warn`, `info`, `debug`) based on the environment.
  - Use JSON format for structured logging.
  - Separate transports for:
    - Console logs in development.
    - File logs for production.
    - External services like AWS CloudWatch or Elasticsearch (if needed).
  - Example:
    ```javascript
    const winston = require('winston');
    const logger = winston.createLogger({
      level: process.env.LOG_LEVEL || 'info',
      format: winston.format.json(),
      transports: [
        new winston.transports.Console(),
        new winston.transports.File({ filename: 'app.log' }),
      ],
    });

    module.exports = logger;
    ```

###### Python
- **Equivalent Library:** Use `logging` or `loguru` for simplicity and advanced features.
- **Standards:**
  - Use the `logging` module for standardization, or `loguru` for enhanced features.
  - Define log levels (`DEBUG`, `INFO`, `WARNING`, `ERROR`, `CRITICAL`).
  - Structure logs in JSON if used with monitoring tools (e.g., ELK Stack).
  - Example:
    ```python
    import logging

    logging.basicConfig(
        level=logging.INFO,
        format="%(asctime)s - %(levelname)s - %(message)s",
        handlers=[
            logging.StreamHandler(),
            logging.FileHandler("app.log")
        ]
    )
    logger = logging.getLogger("app")

    logger.info("This is an info log")
    logger.error("This is an error log")
    ```

For either NodeJS or Python, you may want to log to a folder outside of the app and have the team informed where the logs are. You may still log into the app folder, but:
- Make sure the app's nested log folder is secured from internet user access (because it may reveal sensitive details on crashing) using apache htaccess or nginx vhost
- You may gitignore the nested log folder to prevent polluting git diff.

---
#### 2. **Styling**

##### 2.1. **BEM, CSS Preprocessors, White-Labeling, Z-Index Conventions**

A standardized approach to CSS ensures consistent styling across projects while providing flexibility for scaling and maintainability:

- **Class Naming Conventions**: Use consistent conventions like **BEM** or utility-first frameworks such as **Tailwind CSS** to maintain modularity and scalability. Example:
    
    - **BEM**: `card__header--highlighted`
    - **Utility-First**: `bg-blue-500 text-white rounded-lg`
- **Generated Style Guides**: Use tools like **Style Dictionary** or **Storybook** to document and visualize reusable styles and components.
  
- **CSS Preprocessors**: Use tools like **SASS** or **LESS** to simplify CSS management. These preprocessors enable features such as variables, nesting, and mixins, making the code more modular and maintainable.
    - **Compass**: For projects using SASS, consider integrating **Compass**, a powerful CSS authoring framework that adds utility functions, mixins, and best practices.
	- **Precompiled CSS**: Establish an agreed standard for precompiling styles during the build process, ensuring faster load times and consistent delivery. This approach integrates well with CI/CD pipelines.
    
- **White-Labeling**: If future white-labeling is a possibility, design CSS with flexibility in mind:
    
    - Use **CSS variables** or SASS variables for branding elements like colors, typography, and logos, making it easy to rebrand the application. Example:
        
	```
	$primary-color: #4f46e5;
	$secondary-color: #64748b;
	$font-base: 'Inter', sans-serif;
	
	body {
		font-family: $font-base;
		color: $primary-color; 
	}
	```
        
    - Abstract styles for core components (e.g., buttons, headers) into reusable, themable classes or mixins.
        
##### Key Considerations for Future White-Labeling

1. **Dynamic Theming**: Use runtime theming solutions (e.g., CSS variables or React Context APIs) to allow customers to customize their brand-specific look and feel dynamically.
2. **Component Encapsulation**: Keep components encapsulated and separate style-related logic to minimize the risk of unwanted overrides during white-labeling.
3. **Modular Architecture**: Structure CSS files and SASS partials for modularity, allowing easy overrides and adjustments for individual themes.
4. **Branding Tokenization**: Define tokens for branding elements (e.g., `$button-primary-color`, `$header-font-size`) to make rebranding as simple as updating a configuration file.

##### 2.2. **z-index Magnitudes and Layering**

When multiple UI elements (e.g., dropdowns, tooltips, modals) overlap, a clear **z-index** policy helps avoid unintended collisions and maintain predictable layering:

- **0–10**
    
    - **Usage**: Base layer for page content, images, text, or static components that typically stay beneath overlays.
    - **Reason**: Ensures standard content doesn’t override interactive elements or dialogs.
- **10–99**
    
    - **Usage**: Interactive overlays such as dropdown menus, tooltips, and pop-ups that must appear on top of base content.
    - **Reason**: This intermediate layer keeps them above everyday content but still below critical dialogs.
- **100–119**
    
    - **Usage**: High-priority elements like modals, alerts, or other UI components demanding immediate user attention.
    - **Reason**: Guarantees these must-have elements appear above all other layers, including secondary overlays.

**Why Reserve These Ranges?**

1. **Predictability**: Team members can quickly identify correct z-index values without guesswork or “fighting” with existing overlays.
2. **Scalability**: If you need new, even higher-priority layers (e.g., global notifications), you can simply allocate another band (e.g., `120–129`).
3. **Maintainability**: Defining these bands in a centralized location (e.g., a SASS variables file) ensures consistent usage across the codebase.

**Example (SASS Variables)**

```scss
// _zindex.scss
$z-index-base: 0 !default;      // 0–10
$z-index-overlay: 10 !default;  // 10–99
$z-index-modal: 100 !default;   // 100–119
```

By sticking to these defined “bands,” you ensure a clean, conflict-free layering strategy that keeps your UI both functional and intuitive.

---

### 3. **Responsive Design and Device Compatibility**

Ensuring your styles adapt seamlessly to different screen sizes is critical for a modern web application. While media queries and fluid layouts are standard techniques, certain quirks—especially on iOS—require special attention. Below are best practices for **responsive design** purely in CSS, with minimal reliance on JavaScript or non-standard HTML.

##### 3.1. Embrace a Mobile-First Approach

- **Fluid Layouts**: Start with simpler, single-column layouts for smaller screens; use CSS media queries to enhance for larger viewports (e.g., tablets, desktops).
- **Scalable Typography**: Use `rem` or `em` units instead of fixed `px` values for fonts. This ensures sizes scale properly across various devices.

```scss
@media (min-width: 640px) {
  body {
    font-size: 1.125rem; // 18px
  }
}
```

##### 3.2. Use Media Queries Strategically

- **Breakpoints**: Define logical breakpoints based on content needs rather than specific device sizes (e.g., `480px`, `640px`, `1024px`).
- **Modular Approach**: Keep related media queries in the same file or logical SASS partial to maintain clarity.
- **Preprocessor Benefits**: SASS and LESS allow nesting media queries within component-specific styles, improving readability.

```scss
.component {
  background-color: $primary-color;

  @media (min-width: 768px) {
    background-color: $secondary-color;
  }
}
```

##### 3.3. iOS and Safari Quirks

iOS Safari can behave unpredictably with fixed elements, `overflow` properties, and certain caching rules:

- **Viewport Meta Tag**: Always include `<meta name="viewport" content="width=device-width, initial-scale=1.0">` in your HTML to ensure proper scaling.
- **Fixed Positioning**: If you have fixed or sticky headers and footers, test thoroughly on iOS Safari to avoid scrolling or zoom issues. Consider using `position: sticky; top: 0;` where possible.
- **Double Tap Zoom**: iOS may zoom in when tapping elements quickly. Setting appropriate font sizes (16px or above) and using the `viewport` meta tag helps mitigate this behavior. Refer to [[Preventing iOS Double-Tap Zoom with the Viewport Meta Tag]]
- **Aggressive Caching on iPad**:
    - Use **Cache-Control** headers or versioned file names (`styles.v2.css`) to manage updates properly.
    - For rapid iteration or debugging, temporarily disable client-side caching with no-store directives.
    - Refer to [[iPad Safari aggressively caches - 2. How to mitigate]]

##### 3.4. Avoiding JavaScript & HTML Quirks in Responsiveness

- **Pure-CSS Responsiveness**: Rely on CSS media queries and flexible units to handle resizing, rather than manually toggling classes or styles via JS.
- **Fallbacks**: For older browsers lacking modern CSS support, provide graceful fallbacks (e.g., fixed-width layouts).
- **Progressive Enhancement**: Start with a fully functional, responsive baseline that doesn’t depend on JavaScript. If advanced interactivity is required, layer it on progressively.

##### 3.5. Testing Across Real Devices

Even with best practices, unpredictable behaviors can occur on actual hardware:

1. **Device Labs**: Whenever possible, test on real iPhones, iPads, and various Android devices. Emulators and simulators are helpful but not always 100% accurate.
2. **BrowserStack or Sauce Labs**: Cloud testing services let you run your site on virtual devices, catching quirks you might miss on desktop browsers.

##### 3.6. Key Takeaways for Responsive Standards

- **Focus on Content**: Let the design adapt around your content rather than forcing it into rigid breakpoints.
- **Mobile-First Principles**: Ensure essential functionality is accessible on the smallest screens first.
- **Stay DRY**: Keep reusable responsive mixins, variables, or utility classes in your SASS/LESS.
- **iOS-Specific Considerations**: Use the viewport meta tag, test fixed/sticky positioning, and implement caching strategies on iPad.
- **Minimal JavaScript**: Avoid depending on JS for layout shifts; CSS-based responsiveness is typically faster and more reliable.
- **Real Device Testing**: Confirm your application’s look and feel on actual hardware for the most accurate results.

By following these guidelines, you’ll have a **robust** and **consistent** user experience across a wide range of devices, including notoriously finicky iOS browsers and aggressively caching iPads.

---
#### 4. **Code Design Standards**

In addition to coding conventions and scaling strategies, it’s essential to follow proven code design patterns. These standards ensure your application remains performant, modular, and maintainable as it grows.

##### 4.1 **Algorithms and Data Structures**

Selecting the right algorithms and data structures is critical for performance, especially in applications handling large datasets or complex operations, because it impacts the performance of storing, retrieving (search or not), and sorting operations.

- **Efficiency Matters**: Evaluate time and space complexity (e.g., Big-O notation) to pick the most efficient data structure (Array vs. LinkedList vs. HashMap, etc.).
- **Application-Specific Choices**:
    - **Search and Retrieval**: Use **trees**, **hash maps**, or **tries** where fast lookups are required.
    - **Queue and Stack**: Ideal for first-in, first-out (FIFO) and last-in, first-out (LIFO) workflows respectively.
    - **Caching**: Introduce caching mechanisms (e.g., **Redis**) to store frequently accessed data, reducing expensive database calls.
- **Testing and Profiling**: Incorporate performance testing and benchmarking tools (e.g., **Benchmark.js** for JavaScript) to verify that chosen data structures meet your performance goals.

##### 4.2 **Design Patterns for Maintainable Code**

Design patterns provide reusable solutions to common software problems, enhancing clarity and uniformity:

- **Factory Pattern**: Centralize object creation to standardize instantiation logic and keep your code DRY (Don’t Repeat Yourself).
- **Singleton Pattern**: Restrict a class or module to a single instance when global state or resources must be shared.
- **Observer/Publisher-Subscriber**: Separate core logic from optional or event-triggered functionality. Useful for real-time features, event dispatch, or notification systems.
- **Strategy Pattern**: Encapsulate related algorithms under a common interface to switch between different behaviors (e.g., payment methods, sorting approaches).

##### 4.3 **Object-Oriented Programming (OOP)**

Adopting OOP principles can simplify large or complex projects—**if** it suits the domain and language constraints:

- **Encapsulation**: Keep data and methods inside objects, exposing only necessary interfaces.
- **Inheritance**: Avoid deep inheritance chains. Instead, prefer composition to make classes more flexible and testable.
- **Polymorphism**: Use interfaces (in TypeScript or other typed languages) or duck typing in JavaScript to allow different implementations of the same method signatures.

> **Tip**: If your project doesn’t naturally align with OOP, consider functional programming paradigms or a hybrid approach—many JavaScript apps blend both styles effectively.

##### 4.4 **JavaScript Modules**

Modular code promotes separation of concerns and reusability:

- **ES6 Modules**: Use `import`/`export` to organize code in self-contained files. Example:
    
    ```javascript
    // mathUtils.js
    export function add(a, b) {
      return a + b;
    }
    
    // main.js
    import { add } from './mathUtils.js';
    ```
    
- **Named vs. Default Exports**: Named exports allow multiple exports per file, while default exports provide a single entry point. Maintain consistency by choosing a convention that suits your project size and structure.
- **Bundlers and Build Tools**: Integrate modules with bundlers like **Webpack**, **Rollup**, or **Vite** for optimized builds.

##### 4.5 **MVC or Other Architectural Patterns**


> [!Note] Architecture can be understood on two levels
System Architecture: This encompasses the broader ecosystem, including how servers, databases, and external services interact with your application—e.g., N-tier architectures.
Code Architecture: This focuses on the design patterns and structure within your application's code, such as how presentation, logic, and data layers are organized.
This section delves into code-level architecture, exploring patterns and principles to create maintainable, scalable applications. The next major section will address N-tier architecture in the context of scaling server-side systems to handle user traffic and growing demands.
>
When your application grows beyond a certain complexity, adopting a layered architecture like **Model-View-Controller (MVC)** can help separate concerns:
>
> - **Models**: Handle data structures, business logic, and interactions with APIs or databases.
> - **Views**: Manage UI components and user-facing elements (HTML, templates, or framework-based components).
> - **Controllers**: Orchestrate interactions between Models and Views, handling input, output, and validation.
>
> **Frameworks**: React, Vue, and Angular loosely follow MVC-like patterns, often blending traditional controllers into components or services.

##### 4.6 **State Management**

Large-scale JavaScript applications benefit from clear, organized state management, that can handle state at a local and/or global level:

- **Local State**: Use framework-specific hooks or local variables for small, isolated components.
- **Global State**: For shared data and cross-component communication, consider libraries like **Redux**, **MobX**, or **Context API** in React. Maintain a single source of truth to reduce data inconsistencies.
- **Best Practice**: Keep state-related logic centralized and documented to avoid confusion and reduce debugging effort.

##### 4.7 **Module Initialization and Event Binding**

Designing modules to encapsulate initialization logic and event handlers leads to cleaner, more maintainable code:

1. **Initialization Function (`init`)**
    
    - A dedicated `init` function can bind DOM event handlers, set up initial state, and prepare any required services or APIs.
    - Export the `init` function so it can be called at the appropriate time—e.g., after the DOM has loaded or during application bootstrap.
    
    ```javascript
    // uiModule.js
    export function init({ onButtonClick }) {
      const button = document.getElementById('action-button');
      button.addEventListener('click', () => {
        onButtonClick('Button clicked!');
      });
    }
    ```
    
2. **Destructured Imports at the Outer Scope**
    
    - In the consuming file, destructure the export and provide any callbacks or dependencies:
        
        ```javascript
        // main.js
        import { init as initUiModule } from './uiModule.js';
        
        function handleExitModal() {
			// code
        }
        
        initUiModule({ handleExitModal });
        ```
        
    - This pattern promotes loose coupling; **uiModule** doesn’t need to know the details of the outer scope’s environment or business logic.
      
3. **Extensibility**
    
    - Accept additional callbacks or configuration objects to handle different events (e.g., form submissions, data fetch triggers, that have been binded by the modular object) without rewriting core logic at the module object.
    - Keep your `init` function minimal and focused on wiring up events, not business logic.

##### Key Takeaways (Architecture and Design Standards)

- **Choose Appropriate Data Structures**: Optimize search, retrieval, and storage based on project needs.
- **Use Design Patterns Wisely**: Improve code readability, maintainability, and scalability.
- **OOP Where It Fits**: Consider your language and project scope before committing to OOP. Mix with functional styles as needed.
- **Modularize Your Code**: Leverage ES6 modules for clarity and reusability.
- **Adopt Proven Architectures**: MVC or similar patterns help tackle complexity; pick frameworks or patterns that fit your app’s domain.
- **Manage State Strategically**: Separate local state from global state, ensuring consistency and reducing bugs.
- **Initialize Modules with Care**: Encapsulate setup logic, bind events, and export only what is necessary for external use.

---

#### 5. **Scaling Strategies**

##### 5.1 Fetch vs SSE vs WebSockets
It impacts both architecture (if you have microservices or a heavily asynchronous design) and scalability (long-lived connections, real-time updates, large data streams, etc.).

##### 5.2. N-tier architecture
N-tier architecture provides a modelby which developers can create flexible and reusable applications. By segregating an application into tiers, developers acquire the option of modifying or adding a specific tier, instead of reworking the entire application. N-tier architecture is a good fit for small and simple applications because of its simplicity and low-cost.

While the concepts of layer and tier are often used interchangeably, one fairly common point of view is that there is indeed a difference. This view holds that a layer is a logical structuring mechanism for the conceptual elements that make up the software solution, while a tier is a physical structuring mechanism for the hardware elements that make up the system infrastructure.

##### 5.3 Microservice architecture if needed
Consider breaking your full-stack app into parts called services. 
- That allows you to allocate one part more to cpu and another part more to concurrency, eg respectively: video generator and api. 
	- For NodeJS, you can use pm2 to control whether a service is cpu bound or concurrency bound
	- For PythonJS, you can use gunicorn to do so.
- They can run on different ports but you are not required to expose those ports online
	- For the microservices to communicate with each other, you give them ports.
	- However you DO NOT expose those ports to the internet
	- If the frontend connects to a service (api or video generator, for example), have reverse proxy into that port (that doesn't require port exposure)

##### 5.4. Server level Scaling
- **Worker Threads**: Offload CPU-intensive tasks to worker threads (e.g., Node.js `worker_threads` or Python `multiprocessing`).
- **Asynchronous Processing**: Use message queues like **RabbitMQ** or **Kafka** to handle high workloads asynchronously.
- **Load Balancing**: Distribute requests across multiple instances using load balancers like **NGINX** or **AWS ELB**.
- **Horizontal Scaling**: Add instances to handle increased traffic (e.g., Kubernetes for container orchestration).

##### 5.5. Consistent Environment
- Having a consistent environment whether it's the system's node version, python node version, or the nodejs packages' versions, or the pip packages' versions - is important because you may launch different instances to keep up with traffic.
- Containerized with Docker
- Pyenv for consistent Python version
- nvm for consistent NodeJS Version
- pipenv or Poetry for Python package versions
- NodeJS with package.json is fine (package.lock.json is specific to the OS and can be gitignored)

##### 5.6 Persistent Services
- pm2 can restart NodeJS services when server crashes/restarts or when app crashes
- supervisor can restart Python services when server crashes/restarts or when app crashes

#### 6. **Versioning and Caching**

Modern web applications benefit greatly from versioning and intelligent caching strategies. Versioning helps you track releases more effectively—especially when aligned with Git commits or repository tags—while proper cache-busting ensures users see the latest code, even on devices (like iPads) with aggressive caching behaviors.
##### 6.1 **Aligning Versioning with Git Commits**

- **Semantic Versioning**: Follow a structure like `MAJOR.MINOR.PATCH` (e.g., `1.2.3`) and tag your Git commits or releases accordingly.
- **Auto-Increment/Commit Hash**: Some teams prefer embedding a short Git commit hash (e.g., `abc123`) into the app’s version to pinpoint the exact commit deployed.
- **Visibility in the App**: Display the version somewhere accessible (like `/about` or a footer) for easier debugging.

> **Tip**: Keep a version variable in `package.json` (for Node apps) or a `.version` file, and automate updates via Git hooks or CI/CD scripts.

##### 6.2 **Service Workers and PWA Versioning**

Progressive Web Apps rely on a **service worker** for offline capabilities and caching static assets. Adjusting the service worker’s cache name and version ensures users get fresh assets when you release updates:

1. **Cache Name Versioning**
    
    ```js
    // service-worker.js
    const CACHE_NAME = 'myapp-cache-v1.2.3';
    
    self.addEventListener('install', (event) => {
      event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
          return cache.addAll([
            '/index.html',
            '/assets/index.css',
            '/assets/app.js',
          ]);
        })
      );
    });
    ```
    
2. **Activate Event**
    
    - In the `activate` event, delete older caches so that your application no longer uses stale assets:
        
        ```js
        self.addEventListener('activate', (event) => {
          event.waitUntil(
            caches.keys().then((cacheNames) => {
              return Promise.all(
                cacheNames.map((cacheName) => {
                  if (cacheName !== CACHE_NAME) {
                    return caches.delete(cacheName);
                  }
                })
              );
            })
          );
        });
        ```
        
3. **Force Updates**
    
    - Prompt the user or automatically update to the new service worker when available. This ensures they’re never stuck on an old version.

##### 6.3 **Cache-Busting in a PHP Application**

Some environments, especially on iOS (notably iPad), aggressively cache resources, even ignoring cache headers. One effective workaround is to **append a version query parameter** to the asset URLs:

```php
<?php 
  include("./assets/version-cache-bust.php"); 
  echo <<<HTML
    <link href="assets/index.css$v" rel="stylesheet">
    <link href="assets/common.css$v" rel="stylesheet">
    <script src="assets/index.js$v"></script>
HTML;
?>
```

- **`version-cache-bust.php`** might define `$v = '?v=1.2.3'` or pull the version from your Git metadata automatically.
- **Unique URLs**: Each time `$v` changes, iOS and other browsers see a different file path (`index.css?v=1.2.4` vs. `index.css?v=1.2.3`), forcing them to fetch the latest version.

> **Note**: Since iPad can ignore certain HTTP caching headers, adding a query parameter ensures that the **URL** itself changes, invalidating old caches.

##### 6.4 **Aggressive Caching on iPad**:
- Refer to previous section on Cache-Busting in PHP Application if applicable to you. If it's CRA or Vite or PWA, iPad will respect their versioning. Otherwise, you have to use versioning in the script and link url's, which is tedious and does add noise to git diffs and code reviews. However, for the tedious part, you can run a sed command in terminal to replace the url versions across project files.

##### 6.5 **Create React App (CRA) and Vite Hash Filenames**

Modern JavaScript build tools like **CRA** (Webpack under the hood) and **Vite** (Rollup/Esbuild) **automatically** handle filename hashing for you:

- **CRA**
    
    - When you run `npm run build` or `yarn build`, CRA generates files like `main.[hash].js` and `main.[hash].css`.
    - Each new build produces a different hash if the contents have changed, effectively invalidating the previous cache.
    - **Custom Version String**: You can still embed a version in your app’s environment variables (e.g., `REACT_APP_VERSION=1.2.3`) and display it. However, the hashed filenames provide the main cache-busting.
- **Vite**
    
    - By default, Vite generates hashed filenames for production builds (e.g., `assets/index.9c4f6.js`).
    - You can customize or **disable** hashing in your `vite.config.js`, but it is highly recommended to keep hashing for robust cache-busting.
    - Similarly, you can define `import.meta.env.VITE_APP_VERSION` or a custom environment variable, referencing it in the code to keep track of the current version.

##### 6.6 **Combining Git Versioning with Asset Hashing**

Even with automated filename hashing, aligning your app’s “human-readable” version (e.g., `1.2.3`) to your Git repository helps with:

- **Release Notes**: The hashed filename changes frequently, but your app version can remain more stable and meaningful to stakeholders.
- **Rollbacks**: If you need to roll back a release, you can easily identify which version to deploy.
- **Debugging**: Logging the version in your JS console or showing it on the UI can expedite troubleshooting.

##### 6.7 **Key Takeaways for Versioning and Caching**

1. **Align Versions with Git**: Keep your app’s version in sync with repository tags or commit hashes for traceability.
2. **Leverage Automatic Hashing**: Tools like CRA and Vite handle hashed filenames, ensuring browsers fetch updated assets.
3. **Service Worker Strategy**: Increment your cache name or version in PWAs to avoid serving stale assets, and remove old caches during the `activate` event.
4. **Force Cache-Busting on iPad**: For PHP (or other servers), add query parameters (`?v=1.2.3`) so that iPad recognizes new asset URLs.
5. **Environment Variables**: For JS frameworks, store version data in environment variables (e.g., `REACT_APP_VERSION`) and display it in the UI for clarity.

By employing these approaches, you’ll have a **consistent, reliable versioning** scheme that keeps your application code and assets **fresh**, mitigating the quirks of aggressive caching—particularly on iOS devices—and ensuring smooth user experiences.

---
#### 7. **Secure Coding Practices**

Implement secure coding practices to protect applications from vulnerabilities:

- ##### **7.1. CMS, Web Panels, etc**: 
	- Keep CMS, web panels, etc updated because often case found vulnerabilities are patched.
	- SSH tunnel into web panel (eg. cpanel)
	- Part of the hacker's toolkit is a scanner for old CMS versions that are vulnerable.
- ##### 7.2.Dot env
	- Do not commit or push up dot env. In fact, you should gitignore .env.
	- Most web servers, such as Apache or Nginx, do not serve dotfiles (files starting with a `.`) by default. However, misconfigurations or custom settings can accidentally expose these files. For even more security:
		- Use a more unique .env filenaming schema. Load that uniquely named .env file directly. Python's dotenv_path. Or NodeJS' dotenv config path.
		- Explicitly block env files or wildcarded unique env filenames in your apache htaccess or nginx vhost.
- ##### 7.3. **Persistent Login**: 
	- Strategies such as cookies, json web token, or session ID's to keep user logged in. But make sure it remains secured.
- ##### 7.4.**Injection Prevention**: 
	- Sanitize inputs to guard against SQL injection, XSS, and other injection attacks. 
	- Use parameterized queries or ORM frameworks to mitigate risks.
- ##### 7.5. **Passwordless SSH Root Access**: 
	- Disable Direct Root Login: Prevent direct root login over SSH and instead utilize key-based authentication for a more secure setup.
	- Use a Non-Root Username: For added security, configure a different username for administrative tasks instead of using the default "root" user.
	- Implement Temporary Root Access: To maximize security, create a script that temporarily enables or disables root access. This script can be secured using a dual-key authentication system, with unique keys stored on the remote server and your local machine.
- ##### 7.6. **Ports and Reverse Proxy **
	- Limit exposing ports to the internet. 
	- If frontend connects to different API's running on different ports, opt for using reverse proxy urls to those ports. Keep ports closed to internet on iptables, ufw (wrapper of iptables), etc.
	- Part of the hacker's toolkit is a port scanner.
- ##### 7.7 **Error Handling**: 
	- Avoid exposing sensitive error messages to end-users (could give hints to bad actors on how to exploit your system); log errors securely for internal debugging.
- ##### 7.8. **Handling Secrets**:
    - **Environment Variables**: Use environment variables to store sensitive data like API keys, tokens, or database credentials.
    - **Secret Management Tools**: Utilize tools like **AWS Secrets Manager**, **HashiCorp Vault**, or **Azure Key Vault** for secure storage and rotation of secrets.
    - **Best Practices**: Never hard-code secrets in your source code. Add `*.env` or equivalent files to `.gitignore` to prevent accidental exposure.
	    - High level developers may casually call it the **secrets layer**.
	    - You can have git pushes/pulls decrypt/encrypt, simplifying secret sharing with internal team, but making sure Github does not have exposure to it. That is one approach https://medium.com/@slimm609/securely-storing-secrets-in-git-542771d3ed8c
- ##### 7.9. **Keep up to date on security practices**: 
	- OWASP Top 10 - Regularly review OWASP recommendations for common security risks.


---

### Best Practices in Software Development

1. **Automated Testing**: Identify issues early with tools that ensure high test coverage.
2. **Simplify Code**: Reduce complexity for better readability and maintenance.
3. **Conduct Code Reviews**: Foster feedback and adherence to standards through peer reviews.
4. **Deploy Incrementally**: Reduce risk by releasing small, manageable updates.
5. **Use Feature Flags**: Test features in controlled environments before full deployment.
6. **Implement CI/CD Pipelines**: Automate building, testing, and deployment for efficiency.
7. **Leverage Version Control**: Use systems like Git to manage and track changes.
8. **Follow Agile Principles**: Embrace iterative and collaborative methodologies.
9. **Foster Ownership**: Encourage developers to take pride in their work for better quality and engagement.
10. **Use Observability Practices**: Monitor applications with tools like **Datadog** or **Grafana** to ensure uptime and performance.

---

### Essential Tools for Adhering to Standards and Best Practices

- **Observability Tools**: Real-time insights into systems using **Datadog**, **Dynatrace**, or **Grafana**.
- **Code Analysis Tools**: Tools like **SonarQube**, **Snyk**, or **Codacy** improve code quality and security.
- **Project Management Tools**: Organize workflows with **Jira**, **Asana**, or **Trello**.
- **CI/CD Tools**: Automate pipelines with **GitLab**, **Jenkins**, or **CircleCI**.
- **Git Platforms**: Manage code repositories with **GitHub**, **GitLab**, or **Bitbucket**.
- **Unit Testing Frameworks**: Tools like **Jest**, **Mocha**, or **Pytest** ensure software reliability.
- **Logging Libraries**: Use **Winston**, **Log4j**, or **Serilog** for structured logging.
- **Linting and Formatting Tools**: Automate code reviews with **ESLint**, **Prettier**, or **Stylelint**.
- **Style Guide Generators**: Tools like **Storybook**, **Style Dictionary**, or **ZeroHeight** help create consistent, reusable design systems.
- **Secret Management Tools**: Use **AWS Secrets Manager**, **Vault**, or **Azure Key Vault** to secure sensitive data.

---

By adopting these standards, practices, and tools, software development teams can ensure consistency, scalability, and maintainability, delivering high-quality software that aligns with organizational goals.