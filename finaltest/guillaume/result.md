# Correction

## MySQL - Command line (4 pts)

Good 

**Total: 4 pts**

----
## PHP - Preparation (4 pts)
- You should declare multiple namespaces using brackets
- The redirect function is missing the `exit()` statement
- In the `sanitizeString` function, you could have casted the input var as a string to make sure your works as expected, in the current code, since you return a string you have no idea if it's the real data

**Total: 3,5 pts**

----
## PHP - Handling users (8 pts)
- You should avoid using functions relying on globals, `insertUser`, `login` should not rely so much on the environment
- You should remove `var_dump` calls before submitting any contributions
- Using the `time` function twice is dangerous, you have a very small chance to create a bug that could have been avoidable by reusing the first value. On a high traffic website, this kind of bug will happen often.
- Reusing the `initSession` function inside the `updatePhotoId` function is a bad idea, first the function is not adequatly named in this case, and you make a useless database query
- Your functions are not under the right namespaces


**Total: 7 pts**

----
## PHP - The chat room (4 pts)

- The natural chat order is `ascendant` and not `descendant`
- You forgot to add the filename extension in the image source
- You could have formatted the `created_at` value

**Total: 3 pts**

----
# Your grade
**17,5 pts**

Very good job!

You have a tendency to take shortcuts sometimes. You should be more carefull and takes time to consider the big picture when you code. 

Remember: every shortcuts taken now is potentially a technical debt in the futur.