<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{

    public function dashboard()
    {
        $onthisday = DB::table('journals')
            ->whereRaw('strftime("%m%d", date) == ?', date('md'))->get();

        $years = [];
        foreach ($onthisday as $journal) {
            $year = date('Y', strtotime($journal->date));
            if (!in_array($year, $years)) {
                $years[] = $year;
            }
        }

        rsort($years);

        $query = Journal::query();

        $params = [
            'journals' => $query->orderBy('date', 'DESC')->limit(100)->get(),
            'onthisdayCount' => count($onthisday),
            'onthisdayYears' => $years,
            'streak' => Journal::getCurrentStreak()
        ];

        return view('journal.dashboard', $params);
    }

    public function index(Request $request)
    {
        $filters = [];
        $query = Journal::query();

        if ($request->has('date')) {
            $filters[] = ['Datum', $request->get('date')];
            $query->whereRaw('strftime("%Y-%m-%d", date) = ?', $request->get('date'));
        }

        if ($request->has('text')) {
            $filters[] = ['Text', $request->get('text')];
            $query->whereRaw('text LIKE ?', '%' . $request->get('text') . '%');
        }

        $params = [
            'journals' => $query->orderBy('date', 'DESC')->limit(100)->get(),
            'filters' => $filters,
            'hasDateFilter' => $request->has('date') ? $request->get('date') : false,
            'otd' => [],
        ];

        if ($request->has('mode')) {
            $date = $request->get('date');
            $month = date('m-d',  strtotime($date));
            $year = date('Y', strtotime($date));

            $params['otd'] = [
                'date' => date('d.m.', strtotime($date)),
                'year' => $year,
            ];

            $prevQuery = Journal::query()
                ->whereRaw('strftime("%m-%d", date) = ?', $month)
                ->whereRaw('cast(strftime("%Y", date) as int) < ?', $year)
                ->orderBy('date', 'DESC')
                ->limit(1);

            if ($prevQuery->exists()) {
                $params['otd']['prevYear'] = date('Y-m-d', strtotime($prevQuery->get()->first()->date));
            }

            $nextQuery = Journal::query()
                ->whereRaw('strftime("%m-%d", date) = ?', $month)
                ->whereRaw('cast(strftime("%Y", date) as int) > ?', $year)
                ->orderBy('date', 'ASC')
                ->limit(1);

            if ($nextQuery->exists()) {
                $params['otd']['nextYear'] =  date('Y-m-d', strtotime($nextQuery->get()->first()->date));
            }
        }


        return view('journal.index', $params);
    }


    public function edit(string $id)
    {
        $journal = Journal::whereId($id)->firstOrFail();

        return view('journal.add.' . $journal->type, [
            'journal' => $journal,
            'type' => $journal->type,
            'subtype' => $journal->subtype,
            'date' => false,
        ]);
    }


    public function save(Request $request, string $id)
    {
        $journal = Journal::whereId($id)->firstOrFail();

        $params = $request->all(['text', 'value', 'date', 'delete']);

        if(isset($params['delete'])) {
            $journal->delete();
            return redirect('/');
        }


        $params['date'] = date('Y-m-d H:i:s', empty($params['date']) ? time() : strtotime($params['date']));


        $journal->fill($params);
        $journal->save();

        return redirect('/');
    }

    public function add(Request $request, string $type = null, string $subtype = null)
    {
        if ($type) {
            $config = config('bejou.presets', []);

            return view('journal.add.' . $type, [
                'journal' => null,
                'type' => $type,
                'subtype' => $subtype,
                'options' => $config[$type . (!empty($subtype) ? '/' . $subtype : '')] ?? [],
                'date' => $request->get('date', null)
            ]);
        }

        $types = [];
        foreach (config('bejou.presets', [
            [
                'label' => 'Text',
                'type' => 'text'
            ]
        ]) as $url => $item) {
            $types[] = [$item['label'], $url];
        }


        return view('journal.add', [
            'types' => $types,
            'date' => $request->get('date', null)
        ]);
    }

    public function create(Request $request, string $type, string $subtype = null)
    {
        $journal = new Journal();
        $journal->type = $type;
        if (!empty($subtype)) {
            $journal->subtype = $subtype;
        }

        $params = $request->all(['text', 'value', 'date']);

        $params['date'] = date('Y-m-d H:i:s', empty($params['date']) ? time() : strtotime($params['date']));

        $journal->fill($params);

        $journal->save();

        return redirect('/');
    }

    public function calendar()
    {
        if (Journal::count() == 0) {
            return view('journal.calendar-empty');
        }

        $firstDate = strtotime(Journal::query()->orderBy('date', 'ASC')->limit(1)->first()->date);

        $postsPerDay = array_reduce(Journal::all()->toArray(), function ($carry, $current) {
            $date = date('Y-m-d', strtotime($current['date']));

            if (empty($carry[$date])) {
                $carry[$date] = 0;
            }

            $carry[$date]++;

            return $carry;
        }, []);

        return view('journal.calendar', [
            'firstDate' => $firstDate,
            'startYear' => date('Y', $firstDate),
            'endYear' => date('Y'),
            'postsPerDay' => $postsPerDay,
            'count' => Journal::count(),
            'firstPost' => date('d.m.Y', $firstDate),

            'imageCount' => Attachment::count(),
            'longestStreak' => Journal::getLongestStreak()
        ]);
    }
}
