<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Battle Ship</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <style type="text/css">
.inputcontrol {
    float: left;
    display: block;
    width: 50%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 1px;
    font-size: 27px;
}
.btn-submit{
    float: left;
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
    width: 30%;
    height: 48px;
    font-size: 27px;
}
.btn-submit:hover{
    cursor: pointer;
}
.btn-restart{
    float: right;
    color: #000;
    background-color: #ffffb2;
}
.action-div{
    width: 94%;
    float: left;
    height: auto;
    padding: 10px;
    background-color: rgb(83, 175, 19);
}
.message_OK {
  width: 94%;
  float: left;
  border-radius: 3px;
  padding: 10px;
  margin: 10px 0;
  background-color: #66ff33;
  text-align: center;
}
.message_NO {
  width: 94%;
  float: left;
  border-radius: 3px;
  padding: 10px;
  margin: 10px 0;
  background-color: #ffc2c2;
  text-align: center;
}
</style>

    </head>
    <body>
        <?php use App\Http\Controllers\battleshipController;?>
 <div  id="container">
    <h1 class="title_text">Battle Ship</h1>
        <table cellpadding="5" cellspacing="5" border="0" id="gameTable">
            <thead>
                <tr><td>&nbsp;</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
            </tr>
        </thead>
        <tbody id="onScreenGridContent">
 <?php //echo battleshipController::createOnScreenGrid(); ?>

    </tbody>
</table>
 <div class="action-div">
   <input type="text" placeholder="A0" id="FireThisShip" onkeyup="changeToUpper();" class="inputcontrol">
  <input type="button" value="Fire!" onclick="fireShip();" class="btn-submit" id="btn-submit">
 </div>
 <div id="replyMessage"></div>
  <input type="button" value="Restart" onclick="restartBattkleShip();" class="btn-restart">
<input type="hidden" id="_token" value="{{ csrf_token() }}">

<script type="text/javascript">
    var allShips = [];
    //return element by ID
    function el(id) {
      return document.getElementById(id);
    }
    //Return Random Number
    function getRandNum(bottom, top) {
            return Math.floor( Math.random() * ( 1 + top - bottom ) ) + bottom;
    }
    //Get Letter to Number
    function letterToNumberDataProvider(char){
        const index = JSON.parse('{"A": "1", "B": "2", "C": "3", "D": "4", "E": "5", "F": "6", "G": "7", "H": "8", "I": "9", "J": "10"}');
         return index[char];
    }
    //Get Number to Letter
    function numberToLetterDataProvider(num){
        const index = JSON.parse('{"1": "A", "2": "B", "3": "C", "4": "D", "5": "E", "6": "F", "7": "G", "8": "H", "9": "I", "10": "J"}');
         return index[num];
    }
    //Load all OnScreenGrid
function loadOnScreenGrid(){
    var CSRF_TOKEN = el("_token").value;
    var vars = "_token="+CSRF_TOKEN;
    var url = "loadOnScreenGrid";
    var hr = new XMLHttpRequest();
    hr.open("GET", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
      if(hr.readyState == 4 && hr.status == 200) {
        var return_data = JSON.parse(hr.responseText);
        el("onScreenGridContent").innerHTML = return_data;
        initialBattleShips_Lshape();
        initialBattleShips_Ishape();
        initialBattleShips_Dshape();
        //console.log(allShips);
        gameStart(allShips);
       }
    }
     hr.send(vars); 
     el("onScreenGridContent").innerHTML = "Loading Ships .......";
}

    //Create L Shape
    function initialBattleShips_Lshape(){
        let MAP_X = getRandNum(1, 8);
        let MAP_Y = getRandNum(1, 7);
        let currentIdex = MAP_Y;
        //console.log("MAP_X: "+MAP_X);
        for (let i = 1; i < 5; i++) {

            let indexCell = numberToLetterDataProvider(currentIdex)+MAP_X;
            el(indexCell).style.backgroundColor  = "LightSeaGreen";

            allShips.push(""+indexCell+"");

            let next = letterToNumberDataProvider(numberToLetterDataProvider(currentIdex));
            next ++;
            currentIdex = next;
            
        }
        currentIdex --;
        //console.log("End With: "+numberToLetterDataProvider(currentIdex)+MAP_X);
        for (let i = 1; i < 3; i++) {
            MAP_X ++;
            let indexCell = numberToLetterDataProvider(currentIdex)+MAP_X;
            el(indexCell).style.backgroundColor  = "LightSeaGreen";

            allShips.push(""+indexCell+"");
        }
   
    }
    //Create I Shape
    function initialBattleShips_Ishape(){
        let MAP_X = getRandNum(1, 7);
        let MAP_Y = getRandNum(1, 7);
        let currentIdex = MAP_Y;
        let chekIdex = numberToLetterDataProvider(currentIdex)+MAP_X;
        chekIdex = el(chekIdex).style.backgroundColor;
        if(chekIdex == "lightseagreen" || chekIdex == "LightSeaGreen"){
            initialBattleShips_Ishape();
        }else{
            for (let i = 1; i < 5; i++) {

            let indexCell = numberToLetterDataProvider(currentIdex)+MAP_X;
            el(indexCell).style.backgroundColor  = "LightSeaGreen";
           
            allShips.push(""+indexCell+"");

            let next = letterToNumberDataProvider(numberToLetterDataProvider(currentIdex));
            next ++;
            currentIdex = next;
            
            }
        }
        
    }
     //Create two dot shapes
    function initialBattleShips_Dshape(size = 2){
        for (let i = 0; i < size; i++) {
        //let exist = false;
        let MAP_X = getRandNum(1, 7);
        let MAP_Y = getRandNum(1, 7);
        let currentIdex = MAP_Y;
        let chekIdex = numberToLetterDataProvider(currentIdex)+MAP_X;
        chekIdex = el(chekIdex).style.backgroundColor;
        if(chekIdex == "lightseagreen" || chekIdex == "LightSeaGreen"){
            initialBattleShips_Dshape(1);
        }else{

            let indexCell = numberToLetterDataProvider(currentIdex)+MAP_X;
            el(indexCell).style.backgroundColor  = "LightSeaGreen";

            allShips.push(""+indexCell+"");
            
        }

     }
        
    }
    
function gameStart(allShips){
    var CSRF_TOKEN = el("_token").value;
    var vars = "_token="+CSRF_TOKEN+"&allShips="+allShips;
    var url = "battleShipStart";
    var hr = new XMLHttpRequest();
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
      if(hr.readyState == 4 && hr.status == 200) {
        var return_data = JSON.parse(hr.responseText);
        //console.log(return_data);
       }else{
        //var return_data = JSON.parse(hr.responseText);
        //console.log("allShips");
       }
    }
     hr.send(vars); 
}


    // initialBattleShips_Lshape();
    // initialBattleShips_Ishape();
    // initialBattleShips_Dshape();
    // console.log(allShips);
    // gameStart(allShips);


//Change character to upper
function changeToUpper(){
    var ship = el("FireThisShip").value;
    el("FireThisShip").value = ship.toUpperCase();
}
//fire a Ship
function fireShip(){
    var ship = el("FireThisShip").value;
    var CSRF_TOKEN = el("_token").value;
    var vars = "_token="+CSRF_TOKEN+"&shipLocation="+ship;
    var url = "fireThisShip";
    var hr = new XMLHttpRequest();
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
      if(hr.readyState == 4 && hr.status == 200) {
        var return_data = JSON.parse(hr.responseText);
        if (return_data.status == "OK") {
            el("replyMessage").innerHTML = return_data.message;
            el(ship).style.backgroundColor  = "SpringGreen";
            el(ship).innerHTML = "✓";
        }else{
             el("replyMessage").innerHTML = return_data.message;
             if (return_data.status != "NoTarget") {
             el(ship).style.backgroundColor  = "LightPink";
             el(ship).innerHTML = "X";
             }
        }
        if (return_data.gameOver == "OK") {
            el("btn-submit").style.backgroundColor  = "LightGrey";
            el("btn-submit").disabled = true;
        }
        el("FireThisShip").value = "";
        console.log(return_data);
       }
    }
     hr.send(vars); 
}
 //Restart game warning
function warningRestart(){
    var con = confirm("Are you sure you want to Restart The Battle Ship?");
    if(con != true){
        return false;
    }else{
        loadOnScreenGrid();
    }

}
//Check page Refresh
function checkPageRefresh(){
    if (window.performance) {
      console.info("window.performance works fine on this browser");
    }
      if (performance.navigation.type == 1) {
        console.info( "This page is Refreshed");
        warningRestart();
      } else {
        console.info( "This page is not Refreshed");
      }
}
//Restart Battkle Ship
function restartBattkleShip(){
    loadOnScreenGrid();
}
loadOnScreenGrid();
checkPageRefresh();
</script>
</div>
    </body>
</html>















