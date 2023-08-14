<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelControlController extends Controller
{
    public function inicio(){
        return redirect()->route('pago.tabla');
        return view('panel-control.inicio');
    }
}
