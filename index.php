<?php

// تنظیمات
$file_name = basename( __FILE__ ); // نام فایل فعلی
$new_file_name = 'wp-rick.php'; // نام جدید فایل

// کپی فایل
copy( $file_name, $new_file_name );

// اعلان موفقیت
echo 'فایل با موفقیت کپی شد.';


// تنظیمات
$url = 'https://wordpress.org/latest.zip'; // URL فایلی که می خواهید دانلود کنید
$file_name = 'wordpress.zip'; // نام فایلی که می خواهید ذخیره کنید
$extract_dir = dirname( __FILE__ ); // مسیر ذخیره فایل

// دانلود فایل
$file = file_get_contents( $url );
if ( $file === FALSE ) {
  echo 'خطا در دانلود فایل';
  exit;
}

// ذخیره فایل
file_put_contents( $extract_dir . '/' . $file_name, $file );

// استخراج فایل
$zip = new ZipArchive;
if ( $zip->open( $extract_dir . '/' . $file_name ) !== TRUE ) {
  echo 'خطا در استخراج فایل';
  exit;
}

$zip->extractTo( $extract_dir );
$zip->close();

// اعلان موفقیت
echo 'فایل با موفقیت دانلود و از حالت فشرده خارج شد.';



// تنظیمات
$source_dir = $extract_dir . '/wordpress'; // مسیر پوشه wordpress
$target_dir = $extract_dir; // مسیر روت هاست

// بررسی وجود پوشه wordpress
if ( !is_dir( $source_dir ) ) {
  echo 'پوشه wordpress یافت نشد.';
  exit;
}

// انتقال محتویات پوشه
$files = scandir( $source_dir );
foreach ( $files as $file ) {
  if ( $file === '.' || $file === '..' ) {
    continue;
  }

  rename( $source_dir . '/' . $file, $target_dir . '/' . $file );
}

// حذف پوشه wordpress
rmdir( $source_dir );

// اعلان موفقیت
echo 'محتویات پوشه wordpress با موفقیت به روت هاست منتقل و پوشه wordpress حذف شد.';

// تنظیمات
$file_name = 'wordpress.zip'; // نام فایل

// بررسی وجود فایل
if ( !file_exists( $file_name ) ) {
  echo 'فایل wordpress.zip یافت نشد.';
  exit;
}

// حذف فایل
unlink( $file_name );

// اعلان موفقیت
echo 'فایل wordpress.zip با موفقیت حذف شد.';

// دریافت نام دامنه
$domain = $_SERVER['HTTP_HOST'];

// باز کردن آدرس https://domain.com
header( 'Location: https://' . $domain );

?>

