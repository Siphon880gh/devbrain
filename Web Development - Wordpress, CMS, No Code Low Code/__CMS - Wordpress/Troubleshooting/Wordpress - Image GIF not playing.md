It may be because Wordpress is generating different sized images for mobile, tablets, etc, and those lost animation. Here are the steps to resolve:

- Make sure to place the image in a single image element, not a text block.
- Make it full image in the Single Image settings (that way, it won’t refer to the different sized generated images)
- To properly resize smaller, you can use % margins left and right. The height will adjust accordingly to keep aspect ratio!
- Keep in mind, you may need different margins for different devices to keep the icon sized appropriately on different devices.