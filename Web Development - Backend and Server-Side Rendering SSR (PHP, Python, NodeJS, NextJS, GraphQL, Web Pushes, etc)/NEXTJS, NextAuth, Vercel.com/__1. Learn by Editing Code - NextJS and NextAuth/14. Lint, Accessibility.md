## Prepare Lint

The boilerplate has already installed [`eslint-plugin-jsx-a11y`](https://www.npmjs.com/package/eslint-plugin-jsx-a11y) which allows you to run lint command to check for suggestions on how to improve your code.

Add to package.json scripts:
```
"lint": "next lint"
```

Run linter:
```
npm run lint
```

Since first time running for the project, it will guide you through installing and configuring ESLint for your project. It will install additional packages at package.json to help with linting. You should choose “Strict”

When you run linter again (not first time), it will tell you all your problems:
```
npm run list
```

For example:
```
./app/ui/invoices/buttons.tsx  
16:33  Error: 'id' is defined but never used.  @typescript-eslint/no-unused-vars
```

Explanation of example error:  
- You can disable that particular error with a comment flag above the error (new line between lines 15 and 16):
	```
	// eslint-disable-next-line @typescript-eslint/no-unused-vars
	```
- Alternatively, if you need to disable it for multiple lines, wrap the code like this:
	```
	/* eslint-disable @typescript-eslint/no-unused-vars */  
	const id = someValue;  
	/* eslint-enable @typescript-eslint/no-unused-vars */
	```
- You can disable all unused variable errors by editing `.eslintrc.json` :
	```
	  "rules": {  
	    "@typescript-eslint/no-unused-vars": "off"  
	  }
	```
- Your goal should be to have 0 warnings and errors:
	```
	✔ No ESLint warnings or errors
	```

## Image Accessibility - Alt

Create a `app/test/accessibility/image-alt/page.tsx`:
```
import Image from 'next/image';  
import MobilePromotion from '@/public/hero-mobile.png'  
  
export default function Page() {  
    return (  
        <Image src={MobilePromotion} />  
    )  
}
```

Then visit in the web browser [http://localhost:3000/test/accessibility/image-alt/](http://localhost:3000/test/accessibility/image-alt/):
- You’ll see the picture successfully rendered and you’ll also see a red error button (which will tell you that the image is missing an alt attribute):
![[Pasted image 20250309040346.png]]

Running `npm run lint` :
```
./app/test/accessibility/image-alt/page.tsx  
6:9  Warning: Image elements must have an alt prop, either with meaningful text, or an empty string for decorative images.  jsx-a11y/alt-text
```

You can fix these errors by adding an alt attribute:
```
<Image src={MobilePromotion} alt="Promotion picturewith side by side mobile phones" />
```


---

## Form Accessibility

When designing forms in Next.js, it is crucial to ensure accessibility for all users, including those relying on assistive technologies (AT). Here’s how we can enhance form accessibility:

### **1. Semantic Form HTML**

Using semantic elements like `<input>`, `<label>`, and `<button>` instead of `<div>` helps AT recognize form elements properly. This ensures users can navigate and interact with the form effectively.

### **2. Labeling Form Fields**

Each input should have a `<label>` associated with it using the `htmlFor` attribute. This improves usability by making the label clickable to focus the input and providing context to AT.

#### **Example:**

```tsx
<label htmlFor="email">Email</label>
<input type="email" id="email" aria-describedby="email-error" className="border p-2" />
<div id="email-error" className="text-red-600 hidden">
  Please enter a valid email.
</div>
```

- `htmlFor="email"` correctly links the label to the input.
- `aria-describedby="email-error"` ensures screen readers announce the error message when focusing on the input.

### **3. Focus Outline for Accessibility**

Users who navigate using keyboards or AT need a visible focus outline. Tailwind provides `focus:outline` utilities to ensure this:

```tsx
<input type="email" id="email" className="border p-2 focus:outline-blue-500" />
```

You can verify this by pressing the `Tab` key and ensuring the field is visually indicated when focused.

If your form follows a **logical structure in the DOM**, you should **not manually set `tabindex`**, because Browsers automatically navigate inputs in their natural order.

Non-interactive elements like `<div>` are not focusable by default. If you need users to tab into them (e.g., a custom dropdown or modal), you can set `<div tabindex="0">Focusable div</div>` which makes the element **focusable in natural tab order**.

You can skip an element from being able to tab-focus on with `<button tabindex="-1">Not focusable</button>`

And you can manually override the tab order with:
```
<input type="text" id="name" tabindex="2" />
<input type="email" id="email" tabindex="1" />
<input type="password" id="password" tabindex="3" />
```

### **4. Handling Form Validation with Accessibility**

When displaying error messages, it is important to dynamically announce them using `aria-live`.

**Example: Error Message**

```tsx
<div id="email-error" aria-live="polite" className="text-red-600 hidden">
  Please enter a valid email.
</div>
```

- `aria-live="polite"` ensures screen readers announce the message but do not interrupt the current reading flow.

**Success Message with `aria-live` and `role="status"`**

When a form is successfully submitted, we want the success message to be immediately announced by screen readers.

```tsx
<div id="form-success" role="status" aria-live="assertive" className="text-green-600 hidden">
  Form submitted successfully!
</div>
```

- `aria-live="assertive"` makes sure screen readers announce the success message right away.
- `role="status"` explicitly tells AT that this is a status message.

**Understanding `aria-live` Priority Levels**

The `aria-live` attribute helps dynamically announce updates. It has three levels of priority:

- **`off`**: Screen readers ignore updates (default behavior if `aria-live` is not set).
- **`polite`**: Messages are read only after the user is done with their current interaction.
- **`assertive`**: Messages are announced immediately, interrupting whatever the user is currently doing.

Use `polite` for error messages so they do not disrupt user interaction, but use `assertive` for success messages to ensure immediate feedback.


**Required attribute**

By adding the `required` attribute to the `<input>` and `<select>` elements in your forms, the browser will display a warning if you try to submit a form with empty values. Screen readers have this built into them as well.

### **Summary of Best Practices**

✅ Use **semantic HTML** for form elements.  
✅ Always use `<label>` with `htmlFor` to link it to the input.  
✅ Apply `aria-describedby` for error messages.  
✅ Ensure focus indicators are visible (`focus:outline`).  
✅ Use `aria-live="polite"` for error messages and `aria-live="assertive"` for success messages.  
✅ Use `role="status"` to explicitly mark the success message for screen readers.
✅ Adding `required` attribute on inputs that cannot be empty.

---
### **Frontend Validation**

Here’s a complete implementation:

```tsx
"use client";
import { useState } from "react";

export default function AccessibleForm() {
  const [email, setEmail] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!email.includes("@")) {
      setError("Please enter a valid email.");
    } else {
      setSuccess("Form submitted successfully!");
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label htmlFor="email" className="block font-semibold">
          Email
        </label>
        <input
          type="email"
          id="email"
          className="border p-2 w-full focus:outline-blue-500"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          aria-describedby={error ? "email-error" : undefined}
          required
        />
        {error && (
          <div id="email-error" aria-live="polite" className="text-red-600">
            {error}
          </div>
        )}
      </div>

      <button type="submit" className="bg-blue-500 text-white p-2 rounded">
        Submit
      </button>

      {success && (
        <div id="form-success" role="status" aria-live="assertive" className="text-green-600">
          {success}
        </div>
      )}
    </form>
  );
}
```

---

## **Backend Validation**

Aka Server-Side Validation

### Setting Up useActionState in a Client Component

To manage form state in Next.js, we use the `useActionState` hook from React. Since this is a React hook, we must convert our form component into a Client Component using the `"use client"` directive.

**Example: Creating a Form Component**

Create a form component inside `/app/ui/invoices/create-form.tsx`:

```tsx
'use client';

// ...
import { useActionState } from 'react';
import { createInvoice, State } from '@/app/lib/actions';

export default function Form({ customers }: { customers: CustomerField[] }) {
  const initialState: State = { message: null, errors: {} };
  const [state, formAction] = useActionState(createInvoice, initialState);

  return <form action={formAction}>...</form>;
}
```

Breakdown of `useActionState`
- It takes two arguments: `(action, initialState)`.
- It returns two values: `[state, formAction]`, where:
    - `state` contains the form’s validation errors and messages.
    - `formAction` is the function that handles the form submission.

### Backend Validation with Zod

Again, Zod is a powerful schema validation library that allows us to define expected input formats and error messages. We had used it in a previous lesson.

In your `/app/lib/actions.ts` file, define a `FormSchema` using Zod (most of this should be familiar to you):

```ts
import { z } from 'zod';

const FormSchema = z.object({
  id: z.string(),
  customerId: z.string({
    invalid_type_error: 'Please select a customer.',
  }),
  amount: z.coerce
    .number()
    .gt(0, { message: 'Please enter an amount greater than $0.' }),
  status: z.enum(['pending', 'paid'], {
    invalid_type_error: 'Please select an invoice status.',
  }),
  date: z.string(),
});
```

Explanations:
- `customerId`: Ensures a customer is selected, otherwise returns an error.
- `amount`: Converts input to a number and ensures it is greater than 0.
- `status`: Ensures a valid invoice status (`"pending"` or `"paid"`) is selected.

### Handling Form Submission

Update the `createInvoice` server action to process form validation.

Modify the `createInvoice` action at `app/lib/actions.ts`:
```ts
export type State = {
  errors?: {
    customerId?: string[];
    amount?: string[];
    status?: string[];
  };
  message?: string | null;
};

export async function createInvoice(prevState: State, formData: FormData) {
  // Validate form fields using Zod
  const validatedFields = FormSchema.safeParse({
    customerId: formData.get('customerId'),
    amount: formData.get('amount'),
    status: formData.get('status'),
  });

  // If validation fails, return errors
  if (!validatedFields.success) {
    return {
      errors: validatedFields.error.flatten().fieldErrors,
      message: 'Missing Fields. Failed to Create Invoice.',
    };
  }

  // Extract validated data
  const { customerId, amount, status } = validatedFields.data;
  const amountInCents = amount * 100;
  const date = new Date().toISOString().split('T')[0];

  // Insert into database
  try {
    await sql`
      INSERT INTO invoices (customer_id, amount, status, date)
      VALUES (${customerId}, ${amountInCents}, ${status}, ${date})
    `;
  } catch (error) {
    return {
      message: 'Database Error: Failed to Create Invoice.',
    };
  }

  // Revalidate cache and redirect user
  revalidatePath('/dashboard/invoices');
  redirect('/dashboard/invoices');
}
```

Key Enhancements:
- **Using `safeParse()`**: Unlike `parse()`, it returns a structured result, allowing graceful error handling without `try/catch`.
- **Returning Errors Early**: If validation fails, errors are returned before the database query runs.
- **Graceful Database Error Handling**: If an error occurs during insertion, a specific error message is returned.

### Display Backend Validation Errors in the Form Component

To provide user feedback, update `/app/ui/invoices/create-form.tsx` to display errors dynamically:
```tsx
export default function Form({ customers }: { customers: CustomerField[] }) {
  const initialState: State = { message: null, errors: {} };
  const [state, formAction] = useActionState(createInvoice, initialState);

  return (
    <form action={formAction}>
      <label>
        Customer:
        <select name="customerId">
          <option value="">Select a customer</option>
          {customers.map((customer) => (
            <option key={customer.id} value={customer.id}>
              {customer.name}
            </option>
          ))}
        </select>
      </label>
      {state.errors?.customerId && <p>{state.errors.customerId[0]}</p>}

      <label>
        Amount:
        <input type="text" name="amount" />
      </label>
      {state.errors?.amount && <p>{state.errors.amount[0]}</p>}

      <label>
        Status:
        <select name="status">
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
        </select>
      </label>
      {state.errors?.status && <p>{state.errors.status[0]}</p>}

      <button type="submit">Create Invoice</button>
      {state.message && <p>{state.message}</p>}
    </form>
  );
}
```

Explanation:
- **`state.errors?.customerId`**: If an error exists, it is displayed below the field.
- **General Messages**: A message is shown if an overall validation error occurs.

---
  
>[!note] Differences to official docs
>
>The official docs have you run `pnpm lint`  (still equivalent to `npm lint` ) and it didn’t instruct to choose Strict or a less strict option. The next step in the official docs is that there should be no warnings or errors from ESLint. However, there will be errors because the boilerplate contains unused variables which is something that ESLint warns about. So my tutorial addresses those errors..