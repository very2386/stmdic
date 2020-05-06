<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cm;
class TestController extends Controller
{
    public function test(){
		$rs = Cm::where('position', 'nsource')->groupBy('name')->orderBy('name')->get();
		foreach($rs as $rd){
			echo $rd->name."<br />";
		}
		return;
    }
}
