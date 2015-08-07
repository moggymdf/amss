<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script>
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_subdep.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;
		$("select#subdep").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
        removeOptions(document.getElementById("person_id")); // clear dropdrowlist person_id when click department
	});
});
$(function(){
	$("select#subdep").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"subdep="+$(this).val(), // ส่งตัวแปร GET ชื่อ subdep ให้มีค่าเท่ากับ ค่าของ subdepartment
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
function removeOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=1;i--){
        selectbox.remove(i);
    }
}
</script>


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
<?php
//ส่วนหัว
if(!(($index==1) or ($index==2) or ($index==5))){
      ?><div class="panel-heading"><h3 class="panel-title">เจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</h3></div><?}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
?>
      <div class="panel-heading"><h3 class="panel-title">กำหนดเจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</h3></div>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label >
                <Select name='department' id='department' class="form-control">
                    <option  value = ''>เลือกสำนัก</option>
                    <?$sql = "select * from  system_department order by department";
                    $dbquery = mysqli_query($connect,$sql);
                    While ($result_department = mysqli_fetch_array($dbquery)){
                    echo "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
                    }?>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกกลุ่ม</label>
          <div class="col-sm-4">
            <label >
                <Select name='subdep' id='subdep' class='form-control'>
                    <option  value = ''>เลือกกลุ่ม</option>
                </select>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกผู้ดูแล(Admin)</label>
          <div class="col-sm-4">
            <label >
                <Select name='person_id' id='person_id' class='form-control'>
                    <option  value = ''>เลือกบุคลากร</option>
                </select>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label ></label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label ></label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label ></label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label ></label>
          </div>
        </div>
          </form>
      </div>
</div>
<?}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
}

//ส่วนลบข้อมูล
if($index==3){
}

//ส่วนบันทึกข้อมูล
if($index==4){
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
		alert("กรุณาเลือกบุคลากร");
		}
		else if(frm1.car_permission1[0].checked ==false && frm1.car_permission1[1].checked ==false && frm1.car_permission1[2].checked ==false ){
			alert("กรุณาเลือกเจ้าหน้าที่ หรือผู้เห็นชอบ หรือผู้อนุมัติ ");
		}else{
			callfrm("?option=car&task=main/permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=car&task=main/permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
</body>
