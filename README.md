# BileMo
OpenClassrooms formation - Projet 7 : Expose an API REST

Code quality reviewed by Codacy :
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/878564f363bc49a29abb1d0b3ed7c1ff)](https://www.codacy.com/manual/ClementThuet/BileMo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ClementThuet/BileMo&amp;utm_campaign=Badge_Grade)

## Getting Started

### Requirements
To install the project you will need :
* An Apache server >=2.4
* PHP >= 7.1
* MySQL or another database of your choice<br> 

I recommend to use WampServer as I did.

### Installing
You can get the project by using git clone (If you don't know how to do it, more info here : <https://git-scm.com/book/it/v2/Git-Basics-Getting-a-Git-Repository>)
```
$ git clone https://github.com/ClementThuet/BileMo.git
```
Then you need to execute `composer install` into the project folder to install the dependencies.<br>
If you don't have composer you can get it here <https://getcomposer.org/doc/00-intro.md>

### Database configuration
Configure your database according to your personal configuration in .env. For me:

```
DATABASE_URL=mysql://root:@127.0.0.1:3306/BileMo
```
Then you can create the database with : php bin/console doctrine:database:create

You can now load fixtures to get nice products and users you can edit the way you like.
```
php bin/console doctrine:fixtures:load
```
More information on Symfony's documentation : <https://symfony.com/doc/current/doctrine.html>

That's all, you can now access to BileMo's API. Enjoy !


## Author
**Clément Thuet**
*  <https://www.linkedin.com/in/cl%C3%A9ment-thuet/>
*  <https://github.com/ClementThuet/>
