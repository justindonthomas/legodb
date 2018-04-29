To install the database, from inside mysql, first run
structure.sql, then run data.sql.

The required demo queries are included in queries.sql and
can be run once the database is installed.

The application for our project is a web interface.
The file [Document Root]/config/configs.php must be altered to point to the database.
The following variables must be set in this file:

$DB_HOST = the host server for the database.
$DB_USER = The database user name.
$DB_PASSWORD = The database password.
$DB_NAME = The name of the database to use.

The entry point for the database will be at:
[Document Root]/cs464/index.html

Logins included with the database are:
justin
passj

user1
pass1

user2
pass2

More users can be created.