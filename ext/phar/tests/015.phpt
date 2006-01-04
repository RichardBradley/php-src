--TEST--
Phar::mapPhar valid file (gzipped)
--SKIPIF--
<?php if (!extension_loaded("phar")) print "skip";
if (!PHP_Archive::canCompress()) print "skip"; ?>
--FILE--
<?php
$file = "<?php
Phar::mapPhar('hio', true);
__HALT_COMPILER(); ?>";
$manifest = pack('V', 1) . 'a' . pack('VVVV', 1, time(), 0, 11);
$file .= pack('VV', strlen($manifest) + 4, 1) . $manifest . pack('VV', crc32('a'), 1) . chr(75) . chr(4) . chr(0); // 'a' gzdeflated
file_put_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.phar.php', $file);
include dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.phar.php';
echo file_get_contents('phar://hio/a');
?>
--CLEAN--
<?php unlink(dirname(__FILE__) . '/' . basename(__FILE__, '.clean.php') . '.phar.php'); ?>
--EXPECT--
a