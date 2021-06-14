<?php
    session_start();
    global $link;

    //check whether the session variable SESS_MEMBER_ID is present or not
    if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '' )) {
?>
        <script>
            window.location = "./";
        </script>

<?php
    }else{
        $session_id = $_SESSION['user_id'];
    }
?>
