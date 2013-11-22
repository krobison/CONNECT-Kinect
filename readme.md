### CS CONNECT
An internal social networking website developed by and for Colorado School of Mines computer science students. This project is actively in development and it is to be deployed in Spring of 2014. It is centered around Thomas Brown's thesis.

### Technical Details
CS CONNECT currently uses a generic LAMP stack to operate, with MySQL as the database and PHP as the scripting language behind the scenes. The databases are located on CousinIT on the Mines campus so in order for this code to be operational the code must reside behind the campus firewall. Typically both production and  development environments are located on the Toiler's server so this should not be an issue.

The framework surrounding the code is Laravel: http://laravel.com.

Laravel is very similiar to Ruby on Rails in many aspects including object-relational mapping, MVC framework, RESTful actions, and etcetera. Laravel can simply be viewed as a PHP flavor of Ruby on Rails. With that being said, before diving into the code it is important to understand some conventions that Laravel use. Ultimately, by abiding by certain conventions it should much quicker and easier for new developers to get themselves acquainted with the system so they can be productive right away...that's what it's suppose to do.

### Setting Up Development Environment
To quickly get going on Toiler's, follow these instructions.

First log onto Toiler's through SSH then make sure you are in the /home/www/ directory.
```shell
# Clone the repository from GitHub through HTTPS.
git clone https://github.com/CONNECT-Mines/CS-CONNECT.git <csconnect-yourusernamehere>

# Give Laravel write access to the storage folder.
cd <csconnect-yourusernamehere>/app
chmod o+w -R storage
```
Once done, access at this link: http://toilers.mines.edu/csconnect-yourusernamehere/index.php

**NOTE:** Currently, pretty URLs are not functional so the `index.php` at the end of the link is required. This requires some work with Apache on Toiler's and once this is done this note will be removed.

### Code Structure & Development Cycle
Quick overview of important folders and files.

- app
  - *routes.php*
  - controllers
  - models
  - views
  - config
    - *database.php*
- assets

As noted, Laravel uses an MVC framework so place respective files in their folders. The assets directory is a centralized location where all CSS, images, and JavaScript files go and can be referenced using Laravel's HTML class.

The *routes.php* file will probably be open at all times during a development session. This is where URLs get mapped to controllers and actions. Think of *routes.php* as the roadmap to find which files you need to edit to get your work done.

Some quick links:
- Laravel documentation: http://laravel.com/docs
  - Database: Query Builder: http://laravel.com/docs/queries
  - Database: Eloquent ORM: http://laravel.com/docs/eloquent
- Laravel cheat sheet: http://cheats.jesse-obrien.ca
