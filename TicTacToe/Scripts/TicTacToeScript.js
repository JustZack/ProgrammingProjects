$(document).ready(function(){
  //Globaly defined so it is persistant with each move
  var XO_Counter = 0;
  //Use this array to keep track of the board
  var TicTacToeArray = [["","",""],["","",""],["","",""]];

  $('.TicTacToeSquare').click(function(){
    //Check if there is already an X or O where we clicked.
    if($(this).find('img').length)
    {
      console.log('That spot is already marked!');
      return; //Exit the method
    }
    var XorO; //Use this to store which mark we are on(X or O)
    if(XO_Counter == 0)
    {
      XorO = 'X'; //Store X as the current mark we are on
    }
    else if(XO_Counter == 1)
    {
      XorO = 'O'; //Store O as the current mark we are on
    }
    //Add an image tag to the TicTacToeSquare that was clicked.
    $(this).append('<img src="Images/' + XorO + '.png">');
    console.log(XorO + "-Button added"); //Log what just happened.
    SetArray($(this), XorO) //Set the array we store to keep track.
    if(WinCheck()) //check if anybody has won at this point in the game
    {
      return; //Returned true, so just exit the method now
    }
    else
    {
      if(XO_Counter == 0)
      {
        XO_Counter++; //otherwise Increment the XO_Counter, representing O now.
      }
      else if(XO_Counter == 1)
      {
        XO_Counter--; //otherwise Increment the XO_Counter, representing X now.
      }
    }
  });

  $('#Reset_Button').click(function(){
    ResetBoard();
  });

  function SetArray(Element, XorO){
    //Determine what location of the array should be filled
    switch(Element.attr('name'))
    {
      case "Top_Left":
        TicTacToeArray[0][0] = XorO;
        break;
      case "Top_Mid":
        TicTacToeArray[0][1] = XorO;
        break;
      case "Top_Right":
        TicTacToeArray[0][2] = XorO;
        break;
      case "Mid_Left":
        TicTacToeArray[1][0] = XorO;
        break;
      case "Mid_Mid":
        TicTacToeArray[1][1] = XorO;
        break;
      case "Mid_Right":
        TicTacToeArray[1][2] = XorO;
        break;
      case "Bot_Left":
        TicTacToeArray[2][0] = XorO;
        break;
      case "Bot_Mid":
        TicTacToeArray[2][1] = XorO;
        break;
      case "Bot_Right":
        TicTacToeArray[2][2] = XorO;
        break;
      }
  }
  function WinCheck(){
    var _RESET = false; //If somebody won this is true
    var Winner; //Store either X or O depending on the value of i below
    for(var i = 0;i < 2;i++)
    {
      if(i == 0)
      {
        //All winning conditions for X will not be checked
        Winner = "X"
      }
      else if(i == 1)
      {
        //All winning conditions for O will not be
        Winner = "O";
      }
      //Top Row Full
      if(TicTacToeArray[0][0] == Winner && TicTacToeArray[0][1] == Winner && TicTacToeArray[0][2] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Mid Row Full
      else if(TicTacToeArray[1][0] == Winner && TicTacToeArray[1][1] == Winner && TicTacToeArray[1][2] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Bot Row Full
      else if(TicTacToeArray[2][0] == Winner && TicTacToeArray[2][1] == Winner && TicTacToeArray[2][2] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Left Column Full
      else if(TicTacToeArray[0][0] == Winner && TicTacToeArray[1][0] == Winner && TicTacToeArray[2][0] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Mid Column Full
      else if(TicTacToeArray[0][1] == Winner && TicTacToeArray[1][1] == Winner && TicTacToeArray[2][1] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Right Column Full
      else if(TicTacToeArray[0][2] == Winner && TicTacToeArray[1][2] == Winner && TicTacToeArray[2][2] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Left To Right Full
      else if(TicTacToeArray[0][0] == Winner && TicTacToeArray[1][1] == Winner && TicTacToeArray[2][2] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }
      //Right To Left Full
      else if(TicTacToeArray[0][2] == Winner && TicTacToeArray[1][1] == Winner && TicTacToeArray[2][0] == Winner)
      {
        alert(Winner + " Wins!");
        _RESET = true;
      }

      if(_RESET == true)
      {
        ResetBoard();
        return true; //Somebody won
      }
    }
  }
  function ResetBoard(){
    //Go through every element in out array and make it nothing
    for(var i = 0;i < 3;i++)
    {
      TicTacToeArray[i][0] = "";
      TicTacToeArray[i][1] = "";
      TicTacToeArray[i][2] = "";
    }
    //Remove the image tags
    $('.TicTacToeSquare').each(function(){
      $(this).find('img').remove();
    });
    XO_Counter = 0;
    console.log('Board reset');
  }
});
