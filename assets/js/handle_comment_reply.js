var blog_comment_id;

function reply_comment(comment_id) {
    blog_comment_id = comment_id;
    document.getElementById("respond").style.display = "none";
    document.getElementById("reply").style.display = "block";
}

function hide_form_reply() {
    document.getElementById("reply").style.display = "none";
}

function check_respond() {
    if (document.c_form.c_name.value == "") {
        alert("Author name is not empty!");
        document.c_form.c_name.focus();
        return false;
    }
    if (document.c_form.c_email.value == "") {
        alert("Author email is not empty!");
        document.c_form.c_email.focus();
        return false;
    }
    if (document.c_form.c_message.value == "") {
        alert("Author message is not empty!");
        document.c_form.c_message.focus();
        return false;
    }
    return true;
}

function check_reply() {
    if (document.c_form_reply.c_name_reply.value == "") {
        alert("Author name is not empty!");
        document.c_form_reply.c_name_reply.focus();
        return false;
    }
    if (document.c_form_reply.c_email_reply.value == "") {
        alert("Author email is not empty!");
        document.c_form_reply.c_email_reply.focus();
        return false;
    }
    if (document.c_form_reply.c_message_reply.value == "") {
        alert("Author message is not empty!");
        document.c_form_reply.c_message_reply.focus();
        return false;
    }
    document.c_form_reply.blog_comment_id.value = blog_comment_id;
    return true;
}