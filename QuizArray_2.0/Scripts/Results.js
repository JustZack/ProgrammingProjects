$(document).ready(function()
{
  $("#Submit-Button").click(function()
  {
    //Go back to the main page
    window.location.href = 'index.php';
  })

//Disables the users ability to press F5 to refresh the page.
//Both functions were found on stack overflow. I did not makes these.
function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
$(document).bind("keydown", disableF5);
});
