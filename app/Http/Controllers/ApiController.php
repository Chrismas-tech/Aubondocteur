<?php

namespace App\Http\Controllers;

use App\Medecin;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
}

/*  

      "column_20" => 125.4
      "column_21" => 232.9
      "type_dacte_realise" => "Acte technique"
      "tarif_2" => "250.8"
      "code_epci" => 200039915
      "nom" => "MARTINA LUCIANI"
      "nom_acte" => "Traitement des calculs du rein et des voies urinaires,"
      "nom_epci" => "CA Cannes Pays de Lérins"
      "adresse" => "CABINET DU DR MARTINA LUCIANI CLINIQUE DE L ESPERANCE 122 AVENUE DU DOCTEUR MAURICE DONAT  06250 MOUGINS"
      "column_9" => "MOUGINS"
      "nom_dep" => "ALPES-MARITIMES"
      "column_13" => "Libéral intégral"
      "libelle_profession" => "Anesthésiste réanimateur"
      "column_10" => "04.97.16.69.10"
      "column_17" => "JANM0020"
      "column_16" => "Lecteur de carte Sesam Vitale"
      "column_15" => "N"
      "column_14" => "Secteur 2, Pas de contrat d'accès aux soins"
      "column_19" => 232.9
      "column_18" => 210
      "coordonnees" => array:2 [▶]
      "insee_dep" => "06"
      "concat" => "MARTINA LUCIANICABINET DU DR MARTINA LUCIANI CLINIQUE DE L ESPERANCE 122 AVENUE DU DOCTEUR MAURICE DONAT  06250 MOUGINS"
      "tarif_1" => "250.8"
      "commune" => "Mougins"
      "column_11" => 3
      "tarif_base_de_remboursement_securite_sociale" => 250.8
      "civilite" => "Femme"
    ]
    "geometry" => array:2 [▶]
    "record_timestamp" => "2021-02-01T22:00:04.169000+00:00"
  ]
*/