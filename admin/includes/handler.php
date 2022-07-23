<?php

    function redirect($url = null) {
        if ($url == null) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
        }
        exit;
    }

    function flag_get($flag_name = 'flag') {
        if (isset($_SESSION[$flag_name]) && !empty($_SESSION[$flag_name])) {
            echo '<div class="m-t-20 sufee-alert alert with-close alert-';
            echo ($_SESSION['flag_status'] == 'success') ? 'success' : 'danger';
            echo ' alert-dismissible fade show">';
            if ($_SESSION['flag_status'] == 'success') { 
                echo '<span class="badge badge-pill badge-primary">Success!</span>';
            } else if ($_SESSION['flag_status'] == 'failed') {
                echo '<span class="badge badge-pill badge-danger">Failed!</span>';
            }
            echo $_SESSION[$flag_name];
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>';
            unset($_SESSION[$flag_name]);
            unset($_SESSION['flag_status']);
        }
    }

    function flag_set($flag_value, $flag_status = 'success', $flag_name = 'flag') {
        $_SESSION[$flag_name] = $flag_value;
        $_SESSION['flag_status'] = $flag_status;
    }

    function field_get($field_name) {
        if (isset($_SESSION[$field_name]) && !empty($_SESSION[$field_name])) {
            echo $_SESSION[$field_name];
            unset($_SESSION[$field_name]);
        }
    }

    function field_set($field_name, $field_value) {
        $_SESSION[$field_name] = $field_value;
    }

    function upload_image($img_field_name, $old_img_field_name = '', $target_dir = '../images/upload/') {
        if (!empty($_FILES[$img_field_name]['name'])) {
            $ext = strtolower(end(explode('.', $_FILES[$img_field_name]['name'])));
            $image_name = rand(10000, 990000) . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES[$img_field_name]['tmp_name'], $target_dir . $image_name);
            return $image_name;
        } elseif ($old_img_field_name != '') {
            return $_POST[$old_img_field_name];
        } else {
            return '';
        }
    }

?>