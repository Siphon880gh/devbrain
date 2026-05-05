
Apple might reject your app with a crash log. 


## Different Devices
Ask your team if they have different iphone models they're willing to let you try connected to XCode

If you can't replicate the crashing in XCode's iOS simulator or your own iPhones, you may want to consider [[Online iOS testing services with remote devices]]

## Versioning

Crash report could look like:
```
{"app_name":"MyApp","timestamp":"2024-01-08 01:08:41.00 -0800","app_version":"2","slice_uuid":"c8a6ca3a-303e-39e2-a2af-761d2b1cdefa","adam_id":"1658237702","build_version":"3","platform":2,"bundleID":"com.myapptype.myapp","share_with_app_devs":0,"is_first_party":0,"bug_type":"309","os_version":"iPhone OS 16.2 (20C65)","roots_installed":0,"name":"MyApp","incident_id":"11920EE2-4A49-4199-AD49-BB03ACEF0CDA"}
{
  "uptime" : 290000,
  "procRole" : "Foreground",
  "version" : 2,
  "userID" : 501,
  "deployVersion" : 210,
  "modelCode" : "iPad11,3",
  "coalitionID" : 1336,
  "osVersion" : {
    "isEmbedded" : true,
    "train" : "iPhone OS 16.2",
    "releaseType" : "User",
    "build" : "20C65"
  },
  "captureTime" : "2024-01-08 01:08:40.0848 -0800",
  "incident" : "21920EE2-4A49-4199-AD49-BB03ACEF0CDA",
  "pid" : 4845,
  "cpuType" : "ARM-64",
  "roots_installed" : 0,
  "bug_type" : "309",
  "procLaunch" : "2024-01-08 01:03:30.8293 -0800",
  "procStartAbsTime" : 7040006321663,
  "procExitAbsTime" : 7047427504127,
  "procName" : "MyApp",
  "procPath" : "\/private\/var\/co
```

You can see the osVersion object's train value. That's the version of iPhone it failed on. This information is crucial for debugging because certain crashes might be specific to particular OS versions due to differences in the OS's behavior, available APIs, or system resource management. For a quick fix, you can try changing the target version (refer to [[_ XCode Primer Guide]])

## Symbolicating

Symbolicating a crash report by pairing it with the corresponding dSYM file translates the memory addresses found in the crash report into human-readable function names, file names, and line numbers. This process provides clarity on where exactly in your code the crash occurred. 

To symbolicate a crash report using Xcode and a dSYM file, follow these brief steps:

1. **Locate the dSYM File**: You can find the dSYM file in the archive you created when you submitted your app. In Xcode, go to "Window" > "Organizer", select your archive, and right-click to show the dSYM in Finder.
    
2. **Place the Crash Report**: Copy the crash report you received from App Store Connect into your project's directory. It doesn't need to be a specific location within the project's folder; it just needs to be accessible.
    
3. **Symbolicate in Xcode**: Open Xcode, and drag the crash report into the Xcode icon in the Dock or directly into the Xcode window. Xcode will automatically attempt to symbolicate the crash report using any dSYM files it finds in the project's directory or known locations.
    
4. **Automatic Symbolication**: Xcode automatically symbolicates the report when you open it if the matching dSYM file is available. There's no need to restart Xcode. If the report is symbolicated successfully, you'll see function names and line numbers instead of just memory addresses.

By following these steps, Xcode should symbolicate the crash report using the dSYM file, allowing you to pinpoint the source of the crash.

---

Symbolicating deep dive:
https://developer.apple.com/videos/play/wwdc2021/10211/