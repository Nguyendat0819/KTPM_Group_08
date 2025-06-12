<?php 
    $conn = mysqli_connect('localhost','root','','ktpm');
    if(!$conn){
        die("faied  error:".mysqli_connect_error());
    }
?>