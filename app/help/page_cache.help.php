<?php
class help_page_cache extends help
{
    public static function set($content)
    {
        $key = empty($_SERVER['REQUEST_URI'])?'':md5($_SERVER['REQUEST_URI']);
        if(empty($key)){
            return false;
        }
        self::codeAnt()->memcache->set($key, $content);
    }

    public static function display()
    {
        $content = self::get();
        if($content!==false){
            die($content);
        }
    }

    public static function get()
    {
        $key = empty($_SERVER['REQUEST_URI'])?'':md5($_SERVER['REQUEST_URI']);
        if(empty($key)){
            return false;
        }
        $content = self::codeAnt()->memcache->get($key);
        if($content === false){
            header("X-CodeAnt-Page-Cache: MISS");
        }else{
            header("X-CodeAnt-Page-Cache: HIT");
        }
        return $content;
    }
    
    public static function isNeedPageCache($year, $month=0, $day=0)
    {
        if(empty($year)){
            return false;
        }
        $now = explode('-', date('Y-m-d'));
        if(!empty($month) && !empty($day)){
            $ts     = mktime(0, 0, 0, $month, $day, $year);
            $nts    = mktime(0, 0, 0, $now[1], $now[2], $now[0]);
            if($nts > $ts){
                return true;
            }else{
                return false;
            }
        }
        if(!empty($month)){
            $ts     = mktime(0, 0, 0, $month, 0, $year);
            $nts    = mktime(0, 0, 0, $now[1], 0, $now[0]);
            if($nts > $ts){
                return true;
            }else{
                return false;
            }
        }else{
            $ts     = mktime(0, 0, 0, 0, 0, $year);
            $nts    = mktime(0, 0, 0, 0, 0, $now[0]);
            if($nts > $ts){
                return true;
            }else{
                return false;
            }
        }
    }
}

?>
