<?php

if($_POST['id'] === "contact-center-form-2-form") {
	require_once 'smtp/PHPMailerAutoload.php';

	$to = ""; // Your e-mail address here.

	$data_array = json_decode($_POST['data']);

	$body = "";
	foreach ($data_array as $key => $value) {
		if (isset($value->name) && $value->name !== "") {
			$body .= $value->name.': '.$value->value.'<br>';
		}
	}

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               	// Enable verbose debug output

	$mail->isSMTP();                                      	// Set mailer to use SMTP
	$mail->Host = "qwe";  		// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               	// Enable SMTP authentication
	$mail->Username = "qwe";  // SMTP username
	$mail->Password = "qwe";  // SMTP password
	$mail->SMTPSecure = "tls";  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = "587";          // TCP port to connect to

	$mail->setFrom("qwe");
	$mail->addAddress($to);     							// Add a recipient

	$mail->isHTML(true);                                  	// Set email format to HTML

	$mail->Subject = "qwe";
	$mail->Body    = $body;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	foreach( $_FILES as $file) {
		if ( !move_uploaded_file( $file['tmp_name'], dirname(__FILE__) . '/../tmp/' . $file['name'] ) ) {
			echo "error upload file";
			continue;
		}

		$file_to_attach = dirname(__FILE__) . '/../tmp/' . $file['name'];
		$mail->AddAttachment( $file_to_attach , $file['name'] );
	}

	if(!$mail->send()) {
		header("HTTP/1.1 406 Not Acceptable");
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
}
if($_POST['id'] === "") {
	$mailto = "";

	$data_array = json_decode($_POST['data']);
	$message = "";
	foreach ($data_array as $key => $value) {
		if (isset($value->name) && $value->name !== "") {
			$message .= $value->name.': '.$value->value.'<br>';
		}
	}

	$subject = "";

	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (RFC)
	$eol = "\r\n";

	// main header (multipart mandatory)
	$headers = "From: $mailto" . $eol;
	$headers .= "Reply-To: $mailto" . $eol;
	$headers .= "MIME-Version: 1.0" . $eol;
	$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
	$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
	$headers .= "This is a MIME encoded message." . $eol;

	// message
	$body = "--" . $separator . $eol;
	$body .= "Content-Type: text/html; charset=iso-8859-1" . $eol;
	$body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
	$body .= "<div>" . $message . "</div>" . $eol . $eol;

	foreach( $_FILES as $file) {
		if ( !move_uploaded_file( $file['tmp_name'], dirname(__FILE__) . '/../tmp/' . $file['name'] ) ) {
			echo "error upload file: " . $file['name'];
			continue;
		}
		$filename = $file['name'];
		$path = dirname(__FILE__) . '/../tmp';
		$file = $path . "/" . $filename;

		$content = file_get_contents($file);
		$content = chunk_split(base64_encode($content));

		// attachment
		$body .= "--" . $separator . $eol;
		$body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
		$body .= "Content-Transfer-Encoding: base64" . $eol;
		$body .= "Content-Disposition: attachment" . $eol;
		$body .= $content . $eol . $eol;
	}

	$body .= "--" . $separator . "--";

	//SEND Mail
	if (mail($mailto, $subject, $body, $headers)) {
		echo "Отправка почты ... ОК!"; // or use booleans here
	} else {
		echo "Отправка почты ... ОШИБКА!";
		print_r( error_get_last() );
	}
}