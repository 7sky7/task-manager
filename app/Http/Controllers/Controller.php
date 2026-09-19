<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    // $this->authorize() や $this->validate() をコントローラ内で使えるようにする
    use AuthorizesRequests, ValidatesRequests;
}
