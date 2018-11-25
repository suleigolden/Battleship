 
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