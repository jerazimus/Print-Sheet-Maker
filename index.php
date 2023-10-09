<?php

$path = '/var/config/printsheetmaker/config.php';

if (file_exists($path)) {
    require_once($path);

    // Check if the DB_HOST constant is defined
    if (defined('DB_HOST')) {
        $db_host = DB_HOST;
        // echo "DB_HOST is set: $db_host <br>";
        try {
            // Attempt to create a PDO instance and connect to the SQLite database
            $db = new PDO($db_host);
            // Set PDO to throw exceptions on error
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // If successful, you can output a success message
            //echo "Connected to the SQLite database successfully.";
        } catch (PDOException $e) {
            // If an error occurs during connection, catch the exception and display an error message
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        echo "DB_HOST constant is not defined.";
    }
} else {
    echo "File does not exist at: $path";
}
?>

<?php

    // Fetch the card data for the popup
    $popupCardData = $db->query('SELECT id, card_name, card_text FROM cards WHERE id = 1')->fetch(PDO::FETCH_ASSOC);

    // Encode the card data as JSON
    $popupCardDataJSON = json_encode($popupCardData);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Sheet Maker</title>
    <link href="styles.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
</head>
<body>
<div class="sidebar no-print">
    <h4 "logo">Print Sheet Maker</h4>
    <p class="sub-title">Create custom playing cards. Easiest way for at home printing on US Letter paper.</p>
    <h5>Card List</h5>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Card Name</th>
            <th>Card Text</th>
        </tr>

        <?php
            $stmt = $db->query('SELECT id, card_name, card_text FROM cards');
            // Display records in a table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>{$row['id']}</td><td>{$row['card_name']}</td><td>{$row['card_text']}</td></tr>";
            }
        ?>
    </table>
   

</div>


<div class="grid-container">
    <?php for ($i = 0; $i < 9; $i++){ ?>
    <div class="card" onclick="togglePopup()">
        <div class="watermark"><p class="watermark-text">printsheetmaker.com</p></div>
    </div>
    <?php } ?>     
</div>



<div class="right-sidebar no-print">
    <div class="row horz-gap">
       <button class="button" id="print-button">🖨️ Print</button>
       <button class="button font-sm" id="print-button">💾 Print & Save</button>
    </div>
        <p>Print Sheet History</p>
        <ul>
            <li>Sun Oct 8 9:44 PM</li>
            <li>Sun Oct 8 10:00 PM</li>
            <li>Sun Oct 8 10:44 PM</li>
        </ul>
        <p>Load previous print sheets</p>
</div>

<div id="popup" class="popup">
  <div class="popup-content">
    
    <span class="close" onclick="togglePopup()">&times;</span>
    <div class="f-row">
        <img class="image-view" src="/public_assets/magic-card-1.jpg" alt="">
    </div>
  </div>
</div>




    <script>

        function togglePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
        }

        

        const print_button = document.getElementById('print-button');

        print_button.addEventListener('click', () => {
        window.print();
        });

    </script>
</body>
</html>
