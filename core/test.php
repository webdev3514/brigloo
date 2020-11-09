<?php
             require '/home3/brigloo/public_html/plugins/PHPMailer/src/Exception.php';
            require  '/home3/brigloo/public_html/plugins/PHPMailer/src/PHPMailer.php';
            require  '/home3/brigloo/public_html/plugins/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer;                        

        $mail->isSMTP();    
       // $mail->Host = "ssl://smtp.gmail.com"; 
        $mail->Host = 'gator3276.hostgator.com';  
        $mail->SMTPAuth = false; 
          $mail->SMTPSecure = 'ssl';                          
        $mail->Port = 465; 
        
        $mail->Username = 'your_name';                
        $mail->Password = 'your_password';                        
                                      
        $mail->setFrom( 'your_name', 'Kamaldhari' );
        $mail->addAddress( 'your_name' );             
        $mail->addReplyTo( 'your_name' );
        
        $mail->isHTML(true);  
        $mail->Subject = "test";
        $mail->Body    = "testing testing";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
?>