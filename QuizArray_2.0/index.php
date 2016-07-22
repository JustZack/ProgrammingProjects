<html>
    <head>
        <title>Quiz</title>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <link rel='stylesheet' type='text/css' href='Styles/main.css'>
        <script type="text/javascript" src="Scripts/IndexScript.js"></script>
    </head>
    <body>
        <!-- Create a NEW quiz program, because it wasnt that tough last time right? -->
        <div id="Admin"><div id="Admin_text"><center>Admin Stuff</center></div><div id="Remove_ID"><input id="ID_num"></input><br><center id="Remove_Button">Remove ID</center></div></div>
        <div class="Make_Quiz center">
            <center>
                <div class="picture"><img src='Images/Plus_Button.png' id='Plus_Button'></div>
                <div id="MakeQuiz_title">Make a new survey</div>
            </center>
        </div>
        <div class="Quizes_Container center">
            <div id='Quiz_title'>Select from existing surveys below</div>

            <?php
            //GOAL: Get all current availible quizes and put them in their own divs

            //Store the credentials for the database.
            //OK to be in the raw PHP because this is not going to be posted anywhere
            //And will not contain sensitive information
            $serverName = 'localhost';
            $userName = 'root';
            $password = '';
            $dbname = 'quiz_db';

            //Create an object which can interact with the databse
            //Then ensure that the connection was made without error.
            $db_connection = new mysqli($serverName, $userName, $password, $dbname);
            if($db_connection->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            //These three lines re-order all entries in the database to
            //Make sure no ID's are skipped.
            $db_connection->query("ALTER TABLE `quiz_data` DROP `id`;");
            $db_connection->query("ALTER TABLE `quiz_data` AUTO_INCREMENT=1;");
            $db_connection->query(""
            ."ALTER TABLE `quiz_data` ADD `id` INT UNSIGNED NOT NULL"
            ." AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);");
            //^^^This line is messy because it was too long be be seen on the picture.

            //This block actualy queries the data we are looking for
            //In the database.
            $sql = "SELECT * FROM `quiz_data`";
            $result = $db_connection->query($sql);
            //Close the connection to the databse because we no longer need to be connected to it.
            $db_connection->close();

            //Variable to keep track of how many questions there are In each survey.
            $NumOfQuestions = 0;
            //Check to make sure there are any surveys in the database.
            if($result->num_rows == 0)
            {
                //This block of code in the if statment simple lets the end user know
                //That there were no surveys found in the database.
                echo "<div class='Quiz_Block'>";
                echo "<div id='question_name'>No surveys found :(</div>";
                echo "</div>";
            }
            //Otherwise start counting the questions
            else
            {
                //Cycle through each entry in the database
                while($row = $result->fetch_assoc())
                {
                    //Get the entire row Called Questions from our
                    //selected location of the database table
                    $Questions = $row['questions'];
                    //Check for a question up to 25 times(because 25 seemed high enough)
                    for($i = 1;$i < 25;$i++)
                    {
                        //Store a variable that has the position of the current
                        //Question Number.
                        //The brackets signify the start of a question in my databse
                        $QLoc = strpos($Questions, "<" . (string)$i . ">");
                        //If Qloc is greater than -1 then it found a question
                        if($QLoc > -1)
                        {
                            //Increment the running total of number of questions we have
                            $NumOfQuestions++;
                        }
                        //Otherwise we break out of the forloop
                        //because we found all of the questions
                        else
                        {
                            break;
                        }
                    }
                    //This is the format for the Quiz_Blocks as I call them.
                    //They create their own divs for everything
                    //They contain:
                    //the name of the quiz, the number of questions, the ID in the database
                    //(mostly for me), and the date of submission
                    echo "<div class='Quiz_Block'>";
                    echo "<div id='question_name'>Name: ". $row['name'] . "</div>";
                    echo "<div id='question_Qnum'>Number of questions: " . $NumOfQuestions . "</div>";
                    echo "<div id='question_id'>ID: " . $row['id'] . "</div>";
                    $CreationDate = substr($row['date_created'], 0, 16);
                    echo "<div id='question_creation_date'>Creation date: " . $CreationDate . "</div>";
                    echo "</div>";
                    //Reset the value of $NumofQuestions so we can use it for the next questions
                    $NumOfQuestions = 0;
                }
            }
            ?>
        </div>
    </body>
</html>
