<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $service = $_POST['service'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';

    $appointment_date = isset($_POST['appointment_date']) ? DateTime::createFromFormat('d/m/Y', $_POST['appointment_date']) : false;

    if ($appointment_date) {
        $appointment_date = $appointment_date->format('Y-m-d');
    } else {
        die("❌ รูปแบบวันที่ไม่ถูกต้อง");
    }

    $sql = "INSERT INTO appointments (firstname, lastname, phone, service, appointment_date, appointment_time) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $lastname, $phone, $service, $appointment_date, $appointment_time);

    if ($stmt->execute()) {
        echo "
        <div class='modal fade' id='successModal' tabindex='-1' aria-labelledby='successModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='successModalLabel'>✅ บันทึกข้อมูลเรียบร้อย!</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                ข้อมูลของคุณถูกบันทึกเรียบร้อยแล้ว
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>ปิด</button>
                <a href='index.php' class='btn btn-primary'>ไปที่หน้าแรก</a>
              </div>
            </div>
          </div>
        </div>

        <script>
        // รอโหลดแล้วเปิด modal
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        }
        </script>";
    } else {
        echo "❌ เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "❌ ไม่มีข้อมูลถูกส่งมา!";
}
?>