<?php

 $path = '/var/config/printsheetmaker/config.php';

 if (file_exists($path)) {
    require_once($path);

    $db_host = getenv('DB_HOST');
    echo "DB_HOST: $db_host <br>";
   
   try {
       // Attempt to create a PDO instance and connect to the SQLite database
       $db = new PDO("sqlite:$db_host");
   
       // Set PDO to throw exceptions on error
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
       // If successful, you can output a success message
       echo "Connected to the SQLite database successfully.";
   } catch (PDOException $e) {
       // If an error occurs during connection, catch the exception and display an error message
       echo "Connection failed: " . $e->getMessage();
   }


} else {
    echo "File does not exist at: $path";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Sheet Maker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
</head>
<body>
<div class="sidebar no-print">
    <h4 "logo">Print Sheet Maker</h4>
    <p class="sub-title">Create custom playing cards. Easiest way for at home printing on US Letter paper.</p>
    <h5>Card List</h5>
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
        <p>History</p>
    <p>Load previous print sheets</p>
</div>

<div id="popup" class="popup">
  <div class="popup-content">
    <span class="close" onclick="togglePopup()">&times;</span>
    <div class="f-row">
        <img class="image-view" src="/public_assets/magic-card-1.jpg" alt="">
        <div class="card-info">
            <input type="text">
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
  </div>
</div>



    <style>

        .font-sm{
            font-size: 14px !important;
        }

        .col {
            display: flex;
            flex-direction: column;
        }
        .row {
            display: flex;
            flex-direction: row;
        }
        
        .vert-gap {
            row-gap: 10px;
        }

        .horz-gap {
            column-gap: 10px;
        }


        @page {
            size: 8.5in 11in; /* Set page size to US Letter (8.5 x 11 inches) */
            margin: 0; /* Remove default margins */
        }
        .list-group{
            align-items: flex-start;
            display: flex;
            flex-direction: column;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
            max-height: 80vh;
            overflow-y: scroll;
            padding: 0px 32px 16px 0px;
            position: sticky;
            scrollbar-color: rgb(138, 150, 181) transparent;
            top: 10;
            z-index: 1;
            background-color: gainsboro;
        }
        .list-group li {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tray{
            position: fixed;
            width: 100%;
            background-color: #f3f4f6;
            bottom: 0;
            left:0;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            column-gap: 10px;
            height: 75px;
        }

        .sidebar{
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px; /* Adjust the width as needed */
            padding: 20px;
            /* background-color: #dde1e7; Adjust the background color as needed */
            
            background: #fff;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        .right-sidebar{
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 200px; /* Adjust the width as needed */
            padding: 20px;
            /* background-color: #f0f0f0; Adjust the background color as needed */
            background: #fff;
            /* box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); */
            border-left: 1px solid #d4d4d4;
        }

        .button{
            /* background: linear-gradient(60deg,#f79533,#f37055,#ef4e7b,#a166ab,#5073b8,#1098ad,#07b39b,#6fba82); */
            background: linear-gradient(90deg, hsla(211, 96%, 62%, 1) 0%, hsla(295, 94%, 76%, 1) 100%);
            animation: animatedgradient 6s ease infinite alternate;
            background-size: 300% 300%;
            border: 1px solid rgba(0,0,0,0);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            min-height: 40px;
            width: 100%;
            border-radius: 10px;

        }

        .sub-title {
            font-size: 14px;
            color: #404040;
            line-height: 1.4;
        }

        .logo {
            font-weight: 500;
        }
        
      body {
            font-family: 'Rubik', sans-serif;
            background-color: white; /* Optional: Add a white background to the page */
            padding: 10px; /* Optional: Add padding to the page */
            display: flex;
            justify-content: center;
            align-items: center;
            page-break-after: always; 
        }

        .card {
            background-image: url(/public_assets/magic-card-1.jpg);
            background-size: cover; /* This makes the image cover the entire div */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            width: 63.5mm; /* Adjust card width */
            max-height: 88.9mm; /* Adjust card height */
            object-fit: cover; /* Maintain aspect ratio and cover entire cell */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor:zoom-in;
        }
        .grid-container{
            display: grid;
            grid-template-columns: repeat(3, 63.5mm);
            grid-template-rows: repeat(3, 88.9mm);
        }
        /* Style for the red lines */
        .grid-container > div {
            border: 1px dashed red;
        }

        .image-view{
            background-size: cover; /* This makes the image cover the entire div */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            width: 63.5mm; /* Adjust card width */
            max-height: 88.9mm; /* Adjust card height */
            object-fit: cover; /* Maintain aspect ratio and cover entire cell */
        }

        .card-info {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .f-row{
            display: flex;
            flex-direction: row;
            column-gap: 20px;
        }

        /* Style for the watermark */
        .watermark-text{
            display: none;
        }

        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }

            .watermark {
                display: block;
                background-color: black;
                padding: 10px;
                border-radius: 6px;
                color: white; /* Red with 50% opacity */
                font-size: 14px; /* Adjust the font size */
                font-weight: bold;
                width: fit-content;
                user-select: none;
            }
            .watermark-text{
                display: block;
            }
        }
        @media (max-width: 767px) {
            .sidebar,
            .right-sidebar {
                display: none;
            }
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 75%;
            height: 75%;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 16px;
        }

    </style>
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
