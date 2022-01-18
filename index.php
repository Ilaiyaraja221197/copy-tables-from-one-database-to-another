<?php


$DB_SRC_NAME = "test1"; //source database name

$source = mysqli_connect("localhost", "root", "",$DB_SRC_NAME); //database connection with source database


$DB_DST_NAME = "test_omni_new"; //destination database name

$dst_db = mysqli_query($source,"CREATE DATABASE $DB_DST_NAME"); //creating a destination database

$tables = mysqli_query($source,"SHOW TABLES FROM $DB_SRC_NAME"); //show all tables in source database


while ($line = mysqli_fetch_row($tables)) {
    
    $tab = $line[0]; //table
    mysqli_query($source,"DROP TABLE IF EXISTS $DB_DST_NAME.$tab") or die('Couldn\'t drop table:'.mysqli_error($source)); // drops table if already exist in destination database
    mysqli_query($source,"CREATE TABLE $DB_DST_NAME.$tab LIKE $DB_SRC_NAME.$tab") or die(mysqli_error($source)) or die('Couldn\'t create table:'.mysqli_error($source)); // create table with its structure
    mysqli_query($source,"INSERT INTO $DB_DST_NAME.$tab SELECT * FROM $DB_SRC_NAME.$tab") or die('Couldn\'t insert data:'.mysqli_error($source));
    echo "Table: <b>" . $line[0] . " </b>Done<br>";
}
