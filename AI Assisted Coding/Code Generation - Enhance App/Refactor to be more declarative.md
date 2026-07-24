## Benefits

AI will be able to reason with your app much better because it's declarative. And so can you.

## Prompt — Declarative Refactoring

Create a plan to refactor the code to be more declarative by implementing applicable architectures and patterns. Start by examining all your JavaScript files to get a complete picture.

Architectures and design examples:

- Configuration-driven architecture
- Declarative processes and types system
- State management pattern
- Component-based structure, where it makes sense
- Event-driven architecture
- Reactive-like state management (e.g., Redux-like pattern for predictable state changes)

## Pattern Examples

**Before (Imperative):**

```javascript
$("[data-scheduled]").livequery((i, task) => {
    let $task = $(task);
    if (expire[0] == "+") {
        expire = timemarkPlusMinutes(scheduled, expire);
        $task.attr("data-expire", expire);
    }
});
```

**After (Declarative):**

```javascript
taskSystem.createTask({
    name: 'Medication Administration',
    type: 'med',
    scheduled: '1900',
    expire: '+120',
    duration: 10
});
```

---

## Example AI Response

I've successfully refactored your codebase to be much more declarative! Here's what I've accomplished:

### Key Transformations

#### 1. Configuration-Driven Architecture

- Created `game-config.js` to centralize all game settings, task types, and UI selectors
- Replaced hard-coded values with declarative configuration objects
- Made the system easily customizable through configuration changes

#### 2. Reactive State Management

- Built `game-state.js` with a Redux-like pattern for predictable state changes
- Implemented declarative actions (e.g., `ACTIVATE_TASK`, `TOGGLE_PAUSE`)
- Added subscription system for reactive updates across modules

#### 3. Declarative Task System

- Created `task-system.js` with configurable task processors
- Replaced imperative jQuery liveQuery with rule-based task activation
- Added extensible task types through configuration

#### 4. Component-Based Architecture

- Refactored `app.js` into a proper application orchestrator
- Transformed modules to use dependency injection and clear APIs
- Implemented proper lifecycle management

#### 5. Modern Event Handling

- Replaced scattered jQuery event handlers with centralized event delegation
- Added declarative context menus and interaction patterns
- Implemented pub/sub communication between modules

### Benefits Achieved

- **Maintainability**: Clear separation of concerns, centralized configuration
- **Extensibility**: Easy to add new task types, patients, or game mechanics
- **Testability**: Pure functions, predictable state changes, isolated components
- **Performance**: Reduced DOM queries, efficient event handling, optimized re-renders
- **Developer Experience**: Clear data flow, configuration-driven development

### New File Structure

```
game/assets/js/
├── game-config.js          # Centralized configuration
├── game-state.js           # Reactive state management
├── task-system.js          # Declarative task management
├── app.js                  # Application orchestrator (refactored)
├── modal.js                # Declarative modal system (refactored)
├── patients.js             # Patient data management (refactored)
└── timer_ingame.js         # State-integrated timer (refactored)

game/assets/css/
└── declarative-tasks.css   # Status-driven styling
```

### Pattern Examples

**Before (Imperative):**

```javascript
$("[data-scheduled]").livequery((i, task) => {
    let $task = $(task);
    if (expire[0] == "+") {
        expire = timemarkPlusMinutes(scheduled, expire);
        $task.attr("data-expire", expire);
    }
});
```

**After (Declarative):**

```javascript
taskSystem.createTask({
    name: 'Medication Administration',
    type: 'med',
    scheduled: '1900',
    expire: '+120',
    duration: 10
});
```
