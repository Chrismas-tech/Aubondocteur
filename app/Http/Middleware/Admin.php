<?php

namespace App\Http\Middleware;

use App\Admin as AppAdmin;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */



    public function handle($request, Closure $next)
    {
        /* Si les variables de session existent, on autorise à continuer la requête */

        $admin = AppAdmin::where('id', 1)->first();

        $admin_name = $admin->name;
        $admin_password = $admin->password;

        if ($request->session()->has('admin_name') == $admin_name && $request->session()->has('admin_password') == $admin_password) {
            return $next($request);
        } else {

            /* Sinon :

            - Si l'une des requests existent, on essaye de se connecter, on se trouve donc sur la page de connection, on vérifie les inputs*/

            if ($request->name || $request->password) {

                $request->validate([
                    'name' => 'required',
                    'password' => 'required',
                ]);

                /* Si les inputs sont correct, on renvoie vers le dashboard_admin */
                if ($request->name ==  $admin_name && $request->password ==  $admin_password) {
                    //dd('YOUHOPPOPO');
                    $request->session()->push('admin_name', $admin_name);
                    $request->session()->push('admin_password', $admin_password);

                    return redirect('admin_dashboard');
                } else {


                    /* On rafraîchit la page avec un message d'erreur */
                    return redirect()->back()->with('error', 'Le nom ou le mot de passe est incorrect !');
                }
            } else {
                /* les inputs n'existent pas, on ne se trouve pas sur la page de connexion admin -> message d'erreur */

                return response()->view('page_error');
            }
        }
    }
}
