<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week2', 'ddwt18','ddwt18');

/** get user id */
$user_id = get_user_id();

/** get_username */
$current_user_name = get_username($db, $user_id);

/* set right column to template cards */
$right_column = use_template('cards');

/* assign int to nbr_series */
$nbr_series = count_series($db);

/* assign int value to nbr_users */
$nbr_users = count_users($db);


/* Landing page */
if (new_route('/DDWT18/week2/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Home' => na('/DDWT18/week2/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', True),
        'Overview' => na('/DDWT18/week2/overview/', False),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week2/overview/', 'get')) {

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table(get_series($db));

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week2/serie/', 'get')) {

    /* Get series from db */
    $serie_id = $_GET['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = $serie_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview/', False),
        $serie_info['name'] => na('/DDWT18/week2/serie/?serie_id='.$serie_id, True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];
    $added_by = get_username($db, $user_id);

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week2/add/', 'get')) {

    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Add Series' => na('/DDWT18/week2/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', True),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week2/add/';

    /* Choose Template */
    include use_template('new');
}

/* Add serie POST */
elseif (new_route('/DDWT18/week2/add/', 'post')) {
    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Add Series' => na('/DDWT18/week2/add/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', True),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week2/add/';

    /* Add serie to database */
    $feedback = add_serie($db, $_POST);
    $error_msg = get_error($feedback);

    include use_template('new');
}

/* Edit serie GET */
elseif (new_route('/DDWT18/week2/edit/', 'get')) {
    /* Get Number of Series */


    /* Get serie info from db */
    $serie_id = $_GET['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        sprintf("Edit Series %s", $serie_info['name']) => na('/DDWT18/week2/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = sprintf("Edit %s", $serie_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week2/edit/';

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week2/edit/', 'post')) {


    /* Update serie in database */
    $feedback = update_serie($db, $_POST);
    $error_msg = get_error($feedback);

    /* Get serie info from db */
    $serie_id = $_POST['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = $serie_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview/', False),
        $serie_info['name'] => na('/DDWT18/week2/serie/?serie_id='.$serie_id, True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];

    /* Choose Template */
    include use_template('serie');
}

/* Remove serie */
elseif (new_route('/DDWT18/week2/remove/', 'post')) {


    /* Remove serie in database */
    $serie_id = $_POST['serie_id'];
    $feedback = remove_serie($db, $serie_id);
    $error_msg = get_error($feedback);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table($db, get_series($db));

    /* Choose Template */
    include use_template('main');
}

/* my account page */
elseif (new_route('/DDWT18/week2/myaccount/', 'get')) {

    /* Page info */
    $page_title = 'MyAccount';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/myaccount', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', True),
        'Registration' => na('/DDWT18/week2/register/', False)
    ]);

    /* Page content */
    $page_subtitle = 'Information of your account';
    $page_content = 'This page show you the content of your account.';

    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('account');
}

/* register page */
elseif (new_route('/DDWT18/week2/register/', 'get')) {

    /* Page info */
    $page_title = 'Register';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/register', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', False),
        'Add series' => na('/DDWT18/week2/add/', False),
        'My Account' => na('/DDWT18/week2/myaccount/', False),
        'Registration' => na('/DDWT18/week2/register/', True)
    ]);

    /* Page content */
    $page_subtitle = 'Register Page';
    $page_content = 'This page is used for user registration.';

    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('register');
}

/* Register POST */
elseif (new_route('/DDWT18/week2/register/', 'post')){
    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/week2/register/?error_msg=%s',
        json_encode($error_msg)));
}


/* Login GET */
elseif (new_route('/DDWT18/week2/login/', 'get')){
    /* Page info */
    $page_title = 'Login';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Login' => na('/DDWT18/week2/login/', True)
    ]);
    $navigation = get_navigation($navigation_tpl, 0);
    /* Page content */
    $page_subtitle = 'Use your username and password to login';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('login');
}

/* Login POST */
elseif (new_route('/DDWT18/week2/login/', 'post')){
    /* Login user */
    $feedback = login_user($db, $_POST);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/week2/login/?error_msg=%s',
        json_encode($feedback)));
}


else {
    http_response_code(404);
}