Aka Get Started

What is NextJS - Express vs NextJS

NextJS is full stack. Express.js is a backend framework designed for building APIs, while Next.js is a full-stack framework that extends React and includes a built-in API routing system that can serve as an alternative to Express.js. By extending React, NextJS enhance SEO, development efficiency, and project performance. Notably, Next.js

In Next.js, you don’t need useEffect and useState to fetch data on page load before replacing a spinner with rendered content. Instead, you can fetch data directly inside a server component by awaiting the response (say, for example from a postgres package!). If needed, Suspense can handle showing a loading state (eg. spinning icon). Sever sided components would not be marked "use client".

---

To begin using NextJS, follow the tutorials at [[0. Preface - Learn by Editing Code on NextJS]]