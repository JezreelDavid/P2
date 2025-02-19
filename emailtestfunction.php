<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    require 'phpmailer/src/Exception.php';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'pasiginae@gmail.com'; // Replace with your SMTP email
        $mail->Password = 'xkmx bkeu qxjd etbp'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls'; // Or 'ssl'
        $mail->Port = 587; // Use 465 for SSL or 587 for TLS

        // Recipients
        $mail->setFrom('pasiginae@gmail.com', 'Dear Lawd Baybeh Jeezus');
        $mail->addAddress('janwellhans.ibarra@gmail.com'); // Replace with recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Test Lang To';
        $mail->Body    = '
            <h1>Welcome!</h1>
            <p>This is a test email sent using PHPMailer.</p>
        ';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>
    <form method="POST" action="">
        <button type="submit">Send Email</button>
    </form>
</body>
</html>
