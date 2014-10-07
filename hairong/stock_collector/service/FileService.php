<?php
class FileHelper
{
	public static function FilePutContents($filename, $content)
	{
	    self::MakeDir(dirname($filename));
		file_put_contents($filename, $content);
	}
    public static function MakeDir($dir) {
        if (!is_dir(dirname($dir))) {
            self::MakeDir(dirname($dir));
        }
        if (!is_dir($dir)) {
            mkdir($dir, 0755);
        }
    }
}