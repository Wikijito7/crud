# Crud
Just a simple crud. It's responsive!

## Main language
 * PHP

## Required to work
 * _PHP_ 7.0 or higher.
 * _MySQL_ or MariaBD
 * _PHP-MySQL_
 
## How it works

 First of all you have to log in (it checks 'username' table). After that, you can create a new entry clicking _Nuevo dato_. 
 Every entry has a _modify_ and _remove_ icon.
 
 If you click the modify icon, it will popup a modal form with everything you need to modify the entry.
 By clicking the remove icon, it will popup another modal box to confirm that you want to delete it.
 
## Setting it up
  * Docker
    * All needed files for Docker are within the repository. You download everything, _cd_ to the project and run `docker-compose up`. It will do the rest.
  
  * Manual
    * First of all, make sure that you have installed MySQL/MariaDB server, PHP and PHP-Mysql. Also, you need a web server like _Apache_ or _Nginx_
  
    * After that, drop everything that is on _codigo-php_ folder in _/var/www/html_.
  
    * Create every table needed using your favorite way to interact with MySQL. You can get the minimum code needed to make this CRUD work on _db-init_ folder.
    
    * Aaand it's done! Now you can use this CRUD however you like.

## Sneak pick
- Log in
`Username: usuario
password: usuario`
![Imagen del login de la aplicación](/images/login.png)
- Main. Where everything happens!
![Imagen de la pantalla principal](/images/main.png)
- Modal form when you are going to add a new book.
![Imagen del modal añadir datos](/images/add.png)
- Modal box when you try to remove a book.
![Imagen del modal borrar datos](/images/remove.png)

## License
This project is free to use! It isn't necesary to mencion me, but it would be nice.
