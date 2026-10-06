Jev is TypeSafe AI’s newest model. It is classified as a **System One** model: a fast, decision-making model designed to return probabilistic choices rather than generate long-form responses. It is accessed through an API, not through a ChatGPT-style conversation.

TypeSafe describes the model’s approach as **“unstructured state in, typed decisions out.”** You cannot talk to Jev as you would a chatbot. There is no chat transcript, system prompt, or generated reply. Instead, you send:
- **State:** the facts to evaluate, supplied as text, an object, or an array.
- **Questions:** typed requests for a **choice**, a **score**, or a **noul** (a yes/no probability).

Jev returns typed answers with probabilities, which your code can use to choose what happens next. TypeSafe presents it as a decision-making model first, rather than a generative one; that design is intended to make it fast and use fewer tokens. The official API call is `POST https://api.typesafe.ai/v1/systemone`.

## Possible uses

Jev could be used to:
- Extract short clips from longer content.
- Sort phone calls or emails into categories.
- Classify leads and assess the risk that a lead will drop off.
- Break transcripts into action items.
- Support retrieval-augmented generation (RAG) chat or search.
- Triage Gmail messages using tags and filters.
- Organize scattered notes or files.
- Search images.
- Check claims as people make them—for example, as a live-TV “BS meter.”
- Route tasks among AI agents.

These examples are discussed in connection with this video: https://youtu.be/3iDiWTt8lok
## Trying it in the playground

The playground uses the same **state-and-questions** contract as the API, presented as a form. It is not a chat box: you still enter state and typed questions rather than a conversational prompt.

Playground: https://console.typesafe.ai/playground

Sample starter playground: https://console.typesafe.ai/playground#share/N4IgJg9gxgrgtgUwHYBcAqCAeKQC4QBSCAbgAQCWAzqWgJ4AOCAygIYBmCA5NW+QE6UUpejABGAG3JRSTWoIRxSAeSQJScCGATiANKQDuACymGK1FqTYwkYFolQtx42qVX7SUcS0rUIbUgCCAJLqmtqUeix8UMYoCFBxYAbkKKZupCh8LORIOQDmpCw2pJR29JJIBYipmtR8CJQIUTEISaIudIysHJYQfBmGal6CGfoQpLRNAgB0ADpI80RkJI4wLHHUKAytpACOMA0o5BBI5sX1KDB8pyWZMAlXO1pQVMc3EPRHcOQAXjv0fAgeSycDg6ykpBgpTyCD0SAgQkM8CKpHqLC0M1ISwy2nE1FoEBgBkGSAoKEAmATUaxQBB8FDZUn6FKmCxQE68LRIGmkYirNQEolQFFQtQ5DxhaY0QY0bbdNQaLTiMxIclCTIMnYocblJqNUhIsGk0QIfKUADcZO4GSyOU142NqO05BYElhpAajBejmcxOQA1posoSE4QlZfXqCUKp30tMlADErqlaRp6nomjFSM9XiczIUPI5yKIsolhIDRC7yJItnpKONKORvl5+jkRChqHlyMQ1PXG1FSISUK3KJL5osSPnSdYMYIikkkOsro5SF5KmsYYVqDGnBvl00wPlLIDUORaY7vCcDwrwsvyABrNRKETUAAs0wAHFGkhg+Fk9KIYEI2JCkg8JCDCqjFt2mQHvUlD0CcjTDlKagnD6sHwac-KEpw24wkIbCAoo2JRPKLAxLaAC085HF2tx8Pclz1EkWb1ghehGCY6hNDcqTrP6dEMY8SQDq2uageKSBdnSOwERAigWIIfAwR6CFupI97+i4JHJKkpAAAq0LYx7SLO-ZJv0W7iBRt7wvopKKYJTH9gBokAhAxDkNOkpLFaDkPE5IkAeY9RRhQqDIEcJxLm5YAMf2-g+cF5FxP5CCSkEpIIoMFl9GAERYuOVCuAioUADKlQAsgYWT0IwfCSmg4wKPQhjeL8brYkV4kWOBtLgrRMR8VeuglOMKQTuJgVCIppr9v0hgQOISRhpJtKlJFjLMhMhJzAsSCNaQeFRpQMYCIeckFcQegCuoUJCFovCqPxlCtYw8X8UUJ2nmKAr9PshxvJKAAUABKCAcP0Wr8QCDYpJ2DQlPEG3vUmMpdOwaiQLA9j0htACU+osLRUNuR5WgSXE2DpSgVq3jkwn+Opaj6EpRyVLd4hHDqHgLVIaj-YIbxISAOggG5cCfJQGDYHgIDAPMpCkLMIDAQA+gKquDSgqtMqkqsAFYkMruCkPLpKK0rIBbIwxuW-CMDiMrOgKxbys5H5G2ULbysAMIojdWs6aYSx6J0zAY1a6TDQA-MrLsAL7O+bytTmt9I2JQqvUYu4iqyueRrggttmxblvW0XeB24Sjsiy7itu6cdwJEL3sgAAIhACPYqnAjp3OC5ZEq+eF2FraxyACdJ-XIBTar5fF3XZfbK3MQQHzTuLw3Hst5XysAOqtUIdPFH4zmDgBmad9Q2IxfcCDj1Prsq6ztLOgv5ul8rcb1AgFFsH0ihKZgWQH1DatskAO10IvaeFUyLGFUFRfqUF6KpWYvEbMNxZLyVJJ9U6JR6BkUxuDW0bQXCowNEUcBkDH6fxAGHYSLkgpBwkhyZA3JeTiAOPlF6LBGCkP4iKCyJJNKZniE2NQqMYbfBomobwwgohCFPkmfgewuFgMrhApwNCn5MCboxHYU0JJSRLFgvMQDHRwVUlQrR0DLYAFEND63IGmTAngoTwx9IAXg3ACyO9YqBH8n4AEU1FC0KKIAc20riljkp8Px2jp4BG3Eo6ULp3IVxNpo-xpdp4ADkTgoX8KjVJXY-GL3jpPF2yseyViiCkWgc8IA6xqnVL2lcS5P3nrvEAlA2T1A3gEreeid4m2VgACQgO4apTZcyJUKNEWISNHgZHGCicqVUWa8LqtEiWJYoaGIIEwJQOSH6b2fikV+LBbYAG1bHKzyakA8Yo2SghOHoJ5JwaSfDmmFd0mB4gATeP07JlsmCSDyIYIQbIuQIE+GsJUaS+BeHoH+C+VgbB2Ait6Fw+42AQwimFCCBg+jHzyK0+JIKxAzmPEuBFSKfnhN0lCz5oZihYH+cjXWpgpl9hyISsYfASVktuSAHJUwfSo1KIgPQOKIYHlQi4MUEqrhsEIRRcQJBtCiPpJWIVATp5BE5EcIUNdF4AF0KnJxVuyTybCECq0QINXIlA4Dv1oZ0kZKteY0iBU-d2QyEKt3Ge4SAXdxxRCUrRPiqMoWsOhaQY08Dlo4OjLSE5AyzlxCUpctpwq95bVZAWIs6wdgxptXGjhBxRERpkoRaGZYKxVmxVQaC-5kZkUBD4D6Kb+hwUIXE4VAAhFwjRDRGqxSUXpB4LBgCyGwIQ6FVJ6CTKSKFxjHlqjrHooSZ9Wz9r1ZbIdJQWC0APLWH5FgWYpDiKSBdmEl3Sn0MevMLScxjAdmAUpATynm0TpUkARhGk8MYJnJMqtcG0ldR05eXSel9ArtowZKDPatwPuMB6tpNjSiAwUy6VpwM9oITSNNtCoAvyzdc4VaBpQvpwZQElpBAAoBO6OBqiAY5nQ6oTDyDHI4ZSL4Oyx1To+toQOrKjGPp0dPKZbEPCQopGE0-Yi4h8nieo1IW81BjD8dJP-PgYIUBxwCean9j9lZCnoCkRwqs-BgcQEpIUkHp7ustqvdetd01+qQ8My2ftSTEW7UrWY+9D5Wmjbwyz8L-ABDs1IFgscgsgB3BYeEemlyBwFhtYjT9SPnPIzm-dysACaDQXFkRQD6OR3h7wfo0dQ4VxX8rkH8DdbD-EMuAtqzYgrIqICftLt+xW3744i26doJGrQKphDxHgK5prRbhYAGprTeLLYgABGEA8cgA

The playground requires you to sign up or sign in first. As of October 2026, the sign-up flow is somewhat awkward: you create an account through the separate interface at https://typesafe.ai/ before using the playground otherwise you'll get some error about being denied because you're a bot.

You create an account at the unique ui here:
![[Pasted image 20261005194251.png]]

## Training approach and name

TypeSafe says it has spent the last two years researching **RLCD (Reinforcement Learning for Calibrated Decisions)**. Its stated aim is to address mode dropping, hallucinations, and reliability problems it associates with **RLHF (Reinforcement Learning from Human Feedback)**, a method used to train modern LLMs.

Jev is named after **William Stanley Jevons**, the 19th-century English economist. Jevons Paradox is the observation that making a resource more efficient can increase its total consumption rather than reduce it; the historical example is more efficient steam engines leading to more coal use. [1, 2]

TypeSafe’s bet is that machine intelligence will follow a similar pattern: if a fast decision becomes nearly free and instantaneous, software systems will make thousands more automated choices instead of relying on a small shortlist. [1, 2] The **System One** label also refers to the fast, intuitive mode of thinking described in Daniel Kahneman’s _Thinking, Fast and Slow_. Jev applies that idea by producing quick probabilistic decisions rather than extended prose. [1, 2]

Two useful follow-up topics are how Jev compares with traditional LLMs and which tasks are best suited to a System One decision model.

![[Pasted image 20261005194318.png]]