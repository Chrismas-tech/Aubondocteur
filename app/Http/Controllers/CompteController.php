<?php

namespace App\Http\Controllers;

use App\City;
use App\Department;
use App\Medecin;
use App\Region;
use App\Review;
use App\Speciality;
use App\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() 
    {
        $this->middleware('auth');
    }     

    public function accueil_compte()
    {
        $user = Auth::User();
        return view('compte.accueil_compte', compact('user'));
    }


    public function create_medecin()
    {
        $user = Auth::User();
        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

        return view('form.create_medecin', compact('user', 'specialities'));
    }

    public function destroy($id)
    {

        $reviews_from_user = Review::where('user_id', '=', $id);
        $reviews_from_user->delete();

        $users = User::findOrFail($id);
        $users->delete();

        return redirect('/');
    }

    public function read_reviews_medecin($medecin_id, $city)
    {

        $review_validated = Review::where('medecin_id', "=", $medecin_id)
            ->where('validation_status_review', "=", 1)->orderBy('created_at', 'desc')->paginate(5);
        $medecin = Medecin::find($medecin_id);

        return view('compte.read_reviews_medecin', compact('review_validated', 'medecin', 'city'));
    }

    public function give_review_medecin_form($medecin_id)
    {
        // Empêcher un utilisateur de remettre une review sur le médecin précédent

        // Via le medecin_id, on cherche dans la table Review une review que l'utilisateur aurait déjà publié sur le médecin (ou medecin_id = $medecin_id et ou user_id = utilisateur connecté) 

        $user_id = auth()->user()->id;
        $reviews_of_user = Review::where('medecin_id', '=', $medecin_id)
            ->where('user_id', '=', $user_id)->get();

        // Si l'utilisateur n'a pas encore de review sur ce médecin
        if ($reviews_of_user->isEmpty()) {

            $medecin = Medecin::find($medecin_id);
            return view('compte.give_review_form_medecin', compact('medecin', 'user_id'));

            // Si l'utilisateur a déjà publié une review su le médecin
        } else {
            return redirect()->back()->with('review_error', 'Vous avez déjà posté un commentaire sur ce médecin !');
        }
    }

    public function send_review_form_medecin(Request $request)
    {
        //VALIDATOR
        $request->validate([
            'date_rdv' => 'required|',
            'review' => 'required|',
            'user_id' => 'required|',
            'medecin_id' => 'required|',
            'validation_status_review' => 'required|',
        ]);

        //REMPLACEMENT VARIABLE
        $user_id = auth()->user()->id;
        $medecin_id = $request->medecin_id;

        $reviews_of_user = Review::where('medecin_id', $medecin_id)
            ->where('user_id', '=', $user_id)->get();

        //AFIN D'EMPECHER LE RE-ENVOI D'UNE REVIEW VIA LE BOUTON RETOUR, ON DOIT VERIFIER SI L'UTILISATEUR POSSEDE UNE REVIEW SUR LE MEDECIN

        // Si l'utilisateur n'a pas encore de review sur ce médecin on accepte la création
        if ($reviews_of_user->isEmpty()) {

            //On change l'ordre de la date : yyyy-mm-dd to dd-mm-yyyy
            $request->date_rdv = date('d-m-Y', strtotime($request->date_rdv));

            $datas = $request->all();
            Review::create($datas);

            $user_id = auth()->user()->id;

            User::where('id', $user_id)->update([
                'nb_reviews_waiting' => DB::raw('nb_reviews_waiting+1'),
            ]);

            return redirect('/accueil_compte')->with('message', 'Votre soumission a bien été envoyée aux modérateurs ! Elle est désormais en attente et sera validée ou rejetée dans les plus brefs délais !');

            // Si l'utilisateur a déjà une review -> message d'erreur
        } else {
            return redirect('/accueil_compte')->with('review_error', 'Vous avez déjà posté un commentaire sur ce médecin !');
        }
    }

    public function add_medecin(Request $request)
    {
        $request->validate([
            'medecin_first_name' => 'required',
            'medecin_last_name' => 'required',
            'speciality' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'phone' => 'required',
            'gps_lat' => 'required',
            'gps_lng' => 'required',
            'validation_status_medecin' => 'required',
            'user_id' => 'required',
        ]);

        /* CAPITALIZE FIRST AND LAST NAME */

        $datas = $request->all();
        $datas["medecin_first_name"] = strtoupper($request->medecin_first_name);
        $datas["medecin_last_name"] = strtoupper($request->medecin_last_name);
        $datas["city"] = strtoupper($request->city);

        Medecin::create($datas);

        return redirect('/form_review_medecin');
    }

    public function review_medecin_store(Request $request)
    {

        $request->validate([
            'review' => 'required|',
            'date_rdv' => 'required',
            'user_id' => 'required',
            'validation_status_review' => 'required',
            'medecin_id' => 'required',
        ]);

        $datas = $request->all();
        Review::create($datas);

        return redirect('/accueil_compte')->with('message', 'Votre soumission a bien été envoyée aux modérateurs ! Elle est désormais en attente et sera validée ou rejetée dans les plus brefs délais !');
    }

    public function form_review_medecin()
    {
        $user = Auth::User();
        $user_id = $user->id;

        User::where('id', $user_id)->update([
            'nb_reviews_waiting' => DB::raw('nb_reviews_waiting+1'),
        ]);

        $medecin_just_created = Medecin::all()->where('user_id', '=', $user_id)
            ->last();

        $placeholder_review = "Ecrivez ici...";

        return view('form.create_review_medecin', compact('user', 'medecin_just_created', 'placeholder_review'));
    }
}
