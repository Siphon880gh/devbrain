
You need two objects stacked vertically top to down:
- Directional Light
- SkyAtmosphere


**Rotate the Y axis of Directional Light**
Now if you rotate the Directional Light's vector so it crosses the plane further, you'll see unreal engine recalculate's the sun's position. You can see it's mirror based

![](https://i.imgur.com/P10PHaQ.png)


![](https://i.imgur.com/TmTqUH6.png)


If you had rotated the directional light away from the SkyAtmosphere even more, it'll become night time. The sun is now rotating on the bottom half of the map.as

---

## Note on SkyLight

You may have thought Skylight is what allows you to change the sun orientation but that is NOT the case

Sky light in Unreal Engine is a feature that simulates the **ambient light** that comes from the sky, which is essential for creating realistic outdoor scenes. Unlike directional lights that simulate sunlight with a specific direction and shadow casting, sky lights capture the sky's ambient light, providing illumination that fills the scene softly from all directions. This creates a more natural and realistic lighting environment by simulating the diffuse light that comes from the sky, even on cloudy days or in shadows.

You can have Directional Light with SkyAtmosphere and not have SkyLight

---

## Explanation


Background: Imagine a flat plane at the SkyAtmosphere object. Now depending on where the directional light's vector hits or where it's pointing away from the SkyAtmosphere's plane, this will emulate where the sun will be in the sky, hence causing daytime/night times. This plane represents the sky's atmosphere and the directional light object represents the sun!

Here the directional plane is shinning directly into the atmosphere (here imagined as a blue plane intersecting the SkyAtmosphere)
![](https://i.imgur.com/n0lSgr5.png)


It doesn't matter SkyAtmosphere's rotation or position, whether it's above or below the directional light, because unreal engine will treat it as if SkyAtmosphere is below the directional light.

With the DirectionalLight pointing directly down into the SkyAtmosphere, you can imagine the sun is now directly above the center of the sky. And it is:
![](https://i.imgur.com/BEdgTnl.png)

Center of the sky
![](https://i.imgur.com/ldfgshh.png)



