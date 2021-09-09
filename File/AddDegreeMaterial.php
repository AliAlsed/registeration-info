<?php
session_start();
$activepage = "app-Material-list";
include "MainPage.php";
?>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<style>
    .tablesorter-default .tablesorter-filter-row td {
        background-color: #fff;
        border-bottom: none !important;
        line-height: normal;
        text-align: center;
        -webkit-transition: line-height .1s ease;
        -moz-transition: line-height .1s ease;
        -o-transition: line-height .1s ease;
        transition: line-height .1s ease;
    }


    td:hover {
        background-color: white;
    }

    th {
        margin: 15px;
        padding: 10px;
    }

    .form-control {
        display: block;
        width: 100%;
        height: calc(1.25em + 1.4rem + 1px);
        padding: 0.7rem 0.7rem;
        font-size: 0.96rem;
        font-weight: 400;
        line-height: 1.25;
        color: #4E5154;
        background-color: #FFFFFF;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        -webkit-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    .input-mar {
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    input {
        margin-bottom: 10px !important;
    }
</style>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="users-list-wrapper2">
                <div class="card">
                    <?php
                    $sql = "SELECT * FROM materials where ID =" . $_GET["id"];
                    $material = mysqli_query($link, $sql);
                    while ($material_data = mysqli_fetch_array($material)) {

                      $nm = $material_data["AName"];
                      $depn = $material_data["Department_Id"];
                      $stg = $material_data["Level_Id"];
                      $co = $material_data["Course_Id"];
                      $degree = $material_data["HighestDegreeCourse"];
                      ?>
                        <div class="card-header">

                            <p> اضافة درجات سعي الطلاب <br>

                                <?php
                                $sqld = "SELECT * FROM departments where ID = $depn";
                                $dep = mysqli_query($link, $sqld);
                                while (
                                  $dep_data = mysqli_fetch_array($dep)
                                ) { ?>
                                    لقسم <?php echo $dep_data["Name"]; ?>
                                <?php }
                                ?>
                                <br>
                                <?php
                                $sqls = "SELECT * FROM levels where ID = $stg";
                                $stgs = mysqli_query($link, $sqls);
                                while (
                                  $stgs_data = mysqli_fetch_array($stgs)
                                ) { ?>
                                    مرحلة <?php echo $stgs_data["Name"]; ?>
                                <?php }
                                ?>
                                <br>
                                <?php
                                $sqlc = "SELECT * FROM courses where ID = $co";
                                $cou = mysqli_query($link, $sqlc);
                                while (
                                  $cou_data = mysqli_fetch_array($cou)
                                ) { ?>

                                    الكورس <?php echo $cou_data["Name"]; ?>
                                <?php }
                                ?>
                                <br>

                                لمادة <?php echo $nm; ?>


                            </p>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a href="exportFormmiddegree.php"><i class="fa fa-file-excel-o"></i></a></li>

                                </ul>
                            </div>
                        </div>

                </div>


                <!-- users list start -->



                <!-- Ag Grid users list section end -->
            </section>
            <!-- users list start -->

            <section class="users-list-wrapper">
                <!-- users filter start -->
                <form method="post" action="postdgress.php">
                    <div class="card">
                        <div class="card-content collapse show">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="tablesorter table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    الرقم
                                                </th>
                                                <th>
                                                    <center> الاسم </center>
                                                </th>
                                                <th>
                                                    <center> uploaded </center>
                                                </th>
                                                <th>
                                                    <center> درجة السعي </center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $subject = $_GET["id"];
                                            $year = (int) $_SESSION["year"];
                                            include "../connect.php";
                                            $q = "SELECT students.Name as Name, students.ID as ID, 
                                            students.Department_Id as Department_Id,
                                            studentstatus.level as level, studentstatus.Year as Year,  studentstatus.uploaded as uploaded,
                                            degree.MidDegree as middegree 
                                            FROM students
                                            JOIN studentstatus ON students.ID=studentstatus.Stu_Id 
                                            LEFT JOIN degree ON students.ID=degree.StuID and degree.MatID = '$subject' 
                                            where Department_Id =$depn  
                                            ";

                                            $stu = mysqli_query($link, $q);
                                            $i = 1;
                                            $counts = "SELECT count(*) as result FROM students 
                                            LEFT JOIN studentstatus ON students.ID=studentstatus.Stu_Id and studentstatus.Year = '$year' and studentstatus.level=$stg
                                            where Department_Id =$depn";
                                            $std_count = mysqli_query(
                                              $link,
                                              $counts
                                            );
                                            $total = mysqli_fetch_assoc(
                                              $std_count
                                            );
                                            ?>
                                            <input type="hidden" name="total" value="<?php echo $total[
                                              "result"
                                            ]; ?>">
                                            <input type="hidden" name="material" value="<?php echo $_GET[
                                              "id"
                                            ]; ?>">

                                            <?php while (
                                              $stu_data = mysqli_fetch_array(
                                                $stu
                                              )
                                            ) { ?>
                                                <tr>
                                                    <th scope="row">
                                                        <center>
                                                            <?php echo $i; ?>
                                                        </center>
                                                    </th>

                                                    <th scope="row">
                                                        <center>
                                                            <?php echo $stu_data[
                                                              "Name"
                                                            ] .
                                                              " - " .
                                                              $stu_data[
                                                                "Year"
                                                              ]; ?>
                                                        </center>
                                                    </th>
                                                    <th scope="row">
                                                        <center>
                                                            <?php if (
                                                              $stu_data[
                                                                "uploaded"
                                                              ] == 2
                                                            ) { ?>
                                                                <p style="color:red"> * </p><?php } ?>
                                                        </center>
                                                    </th>
                                                    <th scop="row">
                                                        <center>
                                                            <input type="hidden" name="id<?php echo $i; ?>" value="<?php echo $stu_data[
  "ID"
]; ?>">
                                                            <input type="number" name="inputdegree<?php echo $stu_data[
                                                              "ID"
                                                            ]; ?>" id="inputdegree<?php echo $stu_data[
  "ID"
]; ?>" class="form-control input-mar" style="margin-bottom: 10px;" placeholder="درجة السعي" max="<?php echo $degree; ?>" min="0" value="<?php echo $stu_data[
  "middegree"
]; ?>">
                                                        </center>

                                                    </th>


                                                </tr>
                                            <?php $i++;} ?>
                                 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                    }
                    ?>

                <button class="btn btn-primary m-2" name="submit" type="submit"> حفظ </button>


        </div>
        </form>
        </section>