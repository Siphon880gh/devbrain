
## CineCamera

This is the object you drop into the Level viewport to control the display, should this be your camera view when playing. It offers properties that mimic a camera's properties such as lens settings, etc

### How to place Cinecamera

Window -> Place Actors. At "Place Actors" panel, search for "Cinecamera". You dont need to add Blueprint. Later you can convert to blueprint if you need more complicated logic including animated movement of the camera.

Converting to Blueprint:
![](https://i.imgur.com/sKWndTP.png)


---

## Focal Length and Aperture

- Focal length is the distance between image sensor and lense inside the camera. this distance is inversely proportional to the wide/medium/close angle. Eg. Long focal length = close shot
- But you can also adjust the sensor width (under Filmback → Sensor/Width/Height). The lager the number, the wider the angle.  
    
- Aperture is the amount of light lit in, eg. camera lense “eyelids”. Language: “wide open”, “closed down”

- least saturated if super opened. but minimum depth of field
- most saturated if super closed. but thats max field of depth field
- so you choose your priority. saturation can be done in post production

- Practical example: a 24mm focal length with an aperture of f/1.2 is a combination that allows for wide-angle shots with a lot of light entering the lens, excellent for capturing expansive scenes with a pronounced focus on the subject and a blurred background.  
    
- Memory: Memorize number combinations for different photo capture settings (forest tourism, etc)

>[!Note] ChatGPT explaining above
>The numbers "24" and "1.2" in the context of photography refer to focal length and aperture, respectively.
>
> 1. Focal Length (24mm): This is the distance between the lens and the image sensor when the subject is in focus, usually stated in millimeters (mm). A 24mm focal length means you're using a wide-angle lens. Wide-angle lenses have a shorter focal length and provide a wider field of view. They are great for capturing landscapes, architectural photos, and other scenes where you want to include more in the frame.
> 2. Aperture (f/1.2): Aperture refers to the opening in a lens through which light passes to enter the camera body. It's expressed in f-numbers such as f/1.2, f/2.8, etc. A smaller number means a larger aperture. At f/1.2, the aperture is very wide, allowing a lot of light to enter the lens. This is excellent for low light conditions and for achieving a shallow depth of field, where the subject is in sharp focus but the background is blurred (bokeh effect).
>
> In summary, a 24mm focal length with an aperture of f/1.2 is a combination that allows for wide-angle shots with a lot of light entering the lens, excellent for capturing expansive scenes with a pronounced focus on the subject and a blurred background.


![](https://i.imgur.com/taFqrWS.png)



Here are where you set the filmback, lens, etc with CineCamera
![](https://i.imgur.com/XnJV6xb.png)


Reference: [https://youtu.be/YZ4gSKZh6do?t=194](https://youtu.be/YZ4gSKZh6do?t=194)

---

## Tracking

Can have the camera always focus on one object (simple scene, eg. short corridor level in a game where you’re only directed to approach the door - resident evil)

Have the CineCamera object selected in Outliner:
![](https://i.imgur.com/EdslUD7.png)


Focus Setting -> Focus Method: Tracking ,-> Tracking Focus Settings->Actor to Track -> Select your object by clicking in viewport or from dropdown


In this example, Cube is a named object in the level
![](https://i.imgur.com/C6FgOqu.png)

