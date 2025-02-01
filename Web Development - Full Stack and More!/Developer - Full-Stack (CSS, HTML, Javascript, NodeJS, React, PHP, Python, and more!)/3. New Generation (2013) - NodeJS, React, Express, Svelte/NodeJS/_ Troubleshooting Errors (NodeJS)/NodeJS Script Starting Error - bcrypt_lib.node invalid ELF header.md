
npm run start:
```
Error: /home/wengindustries/htdocs/wengindustries.com/app/book-search/server/node_modules/bcrypt/lib/binding/napi-v3/bcrypt_lib.node: invalid ELF header
```

Bcrypt compiled on macOS is not compatible with Linux. This means if you compile bcrypt on your local macOS workstation and use it in your Node.js application running on Linux servers, you'll encounter the error mentioned above.

So take care of node_modules and npm install. Make sure to remove package-lock.json first.   

If the error keeps persisting, make sure you double check any nested folders that have their own package.json and node_modules too (typically client/ and server/, or frontend/ and backend/)!