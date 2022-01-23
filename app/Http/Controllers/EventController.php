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

class EventController extends Controller
{
    public function index() {

        $events = DB::table('journals')
            ->select('subtype')
            ->where('type', 'event')
            ->groupBy('subtype')
            ->get();


        return view('event.index', [
            'events' => array_map(function($g) {
                return $g->subtype;
            }, $events->toArray())
        ]);
    }

    public function view(string $subtype) {


        $all = Journal::query()
            ->where('type', 'event')
            ->where('subtype', $subtype)
            ->orderBy('date', 'DESC')
            ->get();

        foreach($all as $i => $item) {
            $next = $all->has($i + 1) ? $all->get($i + 1) : null;
            if($next) {
                $item->diffToPrevious = Carbon::parse($item->date)->diffInDays(Carbon::parse($next->date));
            }
        }


        return view('event.view', [
            'subtype' => $subtype,
            'all' => $all,
        ]);
    }

}
