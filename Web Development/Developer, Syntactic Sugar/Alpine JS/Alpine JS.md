
### Introduction to Alpine.js with a Recipe Card Creation Form Example

Alpine.js is a framework that allows you to enhance your HTML with reactive behavior. In this lesson, we'll craft a Recipe Card Creation Form that updates as users input their information.

#### Setup

Include Alpine.js for functionality and Tailwind CSS for styling in your HTML document's `<head>`.

```html
<script src="//unpkg.com/alpinejs" defer></script>
<link href="//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
```


## Example - Conditional Forms
#### HTML Structure

Our form will include sections for the recipe title and details, structured and styled using Tailwind. We initiate Alpine's data object with `x-data`.

```html
<div x-data="{ step: 1 }" class="...">
  <!-- Title and Description -->
  <h2>Recipe Card Creation Form</h2>
  <p>Fill in the details below to create your recipe card.</p>
  <!-- Form Start -->
  <form action="#" method="POST">
    <!-- Inputs will be detailed next -->
  </form>
</div>
```

#### Reactive Form Steps

We use the `step` property to display different inputs based on user interaction. The form begins with `step 1`.

```html
<div x-data="{ step: 1 }">
  <!-- Step 1: Recipe Name Field -->
  <input 
    x-model="recipeName"
    @input="step = recipeName.length > 0 ? 2 : 1"
    id="recipe-name" 
    type="text" 
    placeholder="Recipe Name">

  <!-- Step 2: Ingredient List Field -->
  <div x-show="step > 1">
    <input 
      id="ingredient-list" 
      type="text" 
      placeholder="List of Ingredients">
  </div>
</div>
```

#### Submission Button

The button at the end simulates creating a recipe card but prevents form submission for the purpose of this example. It's here you would link to your backend process.

```html
<button onclick="event.preventDefault();" class="...">
  Create Recipe Card
</button>
```

#### Conclusion

We've now adapted our form to create a Recipe Card instead of a video. This interactive form responds to user input by revealing additional fields, showcasing the dynamic capabilities of Alpine.js for building user interfaces.

By following this lesson, students can understand how to apply Alpine.js to create a simple yet reactive form that could be used in various web applications.

----

## Another Example - SPA

```
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Toggle Example</title>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div x-data="{ activePanel: 1 }" x-init="window.activePanel = activePanel" x-effect="window.activePanel = activePanel" class="w-full max-w-md p-4">

    <!-- Panel 1 -->
    <div x-show="activePanel === 1" class="bg-white p-6 border rounded-lg shadow-lg">
      <p class="text-gray-800 text-lg">Panel 1 content</p>
      <button @click="activePanel = 2" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-150">
        Show Panel 2
      </button>
    </div>

    <!-- Panel 2 -->
    <div x-show="activePanel === 2" class="bg-white p-6 border rounded-lg shadow-lg" style="display: none;">
      <p class="text-gray-800 text-lg">Panel 2 content</p>
      <button @click="activePanel = 3" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-150">
        Show Panel 3
      </button>
    </div>

    <!-- Panel 3 -->
    <div x-show="activePanel === 3" class="bg-white p-6 border rounded-lg shadow-lg" style="display: none;">
      <p class="text-gray-800 text-lg">Panel 3 content</p>
      <button @click="activePanel = 'none'" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-150">
        Finish
      </button>
    </div>
    
  </div>
</div>

</body>
</html>

```