Purpose: Understand a data structure

For example, lets say you cant get a data structure implementation right. 
Or, you purposely ask as if certain things from your data structure implementation is not working, then it will provide you more angles to learn from.

---

<<
What are some reasons why my linked list would appear empty after I tried reversing it?

\>>
If your linked list appears empty after attempting to reverse it, there may be several potential issues in your reversal algorithm or code:

1. **Lost References**: During the reversal process, if you are not careful with handling the next pointers, you might accidentally lose references to the rest of the list.

2. **Head Pointer Not Updated**: After reversing, you need to update the head pointer to point to the new first node (which was the last node before reversal). If the head is not updated, it may still be pointing to the original head, which is now the last node and likely to be `null` or equivalent, making the list appear empty.

3. **Incorrect Loop Conditions**: If the loop conditions in your reversal algorithm are not correctly defined, the reversal may not be processed correctly, leaving you with an empty list.

4. **Tail Node Not Handled Properly**: The new tail (original head) of the list should have its next pointer set to `null`. Failing to do this can lead to a cycle in the list, which may not be detected, depending on how you are outputting the list contents.

5. **Intermediate Nodes Losing Next Pointers**: When reassigning pointers, there's a risk of overwriting the `next` pointer of a node before its old value has been used to move to the next node in the list.

6. **Failure to Handle Single-Element or Empty Lists**: If your code doesn't account for lists with a single element or no elements, the reversal process may inadvertently make the list appear empty.

7. **Memory Issues**: In languages like C and C++, improper memory management could lead to dereferencing null or dangling pointers, which could give you the illusion of an empty list.

Debugging strategies include checking each node's pointer before and after the reversal, using debug print statements, or stepping through the reversal process with a debugger. Make sure the logic that iterates through the list and prints it out after the reversal is also working correctly.