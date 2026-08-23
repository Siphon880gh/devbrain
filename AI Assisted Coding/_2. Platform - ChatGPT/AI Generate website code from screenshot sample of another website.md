Use model: ChatGPT 4 paid

PROMPT 1
Describe this website layout: `<Upload image>`

PROMPT 2
Help me create a tailwind page from the website description you provided. For images, you can add placeholders with placehold.com, for example https://via.placeholder.com/150x150.

Expected prompt 2 response:
```
<!DOCTYPE html>  
<html lang="en">  
<head>  
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <title>Financial Solutions Inc.</title>  
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.4/dist/tailwind.min.css" rel="stylesheet">  
</head>  
<body class="bg-gray-100 text-gray-900">  
  
  <!-- Header -->  
  <nav class="bg-white px-6 py-4 shadow">  
    <div class="flex justify-between">  
      <div class="text-xl text-blue-600 font-semibold">Financial Solutions Inc.</div>  
      <div class="space-x-4">  
        <a href="#" class="text-gray-600 hover:text-blue-600">About Us</a>  
        <a href="#" class="text-gray-600 hover:text-blue-600">Services</a>  
        <a href="#" class="text-gray-600 hover:text-blue-600">Contact</a>  
      </div>  
    </div>  
  </nav>  
  
  <!-- Main Content -->  
  <div class="container mx-auto px-6 py-10">  
    <!-- Company Info -->  
    <div class="flex items-center space-x-6 mb-8">  
      <img src="https://via.placeholder.com/150" alt="Company Logo" class="rounded-full">  
      <div>  
        <h2 class="text-2xl font-semibold mb-2">Financial Solutions Inc.</h2>  
        <p class="text-gray-700">At Financial Solutions Inc., we empower our clients with bespoke financial strategies and services. Our team of experienced consultants is dedicated to helping you achieve financial stability and growth. Whether it's investment advice, retirement planning, or tax strategies, we are here to guide you every step of the way.</p>  
      </div>  
    </div>  
  
    <!-- Services -->  
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">  
      <div class="text-center p-4 shadow rounded-lg">  
        <img src="https://via.placeholder.com/400x300" alt="Investment Planning" class="mb-3 mx-auto">  
        <h3 class="text-lg font-semibold">Investment Planning</h3>  
        <p class="text-gray-600">Tailored investment strategies to grow your wealth.</p>  
      </div>  
      <div class="text-center p-4 shadow rounded-lg">  
        <img src="https://via.placeholder.com/400x300" alt="Retirement Planning" class="mb-3 mx-auto">  
        <h3 class="text-lg font-semibold">Retirement Planning</h3>  
        <p class="text-gray-600">Secure your future with retirement plans.</p>  
      </div>  
      <div class="text-center p-4 shadow rounded-lg">  
        <img src="https://via.placeholder.com/400x300" alt="Tax Advisory" class="mb-3 mx-auto">  
        <h3 class="text-lg font-semibold">Tax Advisory</h3>  
        <p class="text-gray-600">Optimize your tax obligations with expert advice.</p>  
      </div>  
    </div>  
  
    <!-- Contact Us -->  
    <div class="bg-white p-6 shadow rounded-lg">  
      <h3 class="text-lg font-semibold mb-4">Contact Us</h3>  
      <form action="#" method="POST">  
        <div class="mb-4">  
          <label for="name" class="block text-gray-600 mb-2">Name</label>  
          <input type="text" id="name" name="name" placeholder="Your Name" class="w-full px-3 py-2 border rounded">  
        </div>  
        <div class="mb-4">  
          <label for="email" class="block text-gray-600 mb-2">Email</label>  
          <input type="email" id="email" name="email" placeholder="Your Email" class="w-full px-3 py-2 border rounded">  
        </div>  
        <div class="mb-4">  
          <label for="message" class="block text-gray-600 mb-2">Message</label>  
          <textarea id="message" name="message" placeholder="Your Message" class="w-full px-3 py-2 border rounded" rows="4"></textarea>  
        </div>  
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Send</button>  
      </form>  
    </div>  
  </div>  
  
  <!-- Footer (Optional) -->  
  <footer class="bg-white px-6 py-4 shadow mt-8">  
    <p class="text-center text-gray-600 text-sm">  
      &copy;2024 Financial Solutions Inc. All rights reserved.  
    </p>  
  </footer>  
  
</body>  
</html>
```

THEN: Try it out in browser
Describe more in the next prompt if you want to adjust the layout