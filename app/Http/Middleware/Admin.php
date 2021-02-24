<?php

namespace App\Http\Middleware;

use App\Admin as AppAdmin;
use Closure;
use Illuminate\Support\Facades\Hash;

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
        /* LES VARIABLES DE SESSION EXISTENT -> PAGE SUIVANTE */
        if ($request->session()->has('admin_name') && $request->session()->has('admin_password')) {
            return $next($request);
        } else {

            /* SINON ON SE TROUVE SUR LA PAGE CONNECTION, $request->connexion existe */
            if ($request->connexion == 1) {

                $request->validate([
                    'name' => 'required',
                    'password' => 'required',
                ]);

                $admin = AppAdmin::where('id', 1)->first();

                $admin_name = $admin->name;
                $admin_password = $admin->password;

                /* SI LE PASSWORD ET LE NAME SONT CORRECTS -> Dashboard ADMIN */
                if ($request->name ==  $admin_name && (Hash::check('123',$admin_password))) {

                    $request->session()->push('admin_name', $admin_name);
                    $request->session()->push('admin_password', $admin_password);

                    return redirect('admin_dashboard');
                } else {

                    /* SINON ERREUR SUR LA MEME PAGE */
                    return redirect()->back()->with('error', 'Le nom ou le mot de passe est incorrect !');
                }
            } else {
                
                /* SINON ON NE DONNE PAS D'ACCES */
                return response()->view('page_error');
            }
        }
    }
}
