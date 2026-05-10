
Error - ..is not supported with this model

Suddenly your AI node or AI model attached to it fails. It use to work before.

An old syntax or calling procedure to an AI API endpoint is outdated. Once you n8n is updated, you need to replace the AI Agent node and AI model that attaches to it.

---

Your workflow fails. Upon looking at Executions logs, you see a crashed out AI model attached to an AI Agent node
![[Pasted image 20260510030025.png]]

Opening the model shows “is not supported with this model”:
![[Pasted image 20260510030042.png]]

Zoomed out:
![[Pasted image 20260510030054.png]]

  

Btw, this Stop is not supported by the model is **NOT** related to Stop on error:  
![[Pasted image 20260510032657.png]]
^ Changing that won’t fix the problem.

**Your error might complain about a different syntax than STOP though.**


---

Next, you need to upgrade n8n so that you have the latest nodes that call the AI API model with the updated syntax

The “STOP” syntax in particular has been fixed with newer n8n release. If you look up the syntax that’s no longer supported according to your AI error, there likely will be forums discussing it’s been patched, unless this just recently happened - then you have to wait or patch it up another way (manually coding AI API calls either through n8n or a remote api endpoint that n8n hits).

Updating: If you’re dockerized, you must re-build image after updating

chore: Update Langchain dependencies (no-changelog) ([https://github.com/n8n-io/n8n/pull/18213](https://github.com/n8n-io/n8n/pull/18213)) → Related Linear tickets, Github issues, and Community forum posts
- fixes **[GPT 5 not working in OpenAI Chat Model node - "unsupported STOP parameter" #18149](https://github.com/n8n-io/n8n/issues/18149)**

---

You replace the AI agent node and model node next because the update wont update the nodes for you:
- Someone fixed by replacing the node too at answer with text starting with “Sorry that was me posting in a hurry”…: [https://github.com/n8n-io/n8n/issues/18149](https://github.com/n8n-io/n8n/issues/18149)


More proof:

The error "Unsupported parameter: 'stop' is not supported with this model" occurs because newer OpenAI models (like GPT-5, o1, or o4-mini) in late 2025/2026 do not support the `stop` parameter in their chat completions API. To fix this, remove the `stop` sequence from your API request or update your library to handle unsupported parameters automatically

And even more proof:

The old “AI Agent” (middle of screenshot) and the floating one is the new one I just dropped in.
![[Pasted image 20260510032214.png]]

Old has older version - 1.7:
- Version is show after all the settings but before the bottom connectors
- You already see a hint in parenthesis that the latest we have available is version 3 if we dropped in a new node
![[Pasted image 20260510030449.png]]

New has newer version - version 3:
![[Pasted image 20260510030700.png]]

Although n8n is updated which is why it has the newer version nodes, it does not automatically update nodes already existing in workflows, in case it breaks your automation

Just connect them, copying settings and prompt text:
![[Pasted image 20260510030841.png]]

  

In the middle of disconnecting the old AI Agent:
![[Pasted image 20260510030851.png]]

Now attach the model to OpenAI Chat Model:
![[Pasted image 20260510030905.png]]

AaI model is attached:
![[Pasted image 20260510030918.png]]

  

Just delete the old AI Agent + Model and re-connect the workflow with the new drop-in’s like nothing happened:
![[Pasted image 20260510030931.png]]

Make sure to test your workflow works now