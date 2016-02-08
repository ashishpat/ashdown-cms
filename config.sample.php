<?php

//Please create a database and a user with all privileges.
//Please enter the host of the server and username and password of the root user or
//a user with all privileges.

define (db_host,"");
define (db_database,"");
define (db_user,"");
define (db_password,"");

/*Define a secret password, you will not be able to change this password in future, make sure it is a strong password*/

define(salt,"key");

/*Replace key with your password*/	

/*
Only edit below this if you know about your severs restriction, IF NOT CONTACT a administrator or someone who managees your server
|***************|
info on rootPath:

rootPath can be null if you are installing this website on your webroot, 
if not you'll have to enter the path to the folder you installed this website
use "/path/path/" format !important

|***************|
info on open_dir_ext:

if your server does not restrict access to upload files
your open_dir_ext can be equal to rootPath
use "/path/.../path/" format !important

*Both variables are required by the website MAKE SURE YOU DEFINE THEM
*/
define(rootPath,"/");
define(open_dir_ext,"");


?>