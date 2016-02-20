<?php
function http($row)
{
    if (substr($row, 0, 7) == "http://") {
        $http = $row;
        return $http;
    } else {
        $http = "http://" . $row;
        return $http;
    } 
} 

?>
