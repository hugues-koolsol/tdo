<?php
define('BNF',basename( __FILE__ ));
define('CRLF',"\r\n");
define('PGMK' , 'tdo_install'); // program key = app key
session_start();
//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='unsetSession'){
 unset($_SESSION[PGMK]);
 header('Location: '.BNF.'?message='.urlencode('Unset session OK'));
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
   header('Location: '.BNF.'?errormessage='.urlencode('the application key must contain 3 characters in the range a-z'));
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
   header('Location: '.BNF.'?errormessage='.urlencode('the application key must contain 3 characters in the range a-z'));
   exit();
  }
 }
 if($err==0){
  $dbLink=mysqli_connect($_POST['server'],$_POST['user'],$_POST['password']);
  if(!$dbLink){
   $err=1;
   header('Location: '.BNF.'?errormessage='.urlencode('I cannot connect to the local database server') );
   exit();   
  }else{
   $_SESSION[PGMK]['server']=$_POST['server'];
   $_SESSION[PGMK]['user']=$_POST['user'];
   $_SESSION[PGMK]['password']=$_POST['password'];
  }
 }
 if($err==0){
  $_SESSION[PGMK]['step']=2;
 }
 header('Location: '.BNF.'?message='.urlencode('Connection OK'));
 exit();
 
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
   header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
   exit();
  }else{
   $sql='CREATE DATABASE `'.$_SESSION[PGMK]['appkey'].'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
   $res6=@mysqli_query($dbLink,$sql);
   if(mysqli_errno($dbLink)==0){
    $_SESSION[PGMK]['step']=3;
   }else{
    $err=1;
    header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the database' . mysqli_error($dbLink) ) );
    exit();
   }
  }
 } 
 header('Location: '.BNF.'?message='.urlencode('Database created OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step3'){
// echo __FILE__ . ' ' . __LINE__ . ' __LINE__ = <pre>' . var_export( __LINE__ , true ) . '</pre>' ; exit(0);
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
    header('Location: '.BNF.'?errormessage='.urlencode('I cannot unzip tdo.zip' ) );
    exit();
   }else{
    if($_SESSION[PGMK]['appkey']!='tdo'){
     $arrRen=array('cron','data','inc','_userdata','www');
     foreach( $arrRen as $k1 => $v1){
      if(!rename ( 'tdo_'.$v1 , $_SESSION[PGMK]['appkey'].'_'.$v1)){
       $err=1;
       header('Location: '.BNF.'?errormessage='.urlencode('I cannot rename ' . $v1 ) );
      }
     }
    }
    if($err==0){
     foreach( $arrRen as $k1 => $v1){
      recurse_replaceContent($_SESSION[PGMK]['appkey'].'_'.$v1,'tdo',$_SESSION[PGMK]['appkey']);
     }
    }
    $_SESSION[PGMK]['step']=4;    
   }
  }else{
   $err=1;
   header('Location: '.BNF.'?errormessage='.urlencode('I cannot open tdo.zip' ) );
   exit();
  }
 }
 header('Location: '.BNF.'?message='.urlencode('Files unzipped OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step4'){
 include('sql__structure.php');
 $_SESSION[PGMK]['step']=5; 
 header('Location: '.BNF.'?message='.urlencode('Tables created OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step5'){
 include('sql__data.php');
 $_SESSION[PGMK]['step']=6; 
 header('Location: '.BNF.'?message='.urlencode('data insert OK'));
 exit();
}

//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step6'){
 if((isset($_POST['isHttps']) && $_POST['isHttps']=='on') || (isset($_POST['incPathUnderRoot']) && $_POST['incPathUnderRoot']=='on')){
  
  if(isset($_POST['isHttps']) && $_POST['isHttps']=='on'){
   $arrFileInc=file($_SESSION[PGMK]['appkey'].'_www/za_inc.php');
   foreach($arrFileInc as $k1 => $v1){
    if(substr($v1,0,30)=='$GLOBALS[\'glob_remoteIsHttps\']'){
     $arrFileInc[$k1]='$GLOBALS[\'glob_remoteIsHttps\']         =true;'.CRLF;
    }
   }
   if($fdincphp=fopen($_SESSION[PGMK]['appkey'].'_www/za_inc.php','w')){ 
    foreach($arrFileInc as $k1 => $v1){
     fwrite($fdincphp, $v1 ); 
    }
    fclose($fdincphp); 
   }
  }
  
  if(isset($_POST['incPathUnderRoot']) && $_POST['incPathUnderRoot']=='on'){
   $tabFiles=array('za_inc.php','zz_maintenance.php');
   foreach( $tabFiles as $k0 => $v0){
    $arrFileInc=array();
    $arrFileInc=file($_SESSION[PGMK]['appkey'].'_www/'.$v0);
    foreach($arrFileInc as $k1 => $v1){
     if(substr($v1,0,39)=='$GLOBALS[\'glob_incPathAreInSubFolders\']'){
      $arrFileInc[$k1]='$GLOBALS[\'glob_incPathAreInSubFolders\']=true;'.CRLF;
     }
    }
    if($fdincphp=fopen($_SESSION[PGMK]['appkey'].'_www/'.$v0,'w')){ 
     foreach($arrFileInc as $k1 => $v1){
      fwrite($fdincphp, $v1 ); 
     }
     fclose($fdincphp); 
    }
   }
   rename($_SESSION[PGMK]['appkey'].'__userdata' , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'__userdata');
   rename($_SESSION[PGMK]['appkey'].'_cron'      , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_cron');
   rename($_SESSION[PGMK]['appkey'].'_data'      , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_data');
   rename($_SESSION[PGMK]['appkey'].'_inc'       , $_SESSION[PGMK]['appkey'].'_www/'.$_SESSION[PGMK]['appkey'].'_inc');
  }
  
 }
 $_SESSION[PGMK]['step']=7;
 header('Location: '.BNF.'?message='.urlencode('special setup OK'));
 exit();
}
//==============================================================================================
if(isset($_POST['action']) && $_POST['action']=='step7'){
 $newAppKey=$_SESSION[PGMK]['appkey'];
 @unlink('tdo.zip');
 @unlink('sql__structure.php');
 @unlink('sql__data.php'); 
 @unlink('README.md'); 
 
 $dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password']);
 if(!$dbLink){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
  exit();
 }else{
  $rootPassword=buildPassword();
  $optionsHash = array('cost'=>12);
  $passWordHash=password_hash($rootPassword, PASSWORD_BCRYPT, $optionsHash);
  $sql='UPDATE `'.$_SESSION[PGMK]['appkey'].'`.`'.$_SESSION[PGMK]['appkey'].'_tbl__users` SET `fld_password_users` = \''.addslashes($passWordHash).'\' WHERE `fld_id_users` = 1 ';
  $res6=@mysqli_query($dbLink,$sql);
  if(mysqli_errno($dbLink)==0){
   @unlink('index.php');
   $_SESSION[$newAppKey]['NAV']['login.php']['message'][]=' the password for root is '.$rootPassword;
   $redir='./'.$newAppKey.'_www/login.php';
   sleep(1);
   unset($_SESSION[PGMK]);
   header('Location: ' . $redir , true , 303 );
   exit();
  }else{
   $err=1;
   header('Location: '.BNF.'?errormessage='.urlencode('I cannot update the root password' . mysqli_error($dbLink) ) );
   exit();
  }
 }
 
 
 
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
  $o1.='A local database will be created with the name xxx  where xxx is the application key';
  $o1.='<br />';
  $o1.='The table names will start with xxx_ where xxx is the application key';
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
 $o1.='<label for="isHttps">';
 $o1.='Check this if your application will be put on a http<span style="color:red;font-weight:bold;">s</span> domain ( on localhost, it has to be http )';
 $o1.='<br /><br />';
 $o1.='<input type="checkbox" id="isHttps" name="isHttps" style="transform:scale(2);">';
 $o1.='</label>';
 
 $o1.='<br /><br /><br />';

 $o1.='<label for="incPathUnderRoot">';
 $o1.='Check this if the include and data directories will be under the www directory instead of the root directory';
 $o1.='<br /><br />';
 $o1.='<input type="checkbox" id="incPathUnderRoot" name="incPathUnderRoot"  style="transform:scale(2);">';
 $o1.='</label>';
 $o1.='</p>';
 
 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step6">Special setup</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}
//==============================================================================================


if(isset($_SESSION[PGMK]['step']) && $_SESSION[PGMK]['step']==7){
 $o1.='<form method="post">';
 $o1.='<p>';
 $o1.='<h2>Step 7</h2>';
 $o1.='</p>';

 $o1.='<p>';
 $o1.='<button type="submit" name="action" value="step7">Finish</button>';
 $o1.='</p>';
 $o1.='</form>';
 $o1.=razSessionForm();
}


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
function buildPassword( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!./,;*+%:\'{}[]' ) {
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
  
//   echo __FILE__ . ' ' . __LINE__ . ' $data =<pre>' . var_export( $data , true ) . '</pre>' ; exit();
   $numData=0;
   $sqldata='';
   foreach($v1['tabChamps'] as $k2 => $v2 ){
//     echo __FILE__ . ' ' . __LINE__ . ' $v2 =<pre>' . var_export( $v2 , true ) . '</pre>' ; exit();
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
////    if($fd=fopen('toto.sql','a')){ fwrite($fd,$sqlinsert) ; fclose($fd); }
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
////   if($fd=fopen('toto.sql','a')){ fwrite($fd,$sqlinsert) ; fclose($fd); }
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