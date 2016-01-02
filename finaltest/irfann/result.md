# Correction

## MySQL - Command line (4 pts)

You can write `... id int NOT NULL AUTO_INCREMENT PRIMARY KEY, ...` instead of `... id int NOT NULL AUTO_INCREMENT,  PRIMARY KEY (id), ...`

**Total: 4 pts**

----
## PHP - Preparation (4 pts)

- Your 'redirect' function is broken, you set the path as absolute which breaks your website on my computer for example
- In the `sanitizeString` function, you should cast the input string to avoid any problem
- Most of yout files are not include within the header and footer

**Total: 3 pts**

----
## PHP - Handling users (8 pts)

- You should write the `isset` check before any other, you're lucky `PHP` is checking it in the `empty` function
- You don't show the error message properly
- In the login function, you should first grab the good user thankd to its username and only then verify the password, in the current implementation i guess a thousand of user stored would take quite a long time.
- The profile page can be accessed event when i'm not logged in
- Your `login` function does not work
  - Every time you `fetch` something something from the database, you try to reach a new row, which means you get what you want in the `if` statement and the session is populated with no data at all until you have multiple users with the same username and password, which anyway, is bad.
- Adding the image in the database and updating the user should happen in the same transaction to make sure you get the right id. Also you don't update the user table to set the `image_id`

**Total: 4 pts**

----
## PHP - The chat room (4 pts)

- The natural chat order is `ascendant` and not `descendant`
- You don't display the username


**Total: 2 pts**

----
# Your grade
**13 pts**

Good job!

Your code is little bit messy sometimes and you seem to overcomplicate some parts which reduce the performance and add rooms to bugs. You should not rush to coding!