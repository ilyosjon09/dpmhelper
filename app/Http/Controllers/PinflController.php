<?php

namespace App\Http\Controllers;

use App\Models\Pinfl;
use Illuminate\Http\Request;

use function Psy\debug;

class PinflController extends Controller
{
    public function index(Request $request)
    {
        $regions  = [
            "ВИЛОЯТ",
            "АНДИЖОН ТУМАНИ",
            "АНДИЖОН ШАҲРИ",
            "АСАКА ТУМАН",
            "АСАКА ШАҲРИ",
            "БАЛИҚЧИ ТУМАН",
            "БУЛОҚБОШИ ТУМАНИ",
            "БЎЗ ТУМАНИ",
            "ЖАЛОЛҚУДУҚ ТУМАНИ",
            "ИЗБОСКАН ТУМАНИ",
            "ҚОРАСУВ ШАҲРИ",
            "ҚЎРҒОНТЕПА ТУМАНИ",
            "МАРХАМАТ ТУМАНИ",
            "ОЛТИНКЎЛ ТУМАН",
            "ПАХТАОБОД ТУМАНИ",
            "УЛУҒНОР ТУМАНИ",
            "ХОНОБОД ШАҲРИ",
            "ХЎЖАОБОД ТУМАНИ",
            "ШАХРИХОН ТУМАНИ",
            "ШАҲРИХОН ШАҲРИ",
        ];

        $region_filter = $request->query('region', 0) == 0 ? null : $regions[$request->query('region', 0)];
        $birth_date_filter = ["birth_date", "=", $request->query('birth_date', null)];
        $middle_name_filter = ["middlename_cyr", "like", '%' . $request->query('middle_name', '%')];
        $name_filter = ["name_cyr", "like", $request->query('name', '%') . "%"];
        $birth_place_filter = ["birth_place", '=', "АНДИЖОН ВИЛОЯТИ " . $region_filter];

        $filters = [];
        if (!$request->query('region') == 0) {
            array_push($filters, $birth_place_filter);
        }
        if (!is_null($birth_date_filter[2])) {
            array_push($filters, $birth_date_filter);
        }
        if (!is_null($request->query('name'))) {
            array_push($filters, $name_filter);
        }
        if (!is_null($request->query('middle_name'))) {
            array_push($filters, $middle_name_filter);
        }



        // dd($filters);
        $pinfls = Pinfl::select(
            [
                'id',
                'name_cyr',
                'surname_cyr',
                'middlename_cyr',
                'birth_date',
                'birth_place',
                'attached'
            ]
        )->where($filters)->paginate(50)->withQueryString();
        $attached_filters = [
            ['attached', '=', 1],
        ];
        if (!$request->query('region') == 0) {
            array_push($attached_filters, $birth_place_filter);
        }
        $attached = \DB::table('pinfls')
            ->where($attached_filters)->count();
        $request->flash();
        return view('pinfl.index', compact('pinfls', 'regions','attached'));
    }

    public function toggleAttached(Request $request)
    {
        $pinfl = Pinfl::findOrFail($request->input('id'));
        $pinfl->attached = $request->input('attached');
        $pinfl->save();

        return redirect('/');
    }
}
