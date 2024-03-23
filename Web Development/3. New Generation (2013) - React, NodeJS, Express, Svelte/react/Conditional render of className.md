
You can have the className render either as:
`card flip` or `card`

Here the className is escaped as javascript evaluating expressions using curly brackets. Inside the curly brackets is a template literal that evaluates into a string. After the word "card" is a ternary operator for the string interpolation, either returning a second class name (therefore, `card flip`) or blank (therefore, `card`):
```
import React, { useState } from 'react';

export default function Flashcard({ flashcard }) {
  const [cardFlip, setCardFlip] = useState(false);

  return (
    <>
      <div className={`card ${cardFlip ? 'flip' : ''}`} onClick={() => setCardFlip(!cardFlip)}>
        <div className='front'>
          {flashcard.question}
          <div className='flashcardOptions'>
            {flashcard.options.map((option, index) => (
              <div key={index} className='flashcardOption'>{option}</div>
            ))}
          </div>
        </div>
      </div>

      <div className='back'>
        {flashcard.answer}
      </div>
    </>
  );
}

```