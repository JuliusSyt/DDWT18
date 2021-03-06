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
        echo (get_series($db));
    });


    $router->get('/series', function() use ($db) {
        echo (count_series($db));
    });

    /* GET for reading individual series */
    $router->get('/series/(\d+)', function($id) use($db) {
        // Retrieve and output information
        $serie_info = get_serieinfo($db, $id);
        echo ($serie_info);
    });

    /* DELETE for individual serie */
    $router->delete('/series/(\d+)', function($id) use($db) {
        // Retrieve and output information
        remove_serie($db, $id);
    });

    /* Post for individual serie */
    $router->post('/series', function($_POST) use($db) {
        // Retrieve and output information
        add_serie($db, $_POST);
    });

});

$router->set404(function() {
     header('HTTP/1.1 404 Not Found');{
         echo'Your requested page was not found';
    }
});

/* Run the router */
$router->run();
