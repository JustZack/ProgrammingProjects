<html>
    <?php
        //Get name of survey and declair 2 arrays for later use.
        $SurveyName = $_POST['Quiz_Name'];
        $SurveyQuestions = array();
        $SurveyAnswers = array();
        $SurveyName = str_replace("'", "\'", $SurveyName);


        $QuestionCount = 0;
        $AnswerCount = array();
        //Check for each question
        for($i = 1;$i < 25;$i++)
        {
            $POSTname = "Question" . $i;
            if(isset($_POST[$POSTname]))
            {
                $_POST[$POSTname] = str_replace("'", "\'", $_POST[$POSTname]);
                array_push($SurveyQuestions, "<" . $i . ">" . $_POST[$POSTname]);
                $QuestionCount++;
            }
            else
            {
                break;
            }
        }

        //Check for each occurence of an answer from the specified question
        for($i = 1;$i < 100;$i++)
        {
            $POSTname = "Answer" . $i;
            if(isset($_POST[$POSTname]))
            {
                $TempAnsCount = 0;
                foreach($_POST[$POSTname] as $answer)
                {
                    $answer = str_replace('"', "\"", $answer);
                    $answer = str_replace("'", "\'", $answer);
                    array_push($SurveyAnswers, "<" . $i .">" . $answer);
                    $TempAnsCount++;
                }
                array_push($AnswerCount, $TempAnsCount);
            }
            else
            {
                break;
            }
        }

        for($i = 0;$i < $QuestionCount;$i++)
        {
            for($u = 0;$u < $AnswerCount[$i];$u++)
            {
              if($i == $QuestionCount - 1 && $u == $AnswerCount[$i] - 1)
              {
                $SurveyChoiceString .= "0";

              }
              else if($i == 0 && $u == 0)
              {
                $SurveyChoiceString .= "0<";
              }
              else
              {
                $SurveyChoiceString .= "0<";
              }
            }
        }
        echo $SurveyChoiceString;
        //Make arrays into a single string
        $Questions = implode($SurveyQuestions);
        $Answers = implode($SurveyAnswers);

        //Database credentials
        $serverName = 'localhost';
        $userName = 'root';
        $password = '';
        $dbname = 'quiz_db';

        //Connect to database
        $db_connection = new mysqli($serverName, $userName, $password, $dbname);
        if($db_connection->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        //SQL stuff, then query the table with that SQL
        $sql = "INSERT INTO `quiz_data` (`id`, `name`, `questions`, `answers`, `AnswerChoices`, `date_created`) VALUES (NULL, '$SurveyName', '$Questions', '$Answers', '$SurveyChoiceString',CURRENT_TIMESTAMP)";

        if($db_connection->query($sql) === TRUE)
        {
            //Yippie, we successfully added our quiz into the database
            //echo "<script>alert('Questions and Answers added successfully');window.location.href = 'index.php'</script>";
            header('location: index.php');
            exit();
        }
        else
        {
            //Uh oh... what happened?
            echo "error: " .$db_connection->error;
        }
    ?>
</html>
