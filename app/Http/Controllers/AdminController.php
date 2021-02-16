<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Experience;
use App\Medecin;
use App\Review;
use App\Speciality;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin', ['except' => array('page_connection')]);
    }

    public function admin_logout(Request $request)
    {
        $request->session()->forget('admin_name');
        $request->session()->forget('admin_password');

        return redirect('/');
    }

    public function verify_admin_connection() {
        return redirect('admin_dashboard');
    }

    public function page_connection()
    {
       return view('admin.page_connection');
    }

    public function admin_dashboard()
    {
        $nb_medecins_waiting = DB::table('medecins')->where('validation_status_medecin', '=', 3)->count();
        $nb_medecins_refused = DB::table('medecins')->where('validation_status_medecin', '=', 2)->count();
        $nb_medecins_validated = DB::table('medecins')->where('validation_status_medecin', '=', 1)->count();

        $count_nb_reviews_waiting = DB::table('users')->sum('nb_reviews_waiting');
        $count_nb_reviews_refused = DB::table('users')->sum('nb_reviews_refused');
        $count_nb_reviews_validated = DB::table('users')->sum('nb_reviews_validated');

        $nb_users = User::count();
        $users_all = User::paginate(20);

        return view('admin.admin_dashboard', compact('nb_users', 'count_nb_reviews_waiting', 'count_nb_reviews_refused', 'count_nb_reviews_validated', 'users_all', 'nb_medecins_waiting', 'nb_medecins_refused', 'nb_medecins_validated'));
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $reviews = Review::where('user_id', '=', $id);

        $users->delete();
        $reviews->delete();

        return redirect('admin');
    }

    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////

    // LISTER LES EXPERIENCES EN FONCTION DE LEURS STATUS

    public function gestionnaire()
    {
        //REVIEWS

        $review_status_validated = DB::table('reviews')->where('validation_status_review', '=', 1);
        $review_status_refused = DB::table('reviews')->where('validation_status_review', '=', 2);
        $review_status_waiting = DB::table('reviews')->where('validation_status_review', '=', 3);

        $review_count_validated = $review_status_validated->count();;
        $review_count_refused = $review_status_refused->count();;
        $review_count_waiting = $review_status_waiting->count();;

        //MEDECINS

        $medecin_status_validated = DB::table('medecins')->where('validation_status_medecin', '=', 1);
        $medecin_status_refused = DB::table('medecins')->where('validation_status_medecin', '=', 2);
        $medecin_status_waiting = DB::table('medecins')->where('validation_status_medecin', '=', 3);

        $medecin_count_validated = $medecin_status_validated->count();
        $medecin_count_refused = $medecin_status_refused->count();
        $medecin_count_waiting = $medecin_status_waiting->count();

        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

        return view('admin.gestionnaire', compact(
            'review_count_validated',
            'review_count_refused',
            'review_count_waiting',
            'medecin_count_validated',
            'medecin_count_refused',
            'medecin_count_waiting',
            'specialities'
        ));
    }

    //GESTIONNAIRE DE VALIDATION : CHANGEMENT DE STATUS DES REVIEWS OU DES MEDECINS
    //GESTIONNAIRE DE VALIDATION : CHANGEMENT DE STATUS DES REVIEWS OU DES MEDECINS 
    //GESTIONNAIRE DE VALIDATION : CHANGEMENT DE STATUS DES REVIEWS OU DES MEDECINS 
    //GESTIONNAIRE DE VALIDATION : CHANGEMENT DE STATUS DES REVIEWS OU DES MEDECINS 
    //GESTIONNAIRE DE VALIDATION : CHANGEMENT DE STATUS DES REVIEWS OU DES MEDECINS 

    public function gestionnaire_medecins_validated()
    {
        //MEDECIN
        $medecin_status_validated = DB::table('medecins')->where('validation_status_medecin', '=', 1)->paginate(50);
        $medecin_count_validated = $medecin_status_validated->count();

        return view('admin.gestionnaire_medecins_validated', compact(
            'medecin_count_validated',
            'medecin_status_validated'
        ));
    }

    public function gestionnaire_medecins_waiting()
    {
        //MEDECIN
        $medecin_status_waiting = DB::table('medecins')->where('validation_status_medecin', '=', 3)->paginate(50);
        $medecin_count_waiting = $medecin_status_waiting->count();

        return view('admin.gestionnaire_medecins_waiting', compact(
            'medecin_count_waiting',
            'medecin_status_waiting'
        ));
    }

    public function gestionnaire_medecins_refused()
    {
        //MEDECIN
        $medecin_status_refused = DB::table('medecins')->where('validation_status_medecin', '=', 2)->paginate(50);
        $medecin_count_refused = $medecin_status_refused->count();

        return view('admin.gestionnaire_medecins_refused', compact(
            'medecin_status_refused',
            'medecin_count_refused',
        ));
    }

    public function gestionnaire_reviews_validated()
    {
        //REVIEWS
        $review_status_validated = Review::orderBy('created_at', 'desc')->where('validation_status_review', '=', 1)->paginate(50);

        $review_count_validated = $review_status_validated->count();

        return view('admin.gestionnaire_reviews_validated', compact(
            'review_status_validated',
            'review_count_validated'
        ));
    }

    public function gestionnaire_reviews_waiting()
    {
        //REVIEWS
        $review_status_waiting = Review::orderBy('created_at', 'desc')->where('validation_status_review', '=', 3)->paginate(50);

        $review_count_waiting = $review_status_waiting->count();

        return view('admin.gestionnaire_reviews_waiting', compact(
            'review_count_waiting',
            'review_status_waiting'
        ));
    }

    public function gestionnaire_reviews_refused()
    {
        //REVIEWS
        $review_status_refused = Review::orderBy('created_at', 'desc')->where('validation_status_review', '=', 2)->paginate(50);

        $review_count_refused = $review_status_refused->count();

        return view('admin.gestionnaire_reviews_refused', compact(
            'review_count_refused',
            'review_status_refused'
        ));
    }



    //VALIDATION
    //VALIDATION
    //VALIDATION
    //VALIDATION
    //VALIDATION
    //VALIDATION



    // WAITING TO REFUSE OR VALIDATE
    // WAITING TO REFUSE OR VALIDATE
    // WAITING TO REFUSE OR VALIDATE
    // WAITING TO REFUSE OR VALIDATE
    // WAITING TO REFUSE OR VALIDATE

    // MEDECIN -> WAITING TO VALIDATE

    public function medecin_waiting_to_validate($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 1]);
        return redirect()->back()->with('message', 'Le médecin a bien été validé !');
    }

    // MEDECIN -> WAITING TO REFUSE

    public function medecin_waiting_to_refuse($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 2]);
        return redirect()->back()->with('message', 'Le médecin a bien été refusé !');
    }

    // REVIEW -> WAITING TO VALIDATE

    public function review_waiting_to_validate($review_id, $medecin_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_waiting' => DB::raw('nb_reviews_waiting-1'),
            'nb_reviews_validated' => DB::raw('nb_reviews_validated+1'),
        ]);

        Medecin::where('id', $medecin_id)->update([
            'nb_reviews' => DB::raw('nb_reviews+1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 1]);
        return redirect()->back()->with('message', 'Le commentaire a bien été validé !');
    }

    // REVIEW -> WAITING TO REFUSE

    public function review_waiting_to_refuse($review_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_waiting' => DB::raw('nb_reviews_waiting-1'),
            'nb_reviews_refused' => DB::raw('nb_reviews_refused+1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 2]);
        return redirect()->back()->with('message', 'Le commentaire a bien été refusé !');
    }

    // VALIDATE TO WAITING OR REFUSE
    // VALIDATE TO WAITING OR REFUSE
    // VALIDATE TO WAITING OR REFUSE
    // VALIDATE TO WAITING OR REFUSE
    // VALIDATE TO WAITING OR REFUSE

    // MEDECIN -> VALIDATE TO WAIT

    public function medecin_validate_to_waiting($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 3]);
        return redirect()->back()->with('message', 'Le médecin a bien été mis en attente !');
    }

    // MEDECIN -> VALIDATE TO REFUSE

    public function medecin_validate_to_refuse($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 2]);
        return redirect()->back()->with('message', 'Le médecin a bien été refusé !');
    }

    // REVIEW -> VALIDATE TO WAIT

    public function review_validate_to_waiting($review_id, $medecin_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_validated' => DB::raw('nb_reviews_validated-1'),
            'nb_reviews_waiting' => DB::raw('nb_reviews_waiting+1'),
        ]);

        Medecin::where('id', $medecin_id)->update([
            'nb_reviews' => DB::raw('nb_reviews-1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 3]);

        return redirect()->back()->with('message', 'Le commentaire a bien été mis en attente !');
    }

    // REVIEW -> VALIDATE TO REFUSE

    public function review_validate_to_refuse($review_id, $medecin_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_validated' => DB::raw('nb_reviews_validated-1'),
            'nb_reviews_refused' => DB::raw('nb_reviews_refused+1'),
        ]);

        Medecin::where('id', $medecin_id)->update([
            'nb_reviews' => DB::raw('nb_reviews-1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 2]);
        return redirect()->back()->with('message', 'Le commentaire a bien été refusé !');
    }


    // REFUSE TO VALIDATE OR WAITING
    // REFUSE TO VALIDATE OR WAITING
    // REFUSE TO VALIDATE OR WAITING
    // REFUSE TO VALIDATE OR WAITING
    // REFUSE TO VALIDATE OR WAITING


    // MEDECIN -> REFUSE TO VALIDATE

    public function medecin_refuse_to_validate($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 1]);
        return redirect()->back()->with('message', 'Le médecin a bien été validé !');
    }

    // MEDECIN -> REFUSE TO WAITING

    public function medecin_refuse_to_waiting($medecin_id)
    {
        Medecin::where('id', '=', $medecin_id)->update(['validation_status_medecin' => 3]);
        return redirect()->back()->with('message', 'Le médecin a bien été mis en attente !');
    }

    // REVIEW -> REFUSE TO VALIDATE

    public function review_refuse_to_validate($review_id, $medecin_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_refused' => DB::raw('nb_reviews_refused-1'),
            'nb_reviews_validated' => DB::raw('nb_reviews_validated+1'),
        ]);

        Medecin::where('id', $medecin_id)->update([
            'nb_reviews' => DB::raw('nb_reviews+1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 1]);
        return redirect()->back()->with('message', 'Le commentaire a bien été validé !');
    }

    // REVIEW -> REFUSE TO WAITING

    public function review_refuse_to_waiting($review_id, $user_id)
    {
        User::where('id', $user_id)->update([
            'nb_reviews_refused' => DB::raw('nb_reviews_refused-1'),
            'nb_reviews_waiting' => DB::raw('nb_reviews_waiting+1'),
        ]);

        Review::where('id', '=', $review_id)->update(['validation_status_review' => 3]);
        return redirect()->back()->with('message', 'Le commentaire a bien été mis en attente !');
    }

    //AJOUTER CREER UN MEDECIN - FORMULAIRE
    //AJOUTER CREER UN MEDECIN - FORMULAIRE
    //AJOUTER CREER UN MEDECIN - FORMULAIRE
    //AJOUTER CREER UN MEDECIN - FORMULAIRE
    //AJOUTER CREER UN MEDECIN - FORMULAIRE


    public function add_medecin_form()
    {
        $specialities = Speciality::all();
        return view('admin.add_medecin_form', compact('specialities'));
    }

    public function send_medecin_form(Request $request)
    {
        $request->validate([

            'medecin_first_name' => 'required|',
            'medecin_last_name' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'speciality' => 'required',
            'gps_lat' => 'required',
            'gps_lng' => 'required',
            'validation_status_medecin' => 'required',

        ]);

        $datas = $request->all();
        Medecin::create($datas);

        return redirect('/gestionnaire')->with('message', 'Le médecin a bien été rajouté à la base de donnée!');
    }
}
