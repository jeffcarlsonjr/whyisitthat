<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        function insertUser()
{
    if(isset($_POST['add']))
    {
    define("MAX_LENGTH", 8);
    
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    $intermediateSalt = md5(uniqid(rand(), TRUE));
    $salt = substr($intermediateSalt, 0, MAX_LENGTH);
    $hash = hash('sha256', $password . $salt);
    
    $query = "INSERT INTO user (username,password,email,salt,lastLogin) VALUES ('".$username."','".$hash."','".$email."','".$salt."',NOW() )";
    
    mysql_query($query) or die(mysql_error());
    
    }
}

function login()
{
    if(isset($_POST['login'])){
        echo mysql_error();
       $username = mysql_real_escape_string($_POST['username']);
       $password = mysql_real_escape_string($_POST['password']);
       
       $query = mysql_query("select * from user where  username = '$username' and password = '".  hashPassword($username,$password)."' ");

       $num = mysql_num_rows($query);
       if($num > 0){
           $row1 = mysql_fetch_assoc($query);
           
           mysql_query('update user set lastLogin = NOW() where id = "'.$row1['id'].'"');
           $_SESSION['id'] = $row1['id'];
           echo $_SESSION['id'];
       }
       else{
           echo "<span style='color:red'>WRONG PASSWORD OR USERNAME</span>";
       }
        
    }
}
function hashPassword($username, $password)
{
    $saltQuery = "select salt from user where username = '$username'; ";
    
    $result = mysql_query($saltQuery);
       
       $row = mysql_fetch_assoc($result);
       $salt = $row['salt'];
       
       $saltedPW = $password . $salt;
       
       $hashedPW = hash('sha256', $saltedPW);
       
       return $hashedPW;
}

connect();
insertUser();
login();

//$pass = 'MySecretPassword';
//
//$intermediateSalt = md5(uniqid(rand(), TRUE));
//$salt = substr($intermediateSalt, 0, MAX_LENGTH);
//echo $salt."<br>";
//$hash = hash('sha256', $pass . $salt);



?>


<form method="post">
    <lable>
        Username:
    </lable>
    <input name="username" type="text"/><br>
    <lable>
        Email:
    </lable>
    <input name="email" type="text"/><br>
    <lable>
        Password:
    </lable>
    <input name="password" type="password"/><br>
    <input type="submit" name="add" value="Submit"/>
    
    
</form>


<br>

<br>


<form method="post">
    <lable>
        Username:
    </lable>
    <input name="username" type="text"/><br>
    
    <lable>
        Password:
    </lable>
    <input name="password" type="password"/><br>
    <input type="submit" name="login" value="Submit"/>
    
</form>
    </body>
</html>
