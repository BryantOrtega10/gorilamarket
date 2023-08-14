<?php

namespace App\Http\Controllers;

use App\Http\Requests\Administrador\CrearRequest;
use App\Http\Requests\Administrador\ModificarRequest;
use App\Models\Menu;
use App\Models\Permisos;
use App\Models\User;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function tabla(){
        $administradores = User::where("role","=","2")->get();
        return view('administrador.tabla',[
            "administradores" => $administradores
        ]);
    }

    public function formAgregar(){
        $menus = Menu::all();

        return view('administrador.agregar',[
            'menus' => $menus
        ]);
    }

    public function agregar(CrearRequest $request){
        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->usuario;
        $usuario->role = 2;
        $usuario->password = bcrypt($request->pass);
        $usuario->save();

        if(isset($request->permisos)){
            foreach($request->permisos as $perm){
                $permiso = new Permisos();
                $permiso->fk_menu = $perm;
                $permiso->fk_user = $usuario->id;
                $permiso->save();
            }
        }
        return redirect()->route('administrador.tabla')->with('mensaje', 'Administrador agregado correctamente');
    }

    public function formModificar($id){
        $menus = Menu::all();
        $usuario = User::find($id);
        $permisos = Permisos::where("fk_user","=",$id)->get();
        $permisosArr = [];
        foreach($permisos as $permiso){
            array_push($permisosArr, $permiso->fk_menu);
        }
        if(old('permisos') !== null){
            $permisosArr = old('permisos');
        }
        return view('administrador.modificar',[
            'menus' => $menus,
            'usuario' => $usuario,
            'permisosArr' => $permisosArr
        ]);
    }

    public function modificar($id,ModificarRequest $request){
        $usuario = User::find($id);
        $usuario->name = $request->nombre;
        $usuario->email = $request->usuario;
        if($request->pass != ""){
            $usuario->password = bcrypt($request->pass);
        }
        $usuario->save();
        Permisos::where("fk_user","=",$id)->delete();
        if(isset($request->permisos)){
            foreach($request->permisos as $perm){
                $permiso = new Permisos();
                $permiso->fk_menu = $perm;
                $permiso->fk_user = $usuario->id;
                $permiso->save();
            }
        }
        
        return redirect()->route('administrador.tabla')->with('mensaje', 'Administrador modificado correctamente');
    }
}
