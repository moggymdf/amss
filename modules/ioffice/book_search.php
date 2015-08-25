<?php
  // Define Variable
  if(isset($_POST["searchtext"])){ }else{ $_POST["searchtext"]=""; }
  if(isset($_SESSION["searchtext"])){ }else{ $_SESSION["searchtext"]=""; }
  if(isset($_POST["searchbookstatusid"])){ }else{ $_POST["searchbookstatusid"]=""; }
  if(isset($_SESSION["searchbookstatusid"])){ }else{ $_SESSION["searchbookstatusid"]=""; }
  if(isset($_POST["searchdepartmentid"])){ }else{ $_POST["searchdepartmentid"]=""; }
  if(isset($_SESSION["searchdepartmentid"])){ }else{ $_SESSION["searchdepartmentid"]=""; }
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
  }
  if($_POST["searchbookstatusid"]){
    switch ($_POST["searchbookstatusid"]) {
      case '999':
        $searchbookstatusid = 999;
        unset($_SESSION["searchbookstatusid"]);
        break;
      default:
        $searchbookstatusid = $_POST["searchbookstatusid"];
        $_SESSION["searchbookstatusid"] = $_POST["searchbookstatusid"];
        break;
    }
  }else{
    $searchbookstatusid = $_SESSION["searchbookstatusid"];
  }
  if($_POST["searchdepartmentid"]){
    switch ($_POST["searchdepartmentid"]) {
      case '999':
        $searchdepartmentid = 999;
        unset($_SESSION["searchdepartmentid"]);
        break;
      default:
        $searchdepartmentid = $_POST["searchdepartmentid"];
        $_SESSION["searchdepartmentid"] = $_POST["searchdepartmentid"];
        break;
    }
  }else{
    $searchdepartmentid = $_SESSION["searchdepartmentid"];
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<br>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">รายการบันทึกเสนอทั้งหมด</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <div class="form-group">
              <select class="form-control" name="searchbookstatusid" >
                <option value="999" <?php if($searchbookstatusid==0){ echo "selected"; } ?>>ทุกสถานะ</option>
                <?php
                  $sqlbookstatus = "SELECT * FROM ioffice_bookstatus";
                  if($resultbookstatus = mysqli_query($connect, $sqlbookstatus)){
                    while ($rowbookstatus = $resultbookstatus->fetch_assoc()) {
                      $selected = "";
                      if($searchbookstatusid==$rowbookstatus["bookstatusid"]){ $selected = "selected"; }
                      echo "<option value='".$rowbookstatus["bookstatusid"]."' ".$selected.">".$rowbookstatus["bookstatusname"]."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" name="searchdepartmentid">
                <option value="999" <?php if($searchdepartmentid==0){ echo "selected"; } ?>>ทุกสำนัก</option>
                <?php
                  $sqldepartment = "select * from  system_department order by department_name";
                  if($resultdepartment = mysqli_query($connect, $sqldepartment)){
                    while ($rowdepartment = $resultdepartment->fetch_assoc()) {
                      $selected = "";
                      if($searchdepartmentid==$rowdepartment["department"]){ $selected = "selected"; }
                      echo "<option value='".$rowdepartment["department"]."' ".$selected.">".$rowdepartment["department_name"]."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=ioffice&task=book_manage&action=search_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
          </form>
        </div>
      </div>
      <hr>
      <table class="table table-hover table-striped table-condensed table-responsive">
        <thead>
          <tr>
          	<th>เลขที่</th>
            <th>ประเภท</th>
          	<th>เรื่อง</th>
            <th>เรียน</th>
            <th>เมื่อ</th>
            <th>โดย</th>
            <th>กลุ่มงาน</th>
            <th>สำนัก</th>
            <th>รายละเอียด</th>
            <th>สถานะ</th>
       	  </tr>
        </thead>
        <tbody>

          <?php
            // Check User
            if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }
            $sqluser = "SELECT * FROM person_main WHERE person_id = '$_SESSION[login_user_id]'";
            if($resultuser = mysqli_query($connect, $sqluser)) {
              $rowuser = $resultuser->fetch_assoc();
              $user_positionid = $rowuser["position_code"];
              $user_position_other_code = $rowuser["position_other_code"];
              $user_subdepartment = $rowuser["sub_department"];
              $user_department = $rowuser["department"];
            }else{
              $user_positionid = "";
              $user_position_other_code = "";
              $user_subdepartment = "";
              $user_department = "";
            }
            // เจ้าหน้าที่
            $sqlpass = "post_subdepartmentid = $user_subdepartment and ";
            // หัวหน้ากลุ่มงาน
            if($user_position_other_code>0){
              $sqlpass = "post_subdepartmentid = $user_subdepartment and ";
            }
            // ผอ.สำนัก
            if($user_positionid==9){
              $sqlpass = "post_departmentid = $user_department and ";
            }
            // รองเลขา
            if($user_positionid==2){
              if($_SESSION["system_delegate"]==1) {
                // กรณีรักษาราชการแทน
                $sqlpass = "";
              }else{
                // กรณีปกติ
                $sqlpass = "post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$_SESSION[login_user_id]."')";
              }
            }
            // เลขา
            if($user_positionid==1){
              $sqlpass = "";
            }
            // Select Book
            if(($searchbookstatusid==999) or ($searchbookstatusid=="")){
              $sqlbookstatus = "";
            }else{
              $sqlbookstatus = " ioffice_book.bookstatusid = ".$searchbookstatusid." and ";
            }
            if(($searchdepartmentid==999) or ($searchdepartmentid=="")){
              $sqldepartment = "";
            }else{
              if($sqlbookstatus!="") {
                $sqldepartment = $sqldepartment." and ";
              }
              $sqldepartment = " ioffice_book.post_departmentid = ".$searchdepartmentid." and ";
            }
            $sql = " SELECT
                  ioffice_book.*,
                  ioffice_booktype.booktypename,
                  ioffice_bookstatus.bookstatusname,
                  pm1.prename as post_prename,
                  pm1.name as post_name,
                  pm1.surname as post_surname,
                  sd1.department_name as post_department_name,
                  sd1.department_precis as post_department_precis,
                  system_subdepartment.sub_department_name,
                  ibl.booklevelname
                FROM
                  ioffice_book
                  LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                  LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                  LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id
                  LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid
                  LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid
                  LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid
                WHERE ".$sqlbookstatus.$sqldepartment." ".$sqlpass." ((bookheader like '%$searchtext%') or (pm1.name like '%$searchtext%'))
                ORDER BY bookid DESC";
                //echo "<div class='well'>".$sql."</div>";
            if ($result = mysqli_query($connect, $sql)) {
              while ($row = $result->fetch_assoc()) {
                switch ($row["bookstatusid"]) {
                  case '1':
                    $tr_class = "class='active'";
                    break;
                  case '2':
                    $tr_class = "class = 'warning'";
                    break;
                  case '3':
                    $tr_class = "class = 'danger'";
                    break;
                  case '4':
                    $tr_class = "class = 'warning'";
                    break;
                  case '20':
                    $tr_class = "class = 'success'";
                    break;
                  case '21':
                    $tr_class = "class = 'success'";
                    break;
                  case '22':
                    $tr_class = "class = 'success'";
                    break;
                  case '30':
                    $tr_class = "class = 'danger'";
                    break;
                  case '40':
                    $tr_class = "class = 'info'";
                    break;
                  default:
                    $tr_class = "";
                    break;
                }
                switch ($row["booktypeid"]) {
                  case '1':
                    $booktype_show = "ปกติ";
                    break;
                  case '2':
                    $booktype_show = "<span class='glyphicon glyphicon-star' aria-hidden='true'></span> ด่วน";
                    break;

                  default:
                    $booktype_show = "&nbsp;";
                    break;
                }
                ?>
                  <tr <?php echo $tr_class; ?>>
                    <td><?php echo $row['bookid']; ?></td>
                    <td><?php echo $booktype_show; ?></td>
                    <td><?php echo $row['bookheader']; ?></td>
                    <td><?php echo $row['booklevelname']; ?></td>
                    <td><?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></td>
                    <td><?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname']; ?></td>
                    <td><?php echo $row["sub_department_name"]; ?></td>
                    <td><a tabindex="0" class="btn btn-default" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="หน่วยงาน" data-content="<?php echo $row["post_department_name"]; ?>"><?php echo $row["post_department_precis"]; ?></a></td>
                    <?php
                      $sqllastcomment = " SELECT * FROM ioffice_bookcomment b
                                          LEFT JOIN person_main pm ON(b.comment_personid=pm.person_id)
                                          WHERE bookid = ".$row["bookid"]." ORDER BY commentid DESC LIMIT 0,1";
                      $resultlastcomment = mysqli_query($connect, $sqllastcomment);
                      $rowlastcomment = mysqli_fetch_assoc($resultlastcomment);
                    ?>
                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">อ่าน</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['bookid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <a href="#" class="btn btn-default">ประเภท&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                              <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                              <hr>
                              <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                              <h4 class="modal-title" id="myModalLabel">เรียน <?php echo $row['booklevelname']; ?></h4>
                            </div>
                            <div class="modal-body">
                              <?php echo $row["bookdetail"]; ?>
                              <hr>
                              <h4>เอกสารแนบ</h4>
                              <?php
                              $sqlfile = "SELECT * FROM ioffice_bookfile WHERE bookid=".$row["bookid"];
                              $resultfile = mysqli_query($connect,$sqlfile);
                              $fnum = 0;
                              while ($rowfile = $resultfile->fetch_assoc()) {
                                echo "<p><a href='".$rowfile["filename"]."' class='btn btn-default' target='_blank'><span class='badge badge-sm'>".++$fnum."</span>&nbsp;".$rowfile["filedesc"]."</a></p>";
                              }
                              ?>
                              <hr>
                              <div class="well well-sm">
                              <h5>โดย&nbsp;<?php echo $row['post_prename'].$row['post_name']." ".$row['post_surname']; ?></h5>
                              <h5>เมื่อ&nbsp;<?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></h5>
                              </h5>
                              </div>
                              <h4>รายการความเห็น</h4>
                              <table class="table table-hover table-striped table-condensed table-responsive">
                                <thead>
                                  <th>ลำดับที่</th>
                                  <th>ความเห็น</th>
                                  <th>โดย</th>
                                  <th>ตำแหน่ง</th>
                                  <th>สำนัก</th>
                                  <th>เมื่อ</th>
                                  <th>สถานะ</th>
                                </thead>
                                <tbody>
                                  <?php
                                    $sqlcomment = " SELECT * FROM ioffice_bookcomment bc
                                                    LEFT JOIN ioffice_bookstatus bs ON(bc.bookstatusid=bs.bookstatusid)
                                                    LEFT JOIN person_main pm ON(bc.comment_personid=pm.person_id)
                                                    LEFT JOIN person_position pp ON(bc.comment_positionid=pp.position_code)
                                                    LEFT JOIN system_department sd ON(bc.comment_departmentid=sd.department)
                                                    WHERE bookid=".$row['bookid'];
                                    //echo $sqlcomment;
                                    $resultcomment = mysqli_query($connect, $sqlcomment);
                                    $commentnum = 0;
                                    while ($rowcomment = $resultcomment->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>".++$commentnum."</td>";
                                      echo "<td>".$rowcomment["commentdetail"]."</td>";
                                      echo "<td>".$rowcomment["prename"].$rowcomment["name"]." ".$rowcomment["surname"]."</td>";
                                      echo "<td>".$rowcomment["position_name"]."</td>";
                                      echo "<td><a tabindex='0' class='btn btn-xs' role='button' data-toggle='popover' data-placement='top' data-trigger='focus' title='หน่วยงาน' data-content='".$rowcomment["department_name"]."''>".$rowcomment["department_precis"]."</a></td>";
                                      echo "<td>".ThaiTimeConvert(strtotime($rowcomment['commentdate']),"","2")."</td>";
                                      echo "<td>".$rowcomment["bookstatusname"]."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                </tbody>
                              </table>
                              <hr>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <?php
                    switch ($row["bookstatusid"]) {
                          case '1':
                            $bookstatusclass = "default";
                            break;
                          case '2':
                            $bookstatusclass = "warning";
                            break;
                          case '3':
                            $bookstatusclass = "danger";
                            break;
                          case '4':
                            $bookstatusclass = "warning";
                            break;
                          case '20':
                            $bookstatusclass = "success";
                            break;
                          case '21':
                            $bookstatusclass = "success";
                            break;
                          case '22':
                            $bookstatusclass = "success";
                            break;
                          case '30':
                            $bookstatusclass = "danger";
                            break;
                          case '40':
                            $bookstatusclass = "info";
                            break;
                        default:
                          # code...
                          break;
                      }
                    ?>
                    <td><a tabindex="0" class="btn btn-<?php echo $bookstatusclass; ?>" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ความเห็นล่าสุด" data-content="<?php echo $rowlastcomment["prename"].$rowlastcomment["name"]." ".$rowlastcomment["surname"]." : ".$rowlastcomment["commentdetail"]; ?>"><?php echo $row['bookstatusname']; ?></a></td>
                  </tr>
                <?php
              }
              // free result set
              mysqli_free_result($result);
            }
          ?>

        </tbody>
			</table>
    </div>
  </div>
</div>
</body>
</html>
