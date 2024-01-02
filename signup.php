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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f7f7f7;
            color: #333;
            background-image: url('images/secondpage.png');
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }
        h1 {
            color: #0275d8; 
            font-size: 24px;
        }
        h2 {
            color:#f7f7f7;
            font-size: 20px;
            margin-top: 50px;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #0275d8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s ease-in-out;
        }
        button:hover {
            background-color: #025aa5; 
        }
        .search_results {
            color:aqua;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .no-results{
            color: #f00;
            font-size: 16px;
            margin-top: 10px;
        }
           </style>
      </head>
    <body>
<?php
    if (isset($_GET["username"])) {
        $username = $_GET["username"];
        echo "<h1>Welcome $username to Time & Fuel Saver</h1>";
    } else {
        echo "<h1>FAILED</h1>";
    }
    ?>
    
    <h2>Search for Cars:</h2>
    <form method="post">
        <input type="text" name="car_model" placeholder="Enter keyword">
        <button type="submit">Search</button>
       
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Car_id = filter_input(INPUT_POST, "Car_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $car_model = filter_input(INPUT_POST, "car_model", FILTER_SANITIZE_SPECIAL_CHARS);
    $year_made = filter_input(INPUT_POST, "year_made", FILTER_SANITIZE_SPECIAL_CHARS);
    $mileage = filter_input(INPUT_POST, "mileage", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "SELECT * FROM owner WHERE Car_id LIKE'%$Car_id%'AND car_model LIKE '%$car_model%' AND year_made LIKE '%$year_made%' AND mileage LIKE '%$mileage%'";


    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if(mysqli_num_rows($result) > 0){
            echo"<div class='search_results'>";
            echo "<h2>Search Results:</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='car-result'>";
            echo "<h3>Car model:{$row["car_model"]}</h3>";
            echo "<p>Year Made:{$row["year_made"]}</p>";
            echo "<p>Mileage per Km:{$row["mileage"]}</p>";
            echo "<form method='post' action='map.php'>";
                    echo "<input type='hidden' name='Car_id' value='{$row["Car_id"]}'>";
                    echo "<button type='submit' name='select_car'>Select Car</button>";
                    echo "</form>";
        }
        echo "</div>";
    } else {
        echo "<div class='no-results'>No results found.Try a different name.</div>";
    }
}
}
?>
    