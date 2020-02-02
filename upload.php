<!DOCTYPE html>
<html lang="ko">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <meta http-equiv="Content-Script-Type" content="text/javascript">

    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">


    <title>업로딩..........</title>

    <script src="js/bootstrap.bundle.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/bootstrap.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.form.js" type="text/javascript"  charset="utf-8"></script>
    <script src="js/jquery-3.3.1.js" type="text/javascript"  charset="utf-8"></script>
    <script src="./js/main.js" type="text/javascript"  charset="utf-8"></script>

  </head>

  <body>

    <header>
      <div id="page-title">Upload Image Files</div>
      <div id="menus">
        <a href="#">기타</a>
        <a href="./upload.php">업로드 페이지</a>
        <a href="./list.html">리스트 페이지</a>
        <a href="./tagging.html">태깅 페이지</a>
      </div>
    </header>

    <div id="upload_block">

        <form  id="uploading" action="upload.php" method="post" multipart="" enctype="multipart/form-data">
          <label for="file" >Select File</label>
          <input type="file" name="file[]" id="file" multiple="multiple" onchange="getThumbnailPrivew(this);">
          <input type="submit" name="color" value="Upload"/>
        </form>

    <div class="preview-list">
        <table id="preview">

        </table>

      </div>

    </div>

    <?php
    $img = $_FILES['file'];

    if(!empty($img))
    {
        $img_desc = reArrayFiles($img);
        // print_r($img_desc);
        $count=1;
        $id = createId();
        foreach($img_desc as $val)
        {
            move_uploaded_file($val['tmp_name'],'./img/jewelry'.($id+$count).'.jpg');
            insertData('jewelry'.($id+$count), ($id+$count));
            $count=$count+1;
        }
    }

    function reArrayFiles($file)
    {
        $file_ary = array();
        $file_count = count($file['name']);

        $file_key = array_keys($file);

        for($i=0;$i<$file_count;$i++)
        {
            foreach($file_key as $val)
            {
                $file_ary[$i][$val] = $file[$val][$i];
            }
        }
        return $file_ary;
    }

    function createId(){
      // echo "1";
      $mysqli = new mysqli('localhost', 'root', 'rudtn95','sample');

      if ($mysqli->connect_errno) {
          die('Connection Error ('.$mysqli->connect_errno.'): '.
          $mysqli->connect_error);
        }

          $sql="select jewelry_name from jewelry where jewelry_name is not NULL";
          $sql_result=mysqli_query( $mysqli,$sql);
          $result_array=mysqli_fetch_array($sql_result);
          $count=mysqli_num_rows($sql_result);

          return $count;
    }

    function insertData($name, $newId){
      $mysqli = new mysqli('localhost', 'root', 'rudtn95','sample');

      if ($mysqli->connect_errno) {
          die('Connection Error ('.$mysqli->connect_errno.'): '.
          $mysqli->connect_error);
        }

        $sql="insert into jewelry (id, jewelry_name) values ('$newId', '$name')";
        $sql_result=mysqli_query( $mysqli,$sql);
    }

    ?>

  </body>
</html>
