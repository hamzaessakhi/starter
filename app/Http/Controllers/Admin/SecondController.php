<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SecondController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('showString2');
    }

    public function showString0() {
        return "<h2>static string 0</h2>";
    }
    public function showString1() {
        return "<h2>static string 1</h2>";
    }
    public function showString2() {
        return "<h2>static string 2</h2>";
    }
    public function showString3() {
        return "<h2>static string 3</h2>";
    }


}
