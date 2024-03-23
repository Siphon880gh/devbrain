If your Windows Forms application is stretching to fill the entire desktop and you want to set it to a specific width and height, you can easily configure this by adjusting the properties of the form. Here's a step-by-step guide to set a specific width and height for your form:

1. **Setting Size in the Designer:**
   - Open your form in the Visual Studio Designer.
   - In the Properties window, find the "Size" property.
   - You can set the "Size" property to your desired width and height (in pixels). For example, if you want the form to be 800 pixels wide and 600 pixels tall, you would enter "800, 600" in the Size property.

2. **Setting Size Programmatically:**
   If you prefer to set the size in your code, you can do so in the form's constructor or in the `Form_Load` event handler. Here's how you can set it in the form's constructor:
   ```csharp
   public MyForm()
   {
       InitializeComponent();
       this.Size = new Size(800, 600); // Set the width to 800 and the height to 600
   }
   ```
   Replace `800` with your desired width and `600` with your desired height.

3. **Preventing Resizing:**
   If you want to prevent the user from resizing the form, you can set the `FormBorderStyle` property to `FixedDialog`, `FixedSingle`, or `Fixed3D`:
   - In the Designer: Find the `FormBorderStyle` property in the Properties window and set it to one of the fixed styles.
   - Programmatically: Add this line in your form's constructor or Form_Load event: `this.FormBorderStyle = FormBorderStyle.FixedSingle;`

4. **Centering the Form on Screen:**
   If you want the form to start centered on the screen, set the `StartPosition` property to `CenterScreen`:
   - In the Designer: Find the `StartPosition` property and set it to `CenterScreen`.
   - Programmatically: Add this line in your form's constructor or Form_Load event: `this.StartPosition = FormStartPosition.CenterScreen;`

By following these steps, you can control the size of your Windows Forms application and prevent it from auto-stretching to fill the desktop.