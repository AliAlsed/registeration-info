<?php
session_start();
include('../connect.php');
global $degress;


function checkgrade($id, $material)
{
    include('../connect.php');

    $sql = "SELECT * FROM `degree` where MatID='$material' and StuID= '$id' ";
    $degress = mysqli_query($link, $sql);

    $row = mysqli_num_rows($degress);



    if ($row == 1) {

        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $material = intval(trim($_POST['material']));
    $year=(int)$_SESSION['yearofmat'];

    for ($i = 1; $i <= $_POST['total']; $i++) {
        // echo $_POST['id' . $i] . '<br>';
        $id = intval($_POST['id' . $i]);
        $degree = $_POST['inputdegree' . $id];

        $ch = checkgrade($id, $material);
        if ($ch) {
            $sql = "UPDATE degree SET Degree = '$degree' where Student_Id='$id' and Material_Id = '$material' ";
            if ($link->query($sql) === TRUE) {
                header('Location: AddDegreeMaterial.php?id=' . $material);
            }
        } else {
            
            $sql = "INSERT INTO degree (MidDegree,MatID,StuID,YearID)
            VALUES ('$degree','$material','$id', '$year')";


            if ($link->query($sql) === TRUE) {
                header('Location: AddDegreeMaterial.php?id=' . $material);
            }else{
                echo $link->error;
            }
        }
    }
}

?>