<?php
/*
 * Created on Aug 20, 2009
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */
function gID($int, $len=4) { $int = (int)$int; for($i = strlen($int); $i < $len; $i++) { $int = "0".$int; } return $int; }
?>
