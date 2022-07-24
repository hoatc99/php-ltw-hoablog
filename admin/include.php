<?php 

    session_start();

    include_once 'includes/dbc.php';
    include_once 'includes/categories.php';
    include_once 'includes/blogs.php';
    include_once 'includes/tags.php';
    include_once 'includes/contacts.php';
    include_once 'includes/subscribers.php';
    include_once 'includes/users.php';
    include_once 'includes/comments.php';

    include_once 'includes/handler.php';

    $admin_id = 1;

    $database = new Database();
    $db = $database->connect();
    $category = new Category($db);
    $blog = new Blog($db);
    $contact = new Contact($db);
    $subscriber = new Subscriber($db);
    $comment = new Comment($db);
    $tag = new Tag($db);
    $user = new User($db);

?>