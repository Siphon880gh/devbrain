
## 🧱 Frontend vs Backend

| Environment            | Module System   | Recommendation                                                                                |
| ---------------------- | --------------- | --------------------------------------------------------------------------------------------- |
| **Node.js (backend)**  | CommonJS OR ESM | Prefer `require()` for legacy code. For modern projects, use `"type": "module"` and `import`. |
| **Browser (frontend)** | ESM only        | Use `<script type="module">` and `import` syntax                                              |

> ✅ Tools like Vite, Webpack, and ESBuild bundle all `require`/`import` calls for the frontend, so you don’t need to worry much.
