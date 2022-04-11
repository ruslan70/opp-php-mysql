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

        // $query = $dbConnection->query("SELECT * FROM  Questions");
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);

        // lopp through all the elements in the array $questions and use
        // each element of the array inside the loop as the new variable $question. (Durchlaufen Sie alle Elemente im Array 
        // $questions und verwenden Sie jedes Element des Arrays innerhalb der Schleife als neue Variable $question).

        foreach ($questions as $question)  {
            // prepare an SQL statement with a placeholder ? the help of the db connection $dbConnection 
            // (Bereiten Sie eine SQL-Anweisung mit einem Platzhalter ? vor die Hilfe der db-Verbindung $dbConnection).
            $subQuery = $dbConnection->prepare("SELECT * From Answers where Answers.QuestionId = ?");
            // put the value of $question['ID'] to the place of the  first question mark ? in the sql statement above
            //(setze den Wert von $question['ID'] an die Stelle des ersten Fragezeichens ? in der sql-Anweisung oben.).
            $subQuery->bindValue(1, $question['ID']);
            // execute the query (die Abfrage ausführen).
            $subQuery->execute();
            // get all the rows received by the query and put them  into the new variable $answers
            // (Holen Sie sich alle Zeilen, die von der Abfrage empfangen wurden, und fügen Sie sie in die neue Variable $answers ein).
            $answers = $subQuery->fetchALL(PDO::FETCH_ASSOC);
            // create a new element 'answers' in the $question-element and store the new array $answers in this element
            // (Erstellen Sie ein neues Element „answers“ im $question-Element und speichern Sie das neue Array $answers in diesem Element).
            $question['answers'] = $answers;
            
            // DEVONLY: Debug output to see what is inside the array $question.
            print "<pre>";
            print_r($question);
            print "</pre>";
        
        
        }






        exit();


        // create  the SLECT query and fetch all table rows as associative array.
        // Bsp.: SELECT * FROM Customers;
        $query = $dbConnection->query("SELECT * FROM  Books"); // https://www.php.net/manual/de/pdo.query.php

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