
Can you use programing to supplement your unreal editing work?
\> Yes!

What's the advantage?
\> Can be faster than dealing with the Blueprint nodes
https://youtu.be/sPYKLelPdIg
\> Can allow more customization


----


<<
Can you use c++ in Unreal Engine?

\>>
Yes, you can use C++ in Unreal Engine. In fact, C++ is the primary programming language used for developing games and interactive content in Unreal Engine. Unreal Engine provides a rich set of C++ APIs and frameworks that enable developers to create complex and high-performance game logic.

Here are some key points about using C++ in Unreal Engine:

1. **Native Support**: Unreal Engine is written in C++ and natively supports C++ for game development. This allows for high performance and control over game mechanics and interactions.

2. **Blueprint Visual Scripting**: For developers who are not as comfortable with C++, Unreal Engine also provides a visual scripting system called Blueprints. Blueprints can be used to create complete games and prototypes without writing code, but they can also interact seamlessly with C++ code, allowing for a combination of both scripting and coding.

3. **C++ Classes**: Unreal Engine uses a class system that extends its functionality through C++. Developers can create their own custom classes derived from the engine's base classes to customize game behavior.

4. **Hot Reloading**: Unreal Engine supports hot reloading of C++ code, which allows developers to compile their game's C++ code while the engine is running and see the results in real-time without restarting the application.

5. **Macros and Annotations**: Unreal Engine uses a custom preprocessor to parse C++ code and generate additional code that facilitates Unreal Engine's reflection system, serialization, garbage collection, and more. This is done using macros like `UCLASS()`, `UFUNCTION()`, `UPROPERTY()`, and others.

6. **Tooling**: The engine includes tools such as Unreal Visual Studio integration that make it easier to write and debug C++ code within the context of an Unreal project.

7. **Performance**: For performance-critical applications, such as high-end games, using C++ allows developers to optimize their code to take full advantage of the hardware capabilities.

8. **Extensibility**: C++ is used for creating plugins and extending the functionality of the Unreal Engine editor itself.

9. **Documentation and Community**: There is extensive documentation available for Unreal Engine's C++ API, and a large community of developers who use C++ with Unreal Engine, making it easier to learn and find support.

To get started with C++ in Unreal Engine, you typically need a solid foundation in C++ programming and a basic understanding of Unreal Engine's principles. From there, you can create new C++ classes, integrate them with Blueprints if needed, and leverage the full power of the engine for your game development projects.


---

<<
How about Unity?

\>>
Unity primarily uses C# as its scripting language, not C++. While it is possible to use native C++ code with Unity, it's not the standard approach and is generally more complex. Here's how you can work with or around C++ in Unity:

1. **C# Scripting**: The majority of the game development within Unity is done using C#. Unity's scripting engine is based on Mono, which allows for cross-platform C# scripting. Unity's version of C# is typically close to the latest version supported by Microsoft, with some differences due to the Mono backend.

2. **C++ Native Plugins**: If you need to use C++ for performance reasons or to integrate existing C++ libraries, you can create native plugins. A native plugin is essentially a C++ library that is compiled for the target platform and then called from C# code using Platform Invoke (PInvoke) or the Unity Native Plugin API. This is often used for platform-specific features, performance-critical code, or to integrate third-party SDKs that are only available in C++.

3. **Intermediate Language (IL2CPP)**: Unity offers an IL2CPP scripting backend which converts the C# code into C++ and then compiles it to native code for the platform. This process is transparent to the developer and is primarily an optimization step to improve performance and compatibility across different platforms.

4. **C++ with Unity**: If you have a game engine written in C++ or substantial C++ libraries you want to use, you would generally wrap them in a C interface and then use PInvoke from C# to interact with them. However, this does mean you'll need to manage the bridge between managed (C#) and unmanaged (C++) code, which can be non-trivial, especially with regards to memory management and performance considerations.

5. **External C++ Code**: In some cases, developers might choose to write parts of their application in C++ and then interact with Unity as a separate process. For example, heavy computations or certain types of simulations might be done in a separate C++ application or service, with Unity handling the rendering and user interaction.

While you can integrate C++ into your Unity project, the typical Unity workflow and the vast majority of tutorials, documentation, and community resources focus on C#. If you're familiar with C++ and moving to Unity, you'll likely find that many concepts translate well to C#, but you'll need to adapt to the new syntax and managed environment of the .NET framework used by Unity.