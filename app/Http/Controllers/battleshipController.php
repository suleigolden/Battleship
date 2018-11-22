<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
error_reporting(E_ALL);
	 error_reporting(E_ERROR);
class battleshipController extends Controller
{
	//View start page
	public function battleShip(){
		return view('welcome');
	}
    

    //Create BattileShip onscreen grid of cells aligned within a square 10 by 10.
	public static function createOnScreenGrid(){
		
		$map .='';
	    for ($i = A; $i < K; $i++){
	    $map .='<tr>
	            <td  class="index ng-binding">'.$i.'</td>';
	             for ($j = 1; $j < 11; $j++){
	             $map .='<td class="gameCell state_0"><i style="color: #000;">'.$i.''.$j.'</i></td>';
	             }
	      $map .='</tr>';
	    }

	    return $map;
	}
  
}
