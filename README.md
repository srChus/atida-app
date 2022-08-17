"# atida-app" 

The application has been developed using the CakePHP 4 framework.
To execute the code it is necessary to use a web server type WAMP

It is necessary to create a Mysql database and define its credentials in the file \config\app_local.php

Default values in the code:
'host' => 'localhost',
'port' => 3306,
'username' => 'root',
'password' => '',
'database' => 'atida',


4 API calls have been created to list products, create new ones, edit and increase stock.

GET http://localhost/atida/api/list-products.json
POST http://localhost/atida/api/add-product.json  -> {name, stock, code}
POST http://localhost/atida/api/update-product/3.json  -> {name, stock, code}
POST http://localhost/atida/api/delete-product/3.json
POST http://localhost/atida/api/stock-update-product/3.json -> {stock}

An import file for POSTMAN with an example of each call has been included in the project.
Atida.postman_collection.json