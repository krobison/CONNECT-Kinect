### Setting Up Development Environment
To quickly get going on Toiler's, follow these instructions.

First log onto Toiler's through SSH then make sure you are in the /home/www/ directory.
```shell
# Clone the repository from GitHub through HTTPS.
git clone https://github.com/CONNECT-Mines/CS-CONNECT.git <csconnect-yourusernamehere>

# Give Laravel write access to the storage folder.
cd <csconnect-yourusernamehere>
cd app
chmod o+w -R storage
```
Once that is done, you should be able to see the website operation at: http://toilers.mines.edu/csconnect-yourusernamehere/index.php

### Technical Details
CS CONNECT currently uses a generic LAMP stack to operate, with MySQL as the database PHP as the scripting language behind the scenes. The databases are located on CousinIT on the Mines campus so in order for this code to be operational the code must reside behind the campus firewall. Typically the development environments are located on the Toiler's server so this is not an issue.

The framework surrounding the code is Laravel, documentation can be found here: http://laravel.com/docs.

Laravel is very similiar to Ruby on Rails in many aspects including object-relational mapping, MVC framework, RESTful actions, and etcetera. Laravel can simply be viewed as a PHP flavor of Ruby on Rails. With that being said, before diving into the code it is important to understand some conventions that Laravel use. Ultimately, by abiding by certain conventions it should take a lot less time to understand how the code is structured.

### CS CONNECT
An internal social networking website developed by and for Colorado School of Mines computer science students. This project is actively in development and it is to be deployed in Spring of 2014. It is centered around Thomas Brown's thesis.




To setup:

### To clone the repository into Toilers.
``

### Give the server write access to app/storage

