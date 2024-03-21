<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Progress Bar Example</title>
<style>
.progress-bar-container {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background-color: #f1f1f1;
  z-index: 9999;
}

.progress-bar {
  height: 100%;
  background-color: #4caf50;
}
</style>
</head>
<body>
<div class="progress-bar-container">
  <div class="progress-bar" style="width: 0;"></div>
</div>

<?php

class FileHandler {
  public static function copyFile($source, $destination) {
    if (!copy($source, $destination)) {
      echo 'خطا در کپی فایل<br>';
      exit;
    }
  }

  public static function downloadFile($url, $destination) {
    $file = file_get_contents($url);
    if ($file === FALSE) {
      echo 'خطا در دانلود فایل<br>';
      exit;
    }
    file_put_contents($destination, $file);
  }

  public static function extractFile($source, $destination) {
    $zip = new ZipArchive;
    if ($zip->open($source) !== TRUE) {
      echo 'خطا در استخراج فایل<br>';
      exit;
    }
    $zip->extractTo($destination);
    $zip->close();
  }

  public static function moveContents($source, $destination) {
    $files = scandir($source);
    foreach ($files as $file) {
      if ($file === '.' || $file === '..') {
        continue;
      }
      rename($source . '/' . $file, $destination . '/' . $file);
    }
  }
}

// تنظیمات
$new_file_name = 'wp-rick.php'; // نام جدید فایل
echo 'شروع کپی فایل...<br>';
flush();

// کپی فایل
FileHandler::copyFile(__FILE__, $new_file_name);
echo 'فایل با موفقیت کپی شد (20%).<br>';
flush();

// تنظیمات دانلود وردپرس
$url = 'https://wordpress.org/latest.zip'; // URL فایلی که می خواهید دانلود کنید
$file_name = 'wordpress.zip'; // نام فایلی که می خواهید ذخیره کنید
$extract_dir = dirname(__FILE__); // مسیر ذخیره فایل
echo 'شروع دانلود وردپرس...<br>';
flush();

// دانلود فایل
FileHandler::downloadFile($url, $extract_dir . '/' . $file_name);
echo 'وردپرس با موفقیت دانلود شد (40%).<br>';
flush();

// استخراج فایل
echo 'شروع استخراج فایل...<br>';
flush();
FileHandler::extractFile($extract_dir . '/' . $file_name, $extract_dir);
echo 'فایل از حالت فشرده خارج شد (60%).<br>';
flush();

// تنظیمات انتقال محتویات وردپرس
$source_dir = $extract_dir . '/wordpress'; // مسیر پوشه wordpress
$target_dir = $extract_dir; // مسیر روت هاست
echo 'شروع انتقال محتویات...<br>';
flush();
FileHandler::moveContents($source_dir, $target_dir);
echo 'محتویات پوشه wordpress به روت هاست منتقل شد (80%).<br>';
flush();

// حذف پوشه wordpress
echo 'شروع حذف پوشه...<br>';
flush();
if (!is_dir($source_dir)) {
  echo 'پوشه wordpress یافت نشد.<br>';
  exit;
}
rmdir($source_dir);
echo 'پوشه wordpress حذف شد (90%).<br>';
flush();

// حذف فایل زیپ وردپرس
echo 'شروع حذف فایل زیپ...<br>';
flush();
if (!file_exists($file_name)) {
  echo 'فایل wordpress.zip یافت نشد.<br>';
  exit;
}
unlink($file_name);
echo 'فایل wordpress.zip حذف شد (100%).<br>';
flush();

$domain = $_SERVER['HTTP_HOST'];
echo 'در حال هدایت به دامنه: ' . $domain . '<br>';
flush();

header('Refresh: 5; URL=https://' . $domain);

?>
</body>
</html>
