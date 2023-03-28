<?php
    if(isset($_GET['textne'])){
        $ngalan = $_GET['kapa'];
        //echo $ngalan;
    }else{
        echo 'type';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="get">
        name:
        <input type="password" name="kapa" id="lol">
        <input type="submit" name="textne" >
    </form>
</body>
</html>