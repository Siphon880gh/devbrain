If you've already built your React app and want to integrate styled-components, it's quite straightforward. Here's how you can do it:

1. **Install styled-components**: You can install styled-components via npm or yarn. Open your terminal or command prompt, navigate to your project directory, and run one of the following commands:

   ```
   npm install styled-components
   ```
   or
   ```
   yarn add styled-components
   ```

2. **Import styled-components**: Once installed, you need to import `styled` from `styled-components` in the files where you want to use it. For example:

   ```javascript
   import styled from 'styled-components';
   ```

3. **Create styled components**: To create a styled component, you can use the `styled` function provided by styled-components. Here's a basic example of creating a styled button:

   ```javascript
   const Button = styled.button`
       background-color: #007bff;
       color: white;
       font-size: 16px;
       padding: 10px 20px;
       border: none;
       border-radius: 4px;
       cursor: pointer;

       &:hover {
           background-color: #0056b3;
       }
   `;
   ```

   In this example, `Button` is a styled button component. You can use it just like any other React component:

   ```javascript
   <Button onClick={handleClick}>Click me</Button>
   ```

4. **Use styled components**: Now, you can use your styled components anywhere within your React app. Simply replace existing HTML elements with your styled components. For example:

   ```javascript
   const StyledDiv = styled.div`
       background-color: lightgray;
       padding: 20px;
   `;

   const MyComponent = () => {
       return (
           <StyledDiv>
               <p>This is a styled div.</p>
           </StyledDiv>
       );
   };
   ```

Styled-components offer a powerful way to encapsulate styles with components in React. You can create complex styles using nested selectors and even use props to dynamically change styles.