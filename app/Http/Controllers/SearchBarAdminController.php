<?php

namespace App\Http\Controllers;

use App\City;
use App\Medecin;
use App\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchBarAdminController extends Controller
{
    public function search_bar_admin_page()
    {

        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();
        return view('admin.search_bar_gestionnaire', compact('specialities'));
    }

    public function search_city_admin_input(Request $request)
    {
        if ($request->ajax()) {

            $query = $request->get('query');
            $datas = City::select('name')
                ->where('name', 'LIKE', $query . '%')
                ->distinct()
                ->get();

            $result = '<div id="div_result_li_city"><ul class="list-unstyled">';

            foreach ($datas as $data) {
                $result .= '<li class="pl-1 li_city_result_admin">' . $data->name . '</li>';
            }

            $result .= '</ul></div>';

            return response()->json($result);
        }
    }

    public function search_name_admin_input(Request $request)
    {

        if ($request->ajax()) {

            $query = $request->get('query');

            $datas = DB::table('medecins')
                ->where('medecin_first_name', 'LIKE', $query . '%')
                ->orWhere('medecin_last_name', 'LIKE', $query . '%')
                ->get();

            $count_datas = count($datas);

            if ($count_datas == 0) {

                $result = '<div id="div_result_li_name"><h4 class="pl-2">Il n\'y a pas de résultat pour la recherche</h4></ul></div>';
            } else if ($count_datas == 1) {

                $result = '<div id="div_result_li_name"><h4 class="pl-2">Il y a 1 résultat pour la recherche "' . $query . '"</h4></ul></div>';
            } else if ($count_datas > 1) {

                $result = '<div id="div_result_li_name"><h4 class="pl-2">Il y a ' . $count_datas . ' résultats pour la recherche "' . $query . '"</h4></ul></div>';
            }

            $resultat = [$result, $count_datas];

            return response()->json($resultat);
        }
    }

    public function find_medecin_admin_1(Request $request)
    {
        $city = $request->city_input_admin;
        $speciality = $request->select_accueil_admin;

        $request->validate([
            'city_input_admin' => 'required|',
            'select_accueil_admin' => 'required|',
        ]);

        $medecins = DB::table('medecins')
            ->where('address', 'LIKE', '%' . $city . '%')
            ->where('speciality', '=', $speciality)->paginate(20);

        return view('admin.find_medecin_admin_1', compact('medecins', 'city', 'speciality'));
    }

    public function find_medecin_admin_2(Request $request)
    {

        $name = $request->first_or_last_name_input_admin;

        $request->validate([
            'first_or_last_name_input_admin' => 'required|',
        ]);

        $medecins = Medecin::where('medecin_first_name', 'LIKE', $name . '%')
            ->orWhere('medecin_last_name', 'LIKE', $name . '%')->paginate(20);


        return view('admin.find_medecin_admin_2', compact('medecins', 'name'));
    }

    public function form_medecin_admin($id)
    {
        $medecin = Medecin::find($id);

        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();
        return view('admin.form_medecin_admin', compact('medecin', 'specialities'));
    }

    public function update_medecin_admin(Request $request, $id)
    {
        $medecin = Medecin::find($id);
        $medecin->update($request->all());

        $modification_validee = 'La modification a bien été enregistrée !';
        $specialities = Speciality::orderBy('speciality_name', 'asc')->get();

        return view('admin.form_medecin_admin', compact('medecin', 'specialities', 'modification_validee'));
    }
}
