<?php 

    session_start();

    include_once 'handler.php';

    include_once 'dbc.php';
    include_once 'categories.php';
    include_once 'blogs.php';
    include_once 'tags.php';
    include_once 'contacts.php';
    include_once 'subscribers.php';
    include_once 'users.php';
    include_once 'comments.php';

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