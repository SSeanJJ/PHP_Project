# CMSC 4003
### Project Part One: Web-Based User Management System

**Due:** See the due date in D2L calendar.

Requirement: Your answers must be typed. You may attach a scanned image or a clear photo of hand-drawn diagrams if needed.

1. **Goal of the Course Project**
The course project contains two parts.  Part One involves designing and implementing login/logout and session controls for system users on the web.  

2. **Part One Description**
 Note that you are allowed to re-use the code in demo.zip provided for Lab 8 for this project.

In this part, you will design and implement a login/logout system where a user will be able to login as a regular user through a web interface.  An administrator of the system will be able to login as an admin user through a web page interface and will have more privileges to access and update the database.  

You will design and implement PHP programs that generate regular user and administrative user web pages.  The session of each logged-in user has to be managed appropriately to guarantee access control by different types of users.  

**Data Requirements**
- Each user has a unique username and a password. A user also has a first name, and a last name.
- An admin user has a start date while a regular user has a date of registration.
Some users are both regular users and admin users (“hybrid user”).  We do not have any other types of users in the system.
- A user session has a unique session id and a session date.  
- A user may own several sessions (one for each login), while a session can only be owned by one user.
- A user may own zero sessions (when not logged in), while a session must be owned a user.

**Function Requirements
Login:** 
- A user can login the system using his/her username and password.  When login is successfully, a user session should be generated for the user.  
- Session management: A user session should be used to verify a user’s identity after a user has logged in.  Except the login page, access to any other web/PHP pages of the system should be denied unless a provided user session can be verified.  (See Lab 8 for more details on session control.  Talk to the instructor if you want to use a session control approach different from what’s introduced in Lab 8.) 
- Logout: A user can logout the system after having logged into it.  When a user is logged out, the respective session of the login of the user should be removed from the system.  
- Web page access: Make sure that a regular user can access only regular user pages while an admin user access only admin user pages.  A hybrid user may access both types of web pages.
- Changing password: A user (admin or student) can change his/her password after login.
Managing users: An admin user can list all users or search for any users in the system.  An admin user can add new users, delete users, and update any information pieces of an existing user except the username (primary key).

**General Requirements**
You should complete the following tasks for Part One of the project:
- Create an EER model/diagram based on the data requirements. 
- Create a database schema based on the EER
- Implement the function requirements for Part One,
- You can use a similar interface to what’s given in the Demo for Lab 8.  You can also design your own user interface.  
- Interface should be intuitive and clear.

**Submission Requirement**

- (a) The EER diagram
- (b) Relational database schema (SQL file) needed for Part One
- (c) The cs2 account name of the group member who has the web pages of the project in his/her account
- (d) The URL of the project
- (e) An administrative user account, a student user account, and a hybrid user account. You need to enter some data in the database for testing/grading purposes.
- (f) You do NOT need to submit a hard copy of your source code

**Grade Distribution**
- (a) EER diagram. (20 pts)
- (b) Database schema. (20 pts)
- (c) Correct implementation of all functions (50 pts)
- (d) Submission according to requirements (10 pts)
