$(document).ready(function(){
  var XO_Counter = 0;
  var TicTacToeArray = [["","",""],["","",""],["","",""]];

  $('.TicTacToeSquare').click(function(){
    var XorO;
    if($(this).find('img').length)
    {
      console.log('Mis-Click...');
    }
    else if(XO_Counter == 0)
    {
      XorO = 'X';

    }
    else if(XO_Counter == 1)
    {
      XorO = 'O';
    }

    $(this).find('img').remove();
    $(this).append('<img src="Images/' + XorO + '.png">');
    console.log(XorO + "-Button added");
    if(SetArray($(this)))
    {
      return;
    }
    else
    {
      if(XO_Counter == 0)
      {
        XO_Counter++;
      }
      else if(XO_Counter == 1)
      {
        XO_Counter--;
      }
    }
  });

  $('#Reset_Button').click(function(){
    ResetBoard();
  });

  function SetArray(Element){
    var XorO;
    if(XO_Counter == 0)
    {
      XorO = "X";
    }
    else if(XO_Counter == 1)
    {
      XorO = "O";
    }
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
    return WinCheck();
  }
  function WinCheck(){
    var _RESET = false;
    var Winner;
    for(var i = 1;i < 3;i++)
    {
      if(i == 1)
      {
        Winner = "X"
      }
      else if(i == 2)
      {
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
      //Somebody Won!
      if(_RESET == true)
      {
        ResetBoard();
        return true;
      }
    }
  }
  function ResetBoard(){
    for(var i = 0;i < 3;i++)
    {
      TicTacToeArray[i][0] = "";
      TicTacToeArray[i][1] = "";
      TicTacToeArray[i][2] = "";
    }
    $('.TicTacToeSquare').each(function(){
      $(this).find('img').remove();
    });
    XO_Counter = 0;
    console.log('Board reset');
  }
});
