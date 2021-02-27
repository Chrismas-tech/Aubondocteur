<?php

namespace App\Http\Controllers;

use App\Medecin;
use App\MedecinOld;
use App\MedecinsOld;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use simple_html_dom;

include('SimpleHtmlDomController.php');

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function geo_gouv()
    {

        $medecins = Medecin::WhereNull('zip_code')->get();

        /*API GEOGOUV - find  gps_lat and gps_lng of each address */
        foreach ($medecins as $medecin) {

            if (!$medecin->zip_code) {

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

                if (!(empty($response["features"]))) {

                    $zip_code = ($response["features"][0]["properties"]["postcode"]);

                    $city = strtoupper($response["features"][0]["properties"]["city"]);

                    $new_address = ($response["features"][0]["properties"]["name"]);
                    $address = $new_address . ' ' . $city;

                    $medecin->city = $city;
                    $medecin->address = $address;
                    $medecin->zip_code = $zip_code;

                    //Latitude
                    //$medecin->gps_lat = $response["features"][0]["geometry"]["coordinates"][1];
                    //Longitude
                    //$medecin->gps_lng = $response["features"][0]["geometry"]["coordinates"][0];

                    $medecin->save();
                }
            }
        }

        return "FINISH";
    }


    public function page_opendatasoft()
    {
        return view('page_opendatasoft');
    }

    public function opendatasoft()
    {

        /* 1) On récupère les inputs */
        //$medecins = Medecin::where('city','NICE')->get();

        $query_speciality = "psychiatre";
        $query_city = "NICE";
        $query_speciality_without_spaces = strtr($query_speciality, ' ', "+");
        $query_city_without_spaces = strtr($query_city, ' ', "+");

        $final_query =  $query_speciality_without_spaces . "+" . $query_city_without_spaces;

        $final_query = "martin luciani";

        $url = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=medecins&q=" . $final_query . "&rows=5&facet=civilite&facet=column_12&facet=column_13&facet=column_14&facet=column_16&facet=libelle_profession&facet=type_dacte_realise&facet=commune&facet=nom_epci&facet=nom_dep&facet=nom_reg&facet=insee_reg&facet=insee_dep&facet=libelle_regroupement&facet=libelle&facet=libelle_acte_clinique";

        /*Create cURL resource*/
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);

        /*Close cURL resource*/
        curl_close($ch);
        $response = json_decode($response_json, true);

        dd($response['records']);

        /* POUR TOUS LES TABLEAUX FIELDS DE RECORD */
        foreach ($response['records'] as $field) {
            dd($field['fields']);

            $record_name = $field['fields']['nom'];
            $record_city = $field['fields']['column_9'];
            $record_address = $field['fields']['adresse'];
            $record_phone = $field['fields']['column_10'];
            $record_speciality = $field['fields']['libelle_profession'];

            /* GPS */
            $record_gps_lat = $field['fields']['coordonnees'][0];
            $record_gps_lng = $field['fields']['coordonnees'][1];

            $record_sector = $field['fields']['column_14'];
            $record_card_vitale = $field['fields']['column_16'];

            $record_libelle_regroupement = $field['fields']['libelle_regroupement'];
            $record_libelle_acte = $field['fields']['libelle'];
            $record_acte_clinique = $field['fields']['libelle_acte_clinique'];
            $record_type_acte_clinique = $field['fields']['libelle_acte_clinique'];
            $record_nom_acte = $field['fields']['nom_acte'];
        }
    }

    public function bdd_name()
    {
        $medecins = Medecin::all();
        $medecins_old = MedecinsOld::all();

        /* Pour tous les médecins de la nouvelle base de données */
        foreach ($medecins as $medecin) {

            $address = $medecin->address;
            $city = $medecin->city;

            foreach ($medecins_old as $medecin_old) {

                /* Dans l'ancienne base de donnée on recherche tous les médecins qui ont une adresse et une ville identique */
                if (($medecin_old->city == $city) && ($medecin_old->address == $address)) {

                    /* Si le nom de famille de l'ancienne base de donné est inclut dans la nouvelle base de donnée, on remplit les champs last et first name */

                    if (strpos($medecin->medecin_name, $medecin_old->medecin_last_name) == true) {

                        if ($medecin_old->email != "") {
                            $medecin->email = $medecin_old->email;
                            $medecin->save();
                        }
                    }
                }
            }
        }
    }

    public function inverse_name()
    {
        $medecins = Medecin::whereNull('medecin_last_name')->whereNull('medecin_first_name')->get();

        /* Pour tous les médecins de la nouvelle base de données */
        foreach ($medecins as $medecin) {

            $entire_name = $medecin->medecin_name;
            $pieces_entire_name = explode(" ", $entire_name);

            $medecin_real_first_name = $pieces_entire_name[0];
            $medecin_real_last_name = $pieces_entire_name[1];

            /* Si le nom et le prénom ne représentent que deux mots */
            if (count($pieces_entire_name) == 2) {

                $medecin->medecin_first_name = $medecin_real_first_name;
                $medecin->medecin_last_name = $medecin_real_last_name;
                $medecin->save();
            }
        }
    }

    public function count_name_null()
    {
        $medecins = Medecin::whereNull('medecin_last_name')->whereNull('medecin_first_name')->get();

        $nb = $medecins->count();
        return view('null', compact('nb'));
    }

    public function find_name()
    {
        $medecins = Medecin::whereNull('medecin_last_name')->whereNull('medecin_first_name')->where('medecin_name', 'like', 'MARIE PIERRE%')->get();

        dd($medecins);
        //$nb_result = [];

        foreach ($medecins as $medecin) {

            $entire_name = $medecin->medecin_name;
            $pieces_entire_name = explode(" ", $entire_name);

            if (count($pieces_entire_name) == 3) {

                //array_push($nb_result, $medecin->medecin_name);

                //$medecin_real_first_name_1 = $pieces_entire_name[0];
                //$medecin_real_first_name_2 = $pieces_entire_name[1];
                $medecin_real_last_name = $pieces_entire_name[1] . ' ' . $pieces_entire_name[2];
                $medecin_real_first_name = $pieces_entire_name[0];

                $medecin->medecin_name = $medecin_real_last_name . ' ' . $medecin_real_first_name;
                $medecin->medecin_first_name = $medecin_real_first_name;
                $medecin->medecin_last_name = $medecin_real_last_name;
                $medecin->save();
            }
        }
    }

    public function city_problem_tiret()
    {
        $cities = Medecin::select('city')->distinct()->get();

        foreach ($cities as $city) {

            //dd($city->city);

            /* Si la ville contient un tiret */
            if (strpos($city->city, '-') == true) {

                //dd($city->city);

                $this_city_without_tiret = str_replace('-', ' ', $city->city);
                //dd($this_city_without_tiret);

                $city_without_tiret = Medecin::where('city', $this_city_without_tiret)->get();

                /* Si la ville existe aussi sans tiret*/
                if (!$city_without_tiret->isEmpty()) {

                    foreach ($city_without_tiret as $city_w_t) {

                        //dd($city->city);
                        //dd($city_w_t->city);
                        $city_w_t->city = $city->city;
                        $city_w_t->save();
                    }
                }
            }
        }
    }

    public function search_web()
    {
        $query = 'nathalie fenioux gavard doctolib';

        /*On remplace tous les espaces par des +*/
        $query_without_spaces = strtr($query, ' ', "+");
        $url = "https://www.google.com/search?q=nathalie+fenioux+gavard";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($curl);
        curl_close($curl);

        $dom_results = new simple_html_dom();
        $dom_results->load($result);

        foreach ($dom_results->find('div.aCOpRe') as $link) {
            dd('yolo');
            dd($link->plaintext);
        }
    }
}
