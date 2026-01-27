<?php 
        $db=new mysqli('localhost','root','','agriloop_db');
        mysqli_set_charset($db, "utf8");
        if ($db->connect_error){
            die("connection failed:".$db->connect_error);
        }
        else{
            // die ("connection success");
        }
       
    
    ?>