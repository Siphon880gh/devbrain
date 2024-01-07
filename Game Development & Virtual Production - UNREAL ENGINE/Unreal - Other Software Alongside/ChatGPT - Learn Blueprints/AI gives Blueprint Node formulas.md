### Status: Not entirely reliable answers...
Not entirely reliable answers from AI, and it will gaslight you saying it is correct. After it gives you the nodes, that's a good point to read the node documentation on Unreal, look up Google Images, and read forums via google search.

### << Hi, you know Unreal Editor 5.3. Give me a list of blueprint formulas for most commonly used designs

\>>
It appears there is an issue with accessing specific pages from the Unreal Engine documentation directly through this tool. However, you can find a list of commonly used Blueprint formulas for designs in Unreal Engine 5.3 by visiting the official Unreal Engine documentation site.

The documentation provides comprehensive guides and tutorials on various aspects of Blueprints, including best practices, basic user guides, types of Blueprints, and quick start guides. These resources are designed to help users of all levels, from beginners to advanced, and cover the core aspects needed to work with Blueprints, such as creating Blueprints, adding and connecting nodes, creating variables, and much more.

To get the most commonly used Blueprint formulas for designs, you should look into the following sections on the Unreal Engine documentation website:

1. **Blueprint Best Practices**: Offers guidance on how to effectively use Blueprints in your projects.
2. **Blueprint Basic User Guide**: Provides an introduction to the creation and utilization of Blueprints.
3. **Blueprint Tutorials**: Includes a variety of tutorials that cover the essentials of using Blueprints in Unreal Engine.
4. **Quick Start Guide**: Helps you to quickly get started with Blueprints by walking you through the basic steps.

Each section is likely to provide sample Blueprints, best practices for setting them up, and tips for optimizing performance and maintainability.

Please visit [Unreal Engine Documentation](https://docs.unrealengine.com/) and navigate to the Blueprint section for Unreal Engine 5.3 to access this information.

---

### \<< Make a cheat sheet or reference sheet. Just list the Nodes sequences

\>>
Creating a cheat sheet with a list of common Blueprint node sequences in Unreal Engine 5.3 would be a bit extensive, as there are many nodes and sequences used for different purposes. However, I can provide a general outline of some basic and commonly used node sequences that serve as the foundation for many Blueprints:

1. **Event Graph Basics:**
   - **BeginPlay** → **Print String**: Used to display a message when the game starts.
   - **Event Tick** → **Add Movement Input**: Continuously applies movement to an actor.

2. **Input Handling:**
   - **InputAction** → **Branch** → **Add Force**: Handles input to apply a force.
   - **InputAxis** → **Multiply (Float)** → **Add Torque**: Applies torque based on axis input.

3. **Variable Manipulation:**
   - **Set Variable** → **OnRep**: Sets a variable and then performs an action when it's replicated.
   - **Get Variable** → **Branch** → **Do N**: Checks a condition before performing an action a set number of times.

4. **Timers and Delays:**
   - **Set Timer by Function Name** → **Custom Function**: Calls a function after a delay.
   - **Delay** → **Spawn Actor**: Delays the spawning of an actor.

5. **Spawning and Destroying:**
   - **BeginOverlap** → **Spawn Actor From Class**: Spawns an actor when an overlap begins.
   - **AnyDamage** → **Destroy Actor**: Destroys the actor when it takes damage.

6. **Animation and Sound:**
   - **Play Animation** → **Sequence**: Plays an animation sequence.
   - **Play Sound At Location**: Plays a sound at a specific location in the world.

7. **UI Interactions:**
   - **Create Widget** → **Add to Viewport**: Creates and displays a UI widget.
   - **OnClicked (Button)** → **Remove from Parent**: Removes a UI widget when a button is clicked.

8. **Math and Logic Operations:**
   - **Equal (Float)** → **Branch**: Checks if two floats are equal and branches logic based on that.
   - **For Loop** → **Array Get**: Iterates over an array to perform actions on each element.

9. **Networking and Multiplayer:**
   - **Switch Has Authority** → **Multicast Event**: Ensures an action is performed across the network.
   - **Replicated Variable** → **OnRep Function**: Calls a function when a replicated variable changes.

10. **AI and Pathfinding:**
    - **Move To Location or Actor**: Commands an AI to move to a specific location or actor.
    - **Get Random Point In Navigable Radius**: Finds a random point for AI to navigate to.

For specific node sequences tailored to particular design patterns or more complex functionalities, it would be best to refer to the Unreal Engine documentation or community forums where developers share their own Blueprints and node setups for various use cases. Keep in mind that the sequences will vary greatly depending on the context and purpose within the game or application.

---

### << I meant, add more subitems under each item. Also, please continue the list. This is great!


\>>
Absolutely, I can expand each item with more detailed subitems and continue the list with additional common Blueprint node sequences:

1. **Event Graph Basics:**
   - **BeginPlay → Print String**: 
     - **Get Player Controller → Print String**: Could be used alongside to specify which player’s start of the game is being logged.
   - **Event Tick → Add Movement Input**:
     - **Get Actor Forward Vector → Multiply (Float) → Add Movement Input**: To move the actor forward based on the tick rate.

2. **Input Handling:**
   - **InputAction → Branch → Add Force**:
     - **Get Player Character → Add Force**: Specifies which character the force is applied to.
   - **InputAxis → Multiply (Float) → Add Torque**:
     - **Get Actor Rotation → Add Torque**: Specifies that the torque is applied based on the actor’s current rotation.

3. **Variable Manipulation:**
   - **Set Variable → OnRep**: 
     - **Validate Variable → Set Variable**: Ensuring the variable meets certain conditions before setting it.
   - **Get Variable → Branch → Do N**: 
     - **Increment Integer → Set Variable**: To keep track of how many times the 'Do N' loop has run.

4. **Timers and Delays:**
   - **Set Timer by Function Name → Custom Function**:
     - **Clear Timer by Function Name**: To stop the timer if needed.
   - **Delay → Spawn Actor**:
     - **IsValid → Spawn Actor**: To check if the spawning location or conditions are valid before spawning.

5. **Spawning and Destroying:**
   - **BeginOverlap → Spawn Actor From Class**:
     - **Cast To Specific Actor → Spawn Actor**: To ensure that only certain actors trigger the spawn.
   - **AnyDamage → Destroy Actor**:
     - **Apply Damage → Destroy Actor**: To apply damage to an actor before deciding whether to destroy it.

6. **Animation and Sound:**
   - **Play Animation → Sequence**:
     - **Is Valid Check → Play Animation**: To verify the animation sequence is valid before playing it.
   - **Play Sound At Location**:
     - **Get Actor Location → Play Sound At Location**: To ensure the sound plays exactly where the actor is.

7. **UI Interactions:**
   - **Create Widget → Add to Viewport**:
     - **Set Widget To Focus → Create Widget**: To immediately focus on the widget after creation.
   - **OnClicked (Button) → Remove from Parent**:
     - **Play Sound → OnClicked**: To provide audio feedback when a button is clicked.

8. **Math and Logic Operations:**
   - **Equal (Float) → Branch**:
     - **Float > Float → Branch**: To check if one float is greater than another before branching.
   - **For Loop → Array Get**: 
     - **Array Length → For Loop**: To loop over the entire array without hardcoding the length.

9. **Networking and Multiplayer:**
   - **Switch Has Authority → Multicast Event**:
     - **Is Server → Switch Has Authority**: To further ensure that only the server performs certain actions.
   - **Replicated Variable → OnRep Function**:
     - **Get All Players → Replicated Variable**: To update all players with the new value.

10. **AI and Pathfinding:**
    - **Move To Location or Actor**:
      - **AI Find Path to Location → Move To**: To dynamically find a path before moving.
    - **Get Random Point In Navigable Radius**:
      - **Get NavMesh Bounds Volume → Get Random Point**: To ensure the point is within the navigable area.

11. **Physics and Collisions:**
    - **OnComponentHit → Apply Damage**:
      - **Break Hit Result → Apply Damage**: To apply damage based on the specifics of the hit, such as the impact strength.
    - **OnComponentBeginOverlap → Toggle Visibility**:
      - **Get Other Actor → Cast To Specific Actor


----

### ChatGPT Thread: Ask it to go into detail on any specific one if needed
https://chat.openai.com/c/52306686-2519-449f-81a5-b99ee728c2ab
