
You as the Prompt Engineer:
1. ChatGPT 4o have it give a comprehensive guide on the technical features
2. Paste the comprehensive guide into Cursor AI Composer


Prompt ChatGPT 4o:
```
I have a table of contents of technical features. 

**Ask me:**
"""
Would you like me to focus on specific components first? For example:

Config Layer
Feature Flags
CI/CD pipeline
Onboarding Documentation
Are there any tools or services you'd like to prioritize? Examples:

Feature Flags: LaunchDarkly, ConfigCat, or an in-house implementation.
CI/CD: GitHub Actions, GitLab CI, Jenkins, etc.
Monitoring: Sentry, Prometheus, Grafana.
Is this for an existing project or a new one? This will help tailor the setup for seamless integration.
"""

---

**Then please create a comprehensive development guide with all required components and configurations. This guide will include clear examples, detailed setup instructions, and configuration files to meet the specified requirements.**

----

Here is the table of contents of technical features:
"""
**Please create a comprehensive setup for improving the developer experience in a TypeScript Node.js project. Specifically, I want:**

1. **Config Layer**
    
    - A clear and maintainable way to handle environment variables (e.g., dotenv, convict, or a custom config service).
    - Best practices for organizing configuration files (e.g., development, staging, production).
    - Type-safe configuration validation (e.g., using Zod or Yup for schema validation).
2. **Feature Flags**
    
    - An example implementation of feature flags (e.g., using LaunchDarkly, ConfigCat, or a simple in-house solution).
    - Instructions on toggling features in different environments (e.g., enabling a new feature for staging only).
    - Best practices to ensure safe rollouts and easy reverts.
3. **Continuous Integration and Continuous Deployment (CI/CD)**
    
    - A recommended Git branching strategy (e.g., trunk-based or GitFlow).
    - A sample GitHub Actions or GitLab CI pipeline configuration (.github/workflows/ci.yml or similar) that includes:
        - Running linting (ESLint) and formatting checks (Prettier).
        - Running unit tests (Jest or similar) with coverage reporting.
        - Building and packaging the application (e.g., Docker image).
        - (Optional) Deploying to a staging or production environment, with environment-based configs.
    - Guidelines on securing secrets and environment variables (e.g., using GitHub Actions secrets, Vault, etc.).
4. **Developer-Friendly Features**
    
    - Recommended local development setup (e.g., npm run dev with hot reloading, local environment with Docker Compose).
    - Automated scripts for bootstrapping the environment, installing dependencies, and running tests.
    - Documentation or README.md instructions to get started quickly.
5. **Optional Add-ons**
    
    - Tips for rolling out features gradually (e.g., canary deployments, A/B testing).
    - Error monitoring and logging strategy (e.g., integrating with Sentry or Winston).
    - Code coverage thresholds and automated code quality checks (e.g., SonarCloud or Codecov).
    - Suggestions on how to handle or store analytics/metrics to track feature usage.

**Please provide**:

- **Configuration files** (e.g., config.ts, featureFlags.ts, .github/workflows/ci.yml).
- **Explanations** of each file/setting, detailing how it works and why it’s best practice.
- **Example code** demonstrating usage of the config layer, feature flags, and the CI pipeline steps.
- **Step-by-step instructions** on how to set up and run everything in a clean project.
6. **Code Quality and Static Analysis Tools**
    
    - **Static Code Analysis**: Integrate tools like **SonarQube** or **CodeClimate** to analyze code quality, detect code smells, and ensure adherence to coding standards.
    - **Type Checking**: Utilize TypeScript’s strict type-checking features to catch type-related errors during development.
    - **Dependency Checking**: Implement tools like **Dependabot** or **Renovate** to automatically manage and update dependencies, ensuring the project remains up-to-date and secure.
7. **Environment Management**

    - **Local Environment Parity**: Ensure the local development environment closely mirrors production using containerization tools like **Docker** and orchestration with **Docker Compose**.
    - **Environment Variable Management**: Use services like **Vault** or **AWS Secrets Manager** for secure storage and access of sensitive environment variables.
8. **Monitoring and Alerting**
    
    - **Application Monitoring**: Integrate monitoring tools such as **Prometheus** and **Grafana** to track application performance and health metrics.
    - **Alerting Systems**: Set up alerting mechanisms using tools like **PagerDuty** or **Slack integrations** to notify the team of critical issues in real-time.
9. **Developer Onboarding and Documentation**
    - **Comprehensive Onboarding Guide**: Create detailed onboarding documentation to help new developers get up to speed quickly, including setup instructions, architectural overviews, and coding guidelines.
    - **API Documentation**: Use tools like **Swagger** or **API Blueprint** to generate and maintain up-to-date API documentation.
    - **Knowledge Base**: Maintain a centralized knowledge base (e.g., using **Confluence** or **Notion**) for best practices, troubleshooting guides, and project-specific information.
10. **Collaboration and Communication Tools**
    
    - **Code Review Process**: Establish a structured code review process using platforms like **GitHub Pull Requests** or **GitLab Merge Requests**, ensuring code quality and knowledge sharing.
    - **Communication Channels**: Utilize tools like **Slack**, **Microsoft Teams**, or **Discord** for effective team communication and collaboration.
    - **Task Management**: Implement task tracking and project management tools such as **Jira**, **Trello**, or **Asana** to organize and prioritize work effectively.
11. **Versioning and Release Management**
    
    - **Semantic Versioning**: Adopt semantic versioning (SemVer) to manage and communicate changes effectively.
    - **Automated Releases**: Use tools like **semantic-release** to automate the release process, including version bumping and changelog generation.
12. **Security Best Practices**
    
    - **Static Application Security Testing (SAST)**: Integrate SAST tools like **ESLint security plugins**, **Snyk**, or **Bandit** to detect security vulnerabilities in the codebase.
    - **Dependency Vulnerability Scanning**: Regularly scan dependencies for known vulnerabilities using tools like **npm audit**, **Snyk**, or **OWASP Dependency-Check**.
    - **Secure Coding Guidelines**: Establish and enforce secure coding practices to prevent common vulnerabilities such as SQL injection, cross-site scripting (XSS), and others.
13. **Performance Optimization**
    
    - **Profiling Tools**: Incorporate profiling tools like **Clinic.js** or **0x** to identify and address performance bottlenecks.
    - **Caching Strategies**: Implement effective caching mechanisms (e.g., **Redis**) to enhance application performance and reduce latency.
    - **Lazy Loading**: Utilize lazy loading techniques for modules and components to optimize load times and resource usage.
14. **Automated Testing Enhancements**
    
    - **Integration and End-to-End Testing**: Expand the testing suite to include integration tests (using tools like **SuperTest**) and end-to-end tests (using **Cypress** or **Puppeteer**) to ensure comprehensive test coverage.
    - **Test Data Management**: Implement strategies for managing test data, such as using fixtures or mocking external services, to maintain reliable and consistent test results.
15. **Internationalization (i18n) and Localization (l10n)**
    
    - **i18n Framework Integration**: Integrate internationalization frameworks like **i18next** or **react-intl** to support multiple languages and regions.
    - **Localization Processes**: Establish processes for translating and managing localized content effectively.

**Additional Requirements**:

- **Advanced Configuration Files**: Include advanced configuration files for the added tools and practices (e.g., .eslintrc, sonar-project.properties, swagger.yaml).
- **Comprehensive Explanations**: Provide detailed explanations for each new tool, configuration, and best practice, highlighting their roles in enhancing the developer experience.
- **Expanded Example Code**: Demonstrate usage of the newly integrated tools and practices through example code snippets and scenarios.
- **Enhanced Setup Instructions**: Offer step-by-step guidance on setting up and integrating the additional components into the project, ensuring seamless adoption by the development team.

---

### Example of an Enhanced Comprehensive Prompt

“Please generate a comprehensive development standards and developer experience enhancement guide for a TypeScript Node.js project. Specifically, I need:

1. **Config Layer**
    
    - A maintainable method for handling environment variables (e.g., using dotenv with convict).
    - Organized configuration files for different environments (development, staging, production).
    - Type-safe configuration validation using **Zod** schemas.
2. **Feature Flags**
    
    - Implementation of feature flags using **LaunchDarkly**.
    - Instructions for toggling features across environments.
    - Best practices for safe feature rollouts and quick reverts.
3. **Continuous Integration and Continuous Deployment (CI/CD)**
    
    - Adopt the **GitFlow** branching strategy.
    - A sample **GitHub Actions** pipeline (.github/workflows/ci.yml) that includes:
        - ESLint and Prettier checks.
        - Running **Jest** tests with coverage reports.
        - Building a Docker image.
        - Deploying to **AWS ECS** for staging and production based on branch.
    - Securing secrets using **GitHub Secrets**.
4. **Developer-Friendly Features**
    
    - Local development setup with npm run dev using **nodemon** for hot reloading.
    - Docker Compose setup for running the application and dependencies locally.
    - Automated scripts for environment setup, dependency installation, and testing.
    - A detailed README.md with setup and contribution guidelines.
5. **Optional Add-ons**
    
    - Implementing canary deployments using **AWS CodeDeploy**.
    - Integrating **Sentry** for error monitoring and **Winston** for logging.
    - Enforcing code coverage thresholds with **Codecov**.
    - Tracking feature usage with **Google Analytics**.
6. **Code Quality and Static Analysis Tools**
    
    - Integrate **SonarQube** for continuous code quality analysis.
    - Set up **Dependabot** to manage and update dependencies automatically.
7. **Environment Management**
    
    - Use **Docker** and **Docker Compose** to ensure environment parity.
    - Securely manage environment variables with **Vault**.
8. **Monitoring and Alerting**
    - Set up **Prometheus** and **Grafana** for application monitoring.
    - Configure **PagerDuty** for real-time alerts on critical issues.
9. **Developer Onboarding and Documentation**
    - Create a comprehensive onboarding guide in CONTRIBUTING.md.
    - Generate API documentation using **Swagger**.
    - Maintain a knowledge base using **Notion**.
	- Generate JavaScript/TypeScript documentation using **JSDoc**: 
		- Set up automated JSDoc generation in the build pipeline 
		- Document all public functions, classes, and interfaces
		- Include code examples and type definitions 
		- Generate HTML documentation output -
		- Configure JSDoc using jsdoc.config.json
1. **Collaboration and Communication Tools**
    
    - Establish a code review process using **GitHub Pull Requests**.
    - Utilize **Slack** for team communication.
    - Implement **Jira** for task and project management.
11. **Versioning and Release Management**
    
    - Adopt **Semantic Versioning (SemVer)**.
    - Automate releases with **semantic-release**.
12. **Security Best Practices**
    
    - Integrate **Snyk** for dependency vulnerability scanning.
    - Enforce secure coding guidelines to prevent common vulnerabilities.
13. **Performance Optimization**
    
    - Use **Clinic.js** for profiling and performance monitoring.
    - Implement caching with **Redis** and optimize code with lazy loading techniques.
14. **Automated Testing Enhancements**
    
    - Add integration tests using **SuperTest** and end-to-end tests with **Cypress**.
    - Manage test data with fixtures and mocks for reliable testing.
15. **Internationalization (i18n) and Localization (l10n)**
    
    - Integrate **i18next** for internationalization support.
    - Establish localization processes for managing translations.Here is the technical features you should augment into you understanding:
"""
```