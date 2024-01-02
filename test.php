<?php
include("database.php");
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFS</title>
    <link rel="icon" type="image/png" href="images/icon.png">
    
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>"method="post">
    <header>
        <h1 >Time&Fuel <br> Saver</h1>
    </header>
    
    <div class="form-group">
    
        <label for="username">Username:</label>
        <input type="text"id="username"name="username"minlength="5" maxlength="20" required>
    </div>
        <div class="form-group">
        <label for="password">Password:</label>
        <input type="password"id="password"name="password" minlength="5" maxlength="25" required>
    </div>
    <div class="form-group">       
            <button style="font-size: 15px; background-color: Indigo; color: white;">Register</button>
        </div>
        <div class="form-group">
            <input type="reset">
        </div>
        <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/background.png');
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }
        form {
            background-color: maroon;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 320px;
            color: white;
        }
        header {
            background-color: SeaShell;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 30px;
            text-align: center;
        }
        h1 {
            color: black;
            margin: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type=text],
        input[type=password] {
            width: calc(100% - 22px);
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 16px;
            background-color: Indigo;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: DarkSlateBlue;
        }
        input[type=reset] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f2f2f2;
            cursor: pointer;
        }
    </style>
    </form>
</body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $password=filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

    $hash=password_hash($password,PASSWORD_DEFAULT);
    $sql="INSERT INTO user(Username,Password) VALUES ('$username','$hash')";
    
    try{
    $result=mysqli_query($conn,$sql);

    if($result){
        header("Location:signup.php?username=".urlencode($username));
        exit();
    }

    else{
         echo"Could not register User";
     }
    }catch(mysqli_sql_exception $e){
        echo"An problem occured ".$e->getMessage();
    }
     mysqli_close($conn);
    }
?>
    

   
