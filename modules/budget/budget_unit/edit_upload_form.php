<?php
echo     "<form Enctype = multipart/form-data  name='frm1'  onsubmit='return  Conf(this);'>";
echo     "<BR><div align='center'><strong><font color='#003366' size='4'>Upload เอกสาร</font></strong></div><BR>";
echo     "<hr><BR><BR>";
echo     "<table align ='center'  width='45%' border='0'>";
echo    "<tr>";
echo    "<td align = 'right'> <strong><font color='#003366' size='3'>ไฟล์เอกสาร&nbsp;&nbsp; </font></strong></td>";
echo    "<td> <input type = 'file'  name = 'userfile'  id= 'file'></td>";
echo    "</tr>";
echo    "<tr> ";
echo   "<td><input type = 'hidden' name = 'max_file_size'  value = '2000000'><input type ='hidden' name = 'id'  value =$_GET[id]><input type ='hidden' name = 'page'  value =$_GET[page]></td>";
echo   "<td>&nbsp;</td>";
echo   "</tr>";
echo  "<tr> ";
echo   "<td>&nbsp;</td>";
echo   "<td  align ='left'> <Input Type='button' name='smb' value='ตกลง' onclick='return  Conf(this)' class='button'></td>";
echo   "</tr>";
echo   "</table>";
echo   "</form>";
?>
<script language="javascript">
function Conf(Object) {
callfrm("?option=budget&task=budget_unit/edit_upload");
}
</script>
