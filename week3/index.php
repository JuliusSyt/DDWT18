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

echo json_encode("hello world");

// Add routes here
$router->mount('/api', function() use($router, $db){
    http_content_type('application/json');

    $router->get('/series', function() use ($db) {
        echo json_encode(get_series($db));
    });

    $router->get('/series', function() use ($db) {
        echo json_encode(count_series($db));
    });

    /* GET for reading individual series */
    $router->get('/series/(\d+)', function($id) use($db) {
        // Retrieve and output information
        $serie_info = get_serieinfo($db, $id);
        return json_encode($serie_info);

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

    /* Update for inidividual serie */
    $router->put('/series/(\d+)', function($id) use($db) {
        // Fake $_PUT
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);

    });
});

$router->set404(function() {
     header('HTTP/1.1 404 Not Found');{
         echo'Your requested page was not found';
    }
});


/* Run the router */
$router->run();
