<?php
include ('top.php');
?>
<h1>Sample Translations</h1>
<?php
//************ open and read sample text 1 ***********
//opens file
$debug = false;
if (isset($_GET["debug"])) {
  $debug = true;
}
$myFolder = ''; //change folder depending on location of file
$myFileName = 'text-1';
$fileExt = '.php';
$filename = $myFolder . $myFileName . $fileExt;
if ($debug)
  print '<p>filename is ' . $filename;
$file = fopen($filename, "r");
if ($debug) {
  if ($file) {
    print '<p>File Opened Successfully.</p>';
  } else {
    print '<p>File Open Failed.</p>';
  }
}
//reads file
print fread($file, 1000); //will need to change max number of bytes depending on size of sample text files
//closes file
fclose($file);

//************ open and read sample text 2 ***********
//opens file
$debug = false;
if (isset($_GET["debug"])) {
  $debug = true;
}
$myFolder = ''; //change folder depending on location of file
$myFileName = 'text-2';
$fileExt = '.php';
$filename = $myFolder . $myFileName . $fileExt;
if ($debug)
  print '<p>filename is ' . $filename;
$file = fopen($filename, "r");
if ($debug) {
  if ($file) {
    print '<p>File Opened Successfully.</p>';
  } else {
    print '<p>File Open Failed.</p>';
  }
}
//reads file
print fread($file, 1000); //will need to change max number of bytes depending on size of sample text files
//closes file
fclose($file);

//************ open and read sample text 3 ***********
//opens file
$debug = false;
if (isset($_GET["debug"])) {
  $debug = true;
}
$myFolder = ''; //change folder depending on location of file
$myFileName = 'text-3';
$fileExt = '.php';
$filename = $myFolder . $myFileName . $fileExt;
if ($debug)
  print '<p>filename is ' . $filename;
$file = fopen($filename, "r");
if ($debug) {
  if ($file) {
    print '<p>File Opened Successfully.</p>';
  } else {
    print '<p>File Open Failed.</p>';
  }
}
//reads file
print fread($file, 1000); //will need to change max number of bytes depending on size of sample text files
//closes file
fclose($file);

//************ open and read sample text 4 ***********
//opens file
$debug = false;
if (isset($_GET["debug"])) {
  $debug = true;
}
$myFolder = ''; //change folder depending on location of file
$myFileName = 'text-4';
$fileExt = '.php';
$filename = $myFolder . $myFileName . $fileExt;
if ($debug)
  print '<p>filename is ' . $filename;
$file = fopen($filename, "r");
if ($debug) {
  if ($file) {
    print '<p>File Opened Successfully.</p>';
  } else {
    print '<p>File Open Failed.</p>';
  }
}
//reads file
print fread($file, 1000); //will need to change max number of bytes depending on size of sample text files
//closes file
fclose($file);
include ('footer.php');
?>
