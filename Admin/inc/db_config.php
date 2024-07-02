<?php

$hname = 'localhost';
$uname = 'root';
$pass ='';
$db = 'kaluwara_db';

$con = mysqli_connect($hname,$uname,$pass,$db);

if(!$con){
    die("Database Not Connected".mysqli_connect_error());
}

function filtration ($data){

    foreach($data as $key => $value){
        $value = trim($value);
        $value = stripcslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $data[$key] = $value;
    }
    return $data;
}

function selectAll($table){
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
}

function select($sql , $values , $datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql))
    {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed ");
        }
    }else{
        die("Query preparation failed ");
    }
}

function update($sql , $values , $datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql))
    {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Updated ");
        }
    }else{
        die("Query preparation Updated failed ");
    }
}


function insert($sql , $values , $datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql))
    {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Insert Updated Successfully ");
        }
    }else{
        die("Failed To Insert Check Again ");
    }
}

function delete($sql , $values , $datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql))
    {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Deleted Successfully");
        }
    }else{
        die("Something Wentwrong");
    }
}

?>