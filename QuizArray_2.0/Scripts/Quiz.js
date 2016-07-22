$(document).ready(function(){
    var QuestionCount = 0;
    var counter = 0;
    var AnsCounter = 0;
    var AnsChoice = [];

    QuestionCounter();

    $('#Submit-Button').click(function(){
        $('.Answer').each(function(){
            if($(this).is(':checked'))
            {
                //AnsChoice[counter] = $(this).parent().text();
                AnsChoice[AnsCounter] = 1;
                AnsCounter++;
                counter++;
            }
            else
            {
                AnsChoice[AnsCounter] = 0;
                AnsCounter++;
            }
        });
        if(counter < QuestionCount)
        {
            counter = 0;
            AnsCounter = 0;
            AnsChoice.length = 0;
            alert("You must answer all of the questions!");
            return false;
        }
        console.log("------------------------------------");
        for(var i = 0;i < AnsChoice.length;i++)
        {
            console.log(AnsChoice[i]);
        }
        var StringAns = AnsChoice.join("<");
        var URLstring = window.location.href;
        var IDLoc = URLstring.indexOf('id')
        var IDstring = URLstring.substring(IDLoc + 3,URLstring.length);
        window.location.href = 'Results.php?Answers=' + StringAns + "&id=" + IDstring;
    });

    function QuestionCounter()
    {
        $(".Question-Container").each(function(){
            QuestionCount++;
        });
    }
});
