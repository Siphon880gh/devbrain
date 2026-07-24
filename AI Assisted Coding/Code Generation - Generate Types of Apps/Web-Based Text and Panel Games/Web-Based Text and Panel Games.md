Use this prompt:
- Fill in the placeholders where applicable. Fill in "N/A - Help me figure out" or "N/A - Do not implement" where not applicable.
```
# Build a Text-Based Web GUI Simulation Game

Create a functional browser-based simulation game that combines text-driven decision-making with an interactive dashboard made of web GUI components.

The game may simulate nursing, business management, emergency response, project management, operations, logistics, education, or another decision-based environment.

Use the completed configuration below to determine the game’s mechanics, interface, data model, and event system.

Example Games (Not exhaustive):
- Business Simulation: In Harvard’s portfolio simulation, players act as executives directing R&D spending toward next-generation batteries or operational upgrades. The simulation culminates in a financial reckoning—did your strategy generate profit, or sink the company into the red?
- Clinical Training: This RN simulator drops players into a compressed 12-hour nursing shift filled with real-world events, diverse patients, and escalating case studies. Success means triaging tasks, acing clinical mini-games, and staying on schedule; failure means clocking overtime—or worse, missing the critical moment that leads to patient injury.

---

## 1. Game Configuration

### Basic Concept

- **Game title:** `[GAME TITLE]`
    
- **Simulation domain:** `[NURSING / BUSINESS / OPERATIONS / OTHER]`
    
- **Player role:** `[EXAMPLE: REGISTERED NURSE, BUSINESS OWNER, MANAGER]`
    
- **Primary objective:** `[WHAT THE PLAYER IS TRYING TO ACCOMPLISH]`
    
- **Target audience:** `[STUDENTS / PROFESSIONALS / GENERAL PLAYERS]`
    
- **Realistic, fictional, or mixed:** `[REALISTIC / FICTIONAL / MIXED]`
    
- **Difficulty level:** `[BEGINNER / INTERMEDIATE / ADVANCED / ADAPTIVE]`
    
- **Educational goals, if any:** `[SKILLS OR KNOWLEDGE THE GAME SHOULD TEACH]`
    

### Scenario

- **Starting situation:** `[DESCRIBE THE INITIAL SCENARIO]`
    
- **Entities being managed:** `[PATIENTS / EMPLOYEES / CUSTOMERS / DEPARTMENTS / PROJECTS / OTHER]`
    
- **Important resources:** `[STAFF, MONEY, MEDICATIONS, INVENTORY, EQUIPMENT, ETC.]`
    
- **Possible emergencies or complications:** `[EXAMPLES]`
    
- **Winning conditions:** `[HOW THE PLAYER SUCCEEDS]`
    
- **Failure conditions:** `[HOW THE PLAYER FAILS]`
    
- **End-of-game results to display:** `[SCORE, RANK, OUTCOMES, FEEDBACK, ETC.]`
    

### Time System

- **Is the game time-based?** `[YES / NO]`
    
- **Time format:** `[CLOCK RANGE / COUNTDOWN / TURN-BASED / TICK-BASED / EVENT-BASED / NONE]`
    
- **Starting game time:** `[EXAMPLE: 7:00 AM]`
    
- **Ending game time:** `[EXAMPLE: 7:00 PM]`
    
- **Countdown duration:** `[EXAMPLE: 30 MINUTES]`
    
- **Real-time conversion:** `[EXAMPLE: 1 REAL SECOND = 1 GAME MINUTE]`
    
- **Tick interval:** `[EXAMPLE: PROCESS GAME LOGIC EVERY 5 GAME MINUTES]`
    
- **Can the player pause the game?** `[YES / NO]`
    
- **Can the player change simulation speed?** `[YES / NO]`
    
- **Available speeds:** `[EXAMPLE: 1×, 2×, 5×, 10×]`
    
- **Do actions consume game time?** `[YES / NO]`
    
- **Should events occur at scheduled times, randomly, or both?** `[SCHEDULED / RANDOM / BOTH]`
    

### Player Actions

- **Main actions available to the player:**  
    `[EXAMPLE: ASSESS, DELEGATE, ADMINISTER MEDICATION, CALL PROVIDER, HIRE STAFF, CHANGE PRICES]`
    
- **Do actions require confirmation?** `[YES / NO / ONLY HIGH-RISK ACTIONS]`
    
- **Can actions fail?** `[YES / NO]`
    
- **Can multiple actions be queued?** `[YES / NO]`
    
- **Should actions have durations or cooldowns?** `[DESCRIBE]`
    
- **Should the game include dialogue or communication choices?** `[YES / NO]`
    

### Events and Progression

- **Scheduled events:** `[EVENTS REVEALED AT SPECIFIC TIMES]`
    
- **Random events:** `[EVENTS SELECTED FROM A RANDOM POOL]`
    
- **Hidden events:** `[EVENTS THE PLAYER CANNOT SEE IN ADVANCE]`
    
- **Deterioration or escalation rules:** `[WHAT HAPPENS WHEN PROBLEMS ARE IGNORED]`
    
- **Dependencies:** `[EVENTS OR TASKS THAT REQUIRE OTHER ACTIONS FIRST]`
    
- **Event reveal timing:** `[IMMEDIATE / DELAYED / PLAYER-ACTION / DEPENDENCY-BASED / MIXED]`
    
- **Branching consequences:** `[HOW DECISIONS CHANGE FUTURE EVENTS]`
    

### Scoring

- **Use a score system?** `[YES / NO]`
    
- **Rewarded behaviors:** `[CORRECT PRIORITIZATION, FAST RESPONSE, PROFIT, SAFETY, ETC.]`
    
- **Penalized behaviors:** `[MISSED TASKS, DELAYS, POOR DECISIONS, RESOURCE WASTE, ETC.]`
    
- **Additional tracked metrics:**  
    `[PATIENT SAFETY, SATISFACTION, MORALE, CASH, REPUTATION, STRESS, QUALITY, ETC.]`
    

### Interface

- **Preferred framework:** `[REACT + TYPESCRIPT / NEXT.JS / VANILLA JS / OTHER]`
    
- **Visual style:** `[CLINICAL DASHBOARD / BUSINESS DASHBOARD / TERMINAL / MODERN APP / OTHER]`
    
- **Desktop, mobile, or responsive:** `[DESKTOP / MOBILE / RESPONSIVE]`
    
- **Preferred panels:** `[LIST THE REQUIRED PANELS]`
    
- **Graphics level:** `[TEXT ONLY / LIGHTWEIGHT GRAPHICS / MODERATE ANIMATION]`
    
- **Accessibility requirements:** `[KEYBOARD SUPPORT, COLOR CONTRAST, SCREEN READER LABELS, ETC.]`
    
- **Save and resume support:** `[YES / NO]`
    
- **Persistence method:** `[IN-MEMORY ONLY / SESSION STORAGE / LOCAL STORAGE / BACKEND API / OTHER]`
    
- **Backend required:** `[YES / NO / OPTIONAL]`
    

---

## 2. Interpret the Configuration

Use the configuration to decide which systems to implement.

Do not force nursing-specific mechanics into a business simulation or business mechanics into a nursing simulation. Adapt the terminology, metrics, actions, resources, and outcomes to the selected domain.

When a configuration field is blank, choose a sensible default and document the assumption.

### Time-System Cases

Implement only the time system selected by the user.

#### Clock-Range Simulation

Use this when the simulation has a starting and ending clock time, such as a nursing shift from 7:00 AM to 7:00 PM.

- Display the current in-game time.
    
- Accelerate game time according to the configured conversion rate.
    
- Trigger scheduled events when the clock reaches their assigned times.
    
- End the game when the ending time is reached.
    
- Allow actions to consume game minutes when configured.
    
- On each tick, increment the clock, update state, and ask the event scheduler to reveal or trigger due events.
    

Example tick flow:

```ts
function onTimeTick(currentTime, events, gameState) {
  const nextTime = incrementTime(currentTime);
  const dueEvents = events.filter(
    (event) => event.scheduledAt === nextTime && !event.isResolved
  );
  return { nextTime, dueEvents };
}
```

Adapt the helper names and conditions to the selected time system.

#### Countdown Simulation

Use this when the player has a limited amount of time to complete an objective.

- Display the remaining time.
    
- Trigger warnings at important thresholds.
    
- End or evaluate the scenario when the countdown reaches zero.
    
- Allow decisions to add or remove time only when supported by the scenario.
    

#### Turn-Based Simulation

Use this when each action advances the simulation by one turn.

- Process consequences after each player action.
    
- Trigger events according to turn numbers or conditions.
    
- Clearly show the current turn and any remaining turn limit.
    

#### Tick-Based Simulation

Use this when the game continuously processes logic at regular intervals.

- Run deterioration, resource usage, queued work, and event checks on each tick.
    
- Allow the user to configure tick speed, batch size, and stop conditions when applicable.
    
- Keep simulation logic separate from visual rendering.
    

#### Event-Based Simulation

Use this when time advances primarily after decisions or completed events.

- Present an event or decision.
    
- Process the player’s response.
    
- Update the state and reveal the next appropriate event.
    
- Support branching paths based on previous decisions.
    

#### No Time System

When the game is not time-based:

- Do not create an unnecessary timer.
    
- Progress through decisions, objectives, tasks, or story stages.
    
- Use state conditions rather than elapsed time to reveal events.
    

---

## 3. Game Architecture

Use a layered architecture that keeps simulation logic, scheduling, storage, and UI separate.

### Recommended Layers

- **Game Logic:** Handles progression, state transitions, action resolution, scoring, and win/loss evaluation.
- **Event Scheduler:** Determines when events become eligible, fire, or resolve based on time, player actions, conditions, and dependencies. Keep this separate from UI rendering.
- **Data Storage:** Holds scenario content, runtime state, and optional save data. Choose the simplest option that meets the configuration.
- **Frontend Display:** Renders panels, handles player input, and reflects state changes reactively.

### Storage Options

Choose based on the configured save/resume requirements:

- **In-memory runtime state:** Default for single-session play with no reload persistence.
- **Browser persistence:** Use `localStorage` or `sessionStorage` when the player should resume after reload within the same browser session or across sessions.
- **Structured scenario files:** Keep entities, tasks, and events in JSON or TypeScript data modules separate from engine code.
- **Optional backend:** Use a server-side store (database or API-backed JSON) when multiple clients must share state, when authoritative validation is required, or when progress must persist across devices.

When a backend is used, keep the frontend responsible for display and input while the server owns authoritative game-state updates, event scheduling, and persistence.

---

## 4. Core Gameplay Requirements

Build the game around a centralized simulation state.

The state should track the following where relevant:

- Current time, countdown value, turn, or tick
    
- Active entities
    
- Entity status and statistics
    
- Available resources
    
- Pending tasks
    
- Completed tasks
    
- Failed or expired tasks
    
- Scheduled events
    
- Pending events
    
- Completed or resolved events
    
- Random event eligibility
    
- Player decisions
    
- Player action history
    
- Decision consequences
    
- Queued actions
    
- Score and performance metrics
    
- Game status
    
- Event history
    
- Notifications and feedback
    

Keep the simulation engine separate from the presentation components so the game can later support additional scenarios.

Use reusable data structures rather than hardcoding all content directly inside interface components.

Each managed entity may also track entity-specific pending events, completed events, current tasks, and status metrics.

Example state shape:

```ts
{
  timer: "08:15",
  entities: {
    Entity_1: {
      name: "Example Entity",
      status: { health: 85, priority: "medium" },
      pendingEvents: ["Event_2"],
      completedEvents: ["Event_1"],
      currentTask: "Resolve urgent issue"
    }
  },
  pendingEvents: ["Event_2"],
  completedEvents: ["Event_1"],
  playerActions: ["Assessed situation", "Allocated resource"]
}
```

Adapt field names and metrics to the selected domain.

---

## 5. Dashboard and Panel System

Create a responsive dashboard containing reusable panels.

Include the configured panels and add any essential panels missing from the configuration.

Possible panels include:

### Overview Panel

Display the most important current information, such as:

- Current game time or remaining time
    
- Current objective
    
- Score
    
- Critical warnings
    
- Overall resource status
    
- Simulation controls
    

### Entity List

Display all patients, employees, departments, customers, projects, locations, or other managed entities.

Each entity summary may include:

- Name or identifier
    
- Current status
    
- Priority
    
- Important metrics
    
- Warning indicators
    
- Number of pending tasks
    

Selecting an entity should update the active detail panels without navigating away from the simulation.

### Entity Detail Panel

Display information for the selected entity.

Depending on the domain, this may contain:

- Background information
    
- Current condition
    
- Vital signs or performance metrics
    
- Orders, goals, or requirements
    
- Available actions
    
- Assigned resources
    
- Recent events
    
- Pending tasks
    
- Completed actions
    

### Task Panel

Display tasks with:

- Task title
    
- Related entity
    
- Task type
    
- Priority
    
- Due time or deadline
    
- Estimated duration
    
- Status
    
- Dependencies
    
- Available actions
    

Allow tasks to be filtered or sorted by priority, deadline, status, or entity.

### Resources Panel

Display available resources such as:

- Staff
    
- Equipment
    
- Medications
    
- Inventory
    
- Money
    
- Capacity
    
- Energy
    
- Time
    
- Support services
    

Update resources immediately when actions consume, release, or generate them.

### Event and Activity Feed

Display chronological updates such as:

- New tasks
    
- Pending and completed events
    
- Status changes
    
- Completed actions
    
- Warnings
    
- Emergencies
    
- Consequences
    
- Score changes
    
- Communication messages
    

Important events should be visually distinct without relying entirely on color.

### Decision Panel

When a decision is required, display:

- The situation
    
- Relevant context
    
- Available choices
    
- Possible immediate costs
    
- Any information the player has already discovered
    

Do not reveal hidden consequences unless the game design specifically calls for them.

### Feedback Panel

After an action, provide clear feedback showing:

- What happened
    
- Which state values changed
    
- Whether the action succeeded
    
- Why the action succeeded or failed
    
- Any new task, event, or consequence
    

---

## 6. Dynamic Panel Behavior

Panels must update dynamically as the simulation state changes.

When the player switches between entities:

- Preserve the overall simulation state.
    
- Load the selected entity’s current information.
    
- Update its tasks, metrics, actions, and history.
    
- Do not reset timers, events, or unfinished actions.
    
- Clearly indicate which entity is selected.
    

Use smooth but lightweight transitions when changing panels.

Animations should improve understanding rather than delay gameplay. Examples include:

- Progress bar movement
    
- Metric increases or decreases
    
- New task highlighting
    
- Warning pulses
    
- Panel fade or slide transitions
    
- Score changes
    
- Event notifications
    

Use CSS transitions by default. Use an animation library only when it provides a meaningful benefit.

---

## 7. Task System

Support static, scheduled, dynamically generated, and conditional tasks.

Each task should be represented by structured data containing fields such as:

```ts
{
  id,
  title,
  description,
  relatedEntityId,
  type,
  priority,
  createdAt,
  dueAt,
  duration,
  status,
  prerequisites,
  availableActions,
  successEffects,
  failureEffects
}
```

Tasks may be created when:

- The game begins
    
- A scheduled time is reached
    
- A random event occurs
    
- An entity reaches a threshold
    
- Another task is completed
    
- A player makes a particular decision
    
- A resource becomes unavailable
    
- A hidden condition becomes true
    

Tasks should not simply disappear when missed. Process their failure or expiration consequences first.

---

## 8. Event System

Create a reusable event engine and event scheduler that supports:

- Scheduled events
    
- Random events
    
- Conditional events
    
- Hidden events
    
- Recurring events
    
- One-time events
    
- Branching events
    
- Entity-specific events
    
- Global simulation events
    
- Player-action-triggered events
    
- Dependency or chain events
    

Each event should define:

```ts
{
  id,
  title,
  description,
  trigger,
  scheduledAt,
  conditions,
  revealCondition,
  probability,
  relatedEntityId,
  severity,
  suggestedActions,
  effects,
  createdTasks,
  availableChoices,
  followUpEvents,
  prerequisiteEventIds,
  hasTriggered,
  isRevealed,
  isResolved
}
```

### Event Reveal Rules

Events may become visible to the player through different mechanisms:

- **Timer-based reveal:** When the in-game clock reaches `scheduledAt`, reveal the event and add it to pending state if not yet resolved.
- **Player-triggered reveal:** When the player performs a configured action on a related entity, reveal the matching event.
- **Dependency-based reveal:** When prerequisite events are resolved or required tasks are completed, reveal or schedule the next event in a chain.

Do not conflate triggering, revealing, and resolving an event. An event may be scheduled internally before it is shown to the player, and it should remain in pending state until the player resolves it or the scenario applies an automatic consequence.

### Event Resolution

Track whether an event is resolved separately from whether it has triggered or been revealed.

When an event is resolved:

- Mark it complete in global and entity-specific event lists.
    
- Apply configured effects, tasks, score changes, or follow-up events.
    
- Archive it for the activity feed and end-of-game review.
    

Prevent one-time events from firing repeatedly.

Use a deterministic random seed when practical so scenarios can be replayed or tested consistently.

Do not let random events make the simulation unfair. Important outcomes should primarily result from player decisions, known risks, or understandable rules.

### Dynamic Event Generation

When random or procedural events are enabled:

- Assign probabilities by event type rather than using a single global chance.
    
- Generate events from templates tied to entity state, resource pressure, or scenario phase.
    
- Optionally adjust event frequency based on player performance, neglected tasks, or entity deterioration.
    
- Cap simultaneous emergencies so the simulation stays readable and fair.
    

---

## 9. Deterioration and Escalation

When configured, entities should change over time or in response to neglected tasks.

Examples include:

- Patient health deteriorating
    
- Customer satisfaction decreasing
    
- Employee morale falling
    
- Inventory running out
    
- Project risk increasing
    
- Equipment failing
    
- Financial losses accumulating
    
- Work queues growing
    

Escalation should occur through explicit rules and thresholds.

The player should receive reasonable warning signs before major failure unless the scenario intentionally tests recognition of subtle clues.

Create different escalation levels, such as:

1. Stable
    
2. Concerning
    
3. Urgent
    
4. Critical
    
5. Failed or irreversible
    

The interface should communicate these levels clearly.

---

## 10. Actions and Consequences

Every meaningful player action should pass through the simulation engine.

An action may:

- Consume time
    
- Use resources
    
- Create a queued activity
    
- Complete a task
    
- Change an entity’s state
    
- Change score or performance metrics
    
- Reveal information
    
- Trigger another event
    
- Prevent a future event
    
- Create delayed consequences
    
- Fail because requirements were not met
    

Actions with a duration should not always complete immediately.

Support queued actions when enabled. A queued action should include:

```ts
{
  id,
  actionType,
  relatedEntityId,
  startedAt,
  completesAt,
  status,
  completionEffects,
  callbackEventId
}
```

On each time update, turn, or tick:

1. Check queued actions.
    
2. Complete actions whose completion condition has been reached.
    
3. Apply their effects.
    
4. Trigger any associated events or callbacks.
    
5. Remove or archive completed queue items.
    
6. Update the interface.
    

---

## 11. Domain-Specific Adaptation

### Nursing or Clinical Simulation

When the selected domain is nursing or healthcare, consider systems such as:

- Multiple assigned patients
    
- Patient reports and histories
    
- Diagnoses
    
- Vital signs
    
- Assessments
    
- Medication administration
    
- Medication schedules
    
- Provider orders
    
- Laboratory results
    
- Delegation
    
- Documentation
    
- Admissions and discharges
    
- Changes in condition
    
- Emergency response
    
- Prioritization
    
- Staffing and support resources
    
- Patient safety
    
- Satisfaction
    
- Shift handoff
    

Clinical scenarios should be internally consistent and appropriate for the selected difficulty.

For educational simulations, provide an end-of-game debrief explaining:

- Strong decisions
    
- Unsafe or ineffective decisions
    
- Missed cues
    
- Prioritization issues
    
- Better alternatives
    
- Relevant educational principles
    

Clearly identify the game as an educational simulation rather than a substitute for real clinical judgment.

### Business or Management Simulation

When the selected domain is business or management, consider systems such as:

- Revenue
    
- Expenses
    
- Cash flow
    
- Employees
    
- Workload
    
- Customer satisfaction
    
- Marketing
    
- Inventory
    
- Capacity
    
- Quality
    
- Reputation
    
- Project deadlines
    
- Hiring
    
- Pricing
    
- Vendor issues
    
- Operational emergencies
    
- Strategic decisions
    

Business outcomes should result from understandable tradeoffs rather than arbitrary score changes.

---

## 12. Scoring and Outcomes

When scoring is enabled, calculate performance from multiple categories instead of relying on a single point total.

Possible categories include:

- Accuracy
    
- Safety
    
- Priority management
    
- Response time
    
- Resource efficiency
    
- Customer or patient satisfaction
    
- Team morale
    
- Financial performance
    
- Documentation
    
- Completed objectives
    
- Prevented emergencies
    

Display score changes when appropriate, but do not reveal information that would undermine the simulation.

At the end of the game, display:

- Final score
    
- Performance rank
    
- Outcome summary
    
- Entity outcomes
    
- Objectives completed
    
- Missed or failed tasks
    
- Important decisions
    
- Major consequences
    
- Category-by-category performance
    
- Educational or strategic feedback
    
- Restart option
    
- Replay option when supported
    

---

## 13. Technical Requirements

Unless the configuration specifies another stack, use:

- React
    
- TypeScript
    
- Vite
    
- Modern CSS
    
- Local structured data for the initial scenario
    
- React state, reducer, or a lightweight state-management solution
    

Organize the project into clear modules, such as:

```text
src/
  components/
  data/
  engine/
  hooks/
  types/
  utilities/
  scenarios/
  styles/
  App.tsx
  main.tsx
```

Suggested modules include:

```text
src/types/game.ts
src/data/scenario.ts
src/engine/timeEngine.ts
src/engine/eventScheduler.ts
src/engine/eventEngine.ts
src/engine/taskEngine.ts
src/engine/stateStore.ts
src/engine/actionEngine.ts
src/engine/scoringEngine.ts
src/components/GameHeader.tsx
src/components/MainTimer.tsx
src/components/EntityList.tsx
src/components/EntityDetails.tsx
src/components/TaskPanel.tsx
src/components/ResourcePanel.tsx
src/components/EventFeed.tsx
src/components/DecisionPanel.tsx
src/components/EndGameSummary.tsx
```

Requirements:

- Use strict TypeScript types.
    
- Avoid placing all logic in `App.tsx`.
    
- Keep scenario data separate from game-engine logic.
    
- Use stable identifiers for entities, tasks, events, and actions.
    
- Clean up timers when components unmount.
    
- Prevent duplicate event triggers.
    
- Avoid stale-state timer bugs.
    
- Ensure pause and speed controls work correctly.
    
- Make important controls keyboard accessible.
    
- Ensure the layout remains usable on smaller screens.
    
- Include useful empty states.
    
- Include error handling and fallback content.
    

---

## 14. Initial Content Requirements

Create enough starting content to demonstrate the complete game loop.

Include at least:

- A complete starting scenario
    
- The configured number of entities
    
- Initial tasks
    
- Several scheduled events when applicable
    
- Several random or conditional events when applicable
    
- At least one escalating problem
    
- At least one decision with delayed consequences
    
- At least one resource constraint
    
- At least one possible successful outcome
    
- At least one possible failure outcome
    
- A complete end-of-game summary
    

Do not create only an interface mockup. The simulation must be playable.

---

## 15. Development Milestones

Implement the project in functional milestones.

### Milestone 1: Core Interface

- Create the responsive dashboard.
    
- Add the game header and primary panels.
    
- Add entity selection.
    
- Display initial scenario data.
    
- Establish the central game-state structure.
    

### Milestone 2: Time and Progression

- Implement the configured time system.
    
- Add start, pause, resume, and speed controls where applicable.
    
- Implement the event scheduler and time tick loop.
    
- Trigger scheduled events.
    
- End the simulation at the correct time or condition.
    

### Milestone 3: Tasks and Actions

- Add task creation and task status changes.
    
- Add player actions.
    
- Apply resource and state changes.
    
- Support action durations and queues when configured.
    
- Process success and failure effects.
    

### Milestone 4: Events and Escalation

- Add random and conditional events.
    
- Add player-action-triggered and dependency-based event reveals.
    
- Add deterioration or escalation rules.
    
- Add emergencies or complications.
    
- Prevent duplicate event triggers.
    
- Support branching consequences.
    

### Milestone 5: Scoring and End Game

- Track configured performance metrics.
    
- Evaluate winning and failure conditions.
    
- Display the final score and outcome.
    
- Add a detailed debrief or performance report.
    

### Milestone 6: Polish and Testing

- Add lightweight animations and transitions.
    
- Improve accessibility.
    
- Test pause, resume, speed changes, and event timing.
    
- Test conflicting actions and simultaneous events.
    
- Test entity switching.
    
- Test missed deadlines.
    
- Test end-game conditions.
    
- Fix state synchronization and timer issues.
    

Each milestone must leave the application in a working state.

---

## 16. Testing Requirements

During development, add lightweight logging around time ticks, event reveal, event resolution, and action processing so timing bugs can be diagnosed quickly.

Test the following scenarios where applicable:

- Starting and pausing the game
    
- Resuming without losing time accuracy
    
- Changing simulation speed
    
- Triggering scheduled events exactly once
    
- Triggering conditional events
    
- Completing tasks before their deadlines
    
- Missing tasks and applying consequences
    
- Skipped optional tasks and their downstream effects
    
- Switching between multiple entities
    
- Completing queued actions
    
- Running out of a resource
    
- Handling simultaneous events
    
- Reaching escalation thresholds
    
- Winning the game
    
- Failing the game
    
- Reaching the end of the shift or countdown
    
- Restarting the simulation
    
- Loading saved progress when enabled
    
- Player-action-triggered event reveals
    
- Dependency chains where one resolved event unlocks the next
    
- Overlapping or simultaneous events without duplicate processing
    

Include a small set of automated tests for the simulation engine when practical.

Playtest the full scenario to confirm pacing, instruction clarity, action feedback, and difficulty feel appropriate for the configured audience.

---

## 17. Deliverables

Provide:

1. A short explanation of the selected game architecture.
    
2. The proposed project structure.
    
3. The complete working implementation.
    
4. The scenario and event data.
    
5. Instructions to install and run the game.
    
6. A summary of the implemented gameplay systems.
    
7. A list of assumptions made from blank configuration fields.
    
8. Suggestions for extending the game with additional scenarios.
    

Do not stop after producing a plan or static mockup. Build the functional first version of the game.

Do not repeatedly ask whether additional features should be implemented. Use the configuration to create a complete, playable vertical slice.
```