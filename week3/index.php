<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week3', 'ddwt18', 'ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

// Add routes here
$router->mount('/api', function() use($router, $db){
    http_content_type('application/json');

    $router->get('/series', function() use ($db) {
        echo get_series($db);
    });

});

$router->set404(function() {
     header('HTTP/1.1 404 Not Found');{
         echo'Your requested page was not found';
    }
});


/* Run the router */
$router->run();
