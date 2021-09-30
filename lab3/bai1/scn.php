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
    <!-- xu ly tinh dien tich -->
    <?php
    //ban đầu, chương trình sẽ đặt mặc định là 0
    $cd = $cr = $dt = 0;
    // các thông báo lỗi ban đầu sẽ là null,vì nó sẽ hiển thị lên form ban đầu 
    // chỉ khi các biến không hợp lệ thì mới gắn lỗi cho nó hiển thị
    // thấy rằng, vì sao thông báo lỗi của diện tích là có một biến riêng
    // trong khi ta diện tích chỉ có 1 trường để hiển thị, và biến php có thể tự chuyển kiểu mà không cần khai báo
    // để cho hạn chế sai xót, ta sẽ để thông báo lỗi cho diện tích là một biến riêng
    $cderr = $crerr = $dterr = "";
    // kiểm tra xem form đã được post chưa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // gắn các biến sau khi đã loại bỏ các từ thừa 
        $cd = test_input($_POST['cd']);
        $cr = test_input($_POST['cr']);
        //  nếu như 2 số cd và cr hợp lệ thì gắn giá trị cho diện tích
        if (check_input($cd) == 1 && check_input($cr) == 1) {
            //diện tích
            $dt = $cd * $cr;
        }
        // nếu không hợp lệ thì báo lỗi 
        else
        //có 2 loại lỗi, nhập sai hoặc để trống
        {
            // nhập trống cd
            if ($cd == null)
                $cderr = "must not empty";
            // nhập sai cd
            else if (check_input($cd) == 0)
                $cderr = "avaible is a number [0,9xE9]";
            if ($cr == null)
                $crerr = "must not empty";
            else  if (check_input($_POST['cr']) == 0)
                $crerr = "avaible is a number [0,9xE9]";
            $dterr = "NaN";
        }
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

    <!-- bat dau form -->
    <form name="dientichchunhat" action="scn.php" method="POST">
        <table>
            <!-- hang 1, tieu de -->
            <tr>
                <th colspan="3">Diện tích hình chữ nhật</th>
            </tr>
            <!--hang 2 chieu dai -->
            <tr>
                <td><label for="cd">Chiều dài: </label></td>
                <td><input id="cd" name="cd" type="text" value="<?php echo $cd ?>"> </td>
                <!-- báo lỗi  -->
                <td><?php if ($cderr == null) echo "*";
                    else  echo $cderr ?></td>
            </tr>
            <!--hang 3, chieu rong -->
            <tr>
                <td><label for="cr">Chiều rộng: </label></td>
                <td><input id="cr" name="cr" type="text" value="<?php echo $cr ?>"> </td>
                <!-- báo lỗi -->
                <td><?php if ($crerr == null) echo "*";
                    else echo $crerr ?></td>
            </tr>
            <!--hang 4,ket qua dien tich -->
            <tr>
                <td><label for="dt">Diện tích: </label></td>
                <td><input id="dt" name="dt" type="text" value="<?php if ($dterr == null) echo $dt;
                                                                else echo $dterr ?>" readonly> </td>
            </tr>
            <!--hang 5,button tinh -->
            <tr>
                <td colspan="3">
                    <input type="submit" value="Tính">
                </td>
            </tr>
        </table>
    </form>

</body>

</html>