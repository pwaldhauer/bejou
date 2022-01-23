


<x-layout>

    <dl class="stat-list mb-50">
        <div class="stat">
            <dt>Einträge</dt>
            <dd>{{ $count }}</dd>
        </div>
        <div class="stat">
            <dt>Erster Eintrag</dt>
            <dd>{{ $firstPost }}</dd>
        </div>
        <div class="stat">
            <dt>Längste Streak</dt>
            <dd>{{ $longestStreak['days'] }}
                <span class="small">({{ $longestStreak['start']  }} – {{ $longestStreak['end']  }})</span></dd>
        </div>

        <div class="stat">
            <dt>Bilder</dt>
            <dd>{{ $imageCount }}</dd>
        </div>

    </dl>

    <section class="calendar">
        <?php
        for($i = $endYear; $i >= $startYear; $i--):
        ?>

        <div class="calendar-year">
            <h2><?php echo $i ?></h2>

            <div class="months">

                <?php
                $maxMonth = $i === $endYear ? intval(date('m')) : 12;
                for($o = $maxMonth; $o >= 1; $o--):
                $firstDayOfMonth = date('w', strtotime(sprintf('%s-%02d-1', $i, $o)));
                $lastDayOfMonth = intval(date('t', strtotime(sprintf('%s-%02d-1', $i, $o))));



                ?>
                <div class="calendar-month">
                    <h3><?php echo strftime('%B', strtotime(sprintf('%s-%01d-1', $i, $o))) . ' ' . $i ?></h3>
                    <table class="month-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <?php for($j = 2 - $firstDayOfMonth; $j <= $lastDayOfMonth; $j++): ?>

                            <?php
                            $thisDay = sprintf('%s-%02d-%02d', $i, $o, $j);
                            $hasPosts = isset($postsPerDay[$thisDay]);
                            ?>

                            <td class="<?= $hasPosts ? 'has-post' : '' ?>"><?php echo $j > 0 ? '<a href="/journal?date='. $thisDay. '">'. $j . '.</a>' : '' ?></td>
                            <?php if($j !== 0 && ($j + $firstDayOfMonth - 1) % 7 === 0): ?></tr><tr> <?php endif ?>

                            <?php endfor ?>
                        </tr>

                    </table>
                </div>
                <?php
                endfor

                ?>
            </div>
        </div>
        <?php
        endfor;

        ?>
    </section>
</x-layout>
