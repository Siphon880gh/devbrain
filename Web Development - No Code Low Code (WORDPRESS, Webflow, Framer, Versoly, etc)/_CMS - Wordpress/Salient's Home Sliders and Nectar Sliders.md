Salient has both types of Sliders you can access on the sidebar:

![[Pasted image 20250429194815.png]]
# Home Slider

The Home Slider is the original slider of Salient. Because it functions in a similar manner to the Nectar Slider but has less features, the only reason you would use this currently is if your prefer the style and can live without video backgrounds. It requires a page template to be assigned in order to add it to a page and because of this, it can only display one set of slides. i.e. you can’t have a Home Slider on different pages displays different slides.

**How to use:**
Quick edit on your page:
![[Pasted image 20250429195655.png]]

Change Template to: "Home - Slider Only"
![[Pasted image 20250429195632.png]]

When visiting the page, it'll automatically insert the Home Slider as the first section

Note the inflexibility with choosing another section on the page:
- You **cannot reposition** the Home Slider within the content.
- It is **hardcoded** to appear first due to the way the template is structured.
- If you want more placement flexibility (e.g., place a slider lower on the page), you should use a **Nectar Slider** within a page builder (WPBakery) or theme builder block instead.

Note the inflexibility with variations:
- You can only create **one set of slides total** for your entire site. This is because that single Home Slider is tied to a page template (like "Home with Slider"). And the Home Slider settings page is for designing each slide of the global Slider
  
  Home Slider settings page:
  ![[Pasted image 20250429201541.png]]
  
  Home Slider on front page:
  ![[Wordpress - Home Slider.gif]]
  
- You **can’t create separate Home Sliders** for different pages — it's always the **same slides** wherever used.

# Nectar Slider

You can have background videos AND variations

Note the flexibility:
- While you are creating multiple slides at Nectar Slider settings page, you can tag each slide to belonging to a Slider Location (think of it as category or slider name or slides collection).
- You can also rearrange the slides belonging to a Slider Location:
  ![[Pasted image 20250429203721.png]]

**How to use**:
When you add an element on the page (Backend Editor), search for Nectar Slider:
![[Pasted image 20250429203835.png]]

At the Nectar Slider element settings, you can select the Slide Location that you've tagged the slides to:
![[Pasted image 20250429203908.png]]

# Quick Comparison

| Feature                | Nectar Slider | Home Slider            |
| ---------------------- | ------------- | ---------------------- |
| Video background       | ✅ Yes         | ❌ No                   |
| Multiple sliders       | ✅ Yes         | ❌ No (only one global) |
| Page template required | ❌ No          | ✅ Yes                  |
| More customization     | ✅ Yes         | ❌ Limited              |

# Tips
You can have take up entire width of screen instead of having spaces on the left and right, especially if background video or background image.

![[Pasted image 20250429212505.png]]

^ You can also have the slider take up entire screen.