<?php
  require $_SERVER["DOCUMENT_ROOT"] . '/sdk/vendor/autoload.php';

  $s3Client = new \Aws\S3\S3Client([
   'version'     => 'latest',
   'region'      => 'ap-southeast-1',
   'credentials' => [
     'key'    => '',
     'secret' => '',
   ],
  ]);

  $keyname = isset($_GET['keyname']) ? trim($_GET['keyname']) : null;
  if($keyname){
    // https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#deleteobject
    $s3Client->deleteObject([
        'Bucket' => 'devcon-sdk',
        'Key'    => $keyname,
    ]);
  }

  header("Location: index.php");
  exit();
