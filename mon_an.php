<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bài tập món ăn</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="749" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="3" align="center" valign="middle">THÔNG TIN MÓN ĂN</td>
    </tr>
    <tr>
      <td width="258" rowspan="4" align="center" valign="bottom">
      <label for="file"></label>
      <!--XỬ LÝ XUẤT HÌNH ẢNH VÀO Ô HÌNH ẢNH CỦA MÓN ĂN. 
      MẶC ĐỊNH SẼ XUẤT HÌNH ĐẦU TIÊN KHI CHƯA NHẤP VÀO NÚT 'THÊM MÓN NGON' SẼ LÀ 1 TẤM HÌNH DO TA TỰ QUY ĐỊNH.-->
      <?php
        if(!isset($_POST['them'])){ //Kiểm tra xem nếu chưa nhập gì hết thì mặc định xuất hình đầu tiên trong folder hinh_anh
          echo "<img src='hinh_anh/mon_an_1.jpg' width='200px' height='200px'>"; //Xuất ra hình đầu tiên làm mặc định khi mới vào trang web.
        }
        else
        { //Ngược lại, xuất ra hình sẽ được người dùng chọn lấy.
          $hinh='hinh_anh/'.$_FILES['file']['name'];
          echo "<img src='$hinh' width = '200px' height = '200px'>";
        }
      ?>
      <input type="file" name="file" id="file" value="<?php echo $_FILES['file']['name']; ?>" /></td>
      <td width="136">Tên món ăn:</td>
      <td width="337"><label for="textfield"></label>
      <input type="text" name="ten_mon" id="ten_mon" value="<?php if(isset($_POST['them'])) echo $_POST['ten_mon']; ?>" /></td>
    </tr>
    <tr>
      <td>Loại món:</td>
      <td><label for="loai_mon"></label>
        <select name="loai_mon" id="loai_mon">
        <!-- ĐỔ DỮ LIỆU LOẠI MÓN VÀO LIST MENU NÀY. BỎ GIÁ TRỊ MÃ LOẠI MÓN: 1, 2, 3,... VÀO VALUE CỦA OPTION, 
        CÒN GIÁ TRỊ TÊN LOẠI MÓN THÌ SHOW LÊN CHO NGƯỜI DÙNG THẤY ĐỂ LỰA CHỌN -->
          <?php
            $file=fopen('tap_tin\loai_mon.txt',"r",1); //Đọc nội dung file text chứa thông tin loại món.
            $noi_dung='';
            while (!feof($file)) {
              $noi_dung=$noi_dung.fgets($file); //Đọc lần lượt từ đầu file text tới cuối file text, dùng hàm feof (End-of-File) để kiểm tra từ đầu tới cuối.Đổ dữ liệu vào biến $noi_dung.
            }
            fclose($file);
            //Cho giá trị vừa lấy ở $noi_dung vào $mang_loai, xác định mã loại món và tên loại món.
            $mang_loai=explode("/*",$noi_dung); 
            $n = count($mang_loai);
            
            for($i=1; $i < $n; $i++){
              //Nếu là mã loại món thì xuất vào giá trị value của từng option, đồng thời để tên loại món ra ngoài cho người dùng thấy.
                $mang=explode("|",$mang_loai[$i]);
                echo "<option value='$mang[0]'";
                if(isset($_POST['them']) && $_POST['loai_mon']==$mang[0]) echo "selected='selected'";
                  echo ">$mang[1]</option>";
            }            
          ?>
        </select></td>
    </tr>
    <tr>
      <td>Cách chế biến:</td>
      <td rowspan="2" align="center" valign="middle"><label for="che_bien"></label>
      <textarea name="che_bien" id="che_bien" cols="45" rows="5"><?php if(isset($_POST['them'])) echo $_POST['che_bien']; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="bottom"><input type="submit" name="them" id="them" value="THÊM MÓN NGON" /></td>
    </tr>
  </table>

<?php
  if(isset($_POST['them'])){
    //Xác định kiểu định dạng có phải hình ảnh hay không. Đồng thời kiểm tra xem có lỗi không. Giới hạn kích thước < 20MB.
    if(($_FILES['file']['type'] == "image/gif") || ($_FILES['file']['type'] == "image/jpg") && ($_FILES['file']['size'] > 20000) ){
      if($_FILES['file']['error'] > 0){
        echo "Lỗi".$_FILES['file']['error']."<br />";
      }
      else
      {
        $duong_dan="hinh_anh/".$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],"hinh_anh/".$_FILES['file']['name']);
        
      }
    }
      $ten_mon = $_POST['ten_mon'];
      $loai_mon = $_POST['loai_mon'];
      $che_bien = $_POST['che_bien'];
      $hinh = $_FILES['file']['name'];

      $noidung = "/*".$loai_mon."|".$ten_mon."|".$che_bien."|".$hinh;

      //Ghi nội dung trên form vừa nhập vào file text có tên mon_an.txt theo đúng định dạng ở phần nội dung.
      $file = fopen("tap_tin/mon_an.txt","a",1);
      fwrite($file,$noidung);
      echo "<p align='center'<b>Đã ghi file thành công!</b></p>";
      fclose($file);
  }
?>

  <p>&nbsp;</p>
  <table width="700" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="168">Danh mục món ăn</td>
      <td width="519">Thông tin món ăn</td>
    </tr>
    <tr>
      <td>
      <?php
        echo"<table width='100%' class='style44'>";
        for($j=1;$j<$n;$j++)
        {
         $mang_new=explode("|",$mang_loai[$j]);
         echo "<tr>";
                 echo "<td>";
                 echo "<a style='text-decoration:none;' href='mon_an.php?ML=".$mang_new[0]."'><b>".$mang_new[1]."</a>";
                 echo "</br>";
                 echo "</td>";
         echo "</tr>";
        }
        echo "</table>";
      ?>          
      </td>
      <td>
      <?php

            $file = fopen("tap_tin\mon_an.txt","r",1);
            if(!$file)
            {
                echo "<br> Không mở được!<br>";
                exit;
            }
            else
            {
                $noidung='';
                while (!feof($file))
                {
                    $noidung = $noidung.fgets($file);
                }
                fclose($file);
                $mang_mon_an = explode("/*",$noidung);
                $n= count($mang_mon_an);
                echo "<table align='center' width='100%' border='0'>";
                if(!isset($_GET["ML"]))
                {
                    $t=0;
                    for($i=1;$i<$n;$i++)
                    {
                        $t =1;
                        $mang= explode("|",$mang_mon_an[$i]);
                        echo"<tr>";
                        echo " <td><img src='hinh_anh/$mang[3]' width = '200px' height = '200px'/>' </td>";
                        echo "<td><b>Tên món:".$mang[1]."</b>";

                        echo "</br><u>Cách chế biến:</u><br>".nl2br($mang[2])."</td>";
                        echo"</tr>";
                        if($t==1) break;
                    }
                }
                else
                {
                    $ma_loai = $_GET["ML"];
                    for($i=1;$i<$n;$i++)
                    {
                        $mang= explode("|",$mang_mon_an[$i]);
                        if($ma_loai == $mang[0])
                        {
                            echo"<tr>";
                            echo " <td><img src='hinh_anh/$mang[3]' width = '200px' height = '200px'/>' </td>";
                            echo "<td><b>Tên món:".$mang[1]."</b>";

                            echo "</br><u>Cách chế biến:</u><br>".nl2br($mang[2])."</td>";
                            echo"</tr>";
                        }
                    }
                }
            }
            ?>
      </td>
    </tr>
  </table>
</form>
</body>
</html>