
<<
What design pattern or architecture pattern is this - I have different apps that use my automated video maker. Depending on the app, the font families, color scheme, etc of the video that's automatically made would be different. I track which app the user is on then what settings the video maker can apply based on the app, all in mysql.

\>>
The design pattern you're describing is often referred to as the **Strategy Pattern**. This pattern is used when you have multiple algorithms (or strategies) for a specific task, and the choice of algorithm can vary dynamically depending on the context.

In the case of your automated video maker:

- The context is the app the user is using.
- The strategies are the different configurations for font families, color schemes, etc.
- The video maker selects the appropriate strategy based on the app context.

Here's how it aligns with the Strategy Pattern:

1. **Context (The App):** This holds a reference to a Strategy instance and is configured with a ConcreteStrategy object.
    
2. **Strategy (Video Configuration Interface):** This is an interface that defines how the video maker should apply configurations, like setting font families and color schemes.
    
3. **Concrete Strategies (App-Specific Configurations):** These are classes that implement the Strategy interface in different ways. Each app would have its own ConcreteStrategy with specific settings for the video maker.
    

Using a database like MySQL to track which app is being used and to store the corresponding settings for each app is part of the data persistence layer. It's separate from the Strategy Pattern itself but is necessary to store the configuration details that the ConcreteStrategies will apply.