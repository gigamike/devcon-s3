<?php
  require $_SERVER["DOCUMENT_ROOT"] . '/sdk/vendor/autoload.php';

  $message = null;
  if($_POST){
    if($_FILES['photo']['name']){
    	if(!$_FILES['photo']['error']){
        try{
          $s3Client = new \Aws\S3\S3Client([
           'version'     => 'latest',
           'region'      => 'ap-southeast-1',
           'credentials' => [
             'key'    => '',
             'secret' => '',
           ],
          ]);

          // https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#putobject
          $result = $s3Client->putObject([
            'Bucket'     => 'devcon-sdk',
            'Key'        => $_FILES['photo']['name'],
            'SourceFile' => $_FILES['photo']['tmp_name'],
          ]);
        } catch (S3Exception $e) {
          echo $e->getMessage() . "\n";
        }

        header("Location: index.php");
        exit();
    	}else{
    		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
    	}
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Devcon AWS CodeCamp</title>
  </head>
  <body>
    <main role="main" class="container">
      <h1>Upload to S3 Bucket: devcon-sdk</h1>
      <div class="jumbotron">
          <?php if(!is_null($message)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong></strong> <?php echo $message; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="photo">File:</label>
              <input type="file" id="photo" name="photo" required>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
        </form>

      </div>
      <a href="index.php">Back to index</a>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
