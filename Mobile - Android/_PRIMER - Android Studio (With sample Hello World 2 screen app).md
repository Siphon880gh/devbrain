Android Studio is still the main official IDE for Android development. For a new beginner app today, the easiest path is **Kotlin + Jetpack Compose**. Jetpack Compose is Android’s modern UI toolkit, and Google’s Android docs describe it as the modern way to build Android UI. ([Android Developers](https://developer.android.com/develop/ui/compose/documentation?utm_source=chatgpt.com "Get started with Jetpack Compose"))

This guide creates a simple Android app:

- First screen says: **Hello world**
    
- When you click **Hello world**
    
- It changes to a second screen that says: **I came and I conquered**
    

---

## 1. Install Android Studio

Download Android Studio from the official Android developer site:

[https://developer.android.com/studio](https://developer.android.com/studio)

Open Android Studio after installation.

---

## 2. Create a New Android Project

From the Android Studio welcome screen:

1. Click **New Project**
    
2. Choose **Empty Activity**
    
3. Click **Next**
    
4. Fill in the project details:
    

```text
Name: HelloConquered
Package name: com.example.helloconquered
Language: Kotlin
Minimum SDK: API 21 or higher
```

Google’s Compose quick-start guide also uses **Empty Activity**, and notes that Compose uses Kotlin. ([Android Developers](https://developer.android.com/develop/ui/compose/setup?utm_source=chatgpt.com "Quick start | Jetpack Compose"))

Click **Finish**.

Android Studio will create the project and download the needed Gradle files.

---

## 3. Open `MainActivity.kt`

In the left sidebar, go to:

```text
app > java > com.example.helloconquered > MainActivity.kt
```

Replace the contents of `MainActivity.kt` with this:

```kotlin
package com.example.helloconquered

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.compose.BackHandler
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.sp

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        setContent {
            MaterialTheme {
                Surface(
                    modifier = Modifier.fillMaxSize()
                ) {
                    HelloConqueredApp()
                }
            }
        }
    }
}

@Composable
fun HelloConqueredApp() {
    var currentScreen by remember { mutableStateOf("hello") }

    if (currentScreen == "conquered") {
        BackHandler {
            currentScreen = "hello"
        }
    }

    when (currentScreen) {
        "hello" -> HelloWorldScreen(
            onHelloClick = {
                currentScreen = "conquered"
            }
        )

        "conquered" -> ConqueredScreen()
    }
}

@Composable
fun HelloWorldScreen(onHelloClick: () -> Unit) {
    Box(
        modifier = Modifier.fillMaxSize(),
        contentAlignment = Alignment.Center
    ) {
        Text(
            text = "Hello world",
            fontSize = 32.sp,
            modifier = Modifier.clickable {
                onHelloClick()
            }
        )
    }
}

@Composable
fun ConqueredScreen() {
    Box(
        modifier = Modifier.fillMaxSize(),
        contentAlignment = Alignment.Center
    ) {
        Text(
            text = "I came and I conquered",
            fontSize = 32.sp
        )
    }
}

@Preview(showBackground = true)
@Composable
fun HelloWorldPreview() {
    MaterialTheme {
        HelloWorldScreen(
            onHelloClick = {}
        )
    }
}
```

---

## 4. Run the App

At the top of Android Studio:

1. Choose an emulator or connected Android phone.
    
2. Click the green **Run** button.
    
3. Wait for the app to build and open.
    

You should see:

```text
Hello world
```

Click the text.

The screen should change to:

```text
I came and I conquered
```

Pressing the Android back button returns to the first screen.

---

## What the Code Is Doing

`HelloConqueredApp()` keeps track of which screen is showing:

```kotlin
var currentScreen by remember { mutableStateOf("hello") }
```

When the app starts, `currentScreen` is `"hello"`.

When you click **Hello world**, this runs:

```kotlin
currentScreen = "conquered"
```

That causes Compose to redraw the UI and show the second screen.

---

## Important Beginner Note

This example uses simple Compose state to switch screens. That is perfect for learning.

For larger Android apps, you would usually use the official Android **Navigation component** for screen navigation. Google’s docs explain that Navigation supports Jetpack Compose apps and lets you move between composable destinations. ([Android Developers](https://developer.android.com/develop/ui/compose/navigation?utm_source=chatgpt.com "Navigation with Compose | Jetpack Compose"))