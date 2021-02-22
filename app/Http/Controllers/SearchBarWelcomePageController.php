<?php

namespace App\Http\Controllers;

use App\Medecin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchBarWelcomePageController extends Controller
{
    public function autocomplete_search(Request $request)
    {

        if ($request->ajax()) {

            $query = $request->get('query');

            $datas = DB::table('medecins')
                ->select('city')->distinct()
                ->orderBy('city')
                ->where('city', 'LIKE', $query . '%')
                ->OrWhere('zip_code', 'LIKE', $query . '%')
                ->get();

            if ($datas->isEmpty()) {

                $output = '';
            } else {

                $output = '<div class="bg-white pt-3 pl-3 city_search_result"><ul class="list-unstyled p-0 m-0"><li><h5 class="text-primary media_li_result_font">Choisissez une ville parmi les résultats</h5></li>';

                foreach ($datas as $data) {
                    $output .= '<li><p class="p_result media_li_result_font">' . $data->city . '</p></li>';
                }

                $output .= '</ul></div>';
            }
            return $output;
        }
    }
}
