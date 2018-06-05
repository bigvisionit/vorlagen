# Very Simple Mini MVC

This is a very small and simple MVC structure (for REST etc.).

### Version
1.0.0

### Structure


app

config  libraries   views

and

bootstrap.php: includes config/config.php, libraries, views, calls url function 


public

index.php

index.php: includes bootstrap.php and calls the functions


### Examples URL's

http://localhost/minimvc/ => calls /public/index.php index();

http://localhost/minimvc/test/1 => calls /public/index.php test($param);


### Example code with templates

view([ 'test' => $test ]); => calls the view template with one parameter $test

in app/views/test.php you can access the data with the $data array like this: $data['test'];