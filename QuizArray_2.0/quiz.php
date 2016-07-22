<html>
    <head>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <link rel='stylesheet' type='text/css' href='Styles/quiz.css'>
        <script type="text/javascript" src="Scripts/Quiz.js"></script>
    </head>
    <body>
        <?php
        //Get the ID number argument from the URL ex: quiz.php?id=1
        $idNUM = $_GET['id'];

        //Store the credentials needed for accessing the database
        $serverName = 'localhost';
        $userName = 'root';
        $password = '';
        $dbname = 'quiz_db';

        //Make an object that can connect to the database
        $db_connection = new mysqli($serverName, $userName, $password, $dbname);
        if($db_connection->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        //A variable that stores my SQL query to keep things clean
        $sql = "SELECT * FROM quiz_data WHERE id = $idNUM";
        //Query the database for the question with the id $idNUM
        $result = $db_connection->query($sql);
        //Close the connection to the server
        $db_connection->close();

        //grab the $result key array and store it in $row
        $row = $result->fetch_assoc();
        //Start by placing the container for the survey and putting down its name
        echo "<div id='Survey-Container'>";
        echo "<center><div id='SurveyName'>" . $row['name'] . "</div></center>";

        $Questions = array(); //These are the questions without formatting
        $Answers = array();   //These are the answers with reduced formatting

        $Questions_POST = $row['questions']; //Grab the questions column of the selected ID
        $Answers_POST = $row['answers'];     //Grab the answers column of the selected ID

        $Qstart; //This var stores the starting index of a question
        $Qend;   //This var stores the ending index of a question

        for($i = 2;$i < strlen($Questions_POST);$i++) //Go through all questions
        {
            //Start of question
            if($Questions_POST[$i] == ">")
            {
                $Qstart = $i + 1;
            }
            //End of question
            if($Questions_POST[$i] == "<")
            {
                $Qend = $i;
                //Save the question that we just 'selected' as a $tempQuestion
                $tempQuestion = substr($Questions_POST, $Qstart, ($Qend - $Qstart));
                //Save that $tempQuestion  to our array.
                $Questions[] = $tempQuestion;
                //Reset the variables dictating the start and end of the question
                $Qstart = 0;
                $Qend = 0;
            }
            //Always end of question because end of string
            else if($i == strlen($Questions_POST) - 1)
            {
                //Same happeneds here as does in the else if above.
                $Qend = $i + 1;
                $tempQuestion = substr($Questions_POST, $Qstart, ($Qend - $Qstart));
                $Questions[] = $tempQuestion;
            }
        }

        $Astart; //Store the starting index of each answer
        $Aend;   //Store the ending index of each answer

        for($i = 1;$i < strlen($Answers_POST);$i++) //Go through all answers
        {
            //Start of answer
            if($Answers_POST[$i] == ">")
            {
                //Save this location minus one so the answer number is included
                $Astart = $i - 1;
            }
            //End of answer
            else if($Answers_POST[$i] == "<")
            {
                //Save that location as the end of the answer
                $Aend = $i;
                //Save the answer in a temp answer var
                $tempAnswer = substr($Answers_POST, $Astart, ($Aend - ($Astart)));
                //Add that answer to the answers array
                $Answers[] = $tempAnswer;
                //Reset the answer start and end numbers
                $Astart = 0;
                $Aend = 0;
            }
            //Always and of answer because end of string
            else if($i == strlen($Answers_POST) - 1)
            {
                //Add one so the end of the last answer is not cut off.
                $Aend = $i + 1;
                //Then save the answer into a temp var
                $tempAnswer = substr($Answers_POST, $Astart, ($Aend - ($Astart)));
                //Add that answer to the answers array
                $Answers[] = $tempAnswer;
            }
        }
        //Cycle through each question in the questions array
        for($i = 0;$i < count($Questions);$i++)
        {
            //Start by printing out the starting container of the question itself
            echo "<div class='Question-Container'>";
            echo "<div class='Question'>" . $Questions[$i] . "</div><br>";
            //Cycle through each answer in the answers array
            for($u = 0;$u < count($Answers);$u++)
            {
         //Check if the answer in the current index contains the question number
                if(strpos($Answers[$u], ((string)($i + 1) . ">")) !== false)
                {
                    //Save the question number that the answer belongs to
                    $AnswerNum = substr($Answers[$u], 0, 1);
                    //Save the question cleanly cut back into the array
                    //This will take away the question number and >
                    //from the answer
                    $Answers[$u] = substr($Answers[$u], 2, strlen($Answers[$u]) - 2);
                    //Print the whole answer out into its own div with
                    //a radio button
                    echo "<div class='AnswerDiv'><label><input class='Answer'"
                    ." type='radio' name='Answer". $AnswerNum ."'></input>"
                    . $Answers[$u] . "</label></div><br>";
                }
            }
            //Close the question with this end tag of the question-container div
            echo "</div>";
        }
        //Once all of the questions and answers are printed out,
        //we can print out the div containing the submit button
        echo "<center><div id='Submit-Button' type='submit'>"
        ."<img src='Images/Check_Mark.png' id='Check_Mark'>"
        ."Submit Survey <br>And See Results</img></div></center>";
        //Then close off the entire survey div with this end tag
        echo "</div>";
        ?>
    </body>
</html>
