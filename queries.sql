/*
Elizabeth E. Esterly / CS564
Justin D. Thomas / CS464
Final Project
queries.sql

#NOTE: Required statments of intent for SELECT queries are written inline as comments.
# Some INSERT and UPDATE queries are also commented when the operation's intent is not immediately obvious from the syntax.
# Indices are at the end.

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
SELECT username, is_admin, email FROM users AS info WHERE email like '%awesome%'; 

/* Get all the usernames and email addresses of users who have a favorite set. */
SELECT username, email from users where users.user_id in (SELECT favorite_sets.user_id from favorite_sets);

/* Get all the usernames and email addresses of users who don't have a favorite set. */
SELECT username, email from users where users.user_id in (SELECT favorite_sets.user_id where comment = NULL);

			
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

INSERT INTO favorite_sets (user_id, set_id) VALUES ((SELECT user_id FROM users WHERE username = 'elyzabeth'), (SELECT set_id FROM sets WHERE set_name like 'Tower of Orthanc'));

INSERT INTO favorite_sets (user_id, set_id, comment) VALUES ((SELECT user_id FROM users WHERE username = 'elyzabeth'), (SELECT set_id FROM sets WHERE set_name like 'Black Gate'), 'Battle at the Black Gate');

UPDATE favorite_sets SET comment = 'woof!' WHERE favorite_sets.user_id in (SELECT users.user_id from users WHERE users.username like '%bobo%');

UPDATE favorite_sets SET set_id = 3345, comment = 'Battle of Helm\'s Deep' WHERE favorite_sets.user_id in (SELECT users.user_id from users WHERE users.username = 'justin');

UPDATE favorite_sets SET set_id = 224, comment = 'NA NA NA NA NA NA NA NA NA NA NA NA NA NA NA NA LOBSTER! LOBSTER!' WHERE user_id = 5;

DELETE FROM favorite_sets WHERE favorite_sets.set_id in (SELECT sets.set_id WHERE set_name like 'Pooh\'s Corner');

UPDATE favorite_sets SET set_id = 4586, comment = 'Tower of Orthanc, Minifigs = Gandalf the Grey, Saruman the White, Orc x 2' WHERE favorite_id = 3 and favorite_sets.user_id in (SELECT users.user_id from users WHERE users.username = 'elyzabeth');

DELETE FROM favorite_sets where user_id = 4;

/* Join the favorite_sets and users column on id but filter by users who have a favorite set. Get all matching columns from both tables.*/
SELECT * FROM favorite_sets RIGHT JOIN users on favorite_sets.user_id = users.user_id WHERE favorite_sets.set_id IS NOT NULL ORDER BY set_id;

/*Get the ratio of favorite sets that have comments. Count the numerator as a tenth to make it work.*/
SELECT (SELECT COUNT(comment) * 100.0 FROM favorite_sets) / (SELECT COUNT(favorite_id) * 100.0 FROM favorite_sets) AS comment_percent;

/*Get the highest id in the table (id of most recently added user). */
SELECT MAX(favorite_id) FROM favorite_sets;

/* Get the row with id of the user with the minimum id number (first user added). */
SELECT * from favorite_sets WHERE favorite_id = (SELECT MIN(favorite_id) FROM favorite_sets);

			
/*
SETS*
---------------
*/

INSERT INTO sets (set_name, year_released) VALUES ('Knights of the Frozen Throne', '2017');

UPDATE sets SET year_released = '2016' WHERE set_name = 'Knights of the Frozen Throne';

UPDATE sets SET set_name = (SELECT set_name + ' 2016 release') WHERE year_released = 2016;

DELETE FROM sets WHERE set_name like '%Knights of the Frozen Throne%';

/* Get all sets and order by the most recently released.*/
SELECT * FROM sets ORDER BY year_released DESC;

/* Get the names of sets and the year released for sets released between 1954 and 1955.*/
SELECT set_name AS 1954_to_1955_sets, year_released FROM sets WHERE year_released >= 1954 AND year_released <= 1955;

/* Get the set numbers and names of all sets that have a match on wheel, sany number of characters, ring, and any number of characters
(Retrieve sets with wheels and bearings for vehicles), ordered by the most recent release.*/
SELECT set_num, set_name from sets WHERE set_name like 'wheel%ring%' ORDER BY year_released;

/* Get all columns from the set table where the set_id matches a set_id of a favorite set chosen by the user. 
(Info on everyone's favorite sets)*/
SELECT * FROM sets WHERE set_id in (SELECT favorite_sets.set_id FROM favorite_sets);

/*
THEMES
---------------
*/

#Parent ID: When a theme is a subset of another theme, the parent id refers to the larger theme,
#For this theme, the parent id could be #568 (The Two Towers).
INSERT INTO themes (theme_name, theme_parent_id) VALUES ('"They\re Taking the Hobbits to Isengard!"', 568);

#Set the parent theme of this theme to 566, The Lord of the Rings.
UPDATE themes SET theme_parent_id = 566 WHERE theme_name = '"They\re Taking the Hobbits to Isengard!"';

#608 is parent theme Disney
UPDATE themes SET theme_parent_id = 608 WHERE theme_name like '%Disney%';

#Delete cowboys and indians that weren't in the LEGO movie.
DELETE FROM themes WHERE theme_parent_id NOT IN (535) AND theme_parent_id IN (475);

/* Get all the superheor set themes that end in 'man'*/
SELECT theme_name AS man_heroes FROM themes WHERE theme_name LIKE '%man' AND theme_parent_id = 482;

/* Get all the Series minifig themes and their ids and sort by name.*/
SELECT theme_id AS id, theme_name AS series_minifigs FROM themes WHERE theme_name like 'series%minifig%' ORDER BY theme_name;

/*Get all the info on all the sets with the the parent theme Lord of the Rings that were released after 2010.*/
SELECT * FROM themes RIGHT JOIN sets on themes.theme_id = sets.theme_id WHERE sets.year_released > 2010 AND themes.theme_parent_id = 566;

/* Get the names of the themes of the Favorite sets chosen by the users.*/
SELECT theme_name AS user_favorite_themes, theme_id FROM themes WHERE theme_id IN (SELECT sets.theme_id FROM sets WHERE sets.set_id IN (SELECT set_id FROM favorite_sets));

/*
SET_CONTENTS
---------------
*/
#Insert two spare Minifig Wizard hats into set Tower of Orthanc.
INSERT INTO set_contents (set_id, part_number, quantity, is_spare_part) VALUES (4586, 6131, 2, 1);

UPDATE set_contents SET is_spare_part = 0 WHERE set_id = 4586 AND part_number = 6131;

#9999 is no color and -1 is unknown. Merge Null values
UPDATE set_contents SET color_id = 9999 WHERE color_id = -1;

DELETE FROM set_contents WHERE set_id IS NULL OR part_number IS NULL or color_id IS NULL;

#Give all the info from the set_contents and colors table on spare parts that come in quantites of 10 or greater. 
SELECT * FROM set_contents JOIN colors on set_contents.color_id = colors.color_id WHERE set_contents.quantity >= 10 AND set_contents.is_spare_part = 1;

#Get the first 10 results of the number of different types of parts in each set. 
SELECT set_id, COUNT(set_id) AS types_of_parts FROM set_contents GROUP BY set_id LIMIT 10;

/*
PARTS
---------------
*/

#13 is the part_category_id for minifigs.
INSERT INTO parts VALUES (13, 'Microfig Head dual sided Gandalf the White, smile/angry')

INSERT INTO parts VALUES (0, 'deletable entry');

#Move minifg accessories into the broader minfig category.
UPDATE parts SET part_category_id = 13 WHERE part_category_id = 27;

UPDATE parts SET part_category_id = 43 WHERE part_name like '%saruman%';

DELETE FROM parts WHERE part_name like 'deletable%';

/* Get the number of parts in each category and their description.*/
SELECT part_category_id AS id, COUNT(part_category_id) AS num_in_cat, part_name AS cat_name FROM parts GROUP BY part_category_id;

/* */
SELECT COUNT(part_name) AS num_brick_type_categories FROM parts WHERE part_name like '%Bricks%';

/* Get ids and names of parts that start with zbb, parts with category ids greater than or equal to 15, parts with names including the words horse, elf, or tree, but not parts including the word tiger and order them by id.*/
SELECT part_category_id AS id, part_name AS name FROM parts WHERE part_number like 'zbb%' OR part_category_id >= 15 OR part_name like '%horse%' OR part_name like 'elf' OR part_name like 'tree' AND part_name NOT like '%tiger%' ORDER BY id;

/* Get the first 20 name entries for just minifig parts.*/
SELECT part_name AS minifig_parts FROM parts WHERE parts.part_category_id IN (SELECT part_categories.part_category_id FROM part_categories WHERE part_categories.part_category_name like '%minifig%') LIMIT 20;


/*
PART_CATEGORIES
---------------
*/

INSERT INTO part_categories VALUES ('Other');

UPDATE part_categories SET part_category_name = 'Bricks, Curved' WHERE part_category_name = 'Bricks Curved';

UPDATE part_categories SET part_category_name = 'Rocks' WHERE part_category_name = 'Rock';

DELETE FROM part_categories WHERE part_categories = 'Non-LEGO';

/* Get all the part categories that have to do with bricks.*/
SELECT * FROM part_categories WHERE part_category_name like '%brick%';

/* Select all part categories and order alphabetically.*/
SELECT * FROM part_categories ORDER BY part_category_name;

/* Get all the part categories that parts that have the name legolas in them are associated with.*/
SELECT part_category_name AS legolas_greenleaf_categories FROM part_categories WHERE part_categories.part_category_id IN (SELECT parts.part_category_id FROM parts WHERE parts.part_name like '%legolas%');


/*
MINIFIGS
---------------
*/

INSERT INTO minifigs (566, NULL, 'Gimli with Axe', 2004);

UPDATE minifigs SET theme_id = 25 WHERE description like like '%dragon knight%';

UPDATE minifigs SET description = ('After 2000') WHERE year_released > 2000;

DELETE FROM minifigs WHERE theme_id = 566 AND minifig_part_number = NULL;


/* Get the id of most recent 10 minifigs released since 2017 .*/
SELECT * FROM minifigs WHERE year_released >= 2017 ORDER BY year_released DESC LIMIT 10;

/* Get the average year that minifigs were released in.*/
SELECT AVG(year_released) AS avg_year_released FROM minifigs;

/* Get the part numbers for all of the minfigs from the minifig_contents table with a join and sort the results by the year released.*/
SELECT * FROM minifigs RIGHT JOIN minifig_contents ON minifigs.minifig_id = minifig_contents.minifig_id ORDER BY year_released;


/*
MINIFIG_CONTENTS
---------------
*/

INSERT INTO minifig_contents VALUES (NULL, NULL);

UPDATE

UPDATE

DELETE

/* Get all the part contents of each minifig where the names of the parts are available and sort them alphabetically.*/
SELECT * FROM minifig_contents LEFT JOIN parts ON minifig_contents.part_number = parts.part_number WHERE parts.part_name IS NOT NULL ORDER BY part_name;

/* */
SELECT

/* */
SELECT

/* */
SELECT (SELECT)


/*
COLORS GET TABLE BEFORE INSERTION
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

#___________________________________________________________________________
/*
INDICES
------------------
*/
#1) INDEX ON set_contents
# This is a good choice for an index because there is a large amount of data and the table uses a compound key comprised of 3 foreign keys.

# Run the query before the index:
SELECT set_id, COUNT(set_id), color_id, quantity AS types_of_parts FROM set_contents GROUP BY set_id;
#(0.44 sec)

#Create the index.
CREATE INDEX idx_set_color_quant ON set_contents (set_id, color_id, quantity);

#Run the query again using the index. 
SELECT set_id, COUNT(set_id), color_id, quantity AS types_of_parts FROM set_contents USE INDEX (idx_set_color_quant) GROUP BY set_id;
#(0.19 sec) The time to execute is halved.

