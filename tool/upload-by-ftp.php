<?php
/*
大概原理

遍历项目中的所有非排除文件，然后获取文件修改时间晚于文件上一次修改时间的文件
然后将这些文件，通过ftp上传到对应的目录

*/
error_reporting(E_ALL);
//if ($_SERVER['SERVER_ADDR'])exit('can\'t run');//禁止在web服务器下运行
$_GET['exclude'] = array('number.txt','uploads','Zend','docs','cache','You','managesdk'); //排除上传目录,定义为全局变量
require(__DIR__.'/ftpclass.php');

$fileobj = new FilerFile();
$path = '/tmp/ftp-test/'; //项目目录的根目录
$files = $fileobj->Zip($path); //过滤出最新的修改文件
$path = str_replace("/tmp/ftp-test/","",$files);
//$path = str_replace("/data/longtu/","",$path);

$config = array(
        'hostname' => 'xxx.xxx.xx.xxx', //ftp服务器 地址
        'username' => 'xxx',            //ftp用户
        'password' => '?xxxxxxxxxxx', //ftp密码
        'port' => 21                    //端口
);

$ftp = new Ftp();
$ftp->connect($config);                //链接服务器
$a=$ftp->filelist();var_dump($a, $files);die;

$LOCAL_ROOT = realpath(dirname(__DIR__)."/../../");
chdir($LOCAL_ROOT);
foreach ($files as $k=>$v){
      $f = $path.$v;
      $tmp = $ftp->upload($f, $f);
      if($tmp){
        echo "upload $f -> success \n";
      }
}

//$ftp->download('ftp_upload.log','ftp_download.log');
//



//$ftp->upload('ftp_err.log','ftp_upload.log');
//$ftp->download('ftp_upload.log','ftp_download.log');




/*
 *
 *  $dir = "/test";
    if(@ftp_chdir($conn, $dir))

     判断是否为文件夹
 * Enter description here ...
 * @author Administrator
 *
 */

class FilerFile
{
    var $time_path;
    private $fctimes = array();

    function Zip($dir)
    {
        $this->time_path = rtrim($dir,"/")."/.~~~time.php";
        //@unlink($this->time_path);
        $filelist = $this -> GetFileList($dir);
        file_put_contents($this->time_path,"<?php \n return ".var_export($this->fctimes,true).";");
        return $filelist;
    }

    function appendFilectime($file)
    {
        $time_file_path = $this->time_path;
        $ftime = @include($time_file_path);
        $ftime = $ftime ? $ftime : array();
        $time = filectime($file);
        if(!file_exists($time_file_path))file_put_contents($time_file_path,"<?php \n");

    }
    function getFileByFilectime($file)
    {
        static $time_data ;
        $time_file_path = $this->time_path;
        if (!$time_data){
            $time_data= @include_once($time_file_path);
        }
        $time_data = $time_data ? $time_data : array();
        //var_dump($file,$time_data[$file] == filectime($file));
        //echo $file."\t".$time_data[$file]."\n";
        if ($time_data[$file] == filemtime($file)){
            return false;
        }else{
            return $file;
        }
    }


    function GetFileList($dir,$path="")
    {
        static $tmpp = "";
        if ($path=="" && !$tmpp){
            $tmpp = $dir;
        }
        $d = dir($dir);
        $files = array();
        if ($d)
        {
            $pathP=str_replace($tmpp,"",$dir);
            $pathP=str_replace(array("\\\\","/"),DIRECTORY_SEPARATOR,$pathP);
            $pathP=str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR,$pathP);

            while($f = $d->read())
            {
                if ($f == '.' || $f=='..' || $f{0}=='.' || $f=='Zend' || in_array($f, $_GET['exclude']))continue;
                $newdir = rtrim($dir,"/")."/".$f;
                if (is_dir($newdir)){
                    $files = array_merge($files,$this->GetFileList($newdir,$newdir));
                }else{
                    $abspath_file = (rtrim($dir,"/") ? rtrim($dir,"/")."/" : "").$f;
                    $this->fctimes[$abspath_file] = filemtime($abspath_file);
                    if (!$this->getFileByFilectime($abspath_file))continue;
                    $file = (rtrim($pathP,"/") ? rtrim($pathP,"/")."/" : "").$f;
                    $files[] = $file;

                }
            }
        }

        return $files;
    }
}

/*End of file ftp.php*/
/*Location /Apache Group/htdocs/ftp.php*/


