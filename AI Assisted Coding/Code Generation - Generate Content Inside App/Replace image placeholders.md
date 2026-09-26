Goal: Replace all image placeholders in the application with actual generated images. For images that require visual consistency, first identify which images need to be generated, then use them as reference images when prompting the generation of related images.

Note: This workflow is designed for use inside a chat-based agentic coding environment, such as Cursor with Claude, Grok, or another agentic model.

---

## Guide
The chat agent will inspect the application, determine which images are needed, and create a structured image-generation plan. The user will then generate those images by following the prompts produced by the agent. Once the generated files are placed back into the project, the agent will integrate them into the application.

Image consistency should be planned automatically as part of this workflow. If multiple generated images need to depict the same person, character, product, environment, object, visual identity, or other recurring subject consistently, the workflow should identify that dependency ahead of time.

The agent should create the necessary reference image first and place it earlier in the generation sequence. Any later image that depends on that visual identity should explicitly instruct the user to use the previously generated image as an image reference.

The agent should determine these relationships automatically while inspecting the application and encode them into `IMAGE_PLACEHOLDERS.md`.

## Chat agent prompt

```
You will guide the user through a two-phase workflow whose purpose is to replace all image placeholders in the application with actual image content created through image generation.

At the beginning, briefly explain this purpose to the user and tell them how the workflow works:
- **Phase 1:** Inspect the application, discover every image placeholder, determine image consistency and reference-image dependencies, and create an `IMAGE_PLACEHOLDERS.md` generation plan.
- The user then generates the required images by following the prompts in that file. 
- When an entry requires an image reference, the user should use the previously generated reference file specified in `IMAGE_PLACEHOLDERS.md`. 
- Every generated image must be saved using the exact filename specified in `IMAGE_PLACEHOLDERS.md` and placed inside the `pipe/` folder.
- **Phase 2:** Once those files are present, read `IMAGE_PLACEHOLDERS.md` and integrate the generated images into the application.
    
Guide the user through Phase 1 first.

Do not automatically proceed into Phase 2.

After Phase 1 is complete, tell the user that they must generate the listed images and place them inside `pipe/` using the exact filenames specified in `IMAGE_PLACEHOLDERS.md`.

Then ask the user to tell you when they are ready for Phase 2.

Only begin Phase 2 after the user confirms that the generated files have been placed in `pipe/`.

---

## Phase 1 — Discover image placeholders and create `IMAGE_PLACEHOLDERS.md`

First, inspect the application and identify every location where an image is currently missing, represented by a placeholder, represented by temporary or mock imagery, or otherwise requires a generated image.

Search the relevant pages, components, screens, data files, and UI flows. Do not rely on a manually provided list. Determine the required images by examining the app itself.

While inspecting the app, also identify relationships between images.

Determine whether multiple images need to maintain consistency in areas such as:
- People or characters
- Products
- Locations or environments
- Objects or devices
- Recurring props
- Clothing or accessories
- Visual style
- Any other repeated visual identity

When consistency is required, determine which image should become the canonical reference image and ensure that it is generated before any images that depend on it.

Create:

`IMAGE_PLACEHOLDERS.md`

This file should act as the complete image-generation plan for the app.

For every image placeholder you discover, document:
- Where it appears in the app.
- The component, page, screen, or feature that uses it.
- What the image is supposed to depict.
- The exact filename the generated image should use.
- A detailed image-generation prompt.
- Any previously generated image that should be used as an image reference.
- Any consistency requirements such as recurring people, products, environments, objects, branding, lighting, composition, or visual style.

Also create:

`pipe/`

This folder will eventually contain all generated images.

### Image dependency ordering

Order `IMAGE_PLACEHOLDERS.md` according to generation dependencies.

If certain images must be generated first because they will serve as visual references for later images, place those images at the beginning of the list.

For example, if multiple images must depict the same person, product, environment, object, or visual identity, first create a canonical reference image for that subject.

Later entries should explicitly state which previously generated file should be used as the image reference.

Example:

`Use pipe/reference-product.png as the image reference.`

Do the same for any reusable reference assets.

A dependency sequence might look like:
1. `reference-character.png`
    - Establishes the canonical appearance of the character.   
2. `character-office.png`
    - Use `pipe/reference-character.png` as the image reference.
3. `character-cafe.png`
    - Use `pipe/reference-character.png` as the image reference. 
4. `character-product-demo.png`
    - Use `pipe/reference-character.png` as the image reference.   
    - If a product reference also exists, use that image as an additional reference when supported.    

Reference images should appear before every item that depends on them.

Do not assume that repeating the same textual description is sufficient for consistency when an image reference can be used.

### Required format for each entry

Each item in `IMAGE_PLACEHOLDERS.md` should include enough information that the user can generate the images sequentially without having to inspect the application again.

Include at minimum:
1. Placeholder or location in the app
2. Generated filename
3. Image-generation prompt
4. Image reference(s), if applicable
5. Dependency information, if applicable
6. Notes about visual consistency, composition, aspect ratio, or intended usage 

The generated filename should correspond clearly to its purpose and must be the exact filename expected later inside `pipe/`.

For reference-dependent images, make the dependency highly visible.

For example:
**Filename:** `character-office.png`

**Reference image:** `pipe/reference-character.png`

**Generation prompt:**  
Generate the same character shown in the provided reference image, now sitting at a desk in a modern office...

### Complete Phase 1

Do not integrate or replace images in the app during Phase 1.

Phase 1 ends when:
- The app has been inspected for image placeholders.
- `IMAGE_PLACEHOLDERS.md` contains the complete discovered image list.
- Visual consistency requirements have been identified.
- Reference-image dependencies have been identified.
- Image dependencies have been ordered correctly.
- Reference images appear before the images that depend on them.
- Every image has an exact target filename.
- Every image has a generation prompt.
- Every dependent image clearly identifies which reference image or images should be used.
- `pipe/` exists and is ready to receive the generated assets. 

Once Phase 1 is complete, explain to the user that they should now work through `IMAGE_PLACEHOLDERS.md` and generate the images.

Remind them:
- Generate the images in the listed order when dependencies exist.
- Generate reference images first.
- When an entry specifies a reference image, use that generated image as the image reference for the new generation.
- Save every generated image using the exact filename given in `IMAGE_PLACEHOLDERS.md`.
- Put every completed image inside `pipe/`.

Then ask the user to tell you when the files are ready and they want to continue to Phase 2.

Do not proceed further until the user confirms.

---

## Phase 2 — Read generated images from `pipe/` and integrate them

Begin Phase 2 only after the user confirms that the generated files are ready.

At the beginning of Phase 2, the images described in `IMAGE_PLACEHOLDERS.md` should already exist inside:
`pipe/`

and should use the exact filenames specified in `IMAGE_PLACEHOLDERS.md`.

Before modifying the application:
1. Read `IMAGE_PLACEHOLDERS.md`.
2. Inspect the contents of `pipe/`.
3. Compare the expected filenames against the actual files in `pipe/`.
4. Match each generated image to the placeholder or location documented in the MD file.
5. Identify any required images that are missing, incorrectly named, duplicated, or otherwise cannot be matched.

If required files are missing or incorrectly named, do not silently substitute another image. Tell the user what needs to be corrected before continuing with those placeholders.

Once the necessary files are available:
Copy each generated image from `pipe/` into the application’s appropriate persistent asset location, preserving the exact filename unless the framework requires a documented change. Update the application to reference the copied asset, never the original file in `pipe/`. Do not leave any runtime image paths, imports, or URLs pointing to `pipe/`. After integration, verify that the app still resolves every image correctly when `pipe/` is removed.

Preserve the intended:
- Image sizing
- Cropping
- Aspect ratio
- Responsive behavior
- Layout
- Visual hierarchy
- Existing component behavior

After integration, verify that every item in `IMAGE_PLACEHOLDERS.md` has been addressed.

Report any:
- Missing images
- Unused generated images
- Unmatched files
- Remaining placeholders
- Broken image paths
- Incorrect mappings

The workflow is complete when all applicable image placeholders have been replaced with their intended generated content and the application has been checked for remaining placeholder imagery.
```

---

You can manually generate the required images then tell chat you're ready for Phase 2. Or you can automate:

## Prefer automated image generations (to replace the image placeholders)

This may be too much of a manual process. If you're paying for Higgsfield, you can connect to the Higgsfield MCP. If you're paying for ChatGPT, you can use the Codex CLI

### Higgsfield

Extract how to connect Higgsfield MCP at:
[[Loop Prompting with Higgsfield MCP - Fill an App or Game with Images and Videos Using Higgsfield MCP and Cursor Loops]]

Your prompt would be:
```
Use Higgsfield MCP to create the images according to IMAGE_PLACEHOLDERS.md and place them into pipe/
```

### Codex CLI

Codex CLI can generate images natively. Because Codex is optimized for coding, it may sometimes get confused by a plain-text request and try to write image-generation code instead of creating the asset. The Trigger Word: To force image generation, prepend your prompt with the $imagegen skill keyword.

But! The feature might not work right out of the box. Run the enable command in your terminal:
```
codex features enable image_generation
```

Now you can prompt after entering codex cli:
```
Use the $imagegen skill to create the images according to IMAGE_PLACEHOLDERS.md and place them into pipe/
```

In an example, lets say we have a postop wound photo viewer. There is a sample patient with generic image placeholders for heel wound photos. Codex CLI may report:
Explored
  └ Read IMAGE_PLACEHOLDERS.md

• I found 14 required files with a strict reference chain: two independent portraits, then one
  canonical heel image followed by 11 continuity-matched clinical images. I’m starting with the
  two portraits and will then build the heel series in the listed order so each reference is
  available before the next image is generated.

• Generated Image:
  └ Create a...

How it looks:
![[Pasted image 20260925221341.png]]
![[Pasted image 20260925221322.png]]

When finished, the report shows it knew to show wounds progressively healed, and in that way, there needed to be reference photo from every last step:
![[Pasted image 20260925222955.png]]

![[Pasted image 20260925223011.png]]