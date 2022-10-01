<?php

    require_once "../../library/PHPMailer/class.phpmailer.php";
    
    class Mailer {
        var $mail;
        
        public function __construct($smtp_server=array('SMTP')) {
            
            $this->mail = new PHPMailer(true);
            $this->mail->IsSMTP();
            $this->mail->CharSet = "utf-8";
            $this->mail->SMTPDebug = false; //true - Details Mode, 3 - Verbose Mode
            $this->mail->SMTPAuth = true;
            #$this->mail->SMTPSecure = "SSL";
            
            if ($smtp_server[0] == 'SMTP') {
                $this->mail->Host = "socvms.fizqin.com";
                $this->mail->Port = 26;
                $this->mail->Username = "admin@socvms.fizqin.com";
                $this->mail->Password = 'Fizqin123@';                
                $this->mail->setFrom('admin@socvms.fizqin.com','SOCVMS');
            }
        }
        
        public function sendmail($to, $to_name, $subject, $body, $is_html=false) {
            
            if(!$to) $to = array();
            if ($is_html) {
                $this->mail->IsHTML(true);    
            }
            $this->mail->ClearBCCs();
            try{
                
                foreach($to as $xTo):
                    $this->mail->AddAddress($xTo, $to_name);
                    #$this->mail->AddBCC($xTo, $to_name);
                endforeach;
                
                $this->mail->Subject = $subject;
                $this->mail->Body    = $body;
                $this->mail->Send();
                // echo "Message Sent OK</p>\n";
     
            } catch (phpmailerException $e) {
                echo $e->errorMessage(); // Pretty error messages from PHPMailer
            } catch (Exception $e) {
                echo $e->getMessage(); // Boring error messages from anything else!
            }            
        }
        
    }
