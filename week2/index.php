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

/* Landing page */
if (new_route('/DDWT18/week2/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week2/overview/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table(get_series($db));

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week2/serie/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week2/add/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week2/add/';

    /* Choose Template */
    include use_template('new');
}

/* Add serie POST */
elseif (new_route('/DDWT18/week2/add/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
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
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Edit %s", $serie_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week2/edit/';

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week2/edit/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];

    /* Choose Template */
    include use_template('serie');
}

/* Remove serie */
elseif (new_route('/DDWT18/week2/remove/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

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
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table($db, get_series($db));

    /* Choose Template */
    include use_template('main');
}

else {
    http_response_code(404);
}