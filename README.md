# uapi
Universal API for any APP

Three steps for starts

1. Save the directory with files UAPI to a folder with your project.

2. Edit config.php (change the parameters database).

  Include config.php into your project. (like this [ 1.include('/uapi/config.php'); ]).

3. Paste the [ new get_api(); ] into a place in your script where api should start working. 

it's all folks ;)

NOTE:
if you want enable crypt function, you must install mcrypt!

on ubuntu you have to:

apt-get install php5-mcrypt
php5enmod mcrypt
service apache2 restart

for more info, look requirements http://php.net/manual/en/mcrypt.requirements.php

How API does work.

You need send POST or GET request to server.
If you need get info from server, you have to do is:

http://exemple.com/?do=select&src=table

where 'do' is type of request, and 'table' is name of table in your database.
If you want get just one row, you must add 'value' in JSON format into request, like this:

http://exemple.com/?do=select&src=table&value={"id":"1"}

If you need insert data to database you must send to the server another request, like this:

http://exemple.com/?do=select&src=table&data=[{"id":"1"},{"name":"John Doe"}]

where 'data' is JSON array with data which you want insert into database.

If you need update row in table, you have to do is:

http://exemple.com/?do=select&src=table&data=[{"id":"1"},{"name":"Doe John"}]&value={"id":"1"}

