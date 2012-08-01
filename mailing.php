<?php
$mail = trim($_POST['mail']);
$name = htmlspecialchars(trim($_POST['name']));

if (!preg_match("@^[a-z0-9._%+-]+\@[a-z0-9.-]+\.[a-z]{2,4}$@i", $mail))
{
	return false;
}

$passage_ligne = "\n";

// Déclaration des messages au format texte et au format HTML.
$message_txt = 'Vous avez reçu un CROSS:CROSS COFFEE CUP, rendez-vous sur crosscrosscoffeecup.cup pour découvrir ce nouveau concept ! (et changez de messagerie ;)';
$message_html = file_get_contents('../email.html');
$message_html = str_replace(array('{{url}}', '{{id}}'), array($config_url, $id), $message_html);

// Création de la boundary
$boundary = "-----=".md5(rand());

// Sujet
$objet = $name." vous a envoyé une CROSS:CROSS COFFEE CUP";

// Header
$header = "From: \"CCCC\"<contact@crosscrosscoffeecup.com>".$passage_ligne;
$header.= "Reply-to: \"CCCC\" <contact@crosscrosscoffeecup.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

// Message
$message = $passage_ligne."--".$boundary.$passage_ligne;
// Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
$message.= $passage_ligne."--".$boundary.$passage_ligne;
// Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
 
// Envoi du mail.
return mail($mail,$objet,$message,$header);