
For rendering realistic skies, the unreal engine models these effects using a combination of Sky Light, Atmospheric Fog, Volumetric Clouds, and the Sky Atmosphere component, which together provide a comprehensive system for simulating the behavior of light as it travels through the Earth's atmosphere. These components take into account the Rayleigh scattering, which is primarily responsible for the blue sky, and Mie scattering, which accounts for the white appearance of the sunlight that is scattered by larger particles like water droplets and dust.

Sky Atmosphere: This component simulates the scattering and absorption of light as it passes through the Earth's atmosphere. It models the effects of different layers of the atmosphere, including the troposphere and stratosphere, and their impact on light behavior. This includes the effect of gases and particles in the atmosphere that diffuse and scatter sunlight, creating the gradients of color seen at different times of the day.

Atmospheric Fog: Provides a way to simulate the interaction of light with particles in the air, further enhancing the realism of atmospheric effects. It can represent the density and distribution of water vapor and other atmospheric particles, affecting how light diffuses and creating depth in the scene.

When a Sky Light captures the ambient light from the sky, it takes into account the color and intensity variations caused by clouds and other atmospheric phenomena. This results in a more natural and dynamic lighting environment that reflects the soft, diffused light characteristic of overcast days or the subtle variations in light and shadow under partly cloudy skies.

These systems work together to simulate how light is diffused by natural gases in the atmosphere, affecting the overall lighting and coloration of the scene. By adjusting parameters within these components, developers can achieve a wide range of atmospheric conditions, from clear, sunny skies to overcast or polluted atmospheres, each with its unique lighting characteristics. This level of control allows for the creation of highly realistic environments that accurately reflect the complexities of natural light diffusion in the atmosphere.

The system also models Rayleigh and Mie scattering for realistic sky colors and the visual effects of sunlight at different times of the day. You can change the default Rayleigh and Mie settings at the SkyAtmosphere details

![](https://i.imgur.com/x3TCc9R.png)


---

Rayleigh Scattering
![](https://i.imgur.com/094bJJd.png)

Mie Scattering
![](https://i.imgur.com/2rgvCNd.png)


To read about Rayleigh scattering and Mie scattering:
https://laulima.hawaii.edu/access/content/group/dbd544e4-dcdd-4631-b8ad-3304985e1be2/book/chapter_2/scatter.htm

Diffusing through clouds
![](https://i.imgur.com/PgtrPIF.png)
Picture source: http://ww2010.atmos.uiuc.edu/%28Gh%29/guides/mtr/opt/mch/sct.rxml

