# RESTful Server
![Continuos Integration for RESTful project](https://travis-ci.org/daniel-aranda/RESTful.svg?branch=master)
[![Coverage Status](https://coveralls.io/repos/daniel-aranda/RESTful/badge.svg)](https://coveralls.io/r/daniel-aranda/RESTful)

## PHP standalone RESTful server.

This project is not intended to be another Laravel or Symfony, it is a standalone RESTful server with two major focus:
* **Easy to use**, just import it with Composer and mostly be ready to run the server.
* **Performance**, I use the server for two things:
  * **Quick proof of concepts**. The time that take you to setup this Framework should be less than a minute, for practical purposes investing 15 minutes or more in the setup of a Framework is just too much regarding Proof of concepts. 
  * **Big data**. This projects is open source, however in my professional side I work a lot with REST apis and big data over cloud systems and perform matters, and when I said matters I mean tiny details like this example:
    * Some of the popular Frameworks has a minimum response time of 150ms in average, as first hand that sounds quickly but the truth is that it could be faster
    * This Framework can reach speeds of 30ms because it focus on RESTful nothing else, every other additional is optional, in several cases you have a cached response and just want a super quick response.

###Requirements
* PHP 5.4 or greater
* PHP project with [Composer](https://getcomposer.org/doc/00-intro.md)

###Installation
```
composer require "danielaranda/restful=*"
composer update
```

###Create server endpoint.
* At your project root create a folder named public, which is assumed will be the folder that your web server will use as Document Root.
* Create the file public/api.php
```php
<?php
//TBD





