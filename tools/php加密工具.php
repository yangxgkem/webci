
<?php

//参考文档：http://blog.snsgou.com/post-616.html

//返回随机字符串
function RandAbc($length = "")
{
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    return str_shuffle($str);
}

function encode_file_contents($filename, $output_file)
{
    $type = strtolower(substr(strrchr($filename,'.'),1));
    //如果是PHP文件 并且可写 则进行压缩编码
    if ('php' == $type && is_file($filename) && is_writable($filename))
    {
        $T_k1 = RandAbc(); //随机密匙1
        $T_k2 = RandAbc(); //随机密匙2
        $vstr = file_get_contents($filename);

        /*
        string base64_encode(string data);
        本函数将字符串以 MIME BASE64 编码。此编码方式可以让中文字或者图片也能在网络上顺利传输。
        在 BASE64 编码后的字符串只包含英文字母大小写、阿拉伯数字、加号与反斜线，共 64 个基本字符，
        不包含其它特殊的字符，因而才取名 BASE64。编码后的字符串比原来的字符串长度再加 1/3 左右。
        */
        $v1 = base64_encode($vstr);
        $c = strtr($v1, $T_k1, $T_k2); //根据密匙替换对应字符。
        $c = $T_k1.$T_k2.$c;
        $q1 = "O00O0O";
        $q2 = "O0O000";
        $q3 = "O0OO00";
        $q4 = "OO0O00";
        $q5 = "OO0000";
        $q6 = "O00OO0";

        $encode = '$'.$q6.'=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A");$'.$q1.'=$'.$q6.'{3}.$'.$q6.'{6}.$'.$q6.'{33}.$'.$q6.'{30};$'.$q3.'=$'.$q6.'{33}.$'.$q6.'{10}.$'.$q6.'{24}.$'.$q6.'{10}.$'.$q6.'{24};$'.$q4.'=$'.$q3.'{0}.$'.$q6.'{18}.$'.$q6.'{3}.$'.$q3.'{0}.$'.$q3.'{1}.$'.$q6.'{24};$'.$q5.'=$'.$q6.'{7}.$'.$q6.'{13};$'.$q1.'.=$'.$q6.'{22}.$'.$q6.'{36}.$'.$q6.'{29}.$'.$q6.'{26}.$'.$q6.'{30}.$'.$q6.'{32}.$'.$q6.'{35}.$'.$q6.'{26}.$'.$q6.'{30};eval($'.$q1.'("'.base64_encode('$'.$q2.'="'.$c.'";eval(\'?>\'.$'.$q1.'($'.$q3.'($'.$q4.'($'.$q2.',$'.$q5.'*2),$'.$q4.'($'.$q2.',$'.$q5.',$'.$q5.'),$'.$q4.'($'.$q2.',0,$'.$q5.'))));').'"));';
        $encode = '<?php '."\n".$encode."\n".' ?>';

        $write_num = file_put_contents($output_file, $encode);
        if ( ! $write_num OR $write_num <= 0)
        {
            echo "write encode code error:".$output_file;
            exit(0);
        }
        echo "compiling: ".$filename."\n";
        return TRUE;
    }
    else
    {
        copy($filename, $output_file);
    }
}


//增量式编译
function IncrementDumpAll($source_dir, $output_dir, $exclude, $dumplist)
{
    file_exists($output_dir) OR mkdir($output_dir, 0755, TRUE);
    $fp = opendir($source_dir);
    while (FALSE !== ($file = readdir($fp))) {
        if (is_dir($source_dir.$file) && $file[0] !== '.') {
            $out = $exclude[0];
            $is_exclude = FALSE;
            foreach ($exclude as $key => $value) {
                if($out.$value === $output_dir.$file) {
                    $is_exclude = TRUE;
                    break;
                }
            }
            if ( ! $is_exclude) {
                IncrementDumpAll($source_dir.$file.DIRECTORY_SEPARATOR, $output_dir.$file.DIRECTORY_SEPARATOR, $exclude, $dumplist);
            }
        }
        elseif ($file[0] !== '.') {
            $encode_file = $output_dir.$file;
            $file = $source_dir.$file;

            if(!empty($dumplist)) {
                $out = $exclude[0];
                $istrue = FALSE;
                foreach ($dumplist as $key => $value) {
                    if ($encode_file == $out.$value) {
                        if ( ! file_exists($encode_file)) {
                            encode_file_contents($file, $encode_file);
                        }
                        else {
                            $ft = filemtime($file);
                            $ed_ft = filemtime($encode_file);
                            if ($ed_ft > $ft) {
                                encode_file_contents($file, $encode_file);
                            }
                        }
                        $istrue = TRUE;
                        break;
                    }
                }
                if( ! $istrue) {
                    copy($file, $encode_file);
                }
            }
            
            if ( ! file_exists($encode_file)) {
                encode_file_contents($file, $encode_file);
            }
            else {
                $ft = filemtime($file);
                $ed_ft = filemtime($encode_file);
                if ($ed_ft > $ft) {
                    encode_file_contents($file, $encode_file);
                }
            }
        }
    }
}


//编译全部
function DumpAll($source_dir, $output_dir, $exclude, $dumplist = array())
{
    file_exists($output_dir) OR mkdir($output_dir, 0755, TRUE);
    $fp = opendir($source_dir);
    while (FALSE !== ($file = readdir($fp))) {
        if (is_dir($source_dir.$file) && $file[0] !== '.') {
            $out = $exclude[0];
            $is_exclude = FALSE;
            foreach ($exclude as $key => $value) {
                if($out.$value === $output_dir.$file) {
                    $is_exclude = TRUE;
                    break;
                }
            }
            if ( ! $is_exclude) {
                DumpAll($source_dir.$file.DIRECTORY_SEPARATOR, $output_dir.$file.DIRECTORY_SEPARATOR, $exclude, $dumplist);
            }
        }
        elseif ($file[0] !== '.')
        {
            $encode_file = $output_dir.$file;
            $file = $source_dir.$file;
            if(!empty($dumplist)) {
                $out = $exclude[0];
                $istrue = FALSE;
                foreach ($dumplist as $key => $value) {
                    if ($encode_file == $out.$value) {
                        encode_file_contents($file, $encode_file);
                        $istrue = TRUE;
                        break;
                    }
                }
                if( ! $istrue) {
                    copy($file, $encode_file);
                }
            }
            else {
                encode_file_contents($file, $encode_file);
            }  
        }
    }
}

//源目录
$source_dir = "../";
//加密存放目录
$output_dir = "trunk_encode/";
//忽略目录
$exclude = array($output_dir, "logs", "tools");
//指定加密文件,如果此数组不为空,则只加密选定文件,其他文件直接复制不加密
$dumplist = array("app/config/database.php","app/config/email.php");

DumpAll($source_dir, $output_dir, $exclude, $dumplist);