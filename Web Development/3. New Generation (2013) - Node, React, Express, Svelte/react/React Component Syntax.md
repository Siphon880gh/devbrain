```
import React, { useState } from 'react';

const MyMenu = () => {
    console.log(props); // custom attributes of direct parent

  return (
    <ul>
      <li>a</li>
      <li>b</li>
      <li>c</li>
    </ul>
  );
};

export default MyMenu;
```