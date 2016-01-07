# PHP/MySQL - Final test

## MySQL - Command line (4 pts)
```
- Write each "command solution" into the `mysql.sql` file 
- Be precise with your types
```
- Connect to the databse using `mysql -uroot -p`, the password is `r00t`
- Create a database named `ecvchat`
- Move inside the created database 
- Create a table named users with the following properties:
  - `id` int primary key auto increment
  - `email` varchar
  - `username` varchar
  - `password` varchar
  - `photo_id` int
- Create a table named files with the following properties:
  - `id` int primary key auto increment
  - `filename` varchar
  - `path` varchar
  - `extension` varchar
- Create a table named messages with the following properties:
  - `id` int primary key auto increment
  - `message` varchar
  - `created_at` datetime
  - `user_id` int

## PHP - Preparation (4 pts)
- Separate the `index.php` file into a reusable header and footer files
- Create a `session.php` file which start php sessions
  - Protect the session against session fixation attack
- Create a `pdo.php` file containing the mysql connection
  - Connect as the root user
    - username: `root`
    - password: `r00t`
  - Use the $conn keyword for the connection variable
  - Set attribute ERR_MODE with value ERRMODE_EXCEPTION
- Create a `functions.php` file and containing those 2 namespaces
  - `ECVChat`
  - `ECVChat\DB`
- In `functions.php`, under the namespace `ECVChat`
  - Write a `redirect` function which takes as arguments (route) and redirect the user **properly** to the new route
  - Write a `sanitizeString` function which takes as arguments (string) and return the sanitized string (The input is coming from a form, you need to check its type, clean it and filter it).
- Along the whole exercice, use with caution the four following statement
  - include
  - include_once
  - require
  - require_once

## PHP - Handling users (8 pts)
- Use the template `signin.php` to implement a signup form
  - Filter the user inputs
- In `functions.php`, under the namespace `ECVChat\DB`, write a `register` function which takes as arguments (username, password, email) which throw an exception if an error happened and returns `null` otherwise
  - Write a secure query
    - Use prepare statements
    - Hash the password using the `bcrypt algorithm`
  - Handle the exception by displaying the error message to the user
  - if success, redirect the user to the login page

- Use the template `login.php` to implement a login form  
- In `functions.php`, under the namespace `ECVChat\DB`, write a `login` function which takes as arguments (username, password) which returns the user data when success and `null` otherwise
  - Write secure queries
    - Use prepare statements
    - Check the password on php side using the bcrypt algorithm
  - Handle the exception by displaying the error message to the user
  - If success
    - Store the user id in the session with key `id`
    - Store the user username in the session with key `username`
    - Store the user photo_id in the session with key `photo_id`
    - Redirect the user to the chat page

- Write a `logout.php` file which logout the user
  - log out the user
  - redirect the user to the `index.php` file

- Use the template `profile.php` to implement a profile form  
- create an `uploads` folder
- In `functions.php`, under the namespace `ECVChat`
  - Write a `checkUpload` function which takes as arguments (fieldName) and return true if the file is correct, false otherwise
    - Check that no errors has happened while uploading
    - Check that the file is not of size 0
    - Check that the extension is a png or jpeg/jpg file
    - Check that the file has effectively been uploaded in a tmp folder
  - Write a `uploadFile` function which takes as arguments ($filename) and copy the temprorary file in a secure folder
    - Throw an exception if an error happened
    - If it succeed returns two value: `filename` and `extension`
- In `functions.php`, under the namespace `ECVChat\DB`
  - Write a `updateUserImage` function which takes as arguments (userId, filename, path, extension) and return the imageId if it succeeds
    - Throw an exception is an error happen
    - Use a transaction
    - Use prepare statements
- Update the user session with the photo_url
  - Update your code on the login part to join the image table
  - add the `photo_url` field in the session only if it exists
  - Display it in the profile page


## PHP - The chat room (4 pts)
- Use the template `chat.php` to implement a chat form  
- In `functions.php`, under the namespace `ECVChat\DB`
  - Write a `addMessage` function which takes as arguments (message) and throw an exception if an error happened, returns `null` otherwise
  - Write a `getLastMessages` function which takes no arguments and returns the last 10 messages of the chat room 
    - display the messages using the template `message.php`

# Conclusion (Mandatory)
- Dump your sql db using this command:
  - `mysqldump -u username -p ecvchat > dump.sql`
- Use git to push all your work on your remote repository
