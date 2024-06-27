<?php
// รีเซ็ตรหัสผ่าน persident
include '../conn.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("location:../index.php");
    $_SESSION['alert_type'] = 'error';
    $_SESSION['alert_message'] = 'กรุณาลงชื่อเข้าสู่ระบบ';
    $_SESSION['alert_title'] = 'ไม่สามารถเข้าถึงได้ กรุณาลงชื่อเข้าใช้งาน';
    exit;
}

// ตรวจสอบว่ามีการส่งค่า user_id และ username มาหรือไม่
if (isset($_POST['user_id']) && isset($_POST['username'])) {

    $user_id = $_POST['user_id'];
    $new_username = $_POST['username'];
    $name = isset($_POST['name']) ? $_POST['name'] : ''; // กำหนดค่าเริ่มต้นให้ $name เป็นค่าว่าง

        $sql = "UPDATE user SET Username = :username, Name = :name WHERE UserID = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $new_username, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            $_SESSION['alert_type'] = 'error';
            $_SESSION['alert_message'] = 'ไม่สามารถบันทึกข้อมูลได้';
            $_SESSION['alert_title'] = 'บันทึกข้อมูลไม่สำเร็จ';
            header("location:../admin/index.php");
            exit;

      

        }else{  
            
            $_SESSION['username'] = $new_username;
             $_SESSION['name'] = $name;
            $_SESSION['alert_type'] = 'success';
            $_SESSION['alert_message'] = 'บันทึกข้อมูลเรียบร้อย';
            $_SESSION['alert_title'] = 'บันทึกข้อมูลสำเร็จ';
            header("location:../admin/index.php");
            exit;     
          
        }


    
}
?>
