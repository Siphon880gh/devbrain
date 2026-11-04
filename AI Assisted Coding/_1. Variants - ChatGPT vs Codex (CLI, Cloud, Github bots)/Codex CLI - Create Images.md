Codex CLI can generate images natively. Because Codex is optimized for coding, it may sometimes get confused by a plain-text request and try to write image-generation code instead of creating the asset. The Trigger Word: To force image generation, prepend your prompt with the $imagegen skill keyword.

But! The feature might not work right out of the box. Run the enable command in your terminal:
```
codex features enable image_generation
```

Now you can prompt after entering codex cli:
```
Use the $imagegen skill to create an image of a dinosaur
```
