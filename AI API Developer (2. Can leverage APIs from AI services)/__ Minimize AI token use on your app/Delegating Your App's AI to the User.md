# Delegating AI to the user

Weng’s apps stay free by refusing to pay for AI tokens. When a feature needs a model, the app builds the prompt and the user runs it with AI they already pay for. Do not call an AI API from the app, and do not hide a key in the frontend.

Pick the handoff that matches the job:

1. **Chat.** The result is an answer, a rewrite, or JSON the user pastes back. Open ChatGPT or Claude.
2. **Harness.** The result is a change inside this repo (a lesson file, a guide, a sorted folder). The user pastes the prompt into Cursor, Claude Code, or Codex.
3. **The user’s own API key.** Only consider this for a local app or a browser extension, and only after someone can read how the key is handled. A key in a hosted page is the wrong default.

Every prompt builder includes a collapsed info control labeled **Why is this not automatic**. The copy is fixed. Do not paraphrase it.

---

## Prompt: build a prompt builder

Copy the block below into Cursor, Claude Code, or Codex. Replace the bracketed lines, then let it implement the modal in the app you have open.

````
Build a prompt builder modal for this app. The app does not call an AI API and does not pay for tokens. It only assembles a prompt from the user’s inputs and shows that prompt before they leave.

Task:
- Feature name: [name, for example “Ask this folder”]
- What the prompt must make the model do: [one paragraph]
- Inputs the user fills in: [fields, limits, and any suggestion chips]
- Where the model’s reply comes back, if it comes back at all: [paste into a textarea / no return trip]
- Handoff: [ChatGPT and Claude] or [Cursor / Claude Code / Codex] or [both]

Behavior:
- The preview is read-only and updates as the inputs change. Label it “Dynamic prompt preview”.
- “Copy prompt” writes the preview to the clipboard. The button text becomes “Copied” for about 1.6 seconds, then returns to “Copy prompt”.
- Chat handoff: buttons, not plain links. ChatGPT opens `https://chatgpt.com/?m=` plus the encoded prompt. Claude opens `https://claude.ai/new?q=` plus the encoded prompt. If the prompt is longer than 4000 characters, or the URL would be longer than 7500 characters, copy the prompt and open a short chat instead (`https://chatgpt.com/?m=` or `https://claude.ai/new?q=` with the text “I will paste the prompt.”). Tell the user that popups must be enabled.
- Harness handoff: keep Copy prompt. For Cursor, a link may use `https://cursor.com/link/prompt?text=` plus the encoded prompt when the prompt is short. Otherwise tell them to paste it into Cursor, Claude Code, or Codex. If the harness must not edit the repo, say “Use Ask mode.”
- Do not send the prompt to our server. Do not add an API-key field.

Include this disclosure, collapsed, directly above the prompt card. The words stay exact:

<details class="why-not-auto">
  <summary class="why-not-auto__summary"><span class="why-not-auto__icon" aria-hidden="true">i</span> Why is this not automatic</summary>
  <div class="why-not-auto__body">
    <p>Weng provides this service for free and cannot cover the ongoing cost of AI tokens. That's why this Prompt Builder is designed to let users supply their own AI processing resources rather than having the app pay for them. This is also why AI processing isn't integrated directly into the app for a more seamless experience.</p>
    <p>There are several ways to accomplish this:</p>
    <ol>
      <li><strong>Copy the generated prompt into ChatGPT or Claude:</strong> Users can use their existing AI subscriptions to process the prompt.</li>
      <li><strong>Copy the generated prompt into an AI harness like Cursor or Claude Code:</strong> Users can leverage their own AI coding environments and available token allowances.</li>
      <li><strong>Provide their own API key:</strong> The app could process prompts directly using the user's API key, with usage billed to the user. However, this requires trusting that the app does not store, log, or copy the key. This is generally easier to verify with a locally running application or a Chrome extension, although neither is inherently secure without reviewing how it handles credentials.</li>
    </ol>
    <p><strong>For now, letting you use your own AI tools is the most practical approach.</strong> It keeps the service free while allowing you to use AI resources you already have access to. This app uses the method best suited to its particular workflow.</p>
    <p>If the service eventually becomes commercial and can sustain the cost of AI tokens, AI processing could be integrated directly into the app for a more seamless experience.</p>
  </div>
</details>

Use this modal. Reuse the page’s existing modal classes if it already has a dialog; keep the `prompt-builder` structure, ids, and action row. Wire the ids in the behavior section. Suggestion chips are optional and only appear when the task lists them.

<svg xmlns="http://www.w3.org/2000/svg" class="prompt-icon-sprite" aria-hidden="true">
  <symbol id="icon-chatgpt" viewBox="0 0 24 24">
    <path fill="#10a37f" d="M22.282 9.821a5.985 5.985 0 0 0-.516-4.91 6.046 6.046 0 0 0-6.51-2.9A6.065 6.065 0 0 0 4.981 4.18a5.985 5.985 0 0 0-3.998 2.9 6.046 6.046 0 0 0 .743 7.097 5.98 5.98 0 0 0 .51 4.911 6.051 6.051 0 0 0 6.515 2.9A5.985 5.985 0 0 0 13.26 24a6.056 6.056 0 0 0 5.772-4.206 5.99 5.99 0 0 0 3.997-2.9 6.056 6.056 0 0 0-.747-7.073zm-9.022 12.608a4.476 4.476 0 0 1-2.876-1.04l.142-.081 4.779-2.758a.795.795 0 0 0 .393-.681v-6.737l2.02 1.168a.071.071 0 0 1 .038.052v5.583a4.504 4.504 0 0 1-4.495 4.494zM3.6 18.304a4.47 4.47 0 0 1-.535-3.014l.142.085 4.783 2.759a.771.771 0 0 0 .78 0l5.843-3.369v2.332a.08.08 0 0 1-.033.062L9.74 19.95a4.5 4.5 0 0 1-6.14-1.646zM2.341 7.896a4.485 4.485 0 0 1 2.365-1.973V11.6a.766.766 0 0 0 .388.676l5.815 3.355-2.02 1.168a.076.076 0 0 1-.071 0l-4.83-2.786A4.504 4.504 0 0 1 2.34 7.872zm16.596 3.855-5.833-3.387 2.021-1.164a.08.08 0 0 1 .068 0l4.83 2.791a4.494 4.494 0 0 1-.676 8.105v-5.678a.79.79 0 0 0-.41-.667zm2.011-3.023-.142-.085-4.774-2.782a.776.776 0 0 0-.785 0L9.409 9.23V6.897a.066.066 0 0 1 .028-.061l4.83-2.787a4.5 4.5 0 0 1 6.68 4.66zM8.307 12.863l-2.02-1.163a.08.08 0 0 1-.038-.057V6.074a4.5 4.5 0 0 1 7.376-3.453l-.142.08-4.779 2.758a.795.795 0 0 0-.393.681zm1.098-2.365 2.602-1.5 2.607 1.5v2.999l-2.597 1.5-2.607-1.5z"/>
  </symbol>
  <symbol id="icon-claude" viewBox="0 0 24 24">
    <path fill="#d97757" d="M11.15.8h1.7l.62 6.55 4.55-4.55 1.2 1.2-4.55 4.55L23.2 9.15v1.7l-6.55.62 4.55 4.55-1.2 1.2-4.55-4.55-.62 6.55h-1.7l-.62-6.55-4.55 4.55-1.2-1.2 4.55-4.55L.8 10.85v-1.7l6.55-.62L2.8 3.98l1.2-1.2 4.55 4.55z"/>
  </symbol>
</svg>

<div class="modal" id="largePromptModal" hidden>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content prompt-builder" role="dialog" aria-modal="true" aria-labelledby="largePromptModalLabel">
      <div class="modal-header">
        <h4 id="largePromptModalLabel" class="modal-title">[Feature name]</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p class="prompt-builder__lead">[Lead sentence] <span id="ask-folder-name" class="prompt-builder__chip">[subject]</span></p>
        <p class="prompt-builder__note">Popups need to be enabled. Prompts that do not fit in the chat link are copied so you can paste them.</p>
        <!-- why-not-auto details go here -->
        <div class="prompt-builder__card">
          <label class="prompt-builder__label" for="ask-folder-question">[Primary input label]</label>
          <input id="ask-folder-question" class="prompt-builder__input" type="text" maxlength="250" autocomplete="off">
          <div id="ask-folder-suggestions" class="prompt-builder__suggestions" role="group" aria-label="Suggestions"></div>
          <label class="prompt-builder__label" for="largePromptText">Dynamic prompt preview</label>
          <textarea id="largePromptText" class="prompt-builder__preview" rows="8" readonly spellcheck="false"></textarea>
          <p id="ask-folder-status" class="prompt-builder__limit" hidden></p>
          <div class="prompt-actions">
            <button type="button" class="prompt-actions__copy" id="copyLargePromptButton">Copy prompt</button>
            <span class="prompt-actions__open">Open in
              <button type="button" class="prompt-actions__chat" id="openChatGPTButton">
                <svg class="prompt-actions__icon" aria-hidden="true"><use href="#icon-chatgpt"></use></svg>
                ChatGPT
              </button>
              <button type="button" class="prompt-actions__chat" id="openClaudeButton">
                <svg class="prompt-actions__icon" aria-hidden="true"><use href="#icon-claude"></use></svg>
                Claude
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="modal-footer prompt-builder__footer">
        <button type="button" class="prompt-builder__cancel" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

Styling rules, keep these even if you map the classes onto an existing stylesheet:

- One hidden SVG sprite, class `prompt-icon-sprite` (`position: absolute; width: 0; height: 0; overflow: hidden`). Do not use emoji, Font Awesome, or a colored pill as the brand mark.
- ChatGPT is the knot glyph, fill `#10a37f`, referenced as `#icon-chatgpt`. Claude is the spark glyph, fill `#d97757`, referenced as `#icon-claude`. Draw each at 16×16 via `.prompt-actions__icon`.
- “Copy prompt” is the only bordered button in the action row: white background, 1px `#cbd5e1` border, 8px radius, 14px type, padding 7px 12px.
- “Open in” is 14px text. ChatGPT and Claude are borderless text buttons, inline-flex, 6px gap, weight 600, icon then the name. Hover underlines the name with a 3px offset. They are not filled brand buttons.
- The card has 14px padding, a 10px radius, and a hairline border using `color-mix(in srgb, currentColor 12%, transparent)` on a 5% currentColor wash, so it follows light and dark themes.
- Inputs and the preview are white, 14px, 8px radius, 1px border at 18% currentColor. The preview is a block, min-height 9rem, max-height 16rem, padding 12px, line-height 1.5, resize vertical.
- Suggestion chips are white pills (999px radius, 13px, padding 5px 10px). The selected chip has class `is-current`: `#111827` border, `#f1f5f9` background, weight 600.
- The subject sits in `.prompt-builder__chip`: inline, 13px, weight 600, 6px radius, padding 2px 8px, 8% currentColor background.
- The info icon is a 1.05rem circle, italic “i”, 1px border, `border-radius: 999px`. The summary is inline-flex, weight 600, and hides the default disclosure marker. The open body is max-width 42rem.
- Focus rings are 2px solid `#2563eb` with a 2px offset on the input, preview, copy button, and chat buttons.
- Put the disclosure and the card in the modal body. Cancel stays in the footer, left-aligned, with a top border.

Match the app’s type, spacing, and color tokens when they exist. Do not restyle the rest of the page.
````

---

## What the finished modal does

The user edits the inputs and reads the prompt in the same dialog. **Copy prompt** is always enough. **Open in** is a shortcut: a short prompt rides in the chat URL, a long one is copied and the chat opens empty so they can paste. A harness prompt is copied into Cursor, Claude Code, or Codex, because that work needs the repo, not a chat tab.
