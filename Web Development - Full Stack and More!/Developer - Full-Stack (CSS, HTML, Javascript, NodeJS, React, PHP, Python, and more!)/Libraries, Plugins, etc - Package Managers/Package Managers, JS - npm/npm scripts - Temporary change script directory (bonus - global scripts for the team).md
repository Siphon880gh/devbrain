
Using the `--prefix` flag in `npm run` allows you to specify a different directory where the `package.json` file is located, enabling you to execute scripts from that directory. This is particularly useful for:

1. **Globalizing Scripts:** By placing a `package.json` with common scripts in `~/npm/` (or another central location), you can run scripts from anywhere without needing to duplicate them in multiple projects.
    
    ```sh
    npm run build --prefix ~/npm/
    ```
    
2. **Team Consistency:** If your team shares a repository with a centralized script setup, they can all execute the same scripts without maintaining them separately in each project.
    
3. **Using Centralized CI/CD Scripts:** If you have a standard `package.json` for automation, you can use this approach to ensure consistency in deployment, linting, formatting, and other tasks.


For more details: [[Team - Global npm scripts]]

