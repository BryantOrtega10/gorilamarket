<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Permisos;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('categoria.inicio', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","categoria.inicio")
                    ->first();
            return isset($permiso);
        });
        Gate::define('producto.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","producto.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('publicidad.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","publicidad.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('promocion.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","promocion.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('pago.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","pago.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('cobertura.mapa', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","cobertura.mapa")
                    ->first();
            return isset($permiso);
        });
        Gate::define('cliente.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","cliente.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('cupones.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","cupones.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('domiciliario.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","domiciliario.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('configuracion.inicio', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","configuracion.inicio")
                    ->first();
            return isset($permiso);
        });
        Gate::define('despacho.orden', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","despacho.orden")
                    ->first();
            return isset($permiso);
        });
        Gate::define('administrador.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","administrador.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('notificaciones.push', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","notificaciones.push")
                    ->first();
            return isset($permiso);
        });
        Gate::define('distribuidor.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","distribuidor.tabla")
                    ->first();
            return isset($permiso);
        });
        Gate::define('reclutador.tabla', function (User $user) {
            if($user->role == 'superadmin') return true;
            $permiso = Permisos::join("menu as m","m.idmenu","=","fk_menu")
                    ->where("fk_user","=",$user->id)
                    ->where("ruta","=","reclutador.tabla")
                    ->first();
            return isset($permiso);
        });
    }
}
