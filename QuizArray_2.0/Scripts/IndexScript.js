//Wait until the document is fully loaded in the browser to start running.
$(document).ready(function(){
    //Check for a click on the 'Make a new survey' button
    $(".Make_Quiz").click(function(){
        //Take us to the makequiz.php file  so we can make a quiz / survey.
        window.location.href = "makequiz.php";
    });
    //Check if a quiz was clicked on
    $('.Quiz_Block').click(function(){
        //Get all of the data in the div that was just clicked.
        var entireDiv = $(this).text();
        //Make sure that the user didnt click on the message that is shown when
        //There are no surveys in the database.
        if(entireDiv == "No surveys found :(")
        {
          //Completly break out of the method.
            return false;
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
      //This is my 'admin menu'. I only have it here because it made things simpler while
      //Debugging the php script because I was making several quizes to check several things.
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
                //so if / when the admin panel is shown again that button is
                //not shown until it is clicked again
                $("#Remove_ID").css("display" , "none");
            }
        }
    });
    //Checks if the admin panel is clicked on
    $('#Admin_text').click(function(){

        //Check if the remove id button is showing or not.
        if($("#Remove_ID").css("display") == "none")
        {
            //Show the remove ID button
            $("#Remove_ID").css("display" , "block");
        }
        else if($("#Remove_ID").css("display") == "block")
        {
            //Make the remove ID button hidden.
            $("#Remove_ID").css("display" , "none");
        }
    });
    //Checks if the remove ID button was clicked
    $('#Remove_Button').click(function(){
        //Get the ID number the user typed in the textbox
        ID_num = $('#ID_num').val();
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
