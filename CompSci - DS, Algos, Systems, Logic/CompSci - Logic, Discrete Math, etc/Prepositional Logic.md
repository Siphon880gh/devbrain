
What it is: Statement that needs to be proven

---

What is is NOT: Propositional statement to communicate to a team member about rules, such as Q follows P.

What it is NOT: Statement's truthfulness that infers other statement's truthfulness

You cannot say "P -> Q, therefore Q->R". Explanation:
1. **What P→Q being true means**: This statement indicates that whenever P is true, Q must also be true. Alternatively, Q could be true or false when P is false—this scenario still maintains the truth of P→Q.
    
2. **Transition to Q→R**: To evaluate Q→R (if Q, then R), we need specific information about the relationship between Q and R. Even if P→Q is true, it does not provide any information about how Q influences R.
    
3. **Independence of the Statements**: P→Q and  Q→R are logically independent unless additional conditions or premises link Q to R. The truth of one does not imply the truth of the other.

### Example to Illustrate the Independence

Suppose:

- P is "It is raining."
- Q is "The ground is wet."
- R is "People are carrying umbrellas."

We can find a situation where:

- P→Q is true: If it is raining, then the ground is wet.
- Q→R may not be true: The ground being wet (perhaps due to a sprinkler) does not necessarily mean people are carrying umbrellas.

Thus, knowing P→Q is true tells us nothing about whether Q→R is true, underscoring the need for specific evidence or arguments linking Q directly to R.


---

What is is NOT: A statement of truth

When given a propositional statement, your job is to evaluate its truthfulness.

A way to do this is to run the conditions P and Q through multiple cases in a truth table:

| A (It is raining) | B (I carry an umbrella) | A→B (If it is raining, then I carry an umbrella) |
| ----------------- | ----------------------- | ------------------------------------------------ |
| True              | True                    | True                                             |
| True              | False                   | False                                            |
| False             | True                    | True                                             |
| False             | False                   | True                                             |

This truth table passes at every case, therefore P->Q, as in "It is raining -> then I carry an umbrella" is true.

