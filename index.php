<?php
  // https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/welcome.html
  // https://docs.aws.amazon.com/aws-sdk-php/v3/api/

  require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

  $s3Client = new \Aws\S3\S3Client([
   'version'     => 'latest',
   'region'      => 'ap-southeast-1',
   'credentials' => [
     'key'    => 'AKIAICAI3MUBA2RFAZHQ',
     'secret' => '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',
   ],
  ]);

  try {
    // https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#listobjects
    $result = $s3Client->listObjects([
      'Bucket' => 'devcon-sdk',
    ]);
  } catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

  function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <main role="main" class="container">
      <h1>My S3 Bucket: devcon-sdk</h1>
      <div class="jumbotron">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Last Modified</th>
              <th scope="col">Size</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result['Contents'] as $object): ?>
            <tr>
              <th scope="row"><a href="https://s3-ap-southeast-1.amazonaws.com/devcon-sdk/<?php echo $object['Key']; ?>" target="_blank"><?php echo $object['Key']; ?></th>
              <td><?php echo date('Y-m-d H:i:s', strtotime($object['LastModified'])); ?></td>
              <td><?php echo human_filesize($object['Size']); ?></td>
                <th scope="row"><a href="delete.php?keyname=<?php echo $object['Key']; ?>">Delete</th>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>

      </div>
      <a href="upload.php">Add File</a>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
