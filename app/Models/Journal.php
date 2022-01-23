<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'value', 'date'];

    public function processedText() {

        $text = preg_replace_callback('#\(attachment:(.*)\)#i', function($match) {
            $attachment = Attachment::whereId($match[1])->first();
            return sprintf('<img src="/%s" width="600" />', $attachment->path);
        }, $this->text);


        $text = preg_replace('/#([a-zA-Z]+)/', '<a href="/journal?text=%23$1">#$1</a>', $text);

        return $text;

    }


    public static function getLongestStreak()
    {

        return self::streak('days');
    }

    public static function getCurrentStreak()
    {
        return self::streak();
    }

    private static function streak($orderByField = 'max_date')
    {
        // Ja, Query bauen ohne escapen, Hilfe!
        $streak = DB::select(sprintf('WITH groups AS (
    SELECT  RANK() OVER (ORDER BY date) AS row_number,
            date,
            date (date, "-" || RANK() OVER (ORDER BY date) || " days") AS date_group
            FROM journals
            group by date(date)
)

SELECT  COUNT(*) AS days,
        MIN (date) AS start,
        MAX (date) as max_date
FROM groups
GROUP BY date_group
ORDER BY %s DESC
LIMIT 1', $orderByField));

        if(empty($streak)) {
            return null;
        }

        return [
            'days' => $streak[0]->days,
            'start' => date('Y-m-d', strtotime($streak[0]->start)),
            'end' => date('Y-m-d', strtotime($streak[0]->max_date)),
        ];
    }
}
