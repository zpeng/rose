<?php

function getConnection(){
    $link = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD );
    if ( ! $link ) {
        die( "Couldn't connect to MySQL: ".mysql_error()." <br/>".DB_USER."@".DB_HOST );
    }

    @mysql_select_db( DB_NAME,$link )
    or die ( "Couldn't open ".DB_NAME.": ".mysql_error());

    // to support non-western language
    mysql_query("SET NAMES 'utf8'");
    
    return $link;
}

function closeConnection($link){
    mysql_close($link );
}

function executeNonUpdateQuery($link , $query , $location =""){
    $result = mysql_query($query, $link)  or die ( "<p>Database Execption: ".mysql_error(). " <p>Query: ".$query."</p><p> At: ".$location );
    return $result;
}

function executeUpdateQuery($link , $query , $location =""){
    $result = mysql_query($query, $link)
    or die ( "<p>Database Execption: ".mysql_error(). " <p>Query: ".$query."</p><p> At: ".$location );
    return $result;
}
?>
