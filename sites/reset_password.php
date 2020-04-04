<?php
    include_once('lib/securimage/securimage.php');
    include_once('lib/phpmailer/class.phpmailer.php');

    $securimage = new Securimage();

    $email = null;
    $error = null;

    if(isset($_POST['email']) && strcmp($_POST['email'],'') != 0)
    {
        $email = $_POST['email'];

        //captcha check
        if ($securimage->check($_POST['captcha_code']) == true)
        {
            //check email
            $count = $db->checkEmail($email);
            if($count > 0)
            {
                $password = generatePassword(8, 3);
                $ret = $db->changePassword($email, $password);

                $host  = $_SERVER['HTTP_HOST'];
                $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

                $mail_text_array = array();
				$mail_template = file_get_contents("templates_mail/account_create.htm");
				$mail_text_array[0] = Translator::_translate('passwordreset_header');
				$mail_text_array[1] = Translator::_translate('passwordreset_text1')."<strong>".$password."</strong>";
				$mail_text_array[2] = Translator::_translate('passwordreset_text2');
				$mail_text_array[3] = 'http://'.$host.$uri;
				$mail_text_array[4] = Translator::_translate('passwordreset_link_text');
				$mail_text_array[5] = Translator::_translate('email_contact');
				$mail_text_array[6] = Translator::_translate('email_unsubscribe');
				$mail_text_array[7] = Translator::_translate('email_link_to_game');
				$mail_text_array[8] = Translator::_translate('email_quote_'.rand(0, 10));
				$mail_text_array[9] = 'http://'.$host.$uri.'/?site=unsubscribe&email='.base64_encode($email).'&land='.$language;	//unsibscribe link
				$mail_text_array[10] = Translator::_translate('email_link_to_facebook');
				$mail_text_array[11] = Translator::_translate('email_link_to_twitter');
				
				$array_size = count($mail_text_array);
				for($i = 0; $i < $array_size; ++$i)
				{
					$mail_template = str_replace("%".($i + 1)."%", $mail_text_array[$i], $mail_template);
				}
				
				//$mail = new PHPMailer();
				$message = $mail_template;
                /*
                $message = Translator::_translate('tr_reset_password_email_text1').'<br><br>';
                $message.= $password;
                */
                /*$mail->From = 'no-reply@todream.eu';
                $mail->FromName = Translator::_translate('tr_reset_password_email_subject');
                $mail->AddAddress($email);
                $mail->AddAddress($admin_mail);
                $mail->Subject = Translator::_translate('tr_reset_password_email_subject');
                $mail->Body = $message;
                $mail->IsHTML(true);
                $mail->CharSet = 'utf-8';
                if($ret && $mail->Send())
                {*/
		$ch = curl_init("formel.todream.eu/racing_manager_send_email.php");
		$encoded = "from=".urlencode("admin@racing-manager.com")."&";
		$encoded.= "fromname=".urlencode(Translator::_translate('tr_reset_password_email_subject'))."&";
		$encoded.= "email=".urlencode($email)."&";
		$encoded.= "bcc=".urlencode($admin_mail)."&";
		$encoded.= "subject=".urlencode(Translator::_translate('tr_reset_password_email_subject'))."&";
		$encoded.= "message=".urlencode($message);

		curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		if($output == "1")
		{
                    unset($_POST['email']);
                    unset($_POST['password']);
                    header('Location: ?site=login');
                }
                else
                {
                    //email address not in db
                    $error = Translator::_translate('tr_reset_password_password_not_changed');
                }
            }
            else
            {
                //email address not in db
                $error = Translator::_translate('tr_reset_password_email_not_found');
            }
        }
        else
        {
            //captcha false
            $error = Translator::_translate('tr_create_account_security_code_incorrect');
        }
    }

    $head = '<style type="text/css">
            body { background: url(./content/img/bg-login.jpg) !important; }
        </style>';

    //set variables to display form
    $smarty->assign('head', $head);			//for layout.html

    $track['weather'] = 100;

    $smarty->assign('track', $track);
    $smarty->assign('email', $email);
    $smarty->assign('error', $error);
    $smarty->assign('content', 'reset_password.tpl');
