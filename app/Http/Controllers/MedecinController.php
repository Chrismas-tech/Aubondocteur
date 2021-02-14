<?php

namespace App\Http\Controllers;

use App\City;
use App\Medecin;
use App\Review;
use App\Speciality;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedecinController extends Controller
{
    public function index()
    {
        $count_medecins = -1;
        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();
        return view('accueil', compact('specialities', 'count_medecins'));
    }

    public function liste_medecins(Request $request)
    {

        /*VALIDATION FORMULAIRE*/
        /*VALIDATION FORMULAIRE*/
        /*VALIDATION FORMULAIRE*/

        $request->validate([
            'select_accueil' => 'required|',
            'input_search_accueil' => 'required|',
        ]);

        /*Nom de la ville en majusucule car l'adresse BDD est en Uppercase*/
        $city_uppercase = strtoupper($request->input_search_accueil);

        $result_speciality = $request->select_accueil;
        $result_city = $request->input_search_accueil;

        $result_city = ucfirst($result_city);

        $medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('address', 'LIKE', '%' . $city_uppercase . '%')
            ->where('validation_status_medecin', '=', 1)
            ->orderBy('medecin_last_name', 'asc')
            ->paginate(5);


        $nb_medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('address', 'LIKE', '%' . $city_uppercase . '%')
            ->where('validation_status_medecin', '=', 1)->get();


        if ($medecins->isEmpty()) {

            $count_medecins = count($medecins);
            $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

            return view('accueil', compact('specialities', 'medecins', 'result_speciality', 'result_city', 'count_medecins'));
        } else {

            /*API GEOGOUV - find  gps_lat and gps_lng of each address */
            $gps = [];
            foreach ($medecins as $medecin) {

                /*Problème : en intégrant le CSV dans la BDD en SQL, on effectuait un retour à la ligne automatique à l'intérieur de la variable se trouvait un "\r" qu'il faut éliminer ici car je ne sais pas le faire de l'extérieur !*/

                if ($medecin->email == "\r") {
                    $medecin->email = "";
                    $medecin->save;
                }

                /*Si la latitude et la longitude n'existe pas en BDD, on les enregistre */

                if ($medecin->gps_lat == 0.0000000000 || $medecin->gps_lng == 0.0000000000) {

                    $address_with_spaces = $medecin->address;

                    /*On remplace tous les espaces par des +*/
                    $address_without_spaces = strtr($address_with_spaces, ' ', "+");
                    $url = "https://api-adresse.data.gouv.fr/search/?q=" . $address_without_spaces;

                    /*Create cURL resource*/
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPGET, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response_json = curl_exec($ch);

                    /*Close cURL resource*/
                    curl_close($ch);

                    $response = json_decode($response_json, true);

                    /*Saving the gps_coord and if they exist*/

                    if ($response["features"]) {

                        //Latitude
                        $medecin->gps_lat = $response["features"][0]["geometry"]["coordinates"][1];
                        //Longitude
                        $medecin->gps_lng = $response["features"][0]["geometry"]["coordinates"][0];

                        $medecin->save();
                    }
                }
            }


            $count_medecins = count($nb_medecins);
            $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

            return view('liste_medecins', compact('specialities', 'medecins', 'result_speciality', 'result_city', 'count_medecins'));
        }
    }

    public function store_medecin(Request $request)
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
            'user_id' => 'required',
        ]);

        /* CAPITALIZE FIRST AND LAST NAME */

        $datas = $request->all();
        $datas["medecin_first_name"] = strtoupper($request->medecin_first_name);
        $datas["medecin_last_name"] = strtoupper($request->medecin_last_name);

        Medecin::create($datas);

        return redirect('/form_review_medecin');
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

        return redirect('/compte')->with('message', 'Votre soumission a bien été envoyée aux modérateurs ! Elle est désormais en attente et sera validée ou rejetée dans les plus brefs délais !');
    }

    public function bac_a_sable()
    {
        $medecins = Medecin::paginate(2);
        return view('bac_a_sable', compact('medecins'));
    }

    public function back_to_liste_medecins($city, $speciality)
    {

        /*Nom de la ville en majusucule car l'adresse BDD est en Uppercase*/
        $city_uppercase = strtoupper($city);
        //  dd($city);
        // dd($speciality);

        /*VALIDATION FORMULAIRE*/

        $result_speciality = $speciality;
        $result_city = $city;

        $result_city = ucfirst($result_city);

        $medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('address', 'LIKE', '%' . $city_uppercase . '%')
            ->where('validation_status_medecin', '=', 1)
            ->orderBy('medecin_last_name', 'asc')->paginate(5);

        $nb_medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('address', 'LIKE', '%' . $city_uppercase . '%')
            ->where('validation_status_medecin', '=', 1)->get();

        if ($medecins->isEmpty()) {

            $count_medecins = count($medecins);
            $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

            return view('accueil', compact('specialities', 'medecins', 'result_speciality', 'result_city', 'count_medecins'));
        } else {

            $count_medecins = count($nb_medecins);
            $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

            return view('liste_medecins', compact('specialities', 'medecins', 'result_speciality', 'result_city', 'count_medecins'));
        }
    }
}
