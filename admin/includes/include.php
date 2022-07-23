<?php 

    session_start();

    include_once 'handler.php';

    include 'dbc.php';
    include 'categories.php';
    include 'blogs.php';
    include 'tags.php';
    include 'contacts.php';
    include 'subscribers.php';
    include 'users.php';
    include 'comments.php';

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