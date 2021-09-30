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
    <!-- // kiểm tra dữ liệu đầu vào -->
    <?php
    $pheptinh = "";
    $a = $b = 0;
    //biến oke để báo hiệu dữ liệu hợp lệ
    $oke = 0;
    $aerr = $berr = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $a = test_input($_POST['a']);
        $b = test_input($_POST['b']);
        $pheptinh = test_input($_POST['pheptinh']);
        if (check_input($a) == 1 && check_input($b) == 1 && $pheptinh != null)
            $oke = 1;
    }
    
    // hàm này kiểm tra số có hợp lệ không, ket qua true 1/ false 0
    function check_input($data)
    {
        // kiem tra so do co hop le khong
        if (is_numeric($data) == 1)
            if ($data >= 0 && $data <= 999999999)
                return 1;
            else return 0;
    }
    // hàm này xử lý đầu vào, loại bỏ khoảng trống, v.v.v
    function test_input($data)
    {
        // xu ly cat cac khoang space, v.v.v
        $data = str_replace(' ', '', $data);
        // xử lý số 0 phía trước
        if (strlen($data) >= 2)
            for ($i = 0; $i < strlen($data); $i++)
                if ($data[$i] != 0) {
                    $data = substr($data, $i);
                    break;
                } else 
             if ($i == (strlen($data) - 1) && $data[$i] == 0)
                    $data = 0;
        //xử lý -0...
        if (strlen($data) >= 2)
            if ($data[0] == '-' && $data[1] == 0)
                $data = 0;
        // xử lý ký tự đặc biệt
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <form action="pheptinh.php" method="POST">
        <table>
            <!-- // tiêu đề -->
            <tr>
                <td colspan="3">
                    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
                </td>
            </tr>
            <!-- //phép tính -->
            <tr>
                <td>Chọn phép tính:</td>
                <td><input type="radio" id="cong" name="pheptinh" value="cong" checked><label for="cong">Cộng</label>
                    <input type="radio" id="tru" name="pheptinh" value="tru" <?php if ($pheptinh == 'tru') echo 'checked' ?>><label for="tru">Trừ</label>
                    <input type="radio" id="nhan" name="pheptinh" value="nhan" <?php if ($pheptinh == 'nhan') echo 'checked' ?>><label for="nhan">Nhân</label>
                    <input type="radio" id="chia" name="pheptinh" value="chia" <?php if ($pheptinh == 'chia') echo 'checked' ?>><label for="chia">Chia</label>
                </td>
            </tr>
            <!-- // số 1 -->
            <tr>
                <td><label for="a">Số thứ nhất:</label></td>
                <td><input type="text" name="a" id="a" value="<?php echo $a ?>"></td>
                <!-- báo lỗi  -->
                <td>avaiable number [0,9xE9]</td>
            </tr>
            <!-- // số 2 -->
            <tr>
                <td><label for="b">Số thứ hai:</label></td>
                <td><input type="text" name="b" id="b" value="<?php echo $b ?>"></td>
                <!-- báo lỗi  -->
                <td>avaiable number [0,9xE9]</td>
            </tr>
            <!-- //tính -->
            <tr colspan="3">
                <td> <input type="submit" value="Tính"></td>
                
            </tr>
            <?php
            if ($oke == 1)  
            echo "<script>  
            window.location.href = 'xulypheptinh.php?a=$a&b=$b&pheptinh=$pheptinh';
            </script>";
            ?>
        </table>
    </form>
</body>

</html>