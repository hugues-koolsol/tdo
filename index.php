<?php
define('BNF',basename( __FILE__ ));
define('CRLF',"\r\n");
define('PGMK' , 'tdo_install'); // program key = app key
session_start();
//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='unsetSession'){
 unset($_SESSION[PGMK]);
 header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Unset session OK'));
 exit();
}
//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step1'){
 $_SESSION[PGMK]['step']=1;
 $_SESSION[PGMK]['appkey']=$_POST['appkey'];
 $err=0;
 if($err==0){
  if(strlen($_POST['appkey'])!=3){
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' the application key must contain 3 characters in the range a-z'));
   exit();
  }  
 }
 if($err==0){
  for($i=0;$i<3;$i++){
   $c=substr($_POST['appkey'],$i,1);
    
   if(!($c>='a' && $c <='z')){
    $err=1;
   }
  }
  if($err==1){
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' the application key must contain 3 characters in the range a-z'));
   exit();
  }
  if($_POST['appkey']=='tdo' || $_POST['appkey']=='old' || $_POST['appkey']=='inc' || $_POST['appkey']=='css' || $_POST['appkey']=='img' ){
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' this application key is reserved'));
   exit();   
  }
 }
 if($err==0){
  $dbLink=mysqli_connect($_POST['server'],$_POST['user'],$_POST['password']);
  if(!$dbLink){
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
   exit();   
  }else{
   mysqli_set_charset( $dbLink , 'utf8mb4' );
   $_SESSION[PGMK]['server']=$_POST['server'];
   $_SESSION[PGMK]['user']=$_POST['user'];
   $_SESSION[PGMK]['password']=$_POST['password'];
  }
 }
 
 if($_POST['database']!=''){
  $_SESSION[PGMK]['database']=$_POST['database'];
  $dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password'],$_POST['database']);
  if(!$dbLink){
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the database "'.$_POST['database'].'" ') );
   exit();   
  }
  $sql59='SHOW TABLES LIKE \''.$_SESSION[PGMK]['appkey'].'\\_tbl\\_%\'';  
  if(!($result=mysqli_query($dbLink,$sql59))){
   $err=1;
   header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot check the system tables' ) );
   exit();
  }
  $data0=array();
  while($mpsr59=mysqli_fetch_row($result59)){
   $data0[]=array(
   'table_name' =>$mpsr6[0],
   );
  }
  if(count($data0)!=0){
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' some system tables like '.$_SESSION[PGMK]['appkey'].'_tbl_% already exist in the database "'.$_POST['database'].'" ') );   
   exit();
  }
 }else{
  $_SESSION[PGMK]['database']=$_POST['appkey'];  
 }
 
 if($err==0){
  if($_POST['database']!=''){
   $_SESSION[PGMK]['step']=3;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Connection OK and database "'.$_POST['database'].'" already exists,').'<br />'.urlencode(__LINE__ . '  skipping step 2'));
   exit();
  }else{
   $_SESSION[PGMK]['step']=2;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Connection OK'));
   exit();
  }
 }else{
  header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Connection KO'));
  exit();
 } 
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step2'){
// echo __FILE__ . ' ' . __LINE__ . ' __LINE__ = <pre>' . var_export( __LINE__ , true ) . '</pre>' ; exit(0);
 $err=0;
 if($err==0){
//  echo __FILE__ . ' ' . __LINE__ . ' __LINE__ = <pre>' . var_export( $_SESSION , true ) . '</pre>' ; exit(0);
  $dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password']);
  if(!$dbLink){
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
   exit();
  }else{
   mysqli_set_charset( $dbLink , 'utf8mb4' );
   $sql='CREATE DATABASE `'.$_SESSION[PGMK]['appkey'].'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
   $res6=@mysqli_query($dbLink,$sql);
   if(mysqli_errno($dbLink)==0){
    $_SESSION[PGMK]['step']=3;
   }else{
    $err=1;
    header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot create the database' . mysqli_error($dbLink) ) );
    exit();
   }
  }
 } 
 header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Database created OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step3'){
// echo __FILE__ . ' ' . __LINE__ . ' __LINE__ = <pre>' . var_export( __LINE__ , true ) . '</pre>' ; exit(0);
 $dbName=$_SESSION[PGMK]['database'];
 $err=0;
 if($err==0){
  
  $toReplace=file_get_contents('sql__data.php');
  $toReplace=str_replace('tdo',$_SESSION[PGMK]['appkey'],$toReplace);
  file_put_contents('sql__data.php',$toReplace);
  
  
  $toReplace=file_get_contents('sql__structure.php');
  $toReplace=str_replace('tdo',$_SESSION[PGMK]['appkey'],$toReplace);
  file_put_contents('sql__structure.php',$toReplace);
  
  $dir = opendir('.'); 
  while(false!==($file=readdir($dir)) ) {
   if(($file != '.') && ( $file != '..' )  && ( $file != 'index.php' ) && ( $file != 'tdo.zip' ) ) { 
    if(!is_dir($file) ) { 
     $toReplace=file_get_contents($file );
     $toReplace=str_replace('tdo',$_SESSION[PGMK]['appkey'],$toReplace);
     file_put_contents($file,$toReplace);
    } 
   } 
  } 
  closedir($dir); 
  
  $zip_file_name='tdo.zip';
  $za = new FlxZipArchive;
  $res = $za->open($zip_file_name, ZipArchive::CREATE);
  if($res===TRUE){
   $ret=$za->extractTo('./');
   $za->close();
   if($ret===false){
    $err=1;
    header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot unzip tdo.zip' ) );
    exit();
   }else{
    if($_SESSION[PGMK]['appkey']!='tdo'){
     $arrRen=array('www','inc','_no_version_control','cron');
     foreach( $arrRen as $k1 => $v1){
      if(!rename ( 'tdo_'.$v1 , $_SESSION[PGMK]['appkey'].'_'.$v1)){
       $err=1;
       header("HTTP/1.1 303 See Other");
       header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot rename ' . $v1 ) );
       exit();
      }
     }
    }
    if($err==0){
     foreach( $arrRen as $k1 => $v1){
      recurse_replaceContent($_SESSION[PGMK]['appkey'].'_'.$v1,'t'.'do',$_SESSION[PGMK]['appkey']);
     }
     // replace db connexion parameters
     $newParam='<'.'?php'."\r\n"; // ,,
     $newParam.='$GLOBALS[\'glob_db\'][0][\'server\']   =\''.$_SESSION[PGMK]['server']   .'\';'."\r\n"; 
     $newParam.='$GLOBALS[\'glob_db\'][0][\'user\']     =\''.$_SESSION[PGMK]['user']     .'\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][0][\'password\'] =\''.$_SESSION[PGMK]['password'] .'\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][0][\'dbname\']   =\''.$dbName .'\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][0][\'setname\']  =\'utf8mb4\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][0][\'link\']     =null;'."\r\n\r\n\r\n";
     $newParam.='/*'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][1][\'server\']   =\'other_or_same_server\';'."\r\n"; 
     $newParam.='$GLOBALS[\'glob_db\'][1][\'user\']     =\'other_or_same_user\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][1][\'password\'] =\'other_or_same_password\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][1][\'dbname\']   =\'other_or_same_dbname\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][1][\'setname\']  =\'utf8mb4\';'."\r\n";
     $newParam.='$GLOBALS[\'glob_db\'][1][\'link\']     =null;';
     $newParam.='*/'."\r\n";
     if($fdparam=fopen($_SESSION[PGMK]['appkey'].'__no_version_control/__dbaccess.php','w')){
      fwrite($fdparam,$newParam);
      fclose($fdparam);
     }
    }
    $_SESSION[PGMK]['step']=4;    
   }
  }else{
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot open tdo.zip' ) );
   exit();
  }
 }
 header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Files unzipped OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step4'){
 include('sql__structure.php');
 $_SESSION[PGMK]['step']=5; 
 header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' Tables created OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step5'){
 include('sql__data.php');
 $_SESSION[PGMK]['step']=6; 
 header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?message='.urlencode(__LINE__ . ' data insert OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step6'){
 // replace some variables in za_inc & zz_maintenance
 $secretKeyForMaintenance=buildPassword(10);  
 $tabFiles=array('za_inc.php','zz_maintenance.php');
 foreach( $tabFiles as $k0 => $v0){
  $arrFileInc=array();
  $arrFileInc=file($_SESSION[PGMK]['appkey'].'_www/'.$v0);
  foreach($arrFileInc as $k1 => $v1){
   
   if(substr($v1,0,39)=='$GLOBALS[\'glob_incPathAreInSubFolders\']'){
    if(isset($_POST['incPathUnderRoot']) && $_POST['incPathUnderRoot']=='on'){
     $arrFileInc[$k1]='$GLOBALS[\'glob_incPathAreInSubFolders\']=true;'.CRLF;
    }else{
     $arrFileInc[$k1]='$GLOBALS[\'glob_incPathAreInSubFolders\']=false;'.CRLF;      
    }
   }
   
   if(substr($v1,0,35)=='define(\'SECRET_KEY_FOR_MAINTENANCE\''){
    $arrFileInc[$k1]='define(\'SECRET_KEY_FOR_MAINTENANCE\','.var_export($secretKeyForMaintenance,true).');'.CRLF;
   }
   
   
  }
  if($fdincphp=fopen($_SESSION[PGMK]['appkey'].'_www/'.$v0,'w')){ 
   foreach($arrFileInc as $k1 => $v1){
    fwrite($fdincphp, $v1 ); 
   }
   fclose($fdincphp); 
  }
 }
 if(isset($_POST['incPathUnderRoot']) && $_POST['incPathUnderRoot']=='on'){
  rename($_SESSION[PGMK]['appkey'].'__no_version_control' , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'__no_version_control'  );
  rename($_SESSION[PGMK]['appkey'].'_cron'                , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_cron'                 );
  rename($_SESSION[PGMK]['appkey'].'_data'                , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_data'                 );
  rename($_SESSION[PGMK]['appkey'].'_inc'                 , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_inc'                  );
 }
 
 $newAppKey=$_SESSION[PGMK]['appkey'];
 @unlink('tdo.zip');
 @unlink('sql__structure.php');
 @unlink('sql__data.php'); 
 @unlink('README.md'); 
 
 $dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password']);
 if(!$dbLink){
  $err=1;
  header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
  exit();
 }else{
  mysqli_set_charset( $dbLink , 'utf8mb4' );
  $rootPassword='root'.mt_rand(100,999); // option : use function buildPassword();
  $optionsHash = array('cost'=>12);
  $passWordHash=password_hash($rootPassword, PASSWORD_BCRYPT, $optionsHash);
  $sql='UPDATE `'.$_SESSION[PGMK]['database'].'`.`'.$_SESSION[PGMK]['appkey'].'_tbl__users` SET `fld_password_users` = \''.addslashes($passWordHash).'\' WHERE `fld_id_users` = 1 ';
  $res6=@mysqli_query($dbLink,$sql);
  if(mysqli_errno($dbLink)==0){
   unlink('index.php');
   $newParam='<'.'?php'."\r\n"; // ,,
   $newParam.='header(\'Status: 301 Moved Permanently\',false,301);'."\r\n";
   $newParam.='header(\'Location: '.$newAppKey.'_www\');'."\r\n";
   $newParam.='exit(0);';
   if($fdparam=fopen('index.php','w')){
    fwrite($fdparam,$newParam);
    fclose($fdparam);
   }
   $_SESSION[$newAppKey]['NAV']['login.php']['message'][]=' the password for root is '.$rootPassword;
   $redir='./'.$newAppKey.'_www/login.php';
   sleep(1);
   unset($_SESSION[PGMK]);
   header("HTTP/1.1 303 See Other");header('Location: ' . $redir , true , 303 );
   exit();
  }else{
   $err=1;
   header("HTTP/1.1 303 See Other");header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot update the root password' . mysqli_error($dbLink) ) );
   exit();
  }
 }
 header("HTTP/1.1 303 See Other");
 header('Location: '.$_SESSION[PGMK]['appkey'].'_www/login.php');
 exit();
}

//==============================================================================================
//==============================================================================================
//==============================================================================================
//==============================================================================================
$o1='';
$o1.=headerHtml();
$err=0;
$o1.='<h1>tdo install on localhost</h1>';
if(isset($_GET['errormessage'])){
 $o1.='<p style="color:red;">'.$_GET['errormessage'].'</p>'; 
}
if(isset($_GET['message'])){
 $o1.='<p style="color:blue;">'.$_GET['message'].'</p>'; 
}
//==============================================================================================
if(!isset($_SESSION[PGMK]['step']) || $_SESSION[PGMK]['step']==1){

 if($err==0){
  if(session_status()==PHP_SESSION_NONE){
   $o1.='<p style="color:red;">The session must work! Please, fix your php first.</p>';
   $err=1;
  }  
 }
 if($err==0){
  if($_SERVER['HTTP_HOST']!='localhost'){
   $o1.='<p style="color:red;">This should be installed only on localhost</p>';
   $err=1;
  }  
 }
 if($err==0){
  $o1.='<form method="post">';

  $o1.='<p>';
  $o1.='<h2>Step 1</h2>';
  $o1.='</p>';

  $o1.='<p>';
  $o1.='Enter a 3 character key for the application in the range a-z';
  $o1.='<br />';

  $val=isset($_SESSION[PGMK]['appkey'])?$_SESSION[PGMK]['appkey']:'aaa';
  $o1.='<input type="text" value="'.$val.'" name="appkey" size="3" maxlength="3"/>';
  $o1.='<br />';
  $o1.='reserved application keys are : "tdo" "old" "inc" "css" "img"';
  $o1.='<br />';
  $o1.='<p>';
  $o1.='Enter a name of the database to use or live it void';
  $o1.='<br />';
  unset($_SESSION[PGMK]['database']);
  $val=isset($_SESSION[PGMK]['database'])?$_SESSION[PGMK]['database']:'';
  $o1.='<input type="text" value="'.$val.'" name="database" size="30" maxlength="64"/>';
  $o1.='<br />';
  $o1.='If you live it void, a local database will be created with the name xxx  where xxx is the application key';
  $o1.='<br />';
  $o1.='The new table names that are use by this system will start with xxx_tbl_ where xxx is the application key';
  $o1.='</p>';

  $o1.='<p>';
  $o1.='the user for your local MySql database';
  $o1.='<br />';
  $o1.='<input type="text" value="admin" name="user" size="32" />';
  $o1.='</p>';

  $o1.='<p>';
  $o1.='the password for your local database';
  $o1.='<br />';
  $o1.='<input type="text" value="admin" name="password" size="32" />';
  $o1.='</p>';

  $o1.='<p>';
  $o1.='The server address';
  $o1.='<br />';
  $o1.='<input type="text" value="localhost:3306" name="server" size="32" />';
  $o1.='</p>';

  $o1.='<p>';
  $o1.='<button type="submit" name="action" value="step1">Send</button>';
  $o1.='</p>';
  $o1.='</form>';
 }
}


//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==2){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 2</h2>';
 $o1.='</p>';

 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step2">Create database "'.$_SESSION[PGMK]['appkey'].'"</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}


//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==3){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 3</h2>';
 $o1.='</p>';

 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step3">unzip and rename the files</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}


//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==4){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 4</h2>';
 $o1.='</p>';

 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step4">create tables in the database</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();  
}


//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==5){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 5</h2>';
 $o1.='</p>';

 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step5">insert data in the tables</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}


//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==6){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 6</h2>';
 $o1.='</p>';
 
 
 $o1.='<p>';
 
 $o1.='<label for="incPathUnderRoot" style="display:none;">';
 $o1.='Check this if the include and data directories will be under the www directory instead of the root directory ( not recommended for git or svn )';
 $o1.='<br /><br />';
 $o1.='<input type="checkbox" id="incPathUnderRoot" name="incPathUnderRoot" style="transform:scale(2);display:none;">';
 $o1.='</label>';
 
 $o1.='</p>';
 
 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step6">Special setup</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}

//==============================================================================================
//==============================================================================================

$o1.=footerHtml();
echo $o1;


//========================================================================================================
//========================================================================================================
//========================================= FUNCTIONS ====================================================
//========================================================================================================
//========================================================================================================
function razSessionForm(){
 $o1='';
 $o1.='<div style="position:fixed;bottom:0;text-align:center;">';
 $o1.='<form method="post" style="margin:15px auto;">';
 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="unsetSession">unset session to restart all the installation from scratch</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.='</div>';
 return $o1; 
}
//========================================================================================================
function recurse_replaceContent($src,$oldKey,$newKey){ 
 $dir = opendir($src); 
 while(false!==($file=readdir($dir)) ) {
  if(($file != '.') && ( $file != '..' )) { 
   if(is_dir($src . '/' . $file) ) { 
    recurse_replaceContent($src . '/' . $file , $oldKey,$newKey); 
   }else{
    $toReplace=file_get_contents($src . '/' . $file );
    $toReplace=str_replace($oldKey,$newKey,$toReplace);
    file_put_contents($src . '/' . $file,$toReplace);
   } 
  } 
 } 
 closedir($dir); 
}
//========================================================================================================
class FlxZipArchive extends ZipArchive {
 public function addDir($location, $name) {
       $this->addEmptyDir($name);
       $this->addDirDo($location, $name);
 } 
 private function addDirDo($location, $name) {
  $name .= '/';
  $location .= '/';
  $dir = opendir ($location);
  while ($file = readdir($dir)){
   if ($file == '.' || $file == '..') continue;
   $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
   $this->$do($location . $file, $name . $file);
  }
 }
}
//========================================================================================================
function headerHtml(){
 header('Content-Type: text/html; charset=utf-8');
 $o1='';
 $o1.='<!DOCTYPE html>'.CRLF;
 $o1.='<html>'.CRLF;
 $o1.=' <head>'.CRLF;
 $o1.='  <meta charset="utf-8" />'.CRLF;
 $o1.='  <title>install</title>'.CRLF;
 $o1.='<style type="text/css">'.CRLF;
 $o1.='body{background-color:#fdfdfd;color:#444;font-size:16px;font-family:verdana;text-align:center;}'.CRLF;
 $o1.='@-ms-viewport {width: device-width;}html{box-sizing: border-box;}*,*::before,*::after {box-sizing: inherit;font-weight:500;}'.CRLF;
 $o1.='input{padding:5px;font-family:inherit;font-size:inherit;border:1px #eee inset;border-radius:5px;}'.CRLF;
 $o1.='button{padding:5px;font-family:inherit;font-size:inherit;border:1px #eee outset;border-radius:5px;}'.CRLF;
 $o1.='p{margin:2em;}'.CRLF;
 
 
 $o1.='</style>'.CRLF;
 $o1.=' </head>'.CRLF;
 $o1.=' <body>'.CRLF;
 $o1.='  <!-- content -->'.CRLF;
 return $o1;
}
//========================================================================================================
function footerHtml(){
 $o1='';
 $o1.=' </body>'.CRLF;
 $o1.='</html>'.CRLF;
 return $o1;
}
//========================================================================================================
function buildPassword( $length = 8, $chars = 'abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!./,;*+%:\'{}[]-()&#?<>' ){
 // some characters are taken off like i,l,I,1,0,O because they look the same
 return substr( str_shuffle( $chars ), 0, $length );
}
//========================================================================================================
function integrerCsv($v1){
 $nombreInsertParGroupe=50;
 $retu=array('status' => 'KO' , 'debug' => array());
 mysqli_query($v1['dbLink'],'SET SESSION sql_mode=\'NO_AUTO_VALUE_ON_ZERO\'');
 if(mysqli_errno($v1['dbLink'])==0){
 }else{
  $retu['debug'][]=  ' mysqli_error() = ' . mysqli_error($v1['dbLink']) . ' , pour SET SESSION sql_mode=\'NO_AUTO_VALUE_ON_ZERO\' ' ;
  return $retu;
 }
 $sqlinsertMain=CRLF.'INSERT INTO `'.$v1['dbName'].'`.`' . $v1['table'] .'` ( '.$v1['listeDesChamps'].' ) VALUES ' . CRLF ;
 $valueLines=''; 
 if(($handle = fopen($v1['file'], 'r')) !== false){
  $countLines=0;
  while(($data=fgetcsv($handle, 0 , ';'  , '"'  )) !== false) { // no escape on php 5.2.17 sophiemallebranche.com
   $numData=0;
   $sqldata='';
   foreach($v1['tabChamps'] as $k2 => $v2 ){
    $typeChamp=$v2[1];
    $nullAdmis=$v2[2]=='YES'?true:false;
    if(
       strpos(strtolower($typeChamp),'int(')!==false
     ||strpos(strtolower($typeChamp),'decimal(')!==false
     ||strpos(strtolower($typeChamp),'bigint(')!==false
     ||strpos(strtolower($typeChamp),'float(')!==false
     ||strpos(strtolower($typeChamp),'double(')!==false
     ||strpos(strtolower($typeChamp),'real(')!==false
    ){
     $format='num';
    }else if(
       strpos(strtolower($typeChamp),'char')!==false
     ||strpos(strtolower($typeChamp),'text')!==false
     ||strpos(strtolower($typeChamp),'blob')!==false
     ||strpos(strtolower($typeChamp),'enum(')!==false
     ||strpos(strtolower($typeChamp),'set(')!==false
     ||strpos(strtolower($typeChamp),'timestamp')!==false
     ||strpos(strtolower($typeChamp),'datetime')!==false
     ||strpos(strtolower($typeChamp),'date')!==false
     ||strpos(strtolower($typeChamp),'time')!==false
    ){
     $format='texte';
    }else{
     $retu['debug'][]= 'Erreur ' . __LINE__ . ' typeChamp="' . $typeChamp . '" pour $numData=' . $numData . ' non pris en compte dans ' . var_export( $v1 , true )  ;
     return $retu;
    }
    if($sqldata!='') $sqldata.= ' , ';
    if($format=='texte'){
     if($nullAdmis==true && $data[$numData]=='NULL'){
      $sqldata.= ' NULL ';           
     }else{
      $sqldata.= ' \''.addslashes(str_replace('\\"','"',str_replace('\\\\','\\',$data[$numData]))).'\' ';     
     }
    }else if($format=='num'){
     if($nullAdmis==true && $data[$numData]=='NULL'){
      $sqldata.= ' NULL ';      
     }else{
      $sqldata.= ' '.$data[$numData].' ';      
     }
    }
    $numData++;
   }
   if($valueLines!='') $valueLines.=' , '.CRLF;
   $valueLines.=' ( '.$sqldata.' ) ';
   if($countLines==$nombreInsertParGroupe){
    $sqlinsert=$sqlinsertMain . $valueLines;
    mysqli_query($v1['dbLink'], $sqlinsert  );
    if(mysqli_errno($v1['dbLink'])==0){
    }else{
     $retu['debug'][]=  __LINE__ . ' mysqli_error() = ' . mysqli_error($v1['dbLink']) . ' , pour $sqlinsert = ' . $sqlinsert ;
     return $retu;
    }
    $valueLines='';
    $countLines=0;
   }
   $countLines++;
  }
  fclose($handle);
  if($valueLines!=''){
   $sqlinsert=$sqlinsertMain . $valueLines;
   mysqli_query($v1['dbLink'], $sqlinsert  );
   if(mysqli_errno($v1['dbLink'])==0){
   }else{
    $retu['debug'][]=  ' mysqli_error() = ' . mysqli_error($v1['dbLink']) . ' , pour $sqlinsert = ' . $sqlinsert ;
    return $retu;
   }
  }
 }else{
  $retu['debug'][]= 'Erreur ' . __LINE__ . ' ouverture fichier'  ;
  return $retu;
 }
 @unlink($v1['file']);
 $retu['status']='OK';
 return($retu); 
}
//========================================================================================================