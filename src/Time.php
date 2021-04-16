<?php


namespace guoguo882010;


class Time
{
    /**
     * 返回今日开始和结束的时间戳
     *
     * @return array
     */
    public static function today()
    {
        return [
            mktime(0, 0, 0, date('m'), date('d'), date('Y')),
            mktime(23, 59, 59, date('m'), date('d'), date('Y'))
        ];
    }

    /**
     * 返回明天开始和结束的时间戳
     *
     * @return array
     */
    public static function tomorrow()
    {
        $start = strtotime(date('Y-m-d 0:0:0',strtotime("+1 days")));
        $end = $start + 86400 - 1; //-1秒
        return [$start,$end];
    }

    /**
     * 返回后天开始和结束的时间戳
     *
     * @return array
     */
    public static function dayAfterTomorrow()
    {
        $start = strtotime(date('Y-m-d 0:0:0',strtotime("+2 days")));
        $end = $start + 86400 - 1; //-1秒
        return [$start,$end];
    }

    /**
     * 返回昨日开始和结束的时间戳
     *
     * @return array
     */
    public static function yesterday()
    {
        $yesterday = date('d') - 1;
        return [
            mktime(0, 0, 0, date('m'), $yesterday, date('Y')),
            mktime(23, 59, 59, date('m'), $yesterday, date('Y'))
        ];
    }

    /**
     * 返回本周开始和结束的时间戳
     *
     * @return array
     */
    public static function week()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("+0 week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("+0 week Sunday", $timestamp))) + 24 * 3600 - 1
        ];
    }

    /**
     * 返回上周开始和结束的时间戳
     *
     * @return array
     */
    public static function lastWeek()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("last week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("last week Sunday", $timestamp))) + 24 * 3600 - 1
        ];
    }

    /**
     * 返回下周开始和结束的时间戳
     *
     * @return array
     */
    public static function nextWeek()
    {
        $start = strtotime(date('Y-m-d 0:0:0',strtotime("next week")));
        $end = $start + 604800;
        return [$start,$end];
    }

    /**
     * 返回本月开始和结束的时间戳
     *
     * @return array
     */
    public static function month($everyDay = false)
    {
        return [
            mktime(0, 0, 0, date('m'), 1, date('Y')),
            mktime(23, 59, 59, date('m'), date('t'), date('Y'))
        ];
    }

    /**
     * 返回上个月（环比）开始和结束的时间戳
     *
     * @return array
     */
    public static function lastMonth()
    {
        $begin = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
        $end = mktime(23, 59, 59, date('m') - 1, date('t', $begin), date('Y'));

        return [$begin, $end];
    }

    /**
     * 返回上个月得1号到上个月的今天时间戳
     * 例如：今天是3月15号，那么返回2月1号到2月15号时间戳
     *
     * @return array
     */
    public static function lastMonth1ToToday()
    {
        $start = mktime(0, 0, 0, date("n")-1, 1);
        $end = self::lastMonthToday();
        return [$start,$end];
    }

    /**
     * 返回上个月得今天时间戳
     *
     * @return int
     */
    public static function lastMonthToday()
    {
        $time = strtotime(date("Y-m-d"));
        $last_month_time = mktime(date("G", $time), date("i", $time),
            date("s", $time), date("n", $time), 0, date("Y", $time));
        $last_month_t =  date("t", $last_month_time);
        if ($last_month_t < date("j", $time)) {
            return date("Y-m-t H:i:s", $last_month_time);
        }
        return strtotime(date(date("Y-m", $last_month_time) . "-d" . '23:59:59', $time));
    }

    /**
     * 返回下月开始和结束时间戳
     *
     * @return array
     */
    public static function nextMonth()
    {
        $begin = mktime(0, 0, 0, date("n")+1, 1);
        $end = mktime(23, 59, 59, date("n")+1, date("t",$begin));

        return [$begin,$end];
    }

    /**
     * 返回今年开始和结束的时间戳
     *
     * @return array
     */
    public static function year()
    {
        return [
            mktime(0, 0, 0, 1, 1, date('Y')),
            mktime(23, 59, 59, 12, 31, date('Y'))
        ];
    }

    /**
     * 返回去年开始和结束的时间戳
     *
     * @return array
     */
    public static function lastYear()
    {
        $year = date('Y') - 1;
        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year)
        ];
    }

    /**
     * 获取几天前零点到现在/昨日结束的时间戳
     *
     * @param int $day 天数
     * @param bool $now 返回现在或者昨天结束时间戳
     * @return array
     */
    public static function dayToNow($day = 1, $now = true)
    {
        $end = time();
        if (!$now) {
            list($foo, $end) = self::yesterday();
        }

        return [
            mktime(0, 0, 0, date('m'), date('d') - $day, date('Y')),
            $end
        ];
    }

    /**
     * 返回几天前的时间戳
     *
     * @param int $day
     * @return int
     */
    public static function daysAgo($day = 1)
    {
        $nowTime = time();
        return $nowTime - self::daysToSecond($day);
    }

    /**
     * 返回几天后的时间戳
     *
     * @param int $day
     * @return int
     */
    public static function daysAfter($day = 1)
    {
        $nowTime = time();
        return $nowTime + self::daysToSecond($day);
    }

    /**
     * 天数转换成秒数
     *
     * @param int $day
     * @return int
     */
    public static function daysToSecond($day = 1)
    {
        return $day * 86400;
    }

    /**
     * 周数转换成秒数
     *
     * @param int $week
     * @return int
     */
    public static function weekToSecond($week = 1)
    {
        return self::daysToSecond() * 7 * $week;
    }

    /**
     * 给定一个日期（例：2021-02-13）返回这个日期的开始-结束时间戳
     *
     * @param $date
     * @return array
     */
    public static function dateToTimestamp($date)
    {
        return [
            strtotime($date.' 0:0:0'),
            strtotime($date.' 08:00:00')
        ];
    }
}