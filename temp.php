<?php

// 데이터베이스 테스트

$mysqli = new mysqli('localhost', 'root', 'rudtn95','sample');

if ($mysqli->connect_errno) {
    die('Connection Error ('.$mysqli->connect_errno.'): '.
    $mysqli->connect_error);
}

if($_POST['type']==1)
{
$sql="select * from jewelry where showed is NULL;";
$sql_result=mysqli_query( $mysqli,$sql);
$result_array=mysqli_fetch_array($sql_result);


  if($_POST['num']==1){
        $sql = "update jewelry SET `jewelry_type`='$_POST[jewelry_type]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `material_type`='$_POST[material_type]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `core_type`='$_POST[core_type]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `metal_color`='$_POST[metal_color]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `core_color`='$_POST[core_color]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `setting_type`='$_POST[setting_type]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `stone_shape`='$_POST[stone_shape]' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
        $sql = "update jewelry SET `showed`='1' WHERE `id`='$result_array[id]'";
        $sql_result=mysqli_query( $mysqli,$sql);
  }

  $sql="select * from jewelry where showed is NULL;";
  $sql_result=mysqli_query( $mysqli,$sql);
  $result_array=mysqli_fetch_array($sql_result);

  if($result_array){
        echo "<img src='img/$result_array[jewelry_name].jpg'>";
        $sql_result=mysqli_query( $mysqli,$sql);

  }
  else{
        echo 1;
  }
}


else if($_POST['type']==2){
  $sql="select jewelry_name from jewelry ".$_POST['where'];                        //test 테이블의 레코드를 모두 뽑아오기
  $sql_result=mysqli_query( $mysqli,$sql);          //질의(위 내용)를 수행하라.
  $count=mysqli_num_rows($sql_result);          //mysql_num_rows() 함수 : 행의 개수를 세는 함수.

  $nothing =0;

  for($i=0; $i<$count; $i++)
  {
      $result_array=mysqli_fetch_array($sql_result);
      if($result_array && $nothing==0){
        $nothing=-1;
      }

        if($i%$_POST['show']==0)
        {
          echo "<tr>";
        }

        echo "<td>
          <span class='edge'>
            <img  id='list' src='img/$result_array[jewelry_name].jpg'>
            <div id='cover' onMouseOver='popupOn(event, this);' onMouseOut='popupDown();'> </div>
          </span>
        </td>";

        if($i%$_POST['show']==$_POST['show']-1)
        {
          echo "</tr>";
        }
  }

  if($nothing==0){
    echo "$nothing";
  }
}

else if($_POST['type']==3){
  $sql="select * from jewelry ".$_POST['name'];                        //test 테이블의 레코드를 모두 뽑아오기
  $sql_result=mysqli_query( $mysqli,$sql);          //질의(위 내용)를 수행하라.
  $result_array=mysqli_fetch_array($sql_result);

  if($result_array[jewelry_type]){
    echo "Jewelry Type : $result_array[jewelry_type] <br>";
  }
  else {
    echo "Jewelry Type : 선택안됨 <br>";
  }

  if($result_array[material_type]){
    echo "Material Type : $result_array[material_type] <br>";
  }
  else {
    echo "Material Type : 선택안됨 <br>";
  }

  if($result_array[core_type]){
    echo "Core Type : $result_array[core_type] <br>";
  }
  else {
    echo "Core Type : 선택안됨 <br>";
  }

  if($result_array[metal_color]){
    echo "Metal Color : $result_array[metal_color] <br>";
  }
  else {
    echo "Metal Color : 선택안됨 <br>";
  }

  if($result_array[core_color]){
    echo "Core Color : $result_array[core_color] <br>";
  }
  else {
    echo "Core Color : 선택안됨 <br>";
  }

  if($result_array[setting_type]){
    echo "Setting Type : $result_array[setting_type] <br>";
  }
  else {
    echo "Setting Type : 선택안됨 <br>";
  }

  if($result_array[stone_shape]){
    echo "Stone Shape : $result_array[stone_shape] <br>";
  }
  else {
    echo "Stone Shape : 선택안됨 <br>";
  }
}

 ?>
