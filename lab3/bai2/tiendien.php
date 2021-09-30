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
    <!-- xử lý tính tiền điện -->
    <?php
    //ban đầu, chương trình sẽ đặt mặc định là 0
    $cscu = $csmoi  = $tt = 0;
    $dg = 20000;
    $ch = '';
    // các thông báo lỗi ban đầu sẽ là null,vì nó sẽ hiển thị lên form ban đầu 
    // chỉ khi các biến không hợp lệ thì mới gắn lỗi cho nó hiển thị
    // thấy rằng, vì sao thông báo lỗi của tổng tiền là có một biến riêng
    // trong khi ta diện tích chỉ có 1 trường để hiển thị, và biến php có thể tự chuyển kiểu mà không cần khai báo
    // để cho hạn chế sai xót, ta sẽ để thông báo lỗi cho tổng tiền là một biến riêng
    $cherr = $cscuerr = $csmoierr = $dgerr = $tterr = "";
    // kiểm tra xem form đã được post chưa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // gắn các biến sau khi đã loại bỏ các từ thừa 
        $ch = test_input_for_name($_POST['ch']);
        $cscu = test_input($_POST['cscu']);
        $csmoi = test_input($_POST['csmoi']);
        if ($csmoi < $cscu) $csmoierr = ' CẢNH BÁO: chỉ số mới < chỉ số cũ';
        $dg = test_input($_POST['dg']);
        //  nếu như các đầu vào hợp lệ 
        if (
            // check input này nên xem hàm check input for name để hiểu hơn vì sao
            (check_input_for_name($ch) == 0 || check_input_for_name($ch) == 2) &&
            check_input($cscu) == 1
            && check_input($csmoi) == 1 && check_input($dg) == 1
        ) {
            //tổng tiền
            $tt =  ($csmoi - $cscu) * $dg;
        }
        // nếu không hợp lệ thì báo lỗi 
        else
        //có 2 loại lỗi, nhập sai hoặc để trống
        {
            // nhập trống ch
            if ($ch == null)
                $cherr = "optinal";
            // nhập sai ch
            else if (check_input_for_name($ch) == 1)
                $cherr = "avaible is a Name not number ";

            // nhập trống chỉ số cũ    
            if ($cscu == null)
                $cscuerr = "must not empty";
            // nhập sai chỉ số cũ 
            else  if (check_input($cscu) == 0)
                $cscuerr = "avaible is a number [0,9xE9]";

            // nhập trống chỉ số mới 
            if ($csmoi == null)
                $csmoierr = "must not empty";
            // nhập sai chỉ số mới
            else  if (check_input($csmoi) == 0)
                $csmoierr = "avaible is a number [0,9xE9]";

            //nhập trống đơn giá
            if ($dg == null)
                $dgerr = "must not empty";
            // nhập sai đơn giá
            else  if (check_input($dg) == 0)
                $dgerr = "avaible is a number [0,9xE9]";
            //tổng tiền
            $tterr = "NaN";
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
    // hàm này để kiểm tra cho trường tên không phải số
    function check_input_for_name($data)
    {
        if ($data == null) return 0; // nếu mà rỗng = 0
        for ($i = 0; $i < strlen($data); $i++) // nếu có giá trị thì phải là string, trả về 1 nếu sai
            if (is_numeric($data[$i]) == 1)
                return 1;
        return 2; // trả về 2 nếu đúng là string
    }
    //hàm này dành cho xử lý khoảng trống Name
    function test_input_for_name($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
    <form name="tiendien" action="tiendien.php" method="POST">
        <table>
            <!-- hang 1, tieu de -->
            <tr>
                <th colspan="4">Thanh toán tiền điện</th>
            </tr>
            <!--hang 2 chủ hộ -->
            <tr>
                <td><label for="ch">Chủ hộ: </label></td>
                <td><input id="ch" name="ch" type="text" value="<?php echo $ch ?>"> </td>
                <!-- báo lỗi  -->
                <td><?php if ($cherr == null) echo "optinal";
                    else  echo $cherr ?></td>
            </tr>
            <!--hang 3, chỉ số cũ -->
            <tr>
                <td><label for="cscu">Chỉ số cũ: </label></td>
                <td><input id="cscu" name="cscu" type="text" value="<?php echo $cscu ?>"> </td>
                <td><label for="cscu">(Kw)</label></td>
                <!-- báo lỗi -->
                <td><?php if ($cscuerr == null) echo "*";
                    else echo $cscuerr ?></td>
            </tr>
            <!--hang 4, chỉ số mới -->
            <tr>
                <td><label for="csmoi">Chỉ số mới: </label></td>
                <td><input id="csmoi" name="csmoi" type="text" value="<?php echo $csmoi ?>"> </td>
                <td><label for="csmoi">(Kw)</label></td>
                <!-- báo lỗi -->
                <td><?php if ($csmoierr == null) echo "*";
                    else echo $csmoierr ?></td>
            </tr>
            <!--hang 5,đơn giá -->
            <tr>
                <td><label for="dg">Đơn giá: </label></td>
                <td><input id="dg" name="dg" type="text" value="<?php echo $dg ?>"> </td>
                <td><label for="dg">(VNĐ)</label></td>
                <!-- báo lỗi -->
                <td><?php if ($dgerr == null) echo "*";
                    else echo $dgerr ?></td>
            </tr>
            <!-- hàng 6 tổng tiền -->
            <tr>
                <td><label for="tt">Số tiền thanh toán: </label></td>
                <td><input id="tt" name="tt" type="text" value="<?php if ($tterr == null) echo $tt;
                                                                else echo $tterr ?>" readonly> </td>
                <td><label for="tt">(VNĐ)</label></td>
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