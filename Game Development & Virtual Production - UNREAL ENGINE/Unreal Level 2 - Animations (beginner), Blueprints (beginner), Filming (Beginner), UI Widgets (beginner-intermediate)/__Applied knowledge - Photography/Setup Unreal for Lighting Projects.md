There are several reasons why for lighting projects (scening, virtual production, etc) you need to set different options. Unreal is originally for game developers who cannot spend endless hours to program lighting when they have other game logic to worry about. Another reason is that if you have all the lighting rendered during editing, it'll slow down the editing experience.

Because we want to see the lighting while editing to be precisely the output when we are finished, we have to enable certain settings.

---


Project Settings:
Search:directx -> Default RHI at DirectX12;
.. -> DirectX 11 & 12 (SMS): ON

Rendering tab -> Lumen section -> Dynamic Global Illumination Method: Lumen;
..-> .. -> Ray-Lighting Mode: Surface Cache;
..-> .. -> Software Ray Tracing Mode: Digital Tracing;
..-> .. -> Shadow Map Method: Virtual Shadow Maps (Beta);
..-> .. -> Support Hardware  Ray Tracing: ON;
..-> .. -> Use Hardware Ray Tracing when available: ON;

https://youtu.be/fSbBsXbjxPo?t=97

---

Turn off automatic lighting and exposure (for games because a lot of C++ programming). But for scene work, we want the true lighting while editing:

Off automatic lighting:
![](https://i.imgur.com/IUVTrSp.png)


Off Auto Exposure and make sure it's set to Manual:
![](https://i.imgur.com/fFt8AXn.png)


You may notice that while editing the level could appear dimmer/darker, but while playing, the lighting is blown up, more than you'd say the exposure settings in your camera actor can affect. You want to tick off "Allow Static Lighting", then you need to restart (it'll take a while to boot back up):

Tick off "Allow Static Lighting"
![](https://i.imgur.com/Z8reIHj.png)
