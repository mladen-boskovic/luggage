<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require_once "../classes/SuperKlasa.php";
require_once "../classes/Korisnik.php";
require_once "../classes/Baza.php";


if(isset($_POST['resetPassEmailDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $email = trim($_POST['email']);
    $proveraEmail = "/^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/";
    $greska = "";

    if(!$email){
        $greska = "Polje za email mora biti popunjeno";
    } else if(!preg_match($proveraEmail, $email)){
        $greska = "Email nije u dobrom formatu";
    }

    if($greska !== ""){
        $code = 422;
        $data = $greska;
    } else{
        $korisnik = new Korisnik(Baza::instanca());
        $korisnik->setEmail($email);
        $korisnikSelect = $korisnik->resetLozinkeEmailProvera();

        if(!$korisnikSelect){
            $code = 409;
        } else {
            $token = md5(sha1($email . rand() . time() . rand()));
            $korisnik->setResetPassword($token);
            $korisnik->setEmail($email);
            $korisnik->resetLozinkeEmailUspesnaProvera();

            $mail = new PHPMailer(true);
            try {
                //Server settings
                //$mail->SMTPDebug = 2;                                     // Enable verbose debug output
                /*$mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );*/
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                             // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                $mail->Username = 'auditorne.php@gmail.com';                // SMTP username
                $mail->Password = 'Sifra123';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                          // TCP port to connect to

                //Recipients
                $mail->setFrom('auditorne.php@gmail.com', 'Luggage');
                $mail->addAddress($email);                                  // Add a recipient
                //$mail->addAddress('ellen@example.com');                   // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');             // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // Optional name

                //Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Resetovanje lozinke';
                $mail->Body    = 'Resetovanje lozinke: <a href="http://localhost/php2sajt1/modules/resetpassword.php?reset='. $token .'" target="_blank">KLIKNITE OVDE</a>';
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                //echo 'Message has been sent';
                $code = 200;
            } catch (Exception $e) {
                //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                $code = 500;
            }
        }
    }


    http_response_code($code);
    echo json_encode(['message' => $data]);
}


if(isset($_GET['reset'])){
    $token = $_GET['reset'];
    $korisnik = new Korisnik(Baza::instanca());
    $korisnik->setResetPassword($token);

    $korisnikSelect = $korisnik->resetLozinkeTokenProvera();
    if(!$korisnikSelect){
		header('Refresh: 5; URL=http://localhost/php2sajt1/index.php');
        echo "<h3>Nevažeči zahtev za resetovanje lozinke</h3>";
    } else{
        header('Location: http://localhost/php2sajt1/index.php?page=resetpassword&reset=' . $token);
    }
}


if(isset($_POST['resetLozinkeDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $token = $_POST['token'];
    $novaLozinka = md5($_POST['novaLozinka']);
    $novaLozinka2 = md5($_POST['novaLozinka2']);
    $promenaLozinkeGreske = [];

    if(!$_POST['novaLozinka']){
        $promenaLozinkeGreske[] = "Polje za novu lozinku mora biti popunjeno";
    } else if(strlen($_POST['novaLozinka']) < 6){
        $promenaLozinkeGreske[] = ("Nova lozinka mora imati bar 6 karaktera");
    }

    if(!$_POST['novaLozinka2']){
        $promenaLozinkeGreske[] = "Polje za ponovljenu lozinku mora biti popunjeno";
    } else if(strlen($_POST['novaLozinka2']) < 6){
        $promenaLozinkeGreske[] = ("Ponovljena lozinka mora imati bar 6 karaktera");
    }


    if($_POST['novaLozinka'] !== $_POST['novaLozinka2']){
        $promenaLozinkeGreske[] = "Nova lozinka i ponovljena lozinka se ne poklapaju";
    }

    if(count($promenaLozinkeGreske)){
        $code = 422;
        $data = $promenaLozinkeGreske;
    } else{
        $noviToken = md5(sha1(time() . rand() . time() . rand() . time() . rand()));
        $korisnik = new Korisnik(Baza::instanca());
        $korisnik->setToken($token);
        $korisnik->setResetPassword($noviToken);
        $korisnik->setLozinka($novaLozinka);

        $code = $korisnik->resetLozinke() ? 204 : 500;
    }


    http_response_code($code);
    echo json_encode(['message' => $data]);
}



if(empty($_POST['resetPassEmailDugme']) && empty($_GET['reset']) && empty($_POST['resetLozinkeDugme'])){
    header("Location: http://localhost/php2sajt1/index.php");
}