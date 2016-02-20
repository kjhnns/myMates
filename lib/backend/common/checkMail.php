<?php
/*
 * Created on 07.10.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

function checkMail($email)
{
    if (eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email)) {
        return true;
    } else {
        return false;
    }
}

?>
