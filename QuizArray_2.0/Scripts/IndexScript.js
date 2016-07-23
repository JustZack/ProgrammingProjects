$(document).ready(function(){
    //Check for a click on the 'Make a new survey' button
    $(".Make_Quiz").click(function(){
        //Take us to the makequiz.php file  so we can make a quiz / survey.
        window.location.href = "makequiz.html";
    });
    $('.Quiz_Block').click(function(){ //Check if a quiz was clicked on
        //Get all of the data in the div that was just clicked.
        var entireDiv = $(this).text();
        //Check if the user clicked the no surveys found block.
        if(entireDiv == "No surveys found :(")
        {
            return false; //Completly break out of the method.
        }
        //Get the text from the div which contains the ID of the quiz EX: "ID: 1"
        var TextOfID = $(this).children('#question_id').text();
        //Get the actual ID from the text above
        var ID_num = TextOfID.substring(3 ,TextOfID.length);
        //Set the URL to the quiz.php document with the argument of the ID number
        window.location.href = "quiz.php?id=" + ID_num;
    });
    //Check if any key was pressed that the document can detect.
    $(document).keypress(function(key){
      //Check if that key was Lowercase or Uppercase J
        if(key.which == 74 || key.which == 106)
        {
            //Checks if the admin panel is not already in view
            if($("#Admin").css("display") == "none")
            {
                //Changes the display property of the id to be block so it is shown
                $('#Admin').css("display", "block");
            }
            //Checks if the admin panel is in view
            else if($("#Admin").css("display") == "block")
            {
                //Changes the display property to none so it is no longer show.
                $('#Admin').css("display", "none");
                //Make the remove ID 'button' not be shown either
                $("#Remove_ID").css("display" , "none");
            }
        }
    });
    $('#Admin_text').click(function(){ //Checks if the admin panel is clicked on

        //Check if the remove id button is showing or not.
        if($("#Remove_ID").css("display") == "none")
        {
            $("#Remove_ID").css("display" , "block"); //Show the remove ID button
        }
        else if($("#Remove_ID").css("display") == "block")
        {
            $("#Remove_ID").css("display" , "none"); //Make the remove ID button hidden.
        }
    });
    $('#Remove_Button').click(function(){ //Checks if the remove ID button was clicked
        ID_num = $('#ID_num').val(); //Get the ID number the user typed in the textbox
        //Check if the user even typed anything before pressing the button
        if(ID_num == "")
        {
            return false;
        }
        else
        {
            //Otherwise go to the Remove_ID.php page with the argument of the ID number
            window.location.href = "Remove_ID.php?id=" + ID_num;
        }
    });
});
