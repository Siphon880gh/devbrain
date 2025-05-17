
In Botpress v12, training refers to the process where your defined intents, entities, and utterances are compiled into a machine learning model that allows the bot to understand and interpret user input.

#### Where Training Happens

Training is handled by the NLU (Natural Language Understanding) module. When training occurs, you’ll see logs like:

Training model for language: en  

The resulting model files are stored in the `.data/global/nlu` directory.

---

#### What Triggers Training?

| Action                               | Triggers Training? | Notes                                                                                                                              |
| ------------------------------------ | ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| Creating or editing intents/entities | ✅ Yes              | Automatically triggered (or queued) when changes are made in Studio.                                                               |
| Clicking "Train" manually            | ✅ Yes              | You can manually initiate training from the NLU section. Also the Training button is at the bottom right of the workflow designer. |
| Talking in the emulator              | ❌ No               | Emulator only tests the current trained model.                                                                                     |
| Improving via analytics/logs         | 🟡 Optional        | You can manually add real user inputs to enhance training data.                                                                    |

#### Summary

- Training is automatic or manual depending on your actions.
- The emulator is strictly for testing, not for training.
- Updated training data = better understanding of user input.

In short, defining new intents and utterances triggers training in the background, ensuring your bot keeps improving as you develop.