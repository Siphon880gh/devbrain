**Human-in-the-loop**  
A workflow in which an agent can work autonomously but pauses when human participation, judgment, or authorization is needed. The human completes the required step or reviews the agent’s work, and then the agent continues.

Human involvement commonly occurs in 3 ways:
- **Secure handoff**  
  An agent may operate the user’s browser, navigating pages and completing routine interactions, but return control when the user must sign in, enter credentials, complete multifactor authentication, solve a CAPTCHA, or provide consent. Afterward, the agent may detect that the user has finished and resume automatically, or it may wait for the user to say, “Continue.”

- **Planned review or approval**  
  Some workflows intentionally include human checkpoints because AI is not sufficiently reliable for that step or because human judgment provides greater confidence. For example, an agent might draft a contract, prepare a marketing campaign, or identify medical billing issues, but require a person to review and approve the result before it is submitted or published.

- **Exception or error handling**  
  An agent may pause when it encounters an error, conflicting information, low confidence, or an unexpected result. Instead of guessing, it presents the issue to the user and asks for correction or direction. Once the human resolves the exception, the agent resumes the remaining workflow.

Human-in-the-loop design allows agents to automate routine work while keeping people in control of sensitive, uncertain, or consequential decisions.