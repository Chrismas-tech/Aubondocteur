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
        $specialities = Speciality::orderBy('speciality', 'asc')->get();

        foreach($specialities as $speciality) {
            if($speciality->speciality) {

            }
        }

        $count_medecins = -1;
        return view('accueil', compact('specialities', 'count_medecins'));
    }

    public function liste_medecins(Request $request)
    {

        /*VALIDATION FORMULAIRE*/
        $request->validate([
            'select_accueil' => 'required|',
            'input_search_accueil' => 'required|',
        ]);

        /* NOM DE LA VILLE EN MAJUSCULE POUR COMPARER AVEC COLONNE CITY DE LA BDD */
        $city_uppercase = strtoupper($request->input_search_accueil);

        $result_speciality = $request->select_accueil;
        $result_city = $request->input_search_accueil;

        /* LE NOM DE LA VILLE AVEC UNE SEULE MAJUSCULE POUR RENVOYER A LA VUE */
        $result_city = ucfirst($result_city);

        /* ON DEMANDE TOUS LES MEDECINS VALIDES PAR L'ADMIN CORRESPONDANT A LA SPECIALITE DE L'UTILISATEUR ET A LA VILLE CHOISIE */

        $medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('city', 'LIKE', $city_uppercase . '%')
            ->where('validation_status_medecin', '=', 1)
            ->orderBy('medecin_last_name', 'asc')
            ->paginate(25);

        $nb_medecins = Medecin::where('speciality', '=', $result_speciality)
            ->where('city', 'LIKE', $city_uppercase . '%')
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

                /*SI LA LATITUDE ET LA LONGITUDE N'EXISTENT PAS SUR LA BDD, ON lES ENREGISTRE */

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
