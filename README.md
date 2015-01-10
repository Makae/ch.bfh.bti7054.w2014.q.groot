# Readme
Hello and welcome to the groot project.
A project wich was developed for the "Web Programming" Module at the BFH-Bern.

[Visit BFH-Bern](http://http://www.ti.bfh.ch/)

## Installation
It is aussumed that the installation is made a xampp installation.
Please notice you can provide different values for the user, password / installation-folder but you have to change the config.php file in order to do that.
1. Create folder **groot** in htdocs of apache
2. Check out or download the zip of Groot from Github
  1. Move the content of **groot/trunk/src** to the newly created groot folder in htdocs
3. Create db with name **groot** -> **utf8_unicode_ci** on your MySQL-Server
4. Create user for the db groot
  1. User: **groot**, PWD: **groot**

## Problems
When running the application an error might occure with the TemplateEngine.
If this occures please **set the rights** of the tmp folder inside **theme/templates/** to **0755**
Basically the user executing the php-application has to have read and write rights inside this folder.

