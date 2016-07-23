$(document).ready(function(){
    var Question_counter = 1; // Global var to count the number of questions
    $("#Add_Answer").live('click', function(){ // Live click event listener for adding answers to questions
        var ClickedButtonName = $(this).attr('name');
        var AnswerNum = ClickedButtonName.substring(ClickedButtonName.length - 1, ClickedButtonName.length);
        $(this).before( AnswerBlockHTML());
        console.log("New answer box added with Answer" + AnswerNum);
    });
    // Live click event listener for adding questions
    $("#Add_New_Question").live('click', function(){
        Question_counter += 1; // Incremment Question counter because we are adding one
        $("#Add_New_Question").parent().before(QuestionBlockHTML()); //Add a  new question block
        console.log('New Question_Block added with name Question_Block' + Question_counter);
    });
    // Live click event listener for deleting questions
    $("#X_Button_Question").live('click', function(){
        $(this).parent().parent().remove(); //Remove the question from the form
        console.log('Question_Block removed with name ' + $(this).parent().parent().attr('name'));
        Question_counter -= 1; //Decrement question counter because we removed a questions
    });
    //Live click event listener for deleting an answer from a question
    $("#X_Button_Answer").live('click', function(){
        $(this).parent().remove(); // remove the answer from the question
        console.log('Answer removed with name ' + $(this).prev().attr('name'));
    });
    function ValidityCheck()//Checks for several conditions to be met, and for validity to be granted
    {
        var QuizName = $("#Quiz_Name").val(); //Store save the name of the quiz in a variable
        var breakout = false; //Bool determing weather or not we are
        if(QuizName == "") //Quiz has no name
        {
            alert("Your survey must have a name!");
            breakout = true;
        }
        else if(typeof $('#Quiz_Question').val() == 'undefined') // Quiz has no questions
        {
            alert('You must have atleast one question!');
            breakout = true;
        }
        else if(typeof $('.Answer').val() == 'undefined') //Quiz has no answers
        {
            alert('You must have atleast one answer!');
            breakout = true;
        }
        if(breakout == true)
        {
            return false;
        }
        $('#Quiz_Question').each(function(){
            if($(this).val() == "") //A has no content
            {
                alert("All questions added must be used!");
                breakout = true;
                return false;
            }
        });
        if(breakout == true)
        {
            return false;
        }
        $('.Answer').each(function(){
            if($(this).val() == "") // An answer has no content
            {
                alert("All answers added must be used!");
                breakout = true;
                return false;
            }
        });
        if(breakout == true)
        {
            return false; //Invalid quiz
        }
        else if(breakout == false)
        {
            return true;
        }
    }
    $('form').submit(function(){ //Function that runs when the submit button is clicked.
        return ValidityCheck();
    });
    //Function returning the question block HTML, used when adding a question to the form
    function QuestionBlockHTML(){
        return(""
        +"<div class='Make_Quiz_Block' name='Question_Block" + Question_counter +"'>"
                +"<p>Input your question below<img src='Images/X_Button.png' id='X_Button_Question' name='X_Button_Question" + Question_counter +"'></img></p>"
                +"<center><textarea cols='65' rows='2' id='Quiz_Question' name='Question" + Question_counter +"'></textarea></center><br>"
                +"<p>Input the answers for your question below</p>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div id='Add_Answer' name='Add_Answer" + Question_counter +"'><img src='Images/Plus_Button.png' id='Plus_Button'>Add Answer</img></div></div>");
    }
    //Function returning the answer block HTML, used when adding an answer to the form
    function AnswerBlockHTML()
    {
        return ("<div><input type='text' class='Answer' name='Answer" + AnswerNum + "[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + AnswerNum + "'></img></div>");
    }
});
