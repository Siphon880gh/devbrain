
### DRY — Don’t Repeat Yourself

**DRY** is a foundational software principle from _The Pragmatic Programmer_.

It means every piece of knowledge, logic, or behavior should have a single authoritative source in the system.

**Goal:** Reduce repeated code, duplicated logic, and scattered configuration.

**How it works:** Instead of copying the same logic in multiple places, extract it into a reusable function, class, module, constant, or configuration source.

**Benefit:** When something changes, you update it in one place instead of hunting through the codebase, reducing bugs and maintenance time.

---

### KISS — Keep It Simple, Stupid

**KISS** means systems work best when they are kept simple and understandable.

In software, this means avoiding unnecessary complexity, cleverness, over-engineering, and confusing abstractions.

**Goal:** Make code easy to read, test, debug, and maintain.

**How it works:** Prefer straightforward solutions over complicated ones unless the complexity is truly justified.

**Benefit:** Simple code is easier for current and future developers to understand and safely modify.

---

### SOLID — Five Object-Oriented Design Principles

**SOLID** is a group of five principles for writing maintainable object-oriented code.

- **S — Single Responsibility Principle:** A class should have one main reason to change.
    
- **O — Open/Closed Principle:** Code should be open for extension but closed for modification.
    
- **L — Liskov Substitution Principle:** Subclasses should be usable wherever their parent class is expected.
    
- **I — Interface Segregation Principle:** Prefer small, focused interfaces over large, general-purpose ones.
    
- **D — Dependency Inversion Principle:** High-level code should depend on abstractions, not low-level details.
    

**Goal:** Make code easier to extend, test, and refactor.

---

### YAGNI — You Aren’t Gonna Need It

**YAGNI** is a software development principle from Extreme Programming.

It means developers should avoid building features, abstractions, configurations, or systems until they are actually needed.

**Goal:** Avoid wasted work and unnecessary complexity.

**How it works:** Build for the current real requirement, not for imagined future scenarios.

**Benefit:** Keeps the codebase simpler, easier to maintain, and less likely to accumulate unused features.

---
### SRP — Single Responsibility Principle

**SRP** means a function, class, module, or service should focus on one responsibility.

**Goal:** Avoid mixing unrelated concerns in the same place.

**Example:** A class should not handle user validation, database saving, email sending, and PDF generation all at once.

**Benefit:** Smaller, focused code is easier to test, reuse, and change.

---

### SoC — Separation of Concerns

**SoC** means different parts of a system should handle different responsibilities.

**Goal:** Keep unrelated logic separated.

**Example:** UI code, business logic, database access, authentication, and logging should usually live in separate layers or modules.

**Benefit:** Makes systems easier to understand, debug, and modify.