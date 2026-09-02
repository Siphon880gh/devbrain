## From Prompting to Graph-Based AI Workflows

For the past year, prompt engineering has often been treated like a superpower: write the perfect instruction, include a few examples, and let the model produce the answer. That approach is useful, but it is only the beginning of how we can organize AI work.

The next step was **loop prompting**—having an AI agent repeat a task, evaluate its progress, and continue through a batch of work or a series of milestones until it reaches a goal. Now, a broader shift is taking shape: **graph prompting** and, more practically, **graph-based agent workflows**.

The progression looks like this:

**Prompt → Loop → Graph**

- **Prompts** tell the model what to do.
- **Loops** let the model repeat, evaluate, and continue.
- **Graphs** let the system branch, connect, revisit earlier work, and dynamically choose the next path.
    

Instead of following one instruction or repeatedly running the same loop, an AI system can navigate a network of knowledge, tools, memory, decisions, and possible actions. It can plan, act, observe the result, correct course, explore multiple paths, reconnect them, and return to an earlier step when new information changes the situation. The future, in other words, is not only about writing the perfect prompt. It is about designing the graph within which the model operates.

## What graph prompting actually means

Graph prompting structures information as a network of **nodes** and **edges**, or maps reasoning into multiple connected paths, as in Graph-of-Thoughts. This gives an AI explicit relationships to follow instead of asking it to interpret everything as one linear block of text.

A small graph prompt might look like this:

```
You are an expert network analyst. Use the provided graph data containing nodes and edges to answer the question.

Nodes:
- (A: Alice), (B: Bob), (C: Charlie), (D: Diana)

Edges (Relationships):
- Alice -> knows -> Bob
- Bob -> collaborates_with -> Charlie
- Charlie -> mentors -> Diana
- Diana -> knows -> Alice

Question: Find a connection path from Alice to Diana, and list the intermediate steps.

Instructions:
1. Identify the starting node (Alice) and target node (Diana).
2. Trace the directed edges step-by-step.
3. Output the final chain of connections in JSON format.
```

This structure offers several benefits. It creates **relational clarity** by explicitly mapping connections such as those in a social network or supply chain. It supports **nonlinear logic**, allowing paths to split, merge, or loop back. It can also **reduce hallucinations** by grounding the model in a defined topology rather than forcing it to rely entirely on parametric memory.

For software work, however, the most useful interpretation is not simply, “Draw a graph and make the AI smarter.” A better mental model is:

> Turn the goal into small executable nodes, define the dependencies and branches between them, and then have an agent or program repeatedly execute eligible nodes until the graph reaches an end state.

For app development or web scraping, that approach can be much more reliable than one enormous linear prompt.

## Turning project milestones into an executable graph

Suppose an application project has the following milestones:

- Understand the requirements.
- Design the database.
- Build the scraper.
- Test the scraper.
- Debug it if the test fails.
- Store the results.
- Build the API.
- Build the frontend.
- Run an integration test.
- Fix any failures.
- Finish the project.

Those milestones can be represented as a graph:

```
flowchart TD
    A[Requirements] --> B[Design Schema]
    B --> C[Build Scraper]
    C --> D[Test Scraper]
    D -->|Pass| E[Store Results]
    D -->|Fail| F[Debug Scraper]
    F --> D
    E --> G[Build API]
    G --> H[Build Frontend]
    H --> I[Integration Test]
    I -->|Pass| J[DONE]
    I -->|Fail| K[Fix Bugs]
    K --> I
```

This is not necessarily reasoning that happens entirely inside the language model. It is primarily a **workflow or control graph**, and it contains real loops. For example:

`Test Scraper → Debug Scraper → Test Scraper`

Instead of manually designing every node, you can ask an AI to compile a rough milestone list into a formal graph. A reusable planning prompt could be:

```
You are a software project graph planner.

I will give you:

1. A development goal
2. Milestones
3. Constraints
4. Success criteria

Convert them into an executable directed graph.

For every node, specify:

- id
- name
- objective
- inputs
- actions
- outputs
- success_condition
- failure_condition
- max_attempts
- requires
- next_on_success
- next_on_failure

Rules:

1. Break milestones into nodes small enough that an AI coding agent can execute one node at a time.
2. Add dependency edges between nodes.
3. Add verification or test nodes wherever an output can be objectively checked.
4. Add repair loops: implementation -> test -> repair -> test.
5. Do not allow infinite loops. Every loop must have a max_attempts value.
6. Add conditional branches where different outcomes require different actions.
7. Allow independent nodes to run in parallel when appropriate.
8. Do not mark a milestone complete merely because code was generated. Completion must depend on its success condition.
9. If a node reaches its maximum number of attempts, route it to an escalation node.
10. Finish with a final validation node that checks the original goal.

Return:

A. A Mermaid graph showing the workflow.
B. A machine-readable JSON graph.
C. A short explanation of the important loops, branches, and parallel paths.

PROJECT GOAL:
[insert goal]

MILESTONES:
[insert milestones]

CONSTRAINTS:
[insert constraints]

SUCCESS CRITERIA:
[insert criteria]
```

For example, the input could be:

```
PROJECT GOAL:
Build a scraper that collects all product listings from example.com.

MILESTONES:
- Discover category URLs
- Scrape product URLs
- Extract product title, price, and image
- Handle pagination
- Store results in MySQL
- Avoid duplicates
- Test on 100 products
- Run the full scrape

CONSTRAINTS:
- PHP 8.3
- MySQL
- No browser automation unless necessary

SUCCESS CRITERIA:
At least 99% of reachable product pages are parsed without duplicate records.
```

The AI can then produce both a visual workflow and a machine-readable graph that a program can execute.

## Generating a graph is different from running one

This distinction is easy to miss because discussions of Graph-of-Thoughts often blur two separate ideas.

The first is a **graph used as a prompt**. You might give ChatGPT a structure such as:

```
Node A -> Node B
Node B -> Node C
Node C failure -> Node D
Node D -> Node C
```

You can then tell ChatGPT to follow the graph. The model can conceptually traverse that structure during its response, but the whole process is still essentially one model invocation:

```
one LLM invocation
        ↓
LLM interprets the graph
        ↓
LLM produces an answer
```

That does not create a persistent software loop by itself.

The second, more powerful approach is a **graph used as an execution engine**. An outside program maintains persistent state, including:

- the current node;
    
- completed and failed nodes;
    
- attempt counts;
    
- outputs; and
    
- test results.
    

The program then repeatedly runs a cycle like this:

```
Graph Runner
    ↓
Find an eligible node
    ↓
Call the AI
    ↓
Execute tools or code
    ↓
Evaluate the result
    ↓
Update the graph
    ↓
Choose the next node
    ↓
Repeat
```

At that point, the system is no longer merely discussing a graph. It is operating as an actual graph agent.

Consider a `scrape_sample` node:

```
{
  "id": "scrape_sample",
  "objective": "Scrape 20 sample products",
  "success_condition": ">= 19 products contain title, price, and URL",
  "next_on_success": "pagination_test",
  "next_on_failure": "diagnose_scraper",
  "max_attempts": 3
}
```

The resulting loop could be:

```
flowchart TD
    A[Scrape Sample] --> B[Test Result]
    B -->|Pass| C[Pagination Test]
    B -->|Fail| D[Diagnose Scraper]
    D --> E[Modify Scraper]
    E --> A
```

The important point is that failure does not end the workflow. It selects a repair path, and that path returns to the test. The `max_attempts` limit prevents an infinite retry cycle.

## Three levels of looping and orchestration

An LLM can participate in these loops at several levels.

### Level 1: A simulated loop inside one prompt

You can instruct the model:

```
Repeat:
1. Create a solution.
2. Critique the solution.
3. Improve the solution.

Stop when the score is at least 9/10 or after three attempts.
```

The response may contain Attempt 1, a critique, Attempt 2, another critique, and Attempt 3. This can be useful for reasoning, but all the apparent iterations still occur within one model generation. It does not provide reliable external software execution.

### Level 2: A real loop using multiple model calls

An outside program can make the loop literal:

```
while attempts < 3:
    solution = llm("Implement scraper")
    result = run_tests(solution)

    if result.success:
        break

    solution = llm(
        "Here are the failed tests. Fix the scraper."
    )
```

Now the controlling program, not the model's prose, determines whether the process repeats. Because the program can run tests and feed their actual results into the next call, this is much better suited to software development.

### Level 3: Full graph orchestration

A graph generalizes the simple `while` loop. The workflow can branch, merge, retry, revisit nodes, execute independent tasks, and skip paths that do not apply.

For example, a scraper may begin by discovering what kind of site it is. A static HTML site should lead to an HTML parser, a site exposing JSON should lead to an API client, and a JavaScript-rendered site may require a browser strategy. Those paths can later merge into one validation node. If validation fails, a diagnostic branch can identify whether the cause is a selector problem, rate limiting, or JavaScript rendering, choose the corresponding repair, and then retry.

```
flowchart TD
    A[Discover Site Type] -->|Static HTML| B[HTML Scraper]
    A -->|JSON or API| C[API Scraper]
    A -->|JS Rendered| D[Browser Strategy]
    B --> E[Validate]
    C --> E
    D --> E
    E -->|Pass| F[Continue]
    E -->|Fail| G[Diagnose and Repair]
    G --> A
```

That is where graph orchestration becomes substantially more useful than a single prompt or loop.

## Why scraping is a good example

A normal request might say, “Build me a scraper for this website and make sure it works.” That is extremely open-ended, and an agent may generate code and declare the task complete without verifying that the scraper functions.

A more dependable graph would move through the following states:

1. Inspect the site.
    
2. Determine the data source.
    
3. Choose an HTML parser, API client, or browser-based strategy.
    
4. Run a sample scrape.
    
5. Validate the required fields.
    
6. If validation fails, diagnose whether the cause is a selector, API, or blocking problem, repair it, and return to validation.
    
7. Test pagination.
    
8. Test duplicate prevention.
    
9. Test rate-limit handling.
    
10. Run the full scrape.
    
11. Verify the final counts.
    
12. Mark the workflow complete only after final verification succeeds.
    

The graph prevents the agent from treating “code was written” as equivalent to “the project works.”

That is why the most important nodes in a coding graph are often **verification nodes**. A good workflow alternates between action and evidence:

```
DO
 ↓
VERIFY
 ↓
DO
 ↓
VERIFY
```

It should not consist of a long chain of implementation steps followed by “hopefully it works.” For example:

```
flowchart TD
    A[Write Parser] --> B[Run Against Fixtures]
    B --> C[Check Extraction Accuracy]
    C -->|At least 95%| D[Continue]
    C -->|Below 95%| E[Diagnose]
    E --> F[Fix Parser]
    F --> B
```

This regular alternation between implementation and objective testing is one of the largest practical advantages of graph-based development.

## Dynamic graphs can create new nodes

Graphs do not have to be completely fixed in advance. A node can discover new information and use it to instantiate additional nodes.

Suppose the graph begins with `Analyze Website`, and that node discovers four categories:

- Computers
    
- Monitors
    
- Keyboards
    
- Phones
    

The runner can dynamically create one scraping node for each category, execute independent nodes in parallel where appropriate, and then merge their outputs:

```
flowchart TD
    A[Analyze Categories] --> B[Scrape Computers]
    A --> C[Scrape Monitors]
    A --> D[Scrape Keyboards]
    A --> E[Scrape Phones]
    B --> F[Merge Results]
    C --> F
    D --> F
    E --> F
```

This dynamic behavior is especially useful for scraping because a system often does not know every category, page type, or subtask until it inspects the target.

## Graphs can also be nested

A workflow can place a reasoning loop inside one of its nodes. For instance, a `Solve Parser Issue` node might generate Hypothesis A, test it, move to Hypothesis B if the first test fails, test the second hypothesis, and choose the best solution before allowing the project graph to continue.

That produces three conceptual layers:

```
PROJECT GRAPH
│
├── Milestone A
│
├── Milestone B
│     │
│     └── REASONING GRAPH
│           ├── Hypothesis 1
│           ├── Hypothesis 2
│           └── Hypothesis 3
│
├── Milestone C
│
└── Milestone D
```

In practice, a **project graph** can contain a **task graph**, which can contain a **reasoning graph**. That allows loops to run inside one part of the larger workflow without forcing the entire project to restart.

## A practical graph-agent architecture

A useful implementation would begin with the user's goal, send it to a graph generator, store the resulting workflow in `project.json`, and pass that graph to a runner. The runner would coordinate the LLM with code execution, HTTP requests, or browser tools. An evaluator would inspect each result, update the node's status, and select the next eligible node.

```
flowchart TD
    A[User Goal] --> B[Graph Generator]
    B --> C[project.json]
    C --> D[Graph Runner]
    D --> E[LLM, Code, HTTP or Browser]
    E --> F[Result]
    F --> G[Evaluator]
    G --> H[Update Node Status]
    H --> I[Choose Next Node]
    I --> D
```

The runner might maintain state like this:

```
{
  "nodes": {
    "scraper_test": {
      "status": "failed",
      "attempts": 2,
      "max_attempts": 4,
      "output": "18/20 products parsed",
      "failure_reason": "price selector failed on sale products"
    }
  }
}
```

The graph therefore becomes the system's **memory and state machine**, while the LLM serves as a reasoning and execution component operating within that state.

## The key mental model

The most useful way to understand this approach is not, “Graph prompting lets ChatGPT think in a graph.” It is:

> I represent the problem as a state machine, and the AI becomes an intelligent function operating on individual states.

The overall process is:

```
milestones
    ↓
AI graph compiler
    ↓
graph.json
    ↓
runner
    ↓
LLM executes a node
    ↓
test or evaluator
    ↓
edge selection
    ↓
next node
    ↓
repeat
```

For app development and scraping, **graph-based agent workflow** is ultimately the more precise term. Graph prompting describes how the structure is represented to the model; the runner is what produces real loops, retries, branches, persistent state, and measurable progress.

If you already have a list of application-development milestones, the most practical next step is to convert one real project into both a `graph.json` file and a small PHP or Python runner. Doing that turns the idea from an abstract prompting technique into a working system very quickly.

## Sources and further reading

1. [Graph-Based Prompting and Reasoning](https://cameronrwolfe.substack.com/p/graph-based-prompting-and-reasoning)
    
2. [What Is Graph Prompting?](https://drainpipe.io/knowledge-base/what-is-graph-prompting/)
    
3. [Graph-Based Prompting and Reasoning with Language Models](https://medium.com/data-science/graph-based-prompting-and-reasoning-with-language-models-d6acbcd6b3d8)
    
4. [IBM: Prompt Engineering Techniques](https://www.ibm.com/think/topics/prompt-engineering-techniques)
    
5. [MindMap: Knowledge Graph Prompting Sparks Graph of Thoughts in Large Language Models](https://arxiv.org/html/2308.09729v5)
    
6. [Decision Support Systems research article](https://www.sciencedirect.com/science/article/pii/S0167923625001290)