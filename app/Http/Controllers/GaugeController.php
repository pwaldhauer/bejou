<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class GaugeController extends Controller
{

    public function index()
    {

        $gauges = DB::table('journals')
            ->select('subtype')
            ->where('type', 'gauge')
            ->groupBy('subtype')
            ->get();


        return view('gauge.index', [
            'gauges' => array_map(function ($g) {
                return $g->subtype;
            }, $gauges->toArray())
        ]);
    }

    public function view(string $subtype)
    {
        $all = Journal::query()
            ->where('type', 'gauge')
            ->where('subtype', $subtype)
            ->orderBy('date', 'DESC')->get();

        $chartData = [];
        foreach ($all as $g) {
            $chartData[] = [
                strtotime($g->date) * 1000,
                $g->value
            ];
        }

        return view('gauge.view', [
            'subtype' => $subtype,
            'all' => $all,
            'chartData' => $chartData,
        ]);
    }

}
