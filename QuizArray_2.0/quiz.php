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

        //Save undefined arrays that will eventualy Store
        //All of the questions and answers to those questions
        $Questions = array(); //These are the questions without formatting
        $Answers = array();   //These are the answers with reduced formatting

        //These are the raw versions containing identifiers for each questions and answers
        //These contain identifiers for each question and answer
        //so they can be differenciated.
        $Questions_POST = $row['questions']; //Grab the questions column of the selected ID
        $Answers_POST = $row['answers'];     //Grab the answers column of the selected ID

        //Find all questions and add them to the array
        $Qstart; //This var stores the starting index of a question
        $Qend;   //This var stores the ending index of a question

        //Count up from two to the index of the last character of the array
        //We start at two because the first index (0) is a < symbol
        //And the second index (1) is the number 1 ALWAYS
        //It is important to understand that
        //questions are formatted like this in the Database:
  //<1>This is a question?<2>This is also a question??<3>This is not a question!
        for($i = 2;$i < strlen($Questions_POST);$i++)
        {
            //If the current character we are on is >,
            //which is the start of the current question
            //then we will save the Start Of the question as
            //that location plus one because
            //the index we are on is the character >
            if($Questions_POST[$i] == ">")
            {
                $Qstart = $i + 1;
            }
            //If the character is <, which is the start of the next question,
            //we will save that index without subtracting one to keep the
            //length correct later.
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
            //Check if we are at the end of the string so we can
            //call the end of the file the end of the final question
            else if($i == strlen($Questions_POST) - 1)
            {
                //Same happeneds here as does in the else if above.
                $Qend = $i + 1;
                $tempQuestion = substr($Questions_POST, $Qstart, ($Qend - $Qstart));
                $Questions[] = $tempQuestion;
            }
        }

        //Find all Answers and add them to the array
        $Astart; //Store the starting index of each answer
        $Aend;   //Store the ending index of each answer
        //Start from index 1 and go all the way up to the length of the answers
        //stored in the database
        //Answers are formated like this in the database:
        //<1>answer1<1>answer2<1>answer3<2>answer1<2>answer<2>answer3
        //every answer with <number> preceding it are used in the question
//number they corespond to EX: <1>answer1<1>answer2 are both used in <1>question
        for($i = 1;$i < strlen($Answers_POST);$i++)
        {
            //Check if the current character is >
            if($Answers_POST[$i] == ">")
            {
                //Save this location minus one so the answer number is included
                $Astart = $i - 1;
            }
            //Check if the current character is <
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
            //Check if we are at the end of the string and
            //call that the end of the answer
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
        //Cycle through each question int he questions array
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
