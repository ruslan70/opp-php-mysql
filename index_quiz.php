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
            echo "Work with Databases and PHP PDO / <h3>My Quiz</h3>"; 

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


        $query = $dbConnection->query("SELECT * FROM  QuizQuestions");
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);

        // lopp through all the elments in the array $questions and use
        // each element of the array inside the loop as the new variable $question.
        // foreach ($questions as $question)  { replace with this:
        foreach ($questions as $key => $question)  {
            // prepare an SQL statement with a placeholder ? the help of the db connection $dbConnection.
            $subQuery = $dbConnection->prepare("SELECT * From QuizAnswers where QuizAnswers.QuestionId = ?");
            // put the value of $question['ID'] to the place of the  first question mark ? in the sql statement above.
            $subQuery->bindValue(1, $question['ID']);
            // excute the query.
            $subQuery->execute();
            // get all the rows received by the query and put them  into the new variable $answers.
            $answers = $subQuery->fetchALL(PDO::FETCH_ASSOC);
            // create a new element 'answers' in the $question-element and store the new array $answers in this element.
            $questions[$key]['answers'] = $answers;
            
            // DEVONLY: Debug output to see what is inside the array $question.
            print "<pre>";
            print_r($question);
            print "</pre>";
        
        }

      






        exit();

        // create  the SELECT query and fetch all table rows as associative array.
        // Bsp.: SELECT * FROM :
         //$query = $dbConnection->query("SELECT * FROM  QuizQuestions"); // https://www.php.net/manual/de/pdo.query.php
        // $query = $dbConnection->query("SELECT ID, Text FROM  QuizQuestions");
        // $query = $dbConnection->query("SELECT * FROM  QuizQuestions WHERE Text LIKE '%schweiz%' ");
        // $query = $dbConnection->query("SELECT * FROM QuizQuestions LEFT JOIN QuizAnswers ON QuizAnswers.QuestionId=QuizQuestions.ID");
        // $query = $dbConnection->query("SELECT Text, IsCorrectAnswer FROM QuizAnswers WHERE QuestionId=1");
         //$query = $dbConnection->query("SELECT QuizQuestions.Text, QuizAnswers.Text FROM QuizAnswers LEFT JOIN QuizQuestions ON QuizQuestions.ID=QuizAnswers.QuestionId WHERE QuestionId=1");
         
           $query = $dbConnection->query("SELECT QuizQuestions.Text, QuizAnswers.Text 
           FROM QuizAnswers 
           LEFT JOIN QuizQuestions ON QuizQuestions.ID=QuizAnswers.QuestionId");
        // $query = $dbConnection->query("SELECT QuizQuestions.ID=1, QuizAnswers.Text FROM QuizQuestions LEFT JOIN QuizAnswers ON QuizQuestions.ID=QuizAnswers.QuestionId WHERE QuestionId=1");
        /*$query = $dbConnection->query("SELECT QuizQuestions.Text, QuizAnswers.Text FROM QuizQuestions
         LEFT JOIN QuizAnswers ON QuizQuestions.ID=QuizAnswers.QuestionId
          WHERE QuizAnswers.IsCorrectAnswer=1 AND QuestionId=1"); */
        

        // um header herauszuholen, aber nach < while ($row = $query->fetch(PDO::FETCH_ASSOC)) > braucht dies nicht mehr
        // $query->fetch(PDO::FETCH_ASSOC);  //https://www.php.net/manual/de/pdostatement.fetch.php

        //DEVONLY
       /* echo '<pre>';
        print_r($query);
        echo '<pre>'; */

        echo '<div class="container-fluid p-5">';
        echo '<div class="h3">My Quiz</div>';
        echo '<table class="table table-striped">';

         // Print table header.
        echo '<thead>';
        echo '<tr>';

        // Get column metadata and the name ot the column.
        $columnCount = $query->columnCount();
        //echo "num cols: $columnCount";

        for ($i = 0; $i < $columnCount; $i++) {
            $columnInfo = $query->getColumnMeta($i);
            $columnName = $columnInfo['name'];
            echo "<td>$columnName</td>";
            
        }

       
        echo '</tr>';
        echo '</thead>';

        foreach($query as $row) {
            echo "<tr>";
            for ($i = 0; $i < $columnCount; $i++) {
                echo "<td>$row[$i]</td>";
            }
            echo "</tr>";
            //print_r("$row[0] $row[1]");
            //echo '<tr><td>';
            //echo "$row[0]";
            //echo "</td><td>";
            //echo "$row[1]</td></tr>";
        }

      //  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //print_r($row);
                // Print table rows (for each book one row).
            

            // For each column (<td>) one value.
           // foreach ($row as $columnName => $value){
            //    echo "<td>$value</td>";
           // }
           // echo '</tr>';
            // End of table rows.

      //  }

        

        

        
        echo '</table>';
        echo '</div>';
        echo '</div>';

        

        
        

        
        ?>

    
  
</body>
</html>