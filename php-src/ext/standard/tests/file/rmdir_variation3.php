<?php
/* Prototype  : bool rmdir(string dirname[, resource context])
 * Description: Remove a directory
 * Source code: ext/standard/file.c
 * Alias to functions:
 */

echo "*** Testing rmdir() : variation ***\n";

$workDir = "rmdirVar3.tmp";
$subDir = "aSubDir";
mkdir($workDir);
$cwd = getcwd();

$dirs = array(
             // relative
             $workDir.'/'.$subDir,
             './'.$workDir.'/'.$subDir,
             $workDir.'/../'.$workDir.'/'.$subDir,

             // relative bad path
             $workDir.'/../BADDIR/'.$subDir,
             'BADDIR/'.$subDir,

             //absolute
             $cwd.'/'.$workDir.'/'.$subDir,
             $cwd.'/./'.$workDir.'/'.$subDir,
             $cwd.'/'.$workDir.'/../'.$workDir.'/'.$subDir,

             //absolute bad path
             $cwd.'/BADDIR/'.$subDir,

             //trailing separators
             $workDir.'/'.$subDir.'/',
             $cwd.'/'.$workDir.'/'.$subDir.'/',

             // multiple separators
             $workDir.'//'.$subDir,
             $cwd.'//'.$workDir.'//'.$subDir,

             );


foreach($dirs as $dir) {
   mkdir($workDir.'/'.$subDir);
   echo "-- removing $dir --\n";
   $res = rmdir($dir);
   if ($res === true) {
      echo "Directory removed\n";
   }
   else {
      rmdir($workDir.'/'.$subDir);
   }
}

rmdir($workDir);

?>
===DONE===
