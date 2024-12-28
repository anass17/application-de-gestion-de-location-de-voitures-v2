<?php
    session_start();
    if (isset($_SESSION['id'])) {

        session_write_close();

        session_set_cookie_params(
            60 * 30,        //  30 min
            "/",
            "localhost",
            true,
            true
        );

        session_start();

    }
?>