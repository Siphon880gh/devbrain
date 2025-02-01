
```
2016-10-18 06:26:49.455995 Lunch[1559:32097] subsystem: com.apple.UIKit, category: HIDEventFiltered, enable_level: 0, persist_level: 0, default_ttl: 0, info_ttl: 0, debug_ttl: 0, generate_symptoms: 0, enable_oversize: 1, privacy_setting: 2, enable_private_data: 0 2016-10-18 06:26:49.458682 Lunch[1559:32097] subsystem: com.apple.UIKit, category:
```

The messages you're seeing in the Xcode console are system log messages, not directly related to your application's print statements. These messages come from the internal workings of the iOS frameworks and subsystems, and while they can sometimes provide useful information for debugging, they can also clutter your console output, making it harder to find your application's debug prints.

If these messages are overwhelming and you'd like to focus on your own output, you can filter them out. Here's how you can reduce the noise in your Xcode console:

1. **Console Filtering**: At the bottom of the Xcode console, there's a filter bar where you can type in text. If you input text there, the console will only show lines that contain that text. You can use this to filter in only the messages you're interested in. For example, if your print statements all start with a certain prefix, you can filter for that prefix.

2. **Custom Console**: If you're running an application that doesn't need to be attached to Xcode to function, you can log your debug statements to a file and then tail that file in a terminal window. This way, you can completely bypass the Xcode console and its verbosity.

3. **OSLog and Unified Logging System**: Consider using `os.log` or the unified logging system, where you can specify different log levels (info, debug, error, etc.) for your messages. You can then use the Console app on macOS to filter logs by level, subsystem, or category, making it much easier to find relevant information.

4. **Disabling OS Log Output**: While it's generally not recommended because it might hide useful debug information, you can reduce the verbosity of system logs by setting an environment variable. In your scheme's run settings, add `OS_ACTIVITY_MODE` as the environment variable and set its value to `disable`. This will suppress a lot of system logging, but be aware that it might also hide valuable information, especially when diagnosing system-related issues.
   
   
   Product -> Scheme ->
   
￼![](kUcbKeD.png)

5. **Use Breakpoints for Debugging**: Instead of relying solely on print statements, you can use breakpoints in Xcode for debugging. You can even add a log message to a breakpoint without stopping the program. Right-click on a breakpoint, select Edit Breakpoint, and then add a log message action. This way, you can get specific messages in the console without additional clutter.

Remember, while filtering out noise can help during development, it's important not to ignore all system messages, as they can sometimes provide crucial information about what's happening in the system or why your app is behaving unexpectedly.

