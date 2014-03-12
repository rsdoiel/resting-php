resting-php
===========

Utility libraries for maintaining legacy PHP RESTful APIs. These libraries are really prototypes
for some general problems I've run across in my day job.  We have lots of legacy PHP code with
much dating back to PHP version 3.  Things have gotten tweaked to run with more recent versions
but as we've moved to PHP 5.x more and more thinks need little chunks rewriting or replaced.
This code was my personal experimentations implementing small simple modules I could use to 
shim old code while waiting to get time to do the radical rewrites really required.

+ assert.php - a very light weight testing library inspired by NodeJS's simple assert module.
+ resting.php - A functional style wrapper for building RESTful API using PCRE expressions and routes concepts
+ persistence.php - a simple Object that supports legacy mysql_* and newer mysqli_* DB functionality. Also supports configuraiton from a URL style DB connection string (e.g. mysqli://someuser:somepassword@somehostname/somedatabase).

Others little bits of code are likely to follow.

