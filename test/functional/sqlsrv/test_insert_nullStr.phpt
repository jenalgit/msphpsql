--TEST--
Insert empty strings into various char and binary types.
--SKIPIF--
<?php require('skipif.inc'); ?>
--FILE--
<?php

sqlsrv_configure('WarningsReturnAsErrors', 0);
sqlsrv_configure('LogSeverity', SQLSRV_LOG_SEVERITY_ALL);

require_once("MsCommon.inc");

$conn = connect();
if ($conn === false) {
    fatalError("connect failed.");
}

$stmt = sqlsrv_query($conn, "IF OBJECT_ID('[168256.2]', 'U') IS NOT NULL DROP TABLE [168256.2]");
if ($stmt) {
    sqlsrv_free_stmt($stmt);
}
$stmt = sqlsrv_query($conn, "CREATE TABLE [168256.2] ([char_type] char(5), [varchar_type] varchar(5), [varchar(max)_type] varchar(max), [text_type] text, [nchar_type] nchar(5), [nvarchar_type] nvarchar(5), [nvarchar(max)_type] nvarchar(max), [ntext_type] ntext, [binary_type] binary(5), [varbinary_type] varbinary(5), [varbinary(max)_type] varbinary(max), [image_type] image)");
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
sqlsrv_free_stmt($stmt);
$stmt = sqlsrv_query($conn, "TRUNCATE TABLE [168256.2]");
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
sqlsrv_free_stmt($stmt);
$stmt = sqlsrv_query(
    $conn,
    "INSERT INTO [168256.2] (char_type, varchar_type, [varchar(max)_type], text_type, nchar_type, nvarchar_type, [nvarchar(max)_type], ntext_type, binary_type, varbinary_type, [varbinary(max)_type], image_type) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
    array('','','','','','','','',
        array('',SQLSRV_PARAM_IN,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_BINARY)),
        array('',SQLSRV_PARAM_IN,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_BINARY)),
        array('',SQLSRV_PARAM_IN,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_BINARY)),
        array('',SQLSRV_PARAM_IN,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_BINARY)))
);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
sqlsrv_free_stmt($stmt);
$stmt = sqlsrv_query($conn, "SELECT * FROM [168256.2]");
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
var_dump($row);
sqlsrv_free_stmt($stmt);

sqlsrv_query($conn, "DROP TABLE [168256.2]");

sqlsrv_close($conn);

echo "Test successful.\n"
?>
--EXPECT--
array(12) {
  ["char_type"]=>
  string(5) "     "
  ["varchar_type"]=>
  string(0) ""
  ["varchar(max)_type"]=>
  string(0) ""
  ["text_type"]=>
  string(0) ""
  ["nchar_type"]=>
  string(5) "     "
  ["nvarchar_type"]=>
  string(0) ""
  ["nvarchar(max)_type"]=>
  string(0) ""
  ["ntext_type"]=>
  string(0) ""
  ["binary_type"]=>
  string(5) "     "
  ["varbinary_type"]=>
  string(0) ""
  ["varbinary(max)_type"]=>
  string(0) ""
  ["image_type"]=>
  string(0) ""
}
Test successful.
