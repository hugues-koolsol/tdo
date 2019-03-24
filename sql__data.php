<?php
//=================== DATA =============================


$err=0;
$dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password'],$_SESSION[PGMK]['database']);
if(!$dbLink){
 $err=1;
 header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot connect to the local database server') );
 exit();
};

mysqli_set_charset( $dbLink , 'utf8mb4' );
if($err==0){

 $sql='TRUNCATE `tdo_tbl__css` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__css'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__css' ,
  'file'            => 'sql_data___tbl__css.txt' ,
  'listeDesChamps'  => '`fld_id_css` , `fld_name_css` , `fld_active_css` , `fld_color_back_css` , `fld_color_text_css` , `fld_json_css` , `fld_tsupd_css` , `fld_tscrt_css` , `fld_cntupd_css`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_css',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_name_css',
    1 => 'varchar(32)',
    2 => 'NO',
    3 => 'UNI',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_active_css',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_color_back_css',
    1 => 'varchar(256)',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_color_text_css',
    1 => 'varchar(256)',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_json_css',
    1 => 'text',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_tsupd_css',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_tscrt_css',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_cntupd_css',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__css' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__groups` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__groups'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__groups' ,
  'file'            => 'sql_data___tbl__groups.txt' ,
  'listeDesChamps'  => '`fld_id_groups` , `fld_name_groups` , `fld_parent_id_groups` , `fld_isactive_groups` , `fld_tsupd_groups` , `fld_tscrt_groups` , `fld_cntupd_groups`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_groups',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_name_groups',
    1 => 'varchar(32)',
    2 => 'NO',
    3 => 'MUL',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_parent_id_groups',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'MUL',
    4 => '1',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_isactive_groups',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_tsupd_groups',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_tscrt_groups',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_cntupd_groups',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__groups' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__grpspgs` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__grpspgs'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__grpspgs' ,
  'file'            => 'sql_data___tbl__grpspgs.txt' ,
  'listeDesChamps'  => '`fld_id_grpspgs` , `fld_group_id_grpspgs` , `fld_page_id_grpspgs` , `fld_is_menu_grpspgs` , `fld_menu_order_grpspgs` , `fld_tscrt_grpspgs` , `fld_tsupd_grpspgs` , `fld_cntupd_grpspgs`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_grpspgs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_group_id_grpspgs',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'MUL',
    4 => '0',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_page_id_grpspgs',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'MUL',
    4 => '0',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_is_menu_grpspgs',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_menu_order_grpspgs',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_tscrt_grpspgs',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '2000-01-01 00:00:00',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_tsupd_grpspgs',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '2000-01-01 00:00:00',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_cntupd_grpspgs',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__grpspgs' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__langvalues` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__langvalues'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__langvalues' ,
  'file'            => 'sql_data___tbl__langvalues.txt' ,
  'listeDesChamps'  => '`fld_id_lngVals` , `fld_key_lngVals` , `fld_lang_lngVals` , `fld_page_id_lngVals` , `fld_value_lngVals` , `fld_type_lngVals` , `fld_tsupd_lngVals` , `fld_tscrt_lngVals` , `fld_cntupd_lngVals`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_lngVals',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_key_lngVals',
    1 => 'varchar(128)',
    2 => 'NO',
    3 => 'MUL',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_lang_lngVals',
    1 => 'varchar(16)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_page_id_lngVals',
    1 => 'bigint(20) unsigned',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_value_lngVals',
    1 => 'text',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_type_lngVals',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => 'page',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_tsupd_lngVals',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_tscrt_lngVals',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_cntupd_lngVals',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__langvalues' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__pages` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__pages'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__pages' ,
  'file'            => 'sql_data___tbl__pages.txt' ,
  'listeDesChamps'  => '`fld_id_pages` , `fld_name_pages` , `fld_menu_pages` , `fld_isajax_pages` , `fld_isremote_pages` , `fld_isuser_pages` , `fld_localadmin_pages` , `fld_isaction_pages` , `fld_parent_pages` , `fld_tsupd_pages` , `fld_tscrt_pages` , `fld_cntupd_pages`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_pages',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_name_pages',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => 'UNI',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_menu_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_isajax_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_isremote_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_isuser_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_localadmin_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_isaction_pages',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_parent_pages',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_tsupd_pages',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  10 => 
  array (
    0 => 'fld_tscrt_pages',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  11 => 
  array (
    0 => 'fld_cntupd_pages',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__pages' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__paramnames` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__paramnames'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__paramnames' ,
  'file'            => 'sql_data___tbl__paramnames.txt' ,
  'listeDesChamps'  => '`fld_id_parnams` , `fld_key_parnams` , `fld_label_parnams` , `fld_comment_parnams` , `fld_json_parnams` , `fld_order_parnams` , `fld_isuser_parnams` , `fld_tscrt_parnams` , `fld_tsupd_parnams` , `fld_cntupd_parnams`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_parnams',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_key_parnams',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => 'UNI',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_label_parnams',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_comment_parnams',
    1 => 'text',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_json_parnams',
    1 => 'text',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_order_parnams',
    1 => 'text',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_isuser_parnams',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_tscrt_parnams',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_tsupd_parnams',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_cntupd_parnams',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__paramnames' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__paramrules` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__paramrules'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__paramrules' ,
  'file'            => 'sql_data___tbl__paramrules.txt' ,
  'listeDesChamps'  => '`fld_id_parrules` , `fld_name_parrules` , `fld_id_param_parrules` , `fld_tsupd_parrules` , `fld_tscrt_parrules` , `fld_cntupd_parrules`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_parrules',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_name_parrules',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => 'MUL',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_id_param_parrules',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_tsupd_parrules',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_tscrt_parrules',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_cntupd_parrules',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__paramrules' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__paramvalues` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__paramvalues'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__paramvalues' ,
  'file'            => 'sql_data___tbl__paramvalues.txt' ,
  'listeDesChamps'  => '`fld_id_parvals` , `fld_id_parname_parvals` , `fld_json_parvals` , `fld_tscrt_parvals` , `fld_tsupd_parvals`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_parvals',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_id_parname_parvals',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_json_parvals',
    1 => 'text',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_tscrt_parvals',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_tsupd_parvals',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__paramvalues' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__tablelinks` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__tablelinks'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__tablelinks' ,
  'file'            => 'sql_data___tbl__tablelinks.txt' ,
  'listeDesChamps'  => '`fld_id_pglnks` , `fld_parent_table_id_pglnks` , `fld_parent_field_pglnks` , `fld_parent_field_display_pglnks` , `fld_children_table_id_pglnks` , `fld_child_field_pglnks` , `fld_link_mandatory_pglnks` , `fld_tsupd_pglnks` , `fld_tscrt_pglnks` , `fld_cntupd_pglnks`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_pglnks',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_parent_table_id_pglnks',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_parent_field_pglnks',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_parent_field_display_pglnks',
    1 => 'varchar(255)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_children_table_id_pglnks',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_child_field_pglnks',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_link_mandatory_pglnks',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_tsupd_pglnks',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_tscrt_pglnks',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_cntupd_pglnks',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__tablelinks' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__tables` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__tables'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__tables' ,
  'file'            => 'sql_data___tbl__tables.txt' ,
  'listeDesChamps'  => '`fld_id_tables` , `fld_id_server_tables` , `fld_name_tables` , `fld_system_tables` , `fld_view_tables` , `fld_id_reftbl_of_view_tables` , `fld_log_tables` , `fld_remote_tables` , `fld_tsupd_tables` , `fld_tscrt_tables` , `fld_cntupd_tables`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_tables',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_id_server_tables',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_name_tables',
    1 => 'varchar(128)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_system_tables',
    1 => 'char(1)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_view_tables',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_id_reftbl_of_view_tables',
    1 => 'bigint(20)',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_log_tables',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_remote_tables',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_tsupd_tables',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_tscrt_tables',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  10 => 
  array (
    0 => 'fld_cntupd_tables',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__tables' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__todos` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__todos'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__todos' ,
  'file'            => 'sql_data___tbl__todos.txt' ,
  'listeDesChamps'  => '`fld_id_todos` , `fld_priority_todos` , `fld_id_user_todos` , `fld_title_todos` , `fld_comment_todos` , `fld_tsupd_todos` , `fld_tscrt_todos` , `fld_cntupd_todos`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_todos',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_priority_todos',
    1 => 'int(2) unsigned zerofill',
    2 => 'NO',
    3 => '',
    4 => '00',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_id_user_todos',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'MUL',
    4 => '0',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_title_todos',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => 'todo',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_comment_todos',
    1 => 'text',
    2 => 'YES',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_tsupd_todos',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_tscrt_todos',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_cntupd_todos',
    1 => 'int(11)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__todos' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__uploadeddocs` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__uploadeddocs'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__uploadeddocs' ,
  'file'            => 'sql_data___tbl__uploadeddocs.txt' ,
  'listeDesChamps'  => '`fld_id_uploadedDocs` , `fld_name_uploadedDocs` , `fld_originalName_uploadedDocs` , `fld_isPicture_uploadedDocs` , `fld_pictureWidth_uploadedDocs` , `fld_pictureHeight_uploadedDocs` , `fld_documentType_uploadedDocs` , `fld_pictureWeight_uploadedDocs` , `fld_path_uploadedDocs` , `fld_tsupd_uploadedDocs` , `fld_tscrt_uploadedDocs` , `fld_cntupd_uploadedDocs`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_uploadedDocs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_name_uploadedDocs',
    1 => 'varchar(128)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_originalName_uploadedDocs',
    1 => 'varchar(256)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_isPicture_uploadedDocs',
    1 => 'varchar(16)',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_pictureWidth_uploadedDocs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_pictureHeight_uploadedDocs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_documentType_uploadedDocs',
    1 => 'varchar(16)',
    2 => 'NO',
    3 => '',
    4 => NULL,
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_pictureWeight_uploadedDocs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_path_uploadedDocs',
    1 => 'varchar(256)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_tsupd_uploadedDocs',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  10 => 
  array (
    0 => 'fld_tscrt_uploadedDocs',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  11 => 
  array (
    0 => 'fld_cntupd_uploadedDocs',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__uploadeddocs' ) );
  exit();
 }

}

if($err==0){

 $sql='TRUNCATE `tdo_tbl__users` ';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . ' I cannot truncate the table tdo_tbl__users'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $par=array(
  'table'           => 'tdo_tbl__users' ,
  'file'            => 'sql_data___tbl__users.txt' ,
  'listeDesChamps'  => '`fld_id_users` , `fld_login_users` , `fld_email_users` , `fld_loginisemail_users` , `fld_password_users` , `fld_group_id_users` , `fld_active_users` , `fld_translate_users` , `fld_firstname_users` , `fld_lastname_users` , `fld_tsupd_users` , `fld_tscrt_users` , `fld_cntupd_users`' ,
  'tabChamps'       => array (
  0 => 
  array (
    0 => 'fld_id_users',
    1 => 'bigint(20) unsigned',
    2 => 'NO',
    3 => 'PRI',
    4 => NULL,
    5 => 'auto_increment',
  ),
  1 => 
  array (
    0 => 'fld_login_users',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => 'UNI',
    4 => '',
    5 => '',
  ),
  2 => 
  array (
    0 => 'fld_email_users',
    1 => 'varchar(128)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  3 => 
  array (
    0 => 'fld_loginisemail_users',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  4 => 
  array (
    0 => 'fld_password_users',
    1 => 'varchar(256)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  5 => 
  array (
    0 => 'fld_group_id_users',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => 'MUL',
    4 => '1',
    5 => '',
  ),
  6 => 
  array (
    0 => 'fld_active_users',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '1',
    5 => '',
  ),
  7 => 
  array (
    0 => 'fld_translate_users',
    1 => 'tinyint(4)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
  8 => 
  array (
    0 => 'fld_firstname_users',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  9 => 
  array (
    0 => 'fld_lastname_users',
    1 => 'varchar(64)',
    2 => 'NO',
    3 => '',
    4 => '',
    5 => '',
  ),
  10 => 
  array (
    0 => 'fld_tsupd_users',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  11 => 
  array (
    0 => 'fld_tscrt_users',
    1 => 'datetime',
    2 => 'NO',
    3 => '',
    4 => '1000-01-01 00:00:00',
    5 => '',
  ),
  12 => 
  array (
    0 => 'fld_cntupd_users',
    1 => 'bigint(20)',
    2 => 'NO',
    3 => '',
    4 => '0',
    5 => '',
  ),
) ,
  'dbLink'          => $dbLink ,
  'dbName'          => $_SESSION[PGMK]['database'] ,
 );
 $retCsv=integrerCsv($par);
 if($retCsv['status']!='OK'){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode(basename(__FILE__) . ' ' . __LINE__ . 'I cannot fill the table tdo_tbl__users' ) );
  exit();
 }

}

