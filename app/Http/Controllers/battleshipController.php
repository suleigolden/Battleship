<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
error_reporting(E_ALL);
error_reporting(E_ERROR);

class battleshipController extends Controller
{
	//View start page
	public function battleShip(){
		return view('welcome');
	}
    

    //Create BattileShip onscreen grid of cells aligned within a square 10 by 10.
	public static function createOnScreenGrid()
	{
		
		$map .='';
	    for ($i = A; $i < K; $i++){
	    $map .='<tr>
	            <td  class="index ng-binding">'.$i.'</td>';
	             for ($j = 1; $j < 11; $j++){
	             $map .='<td class="state_0" id="'.$i.''.$j.'"></td>';
	             }
	      $map .='</tr>';
	    }

	    return $map;
	}
	 //Ajax Create BattileShip onscreen grid of cells aligned within a square 10 by 10.
	public static function ajaxCreateOnScreenGrid()
	{
		
		$map .='';
	    for ($i = A; $i < K; $i++){
	    $map .='<tr>
	            <td  class="index ng-binding">'.$i.'</td>';
	             for ($j = 1; $j < 11; $j++){
	             $map .='<td class="state_0" id="'.$i.''.$j.'"></td>';
	             }
	      $map .='</tr>';
	    }

	   // return $map;
	   return response()->json($map);
	}

	//Create initial battle ships
	public static function initialBattleShips()
	{
		// const MAP_X = 10;
		// const MAP_Y = 10;
		//const L_start = 1; const L_stop = 8;
	}

	//Restart Battkle Ship
	public function restartBattkleShip()
	{
		Session::forget('allBattleShips');
		Session::forget('totalShipsOnBoard');
		Session::forget('alreadyHitShips');
	}
	
	//Game Start
	public function startBattleShip(Request $request)
	{
		$this->restartBattkleShip();	
		if(Session::has('allBattleShips')){
           // $this->addShipsToCart($request->allShips);
        }else{
        	$this->saveOnScreenGridShips($request->allShips);
        }

		 $outPut = array('status' => "OK",
                        'replyResult' => Session::get('allBattleShips'), );
        return response()->json($outPut);
	}

	//Save all Ships in  a session variable
	 public function saveOnScreenGridShips($allShips)
	 {

	 	$getShips = trim($allShips, ".");
		$setShips = explode(",", $getShips);
		$totalShips = 0;
        if(Session::has('allBattleShips')){
        	foreach ($setShips as $value) {
				session()->push('allBattleShips', $value);
				$totalShips++;
			}
            
        }else{
            session()->put('allBattleShips', []);
            foreach ($setShips as $value) {
				session()->push('allBattleShips', $value);
				$totalShips++;
			}

        }
        session()->put('totalShipsOnBoard', $totalShips);
        return true;
     }

     //fire This Ship
     public function fireThisShipLocation(Request $request)
     {
     	$ship = $request->shipLocation;
     	$allShips = Session::get('allBattleShips');
		$status = ""; $message= ""; $gameOver = "";
		if ($this->checkUserInput($ship)) {

			if ($this->checkAlreadyHitShip($ship)) {
				$message = "<div class='message_NO'>Oops, you already Hit this location</div>";
				$status = "NO";
				$gameOver = "On Going";
			}else if($this->hitShip($ship)){
				$this->sinkShip();
				$message = "<div class='message_OK'>YAAA!..You Hit a target!
							 <br>You have ".Session::get('totalShipsOnBoard')." targets for you to hit in order to sink all the ships</div>";
				$status = "OK";
				$gameOver = "On Going";
			}else{
				$message = "<div class='message_NO'>Oops! You missed!</div>";
				$status = "NO";
				$gameOver = "On Going";
			}
		}else{
			$message = "<div class='message_NO'>Oops, this target is not on the board.</div>";
				$status = "NoTarget";
				$gameOver = "On Going";
		}
		if ($this->checkIfAllShipSink()) {
			$message = "<div class='message_OK'>Congratulation, you have sink all the ships. GAME OVER!</div>";
				$status = "OK";
				$gameOver = "OK";
		}

		$outPut = array('status' => $status,
						'message' => $message,
						'gameOver' => $gameOver, 
					);
        return response()->json($outPut);
     }

     //Check if ship is hit
     public function hitShip($ship)
     {
     	 $status = false;
       if(Session::has('allBattleShips')){
            foreach (Session::get('allBattleShips') as $key => $value) {
                if($value === $ship){
                     Session::pull('allBattleShips.'.$key); 
                     $status = true;
                    break;
                 }
             }
          }

          $this->savealreadyHitShip($ship);

          return $status;
     }

     //Save already hit Ships and already missed hit to a session variable
	 public function savealreadyHitShip($ship)
	 {
	 	if(Session::has('alreadyHitShips')){
        	session()->push('alreadyHitShips', $ship); 
        }else{
	 	 session()->put('alreadyHitShips', []);
         session()->push('alreadyHitShips', $ship);
     }
        return true;
     }
     //Cehck if already hit Ships or already missed hit
	 public function checkAlreadyHitShip($ship)
	 {
	 	 $status = false;
            foreach (Session::get('alreadyHitShips') as $key => $value) {
                if($value === $ship){ 
                     $status = true;
                    break;
                 }
             }

          return $status;
     }
  	//sink hit ship
     public function sinkShip()
     {
     	$totalShips = Session::get('totalShipsOnBoard');
     	$totalShips --;
     	Session::forget('totalShipsOnBoard');
     	session()->put('totalShipsOnBoard', $totalShips);
     }
     //sink all ship is hit
     public function checkIfAllShipSink()
     {
     	$totalShips = Session::get('totalShipsOnBoard');
     	if ($totalShips < 1) {
     		return true;
     	}else{
     		return false;
     	}
     }
     //Check if user input is in the OnScreenGrid
	public static function checkUserInput($input)
	{
		 $status = false; $check = '';
	    for ($i = A; $i < K; $i++){
	           
	           for ($j = 1; $j < 11; $j++){
	             $check = $i.''.$j;
		    	 if($check === $input){ 
	                    $status = true;
	                    break;
	                }
	            }
	      
	    }

	    return $status;
	}
}
