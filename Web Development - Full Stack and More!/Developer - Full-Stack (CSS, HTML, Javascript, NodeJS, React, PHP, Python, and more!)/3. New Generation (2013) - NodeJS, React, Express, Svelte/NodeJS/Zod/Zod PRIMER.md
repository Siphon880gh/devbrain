Aka: Get Started

The schema gets built in a builder pattern, then the final step is safeParse where you pass in the object to be validated against:
- You get the fields back especially if there’s coercion aka typecasting as part of Zod (eg. `amount: z.coerce.number()`  because input fields gets strings)
```
import { z } from 'zod';  
  
    const validatedFields = z  
      .object({  
        name: z.string().min(1),  
        email: z.string().email(),  
        password: z.string().min(6),  
        confirmPassword: z.string().min(6),  
      })  
      .refine((data) => data.password === data.confirmPassword, {  
        message: "Passwords don't match",  
        path: ['confirmPassword'],  
      })  
      .safeParse({  
        name: formData.get('name'),  
        email: formData.get('email'),  
        password: formData.get('password'),  
        confirmPassword: formData.get('confirmPassword'),  
      });  
  
    if (!validatedFields.success) {  
      return validatedFields.error.errors[0].message;  
    }  
  
  
    const { name, email, password } = validatedFields.data;
```

And can tell it to omit certain fields from validation before safeParse

It doesn’t have to be chained. You can just use the object later:
```
const FormSchema = z.object({  
  id: z.string(),  
  customerId: z.string(),  
  amount: z.coerce.number(),  
  status: z.enum(['pending', 'paid']),  
  date: z.string(),  
});
```