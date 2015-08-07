<?php
  // Search Condition
  if($_POST["searchtext"]){
    $searchtext = $_POST["searchtext"];
    $_SESSION["searchtext"] = $_POST["searchtext"];
  }else{
    $searchtext = $_SESSION["searchtext"];
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
      <h3 class="panel-title">รายการบันทึกรอสั่งการ</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-6 text-left">
          <a href="?option=ioffice&task=book_pass" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>&nbsp;ค้นหาใหม่</a>
        </div>
        <div class="col-md-6 text-right">
          <form class="form-inline" action="#" enctype="multipart/form-data" method="POST" >
            <div class="form-group">
              <label for="searchtext"></label>
              <input type="text" class="form-control" id="searchtext" name="searchtext" placeholder="พิมพ์คำค้นหา" value="<?php echo $searchtext; ?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
            <a href="?option=ioffice&task=book_manage&action=pass_clearsearchtext" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> แสดงทั้งหมด</a>
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
            <th>เมื่อ</th>
            <th>โดย</th>
            <th>กลุ่มงาน</th>
            <th>สำนัก</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
       	  </tr>
        </thead>
        <tbody>

          <?php
            // Select Book
            $sql = "  SELECT
                        ioffice_book.*,
                        ioffice_booktype.booktypename,
                        ioffice_bookstatus.bookstatusname,
                        person_main.prename,
                        person_main.name,
                        person_main.surname,
                        system_department.department_name,
                        system_department.department_precis,
                        system_subdepartment.sub_department_name
                      FROM
                        ioffice_book
                        LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                        LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                        LEFT JOIN person_main ON ioffice_book.post_personid = person_main.person_id
                        LEFT JOIN system_department ON system_department.department = ioffice_book.post_departmentid
                        LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid
                      WHERE ((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                            bookheader like '%$searchtext%'
                      ORDER BY booktypeid DESC, bookid ASC";
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
                    $tr_class = "class = 'info'";
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
                    <td><?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></td>
                    <td><?php echo $row['prename'].$row['name']." ".$row['surname']; ?></td>
                    <td><?php echo $row["sub_department_name"]; ?></td>
                    <td><a tabindex="0" class="btn btn-default btn-xs" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="หน่วยงาน" data-content="<?php echo $row["department_name"]; ?>"><?php echo $row["department_precis"]; ?></a></td>
                    <?php
                      $sqllastcomment = " SELECT * FROM ioffice_bookcomment b
                                          LEFT JOIN person_main pm ON(b.comment_personid=pm.person_id)
                                          WHERE bookid = ".$row["bookid"]." ORDER BY commentid DESC LIMIT 0,1";
                      $resultlastcomment = mysqli_query($connect, $sqllastcomment);
                      $rowlastcomment = mysqli_fetch_assoc($resultlastcomment);
                    ?>
                    <td><a tabindex="0" class="btn btn-default btn-xs" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ความเห็นล่าสุด" data-content="<?php echo $rowlastcomment["prename"].$rowlastcomment["name"]." ".$rowlastcomment["surname"]." : ".$rowlastcomment["commentdetail"]; ?>"><?php echo $row['bookstatusname']; ?></a></td>                    <td>
                      <!-- Modal for Read -->
                      <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal<?php echo $row['bookid']; ?>">อ่าน&nbsp;/&nbsp;สั่งการ</button>
                      <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $row['bookid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">เรื่อง <?php echo $row["bookheader"]; ?></h4>
                            </div>
                            <!-- Comment Form -->
                            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="?option=ioffice&task=book_manage&action=comment">
                            <div class="modal-body">

                              <a href="#" class="btn btn-default">ประเภท&nbsp;:&nbsp;<?php echo $booktype_show; ?></a>
                              <a href="#" class="btn btn-default">สถานะ&nbsp;:&nbsp;<?php echo $row["bookstatusname"]; ?></a>
                              <hr>
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
                              <h5>โดย&nbsp;<?php echo $row['prename'].$row['name']." ".$row['surname']; ?></h5>
                              <h5>เมื่อ&nbsp;<?php echo ThaiTimeConvert(strtotime($row['postdate']),"","2"); ?></h5>
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
                              <input type="hidden" id="bookid" name="bookid" value="<?php echo $row['bookid']; ?>">
                              <?php if($row["bookstatusid"]!=4) { ?>
                              <hr>
                              <h4>ขอความเห็น(Consult)</h4>
                              <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid4" value="4"><span class='glyphicon glyphicon-comment' aria-hidden='true'></span> ขอความเห็น
                              </label>
                              </p>
                              <p>
                                <select  name='department' id='department' class="form-control">
                                  <option  value = ''>-</option>"
                                  <?php
                                  $sqldepartment = "select * from  system_department order by department_name";
                                  $resultdepartment = mysqli_query($connect, $sqldepartment);
                                  while ($rowdepartment = $resultdepartment->fetch_assoc()){
                                    echo  "<option  value ='$rowdepartment[department]'>$rowdepartment[department_name]</option>" ;
                                  }
                                  ?>
                                </select>
                              </p>
                              <p>
                                <select  name='sub_department' id='sub_department' class="form-control">
                                  <option  value = ''>-</option>"
                                  <?php
                                  $sqlsubdepartment = "select * from  system_subdepartment order by sub_department_name";
                                  $resultsubdepartment = mysqli_query($connect, $sqlsubdepartment);
                                  while ($rowsubdepartment = $resultsubdepartment->fetch_assoc()){
                                    echo  "<option  value ='$rowsubdepartment[sub_department]'>$rowsubdepartment[sub_department_name]</option>" ;
                                  }
                                  ?>
                                </select>
                              </p>
                              <p>
                                <select  name='person' id='person' class="form-control">
                                  <option  value = ''>-</option>"
                                  <?php
                                  $sqlperson = "select * from  person_main order by name";
                                  $resultperson = mysqli_query($connect, $sqlperson);
                                  while ($rowperson = $resultperson->fetch_assoc()){
                                    echo  "<option  value ='$rowperson[person_id]'>".$rowperson[prename].$rowperson[name]." ".$rowperson[surname]."</option>" ;
                                  }
                                  ?>
                                </select>
                              </p>
                              <textarea class="form-control" rows="4" name="consultdetail" id="consultdetail" placeholder="ส่วนสำหรับแจ้งขอความเห็น"></textarea>
                              <?php
                              }
                              ?>
                              <hr>
                              <h4>ลงความเห็น(Approve)</h4>
                              <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid1" value="2"><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span> ผ่านเรื่อง
                              </label>
                              </p>
                              <?php if($row["bookstatusid"]!=4) { ?>
                              <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid20" value="20"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> อนุมัติ
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid21" value="21"><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> อนุมัติ(ปฏิบัติราชการแทน)
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid22" value="22"><span class='glyphicon glyphicon-check' aria-hidden='true'></span> อนุมัติ(รักษาราชการแทน)
                              </label>
                              </p>
                              <p>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid30" value="30"><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ไม่อนุมัติ
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="bookstatusid" id="bookstatusid40" value="40"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> คืนเรื่อง/แก้ไข
                              </label>
                              </p>
                              <?php } ?>
                              <textarea class="form-control" rows="4" name="commentdetail" id="commentdetail" placeholder="ส่วนสำหรับลงความเห็น"></textarea>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp;ปิด</button>
                              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;บันทึก</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
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
