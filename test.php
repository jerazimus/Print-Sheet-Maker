<!DOCTYPE html>
<html>
<head>
    <title>View Data</title>
</head>
<body>
    <h2>Existing Cards</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Card Name</th>
            <th>Card Text</th>
        </tr>

        <?php
        // Connect to SQLite database
       // $db = new PDO('sqlite:/var/db/printsheetmaker.db');

        try {
            // Attempt to create a PDO instance and connect to the SQLite database
            // $db_host = getenv('DB_HOST');
            //$db = new PDO("sqlite:$db_host");   
            $db = new PDO('sqlite:/var/db/printsheetmaker.db');
            
            // Set PDO to throw exceptions on error
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // If successful, you can output a success message
        echo "Connected to the SQLite database successfully.";
        } catch (PDOException $e) {
            // If an error occurs during connection, catch the exception and display an error message
            echo "Connection failed: " . $e->getMessage();
        }

        // Fetch all records from the database
        $stmt = $db->query('SELECT id, card_name, card_text FROM cards');

        // Display records in a table
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['id']}</td><td>{$row['card_name']}</td><td>{$row['card_text']}</td></tr>";
        }
        ?>
    </table>
</body>
</html>