
On mobiles, make col take up 100%; but when it’s on bigger screens, the cols will distribute evenly

<div class="container">
  <div class="grid grid-cols-1 md:grid-cols-2">
    <div class="w-full md:w-auto">
      <!-- This column will take up 100% width on mobile devices and its default width on medium-sized screens and above -->
    </div>
    <div class="w-full md:w-auto">
      <!-- This column will take up 100% width on mobile devices and its default width on medium-sized screens and above -->
    </div>
  </div>
</div>

^Width auto?
The way browsers calculate an element's width automatically where Block level elements fill the available space of its parent and Inline elements shrink to the size of its children/content. ‍