<html>
    <head>
        <title>Make a Quiz</title>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <link rel='stylesheet' type='text/css' href='Styles/makequiz.css'>
        <script type="text/javascript" src="Scripts/MakeQuiz.js"></script>
    </head>
    <body>
        <form action="CreateQuiz.php" method="post">
        <div class="Quiz_Name_Container">
            <p>Input survey name below</p>
            <input id="Quiz_Name" name="Quiz_Name" type="text"></input><br><center id="notice">please do not include the characters "<" or ">" anywhere in the quiz!</center></div>
            <div class="Make_Quiz_Block" name="Question_Block1">
                <p>Input your question below<img src="Images/X_Button.png" id="X_Button_Question" name="X_Button_Question1"></img></p>
                <center><textarea cols='65' rows='2' id="Quiz_Question" name="Question1"></textarea></center><br>
                <p>Input the answers for your question below</p>
                <div><input type="text"class="Answer" name="Answer1[]"></input><img src="Images/X_Button.png" id="X_Button_Answer" name="X_Button_Answer1"></img></div>
                <div><input type="text"class="Answer" name="Answer1[]"></input><img src="Images/X_Button.png" id="X_Button_Answer" name="X_Button_Answer1"></img></div>
                <div><input type="text"class="Answer" name="Answer1[]"></input><img src="Images/X_Button.png" id="X_Button_Answer" name="X_Button_Answer1"></img></div>
                <div id="Add_Answer" name="Add_Answer1"><img src='Images/Plus_Button.png' id='Plus_Button'>Add Answer</img></div></div>
            <center><div id="Add_New_Question"><img src='Images/Plus_Button.png' id='Plus_Button'>Add Question</img></div></center>
            <center><button type='submit'id='Submit_Survey'><img src='Images/Check_Mark.png' id='Check_Mark'>Submit Survey</img></button></center>
        </form>
    </body>
</html>
