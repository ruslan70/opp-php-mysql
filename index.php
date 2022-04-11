b5-tem
<!doctype html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<boby>
    <?php
            echo "Hello, we are starting to work with Databases and PHP PDO!"; 

            // Prepare connection parameters.
            // getenv(string $varname, bool $local_only = false): string|false .
            $dbHost = getenv('DB_HOST');
            $dbName = getenv('DB_NAME');
            $dbUser = getenv('DB_USER');
            $dbPasswort = getenv('DB_PASSWORD');


        // ich möchte als resultat eine Datenbankverbindung haben: $dbConnection = 
        // dazu muss ich aurufen : new PDO(); . Dieser Auruf liefert mir die Verbindung zur DB.
        // new PDO() benötigt folgende Argumente: "mysql:host=$dbHost;dbname=$dbName;charset=utf8"
        $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPasswort);

        // Tell PDO to throw Exceptions for every error.
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // create  the SELECT query and fetch all table rows as associative array.
        // Bsp.: SELECT * FROM :
        // $query = $dbConnection->query("SELECT * FROM  Books"); // https://www.php.net/manual/de/pdo.query.php
        // $query = $dbConnection->query("SELECT Author, Title FROM  Books");
        // $query = $dbConnection->query("SELECT * FROM `Books` WHERE ID=10");
        // $query = $dbConnection->query("SELECT * FROM Books WHERE Title='Space'");
        // $query = $dbConnection->query("SELECT * FROM `Books` WHERE Category='HTML'");
        // $query = $dbConnection->query("SELECT * FROM `Books` WHERE Year>2020");
        // $query = $dbConnection->query("SELECT `Title`, `Author` FROM `Books` WHERE 1");
        // $query = $dbConnection->query("SELECT * FROM Books ORDER BY Year");
        // $query = $dbConnection->query("SELECT * FROM Books WHERE Title LIKE '%book%'");
        $query = $dbConnection->query("SELECT * FROM `Books` WHERE Year>2019 ORDER BY Year LIMIT 4");

        // um header herauszuholen, aber nach < while ($row = $query->fetch(PDO::FETCH_ASSOC)) > braucht dies nicht mehr
        // $query->fetch(PDO::FETCH_ASSOC);  //https://www.php.net/manual/de/pdostatement.fetch.php

        //DEVONLY
       /* echo '<pre>';
        print_r($query);
        echo '<pre>'; */

        echo '<div class="container-fluid p-5">';
        echo '<div class="h3">My favorite Books</div>';
        echo '<table class="table table-striped">';

         // Print table header.
        echo '<thead>';
        echo '<tr>';

        // Get column metadata and the name ot the column.
        $columnCount = $query->columnCount();

        for ($i = 0; $i < $columnCount; $i++) {
            $columnInfo = $query->getColumnMeta($i);
            $columnName = $columnInfo['name'];
            echo "<td>$columnName</td>";
            
        }

       
        echo '</tr>';
        echo '</thead>';

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                // Print table rows (for each book one row).
            echo '<tr>';

            // For each column (<td>) one value.
            foreach ($row as $columnName => $value){
                echo "<td>$value</td>";
            }
            echo '</tr>';
            // End of table rows.

        }

        

        

        
        echo '</table>';
        echo '</div>';
        echo '</div>';

        

        
        

        
        ?>

    
  
</body>
</html>