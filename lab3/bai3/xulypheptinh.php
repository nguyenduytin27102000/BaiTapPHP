<!DOCTYPE html>
<html>
<head>
<style>
body {
  background-color: linen;
}

table {
 border: 1px solid black;
 width: 50%;
 height: 60%;
}
</style>
</head>
<body>
    <?php
    $pheptinh = $_GET['pheptinh'];
    $a = $_GET['a'];
    $b = $_GET['b'];
    $kq = 0;
    switch ($pheptinh) {
        case 'cong':
            $kq = $a + $b; $pheptinh='cộng';
            break;
        case 'tru':
            $kq = $a - $b;  $pheptinh='trừ';
            break;
        case 'nhan':
            $kq = $a * $b;  $pheptinh='nhân';
            break;
        case 'chia':
            $kq = $a / $b; $pheptinh='chia';
            break;
            
    }
    ?>
    <form action="" method="POST">
        <table>
            <!-- // tiêu đề -->
            <tr>
                <td colspan="3">
                    <h2>KẾT QUẢ PHÉP TÍNH TRÊN HAI SỐ</h2>
                </td>
            </tr>
            <!-- //phép tính -->
            <tr>
                <td>Phép tính đã chọn:</td>
                <td>
                    <?php 
                    echo $pheptinh ?>
                </td>
            </tr>
            <!-- // số 1 -->
            <tr>
                <td><label for="a">Số thứ nhất: </label></td>
                <td><input type="text" name="a" id="a" value="<?php echo $a ?>" readonly></td>
            </tr>
            <!-- // số 2 -->
            <tr>
                <td><label for="b">Số thứ hai</label></td>
                <td><input type="text" name="b" id="b" value="<?php echo $b ?>" readonly></td>
            </tr>
            <!-- kết quả  -->
            <tr>
                <td><label for="kq">Kết quả</label></td>
                <td><input type="text" name="kq" id="kq" value="<?php echo $kq ?>" readonly></td>
            </tr>
            <!-- //tính -->
            <tr colspan="3">
                <td><a href="javascript:window.history.back(-1);">Tro ve trang truoc</a></td>
            </tr>
        </table>
    </form>
</body>

</html>