
Controlling content in notch area aka safe area inset of iPhones
![](cRidnh3.png)


Your content could show there in the inset, so you may want to first reset the content to 100% when in landscape but then add a padding left to push the content into the traditional rectangle aka safe area. This way, the camera notch doesn't get in the way.

Let's say we are considering the landscape view for viewers who rotate the phone into landscape

```
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

<style>
@media screen and (orientation: landscape) {
	.content {
		width:100%;
		box-sizing: border-box;
		position: relative;
		padding-left: 35px !important;
	}
}
</style>
```