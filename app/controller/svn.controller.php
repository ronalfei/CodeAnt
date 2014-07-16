<?php

/**
 * svn简单操作类
 * Enter description here ...
 * @author ronalfei
 *
 */
class controller_svn extends controller
{
   
    /**
     * 手动执行svn 更新
     * Enter description here ...
     */
    public function action_up()
    {
        $dir = _ROOT;
        $cmd1 = ' export LANG="en_US.UTF-8" 2>&1 ;';
        $cmd2 = " cd {$dir} 2>&1 ;";
        $cmd3 = ' sudo svn up 2>&1;';
   
        passthru($cmd1.$cmd2.$cmd3);
        $result = ob_get_contents();
        $this->codeAnt->log->info($result);
        $log_file = "/tmp/svn.log";
        $time = date("Y-m-d H:i:s");
        file_put_contents($log_file, "\r\n-----svn up at {$time}-----\r\n{$result}------------------------------\r\n", FILE_APPEND);
    }

    /**
     * 手动svn 更新包下载
     * Enter description here ...
     */
    public function action_export()
    {
        $cmd1 = ' export LANG="en_US.UTF-8" 2>&1 ;';
        $cmd2 = 'sudo /opt/webapps/lelink/webtar.sh 2>&1 ; ';
        $tmpf = '/tmp/php.tar.gz';
        passthru($cmd1.$cmd2);
        ob_clean();
        $data = file_get_contents($tmpf);
        header('Content-Type : application/octet-stream');
        header('Content-Disposition: attachment; filename=php.tar.gz');
        echo $data;
    }


    public function action_log()
    {
        $log_file= _VAR_ROOT."svn.log";
        $data = file_get_contents($log_file);
        header("content-type:text/plain");
        echo $data;

    }


    /**
     * 打印phpinfo的信息
     * Enter description here ...
     */
    public function action_info()
    {
        var_dump(PHP_INT_MAX);
        echo "</br>",1347291010385434000,"</br>",9223372036854775807;
        phpinfo();
    }
}

?>
