In **NextAuth.js**, `NEXT_REDIRECT` is treated as an error because of how the framework handles redirections within API routes and middleware. The key reasons are:
### 1. **Internal Handling of `NEXT_REDIRECT`**

- NextAuth throws `NEXT_REDIRECT` as an **exception** internally to force a **redirect response** instead of returning a regular JSON response.
- This ensures that the authentication process is properly interrupted and redirected when necessary.
  
[https://medium.com/@mark_huber/when-a-redirect-takes-the-wrong-turn-demystifying-next-redirect-in-next-js-8d522f018eb6](https://medium.com/@mark_huber/when-a-redirect-takes-the-wrong-turn-demystifying-next-redirect-in-next-js-8d522f018eb6)  

So instead of catching the error and sending to console like this:
- Dont do this:
```
try {  
    // ...  
} catch (error) {  
   return (error as Error).message; // Usually going to GUI  
}
```
- And don’t do this:
```
try {  
    // ...  
} catch (error) {  
    console.error('Signup error:', error);  
    return 'Something went wrong during signup.';  // Usually going to GUI  
}
```

---

✓ BUT DO THIS:
```
try {  
    // ...  
} catch (error) {  
    // This is expected - let the redirect happen  
    if ((error as Error).message.includes('NEXT_REDIRECT')) {  
      throw error;  
    }  
}
```