<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel='stylesheet' type='text/css' href='Styles/quiz.css'>
    <link rel='stylesheet' type='text/css' href='Styles/results.css'>
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script type="text/javascript" src="Scripts/Results.js"></script>


  </head>
<?php
    //Get the Id and Answers from the URL arguments
    $Answers = $_GET['Answers'];
    $idNUM = $_GET['id'];

    //Database connection credentials
    $serverName = 'localhost';
    $userName = 'root';
    $password = '';
    $dbname = 'quiz_db';
    //Connect to the database, and check if there was an error
    $db_connection = new mysqli($serverName, $userName, $password, $dbname);
    if($db_connection->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //Query the database with the following SQL, and store its response
    $sql = "SELECT * FROM quiz_data WHERE id = $idNUM";
    $result = $db_connection->query($sql);
    if (!$result) {
      throw new Exception("Database Error [{$db_connection->errno}]"
                         ." {$db_connection->error}");
    }
  //Get all of the data in the ID of the database and store it as a keyed array
    $row = $result->fetch_assoc();
    $AnswerChoices_inDB = $row['AnswerChoices'];//Get the AnswerChoises from Row

    //Seperate both strings into arrays
    //Where < is the seperation of numbers
    $AnswersArray = explode("<",$Answers);
    $Answer_DB_Array = explode("<", $AnswerChoices_inDB);
    //Give this string a starting value, otherwise we could not add to it.
    $NewAnswers_inDB = "";

    //Add up the new results of the the quiz
    for($i = 0;$i < count($Answer_DB_Array);$i++)
    {
      //Save what was added up from what the user answered,
      // and what was already in the database
      $temp = (int)$AnswersArray[$i] + (int)$Answer_DB_Array[$i];
      //This if / else handles the formatting of the answersChoices in the array
      //   less than (<) seperates each number
      if($i == count($Answer_DB_Array) - 1)
      {
        $NewAnswers_inDB .= $temp;
      }
      else
      {
        $NewAnswers_inDB .= $temp . "<";
      }
    }

    //echo $NewAnswers_inDB;
    //Send the updated quiz results to the database
    $sql = "UPDATE `quiz_data` set `AnswerChoices` = '$NewAnswers_inDB' WHERE `id` = '$idNUM'";
    $db_connection->query($sql);

    //From here up we were updating the results
    //From here down we will be displaying the results

    //Now we will grab the questions and answers from the database
    $sql = "SELECT * FROM quiz_data WHERE id = $idNUM";
    $result = $db_connection->query($sql);
    $db_connection->close();
    $row = $result->fetch_assoc();

    //Start of the container for the survey
    echo "<div id='Survey-Container'>";
    echo "<center><div id='SurveyName'> Results for: " . $row['name'] . "</div></center>";

    $Questions = array(); //These are the questions without formatting
    $Answers = array();   //These are the answers with reduced formatting

    $Questions_POST = $row['questions']; //Grab the questions column of the selected ID
    $Answers_POST = $row['answers'];     //Grab the answers column of the selected ID

    $Qstart; //This var stores the starting index of a question
    $Qend;   //This var stores the ending index of a question

    for($i = 2;$i < strlen($Questions_POST);$i++) //Go through all questions
    {
        //Start of a question if this is true
        if($Questions_POST[$i] == ">")
        {
            $Qstart = $i + 1;
        }
        //End of question if this is true
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
        //Always the end of a question, because end of questions string
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

    for($i = 1;$i < strlen($Answers_POST);$i++) //go through all answers
    {
        //Start of an answer
        if($Answers_POST[$i] == ">")
        {
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
        //Always the end of an answer because end of answers string
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

    $NewAnswers_inDB = explode("<", $NewAnswers_inDB);//Get all answer counts
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
                //Save the answer to the $Answers array
                $Answers[$u] = substr($Answers[$u], 2, strlen($Answers[$u]) - 2);
              //Print the whole answer out into its own div with a radio button
                echo "<div class='AnswerDiv'>"
                . $Answers[$u] . "<div class='ansCount'>". $NewAnswers_inDB[$u] ."</div></div><br>";
            }
        }
        echo "</div>"; //Close off the question container div
      }
      //Put the back button at the bottom of the page
      echo "<center><div id='Submit-Button' type='submit'>"
      ."<img src='Images/Back.png' id='Back_mark'>"
      ." Back to main page</img></div></center>";
      echo "</div>";
?>
</html>
