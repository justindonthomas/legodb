/*
Elizabeth E. Esterly / CS564
Justin D. Thomas / CS464
Final Project
queries.sql

#NOTE: Required statments of intent for SELECT queries are written inline as comments.


OVERALL
----------------
Indices - You must create at least 2 indices that are not based on primary keys for your database.  
			CREATE INDEX name_index ON Employee (Employee_Name)
			SELECT * FROM table1 USE INDEX (col1_index,col2_index) WHERE col1=1 AND col2=2 AND col3=3;
			SELECT * FROM table1 IGNORE INDEX (col3_index) WHERE col1=1 AND col2=2 AND col3=3;
			Choose your table(s) and write a statement for each index as to why it is appropriate.  Run a query before and after the index and add the differences in performance to your statement.
ORDERS - You must use ORDER BY at least once and should use it wherever appropriate
			2.2.a.4 - LIMIT - You must use LIMIT at least once and should use it wherever appropriate
			2.2.a.5 - Aggregate Functions - You must use aggregate functions (AVG, COUNT, MIN, MAX, SUM) at least once each and should use them wherever appropriate
*/

/*
USERS
---------------
*/

INSERT INTO users (username) VALUES ('genericUser');

UPDATE users SET is_admin = 1 WHERE username = 'bobothedog';

UPDATE users SET email = 'genericemail@email.email', is_admin = 0 WHERE username = 'genericUser';

DELETE FROM users WHERE username = 'genericUser';

/* Get the usernames of all users that have admin privileges. */
SELECT username FROM users WHERE is_admin = 1; 

/* Get the email of the most recently added user */
SELECT email FROM users ORDER BY user_id DESC LIMIT 1; 

/* Get the username, admin status, and email of the user(s) whose email contains any capitalization of the word 'awesome'*/
SELECT username, is_admin, email FROM user AS info WHERE email like '%awesome%'; 

/* Get all the usernames and email addresses of users who don't have a favorite set. */
SELECT username, email from users where users.username in (SELECT ) #chain a selection here

			
/*
PASSWORDS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
FAVORITE SETS
---------------
*/

INSERT INTO favorite_sets (user_id, set_id) ((SELECT user_id FROM users WHERE username = 'elyzabeth'), (SELECT set_id FROM sets WHERE set_name like 'Tower of Orthanc'));

UPDATE favorite_sets SET set_id = 3345 WHERE favorite_sets.user_id in (SELECT users.user_id from users WHERE users.username = 'justin');

UPDATE favorite_sets SET set_id = , comment = 'I hate LEGOs!' WHERE favorite_sets.user_id in (SELECT users.user_id from users WHERE users.username = 'ihatelegos');

DELETE FROM 

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)

			
/*
SETS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)

/*
THEMES
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)

/*
SET_CONTENTS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

SELECT

SELECT

SELECT

SELECT (SELECT)

/*
PARTS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
PART_CATEGORIES
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
MINIFIGS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
MINIFIG_CONTENTS
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
COLORS
---------------
*/

INSERT

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)

/*
PART_IMAGES
---------------
*/

INSERT 

UPDATE

UPDATE

DELETE

/* */
SELECT

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


