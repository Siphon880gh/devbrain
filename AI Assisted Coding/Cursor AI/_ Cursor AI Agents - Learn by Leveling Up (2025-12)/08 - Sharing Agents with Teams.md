## **Sharing Agent Workflows with Team Members**

**Agents live inside your project folder**, not your personal account. Sharing agents is as simple as sharing your project.

---

### Two Approaches: `.cursorrules` vs `AGENTS.md`

#### The Cursor-Specific Way: `.cursorrules`

Create a `.cursorrules` file in your project root. This file contains instructions that Cursor AI reads automatically.

```
# Available AI Agents

When I say "show me all the ai agents", list the following roles:
- Frontend Developer
- Backend Developer  
- Code Reviewer
- Documentation Writer

## Frontend Developer
You are a senior frontend developer specializing in React and TypeScript...

## Backend Developer
You are a senior backend developer specializing in Node.js and databases...

## Code Reviewer
You are a meticulous code reviewer focused on best practices...
```

#### The Modern Cross-IDE Way: `AGENTS.md`

The `AGENTS.md` approach works across multiple AI-powered IDEs (Cursor, Windsurf, Cline, etc.):

```markdown
# Project AI Agents

## How to Use
Say "act as [role name]" to activate a specific agent.
Say "show me all agents" to see available roles.

---

## Frontend Developer
**Trigger:** "act as frontend dev"

You are a senior frontend developer. You specialize in:
- React/Next.js architecture
- TypeScript best practices
- Component design patterns

---

## Backend Developer  
**Trigger:** "act as backend dev"

You are a senior backend developer. You specialize in:
- API design
- Database optimization
- Security practices
```

---

### The Key Insight: Agents Are Imitation, Not Separate Entities

**Important clarification:** Each AI agent in Cursor's Agent Editor is NOT a separate AI persona that you can directly reference like calling a colleague.

Instead, when you reference a specific role:
1. The AI reads the prompt/instructions listed under that agent name
2. The AI **imitates** that role based on those instructions
3. It's the same underlying AI, just following different system prompts

Think of it like an actor reading different scripts—same person, different character based on the script you hand them.

---

### Sharing with Your Team

| Method | Pros | Cons |
|--------|------|------|
| `.cursorrules` | Native Cursor support, auto-loaded | Cursor-only |
| `AGENTS.md` | Cross-IDE compatible, version controlled | Requires manual reference |
| Agent Editor | Visual interface, easy to edit | Settings not easily shared |

**Recommended approach:** Use `AGENTS.md` in your repo for portability, then reference it in your `.cursorrules`:

```
Always check AGENTS.md for available roles when I ask about agents.
```

This way, team members get the same agent configurations regardless of which AI IDE they use.

