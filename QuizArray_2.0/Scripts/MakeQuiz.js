$(document).ready(function(){
    var Question_counter = 1;
    $("#Add_Answer").live('click', function(){
        var ClickedButtonName = $(this).attr('name');
        var AnswerNum = ClickedButtonName.substring(ClickedButtonName.length - 1, ClickedButtonName.length);
        $(this).before("<div><input type='text' class='Answer' name='Answer" + AnswerNum + "[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + AnswerNum + "'></img></div>");
        console.log("New answer box added with Answer" + AnswerNum);
    });

    $("#Add_New_Question").live('click', function(){
        Question_counter += 1;
        $("#Add_New_Question").parent().before(QuestionBlockHTML());
        console.log('New Question_Block added with name Question_Block' + Question_counter);
        /*
        if($(".Make_Quiz_Block").text().length < 2)
        {
            $("#Quiz_Name").after(QuestionBlockHTML());
        }
        else{
            $("div[name=Question_Block" + (Question_counter - 1) +"]").after(QuestionBlockHTML());
            console.log('New Question_Block added with Question_Block' + Question_counter);
        }*/
    });

    $("#X_Button_Question").live('click', function(){
        $(this).parent().parent().remove();
        console.log('Question_Block removed with name ' + $(this).parent().parent().attr('name'));
        /*
        var ClickedX_Button = $(this).attr('name');
        var QuestionNum = ClickedX_Button.substring(ClickedX_Button.length - 1, ClickedX_Button.length);
        $("div[name=Question_Block" + QuestionNum + "]").remove();
        console.log('Question_Block removed with name Question_Block' + Question_counter);
        */
        /*Question_counter -= 1;*/
    });

    $("#X_Button_Answer").live('click', function(){
        console.log('Answer removed with name ' + $(this).prev().attr('name'));
        $(this).parent().remove();
    });

    $('form').submit(function(){
        var QuizName = $("#Quiz_Name").val();
        var breakout = false;
        if(QuizName == "")
        {
            alert("Your survey must have a name!");
            breakout = true;
        }
        if(breakout == true)
        {
            return false;
        }
        if(typeof $('#Quiz_Question').val() == 'undefined')
        {
            alert('You must have atleast one question!');
            breakout = true;
        }
        if(breakout == true)
        {
            return false;
        }
        if(typeof $('.Answer').val() == 'undefined')
        {
            alert('You must have atleast one answer!');
            breakout = true;
        }
        if(breakout == true)
        {
            return false;
        }
        $('#Quiz_Question').each(function(){
            if($(this).val() == "")
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
            if($(this).val() == "")
            {
                alert("All answers added must be used!");
                breakout = true;
                return false;
            }
        });
        if(breakout == true)
        {
            return false;
        }
    });

    function QuestionBlockHTML(){
        //todo: add the question block HTML (once it is done)
        //" + Question_counter +"
        return(""
        +"<div class='Make_Quiz_Block' name='Question_Block" + Question_counter +"'>"
                +"<p>Input your question  "+/*(" + Question_counter +")*/" below<img src='Images/X_Button.png' id='X_Button_Question' name='X_Button_Question" + Question_counter +"'></img></p>"
                +"<center><textarea cols='65' rows='2' id='Quiz_Question' name='Question" + Question_counter +"'></textarea></center><br>"
                +"<p>Input the answers for your question below</p>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div><input type='text' class='Answer' name='Answer" + Question_counter +"[]'></input><img src='Images/X_Button.png' id='X_Button_Answer' name='X_Button_Answer" + Question_counter +"'></img></div>"
                +"<div id='Add_Answer' name='Add_Answer" + Question_counter +"'><img src='Images/Plus_Button.png' id='Plus_Button'>Add Answer</img></div></div>");
    }
});
