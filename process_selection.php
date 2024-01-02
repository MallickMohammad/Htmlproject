<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fuel Calculator</title>
    <style>
        html, body {
            height: 100%; 
            margin: 0;
            padding: 0;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            background-image: url('images/fuel.png');
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }
        .container {
            width: 100%;
            max-width: 600px; 
            background: #005093;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin: 20px;
        }
        h2 {
            color:wheat;
        }
        p {
            font-size: 1em;
            line-height: 1.6;
        }
        .result {
            background: #e8f4ff;
            padding: 10px;
            border-left: 4px solid #4a90e2;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="container">
    
    <?php
    include("database.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $car_id = filter_input(INPUT_POST, "Car_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $distance = filter_input(INPUT_POST, "distance", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sql = "SELECT mileage FROM owner WHERE Car_id = '$car_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mileage = $row["mileage"];
            $fuel_needed = calculateFuelNeeded($mileage, $distance);
    echo "<h2>Fuel Needed for " . number_format($distance, 1, '.', '') . " km:</h2>";
    echo "<div class='result'>";
    echo "<p>Car ID: $car_id</p>";
    echo "<p>Mileage: $mileage km/l</p>";
    echo "<p>Fuel Needed: $fuel_needed liters</p>";
    echo "</div>";
} else {
    echo "<div class='container'>";
    echo "<p>Selected car not found or no results.</p>";
    echo "</div>";
}
    }
    
    function calculateFuelNeeded($mileage, $distance) {
        if ($mileage <= 0) {
            return "Invalid mileage value";
        }
        $fuel_needed = $distance / $mileage;
    // Format the result to 1 decimal place
    return number_format($fuel_needed, 1, '.', '');
    
        
    }
    ?>
</div>


</body>
</html>













