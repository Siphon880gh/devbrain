
server.js:
```
import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import fs from 'fs';

// Mongoose imports
import mongoose from 'mongoose';
import Book from './src/models/Book.js';

// Setup basic variables
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const isProduction = process.env.NODE_ENV === 'production';
const PORT = process.env.PORT || 3000;

// Initialize Express
const app = express();
app.use(express.json());

// Connect to MongoDB
const dbName = "db";
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/' + dbName)
  .then(() => console.log('✅ Connected to MongoDB'))
  .catch(err => console.error('❌ MongoDB connection error:', err));

// --- API Routes ---
app.get('/api/books', async (req, res) => {
  try {
    const books = await Book.find();
    res.json(books);
  } catch (error) {
    console.error('Error fetching books:', error);
    res.status(500).json({ error: 'Failed to fetch books' });
  }
});

// --- Static Asset Serving in Production ---
function setupProductionStaticRoutes() {
//   const publicPath = path.join(__dirname, 'public');
  const distPath = path.join(__dirname, 'dist');

  if (fs.existsSync(distPath)) {
    console.log('📂 Serving static from:', distPath);
    console.log('📁 Contents:', fs.readdirSync(distPath));
  } else {
    console.error('❌ Static directory not found:', distPath);
  }

  app.use(express.static(distPath));

  app.get('/sitemap.xml', (req, res) =>
    res.sendFile(path.join(distPath, 'sitemap.xml'))
  );

  app.get('/robots.txt', (req, res) =>
    res.sendFile(path.join(distPath, 'robots.txt'))
  );

  app.get('*', (req, res) =>
    res.sendFile(path.join(distPath, 'index.html'))
  );
}

// --- Vite Dev Middleware ---
async function setupViteDevServer() {
  const { createServer } = await import('vite');
  const vite = await createServer({
    server: { middlewareMode: true },
    appType: 'spa',
  });
  app.use(vite.middlewares);
}

// --- Error Middleware ---
app.use((err, req, res, next) => {
  console.error('❌ Server error:', err);
  res.status(500).send('Internal Server Error');
});

// --- Start Server ---
(async () => {
  console.log('🚀 Starting server...');
  console.log('🔧 NODE_ENV:', process.env.NODE_ENV);
  console.log('📁 Root directory:', __dirname);

  if (isProduction) {
    setupProductionStaticRoutes();
  } else {
    await setupViteDevServer();
  }

  app.listen(PORT, () => {
    console.log(`✅ Server running at http://localhost:${PORT}`);
  });
})();
```

vite.config.js:
```
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import path from 'path';

// Custom plugin to serve XML and text files
const serveStaticFiles = () => ({
  name: 'serve-static-files',
  configureServer(server) {
    server.middlewares.use((req, res, next) => {
      const filePath = req.url === '/sitemap.xml' 
        ? path.resolve(__dirname, 'public/sitemap.xml')
        : req.url === '/robots.txt'
          ? path.resolve(__dirname, 'public/robots.txt')
          : null;

      if (filePath && fs.existsSync(filePath)) {
        const content = fs.readFileSync(filePath, 'utf-8');
        const contentType = req.url.endsWith('.xml') 
          ? 'application/xml' 
          : 'text/plain';
        
        res.writeHead(200, {
          'Content-Type': `${contentType}; charset=utf-8`,
          'Content-Length': Buffer.byteLength(content)
        });
        res.end(content);
        return;
      }
      next();
    });
  },
  configurePreviewServer(server) {
    server.middlewares.use((req, res, next) => {
      // Same logic as configureServer
      const filePath = req.url === '/sitemap.xml' 
        ? path.resolve(__dirname, 'public/sitemap.xml')
        : req.url === '/robots.txt'
          ? path.resolve(__dirname, 'public/robots.txt')
          : null;

      if (filePath && fs.existsSync(filePath)) {
        const content = fs.readFileSync(filePath, 'utf-8');
        const contentType = req.url.endsWith('.xml') 
          ? 'application/xml' 
          : 'text/plain';
        
        res.writeHead(200, {
          'Content-Type': `${contentType}; charset=utf-8`,
          'Content-Length': Buffer.byteLength(content)
        });
        res.end(content);
        return;
      }
      next();
    });
  }
});

export default defineConfig({
  plugins: [
    react(),
    serveStaticFiles()
  ],
  build: {
    outDir: 'dist',
    assetsDir: 'assets'
  },
  css: {
    modules: false,
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src')
    }
  },
  server: {
    port: 3000,
  }
});
```