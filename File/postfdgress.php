
<?php
include "../connect.php";
global $degress;
if (isset($_POST["submit"])) {
  $material = intval(trim($_POST["material"]));
  for ($i = 1; $i <= $_POST["total"]; $i++) {
    $id = intval($_POST["id" . $i]);
    $degree = $_POST["inputdegree" . $id];
    $sql = "UPDATE degree SET FinalDR1 = '$degree' where StuID='$id' and MatID = '$material' ";
    if ($link->query($sql) === true) {
      header("Location: AddFDegreeMaterial.php?id=" . $material);
    }
  }
}


?>
