# Readme
Welcome to the groot project.
A project wich was developed for the "Web Programming" Module at the BFH-Bern.

[Visit BFH-Bern](http://http://www.ti.bfh.ch/)

## Installation
It is aussumed that the project is used on a xampp installation.
Please notice you can provide different values for the user, password, db and installation-folder but you have to change the **config.php** file in order to do that.
1. Create folder **groot** in htdocs of apache
2. Clone the project or download the zip of Groot from Github
  * Move the content of **groot/trunk/src** to the newly created groot folder of the htdocs directory
3. Create db with name **groot** -> **utf8_unicode_ci** on your MySQL-Server
4. Create user for the db groot
  * User: **groot**,
  * Password: **groot**
5. Install ZEND Framework via PEAR for Wikipedia REST client
  * [Install](https://code.google.com/p/zend/)

## Problems
When running the application an error might occure with the TemplateEngine.
If this occures please **set the rights** of the **tmp** folder inside **theme/templates/** to **0755**
Basically the user executing the php-application has to have read and write rights inside this folder.

# Additional informations
## Users
Following users are created by the testdata.php File.
And can be used for the login inside the Website.
User, PWD:
* tony, 12345
* hulk, 12345
* thor, 12345
* max, 12345 (admin)

## Specific information regarding the BFH Project

### Infos regarding the Website
* Following Elements do only have a stylistic purpose without any functionality:
  * The Whishlist in the left menu
  * The Hotlist in the left menu
  * The Links in the footer

### Feature list
This list is based on the introduction presentation.
The paths show which files show the fulfilling of the requirements the best.
After the file path there might be a ":methodName()" which specifies the
exact method.
* a Web frontend with a mixture of static and dynamic content
  * Navigation Menu:
    * viewlets/viewlet.navi.php -> Main menu
  * Multi-page Setup:
    * classes/class.controller.php -> Controller for loading different views (Pages)
  * language selection
    * viewlets/viewlet.header.php -> Language selection
  * product catalogue
    * view/view.home.php -> List of the Products
    * view/view.genre.php -> Genre divided-Lists
    * view/view.search.php -> Search Page (accessed view header)
  * user accounts
    * viewlet/viewlet.header.php -> Login-Form in Header
  * shopping cart
    * views/view.shoppingcart.php -> Page "shopping cart"
    * classes/class.shoppingcart.php -> Shopping cart object
  * administrator view
    * **Login** with user **max** (pwd: **12345**)
    * view/view.administration.php
* using HTML, CSS, and JavaScript
  * Web forms and form validation (incl. regular expressions)
    * view/view.administration.php
    * theme/js/
    * core.js
  * cookies and sessions
    * classes/class.shoppingcart.php:displayCart() -> cookies
    * classes/class.userhandler.php -> user-session
    * classes/class.i18n.php -> session, language-value
* a backend for
  * generating HTML on demand
    * classes/class.templaterenderer.php:extendedRender() -> Rendering Engine vor dynamic content
    * theme/templates -> Template folder for Renderer
    * views/view.search.php:render() -> Call of rendering
  * storing content in files and a database
    * classes/class.templaterenderer.php:_templateInclude() -> saves and reads temporary php-file
    * theme/templates/tmp -> folder in which the renderer saves the temporary files
    * classes/class.db.php -> database class which provides the first layer to the mysql-db
    * classes/clase.basemodel.php -> BaseModel for easy read and write to the database
    * classes/models/class.book.php -> Example Child class of BaseModel defines the data-types and columns of the book table
  * managing sessions
    * classes/class.userhandler.php -> handling user login and user logout
    * viewlets/viewlet.header.php -> data from user, passed to class.userhander.php
  * calling external Web services
    * classes/class.utilities.php:wiki() -> method for calling the wikipedia rest client
  * sending mails
    * views/view.payment.php  -> mail($email_adress, $email_title, $email_message);  prepare mail content and send it