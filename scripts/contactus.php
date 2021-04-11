<?php

include_once 'mailer/mailer.php';
include_once 'mailer/class.smtp.php';

function sendMail($email, $name, $subject, $message, $cc = null, $bcc = null)
{

    $mail = new PHPMailer(false);
    $mail->Debug = true;
    // $mail->SMTPDebug = true;
    // $mail->IsSMTP();
    // $mail->SMTPAuth = true;
    // $mail->SMTPSecure = "ssl";
    // $mail->Port = 465; // or 587
    $mail->Host = "mail.meghterbin-mejtemiin.com";
    $mail->Username = $mail->From = "noreply@meghterbin-mejtemiin.com";
    $mail->Password = 'U2rzxwW4SBKs';
    $mail->FromName = "Meghterbin Mejtemiin";
    $mail->AddAddress($email, $name);
    if ($cc)
        $mail->AddCC($cc["email"], $cc["name"]);
    if ($bcc)
        $mail->AddBCC($bcc["email"], $bcc["name"]);
    $mail->WordWrap = 200;
    $mail->CharSet = "UTF-8";
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body = $message;
    if (!$mail->Send())
        return false;
    return true;
    $mail->SmtpClose();
}


$networking_committee = "committee.networking@meghterbin-mejtemiin.com";
$tech_team = "tech-team@meghterbin-mejtemiin.com";
$communication_committee = "committee.communications@meghterbin-mejtemiin.com";


$cities = array(
    "us-dc" => "usa.dc",
    "us-la" => "usa.la",
    "us-sf" => "usa.sf",
    "us-ph" => "usa.philadelphia",
    "us-ho" => "usa.houston",
    "us-oh" => "usa.ohio",
    "us-bo" => "usa.boston",
    "us-se" => "usa.seattle",
    "ca-mo" => "canada.montreal",
    "ca-to" => "canada.toronto",
    "ca-ot" => "canada.ottowa",
    "ca-va" => "canada.vancouver",
    "uk-lo" => "uk.london",
    "ir-du" => "ireland.dublin",
    "fr-pa" => "france.paris",
    "fr-ly" => "france.lyon",
    "fr-li" => "france.lille",
    "fr-na" => "france.nantes",
    "fr-ma" => "france.marseille",
    "fr-be" => "france.besanccon",
    "fr-re" => "france.rennes",
    "bg-le" => "belgium.leuven",
    "bg-br" => "belgium.brussels",
    "ge-fr" => "germany.frankfurt",
    "ge-ei" => "germany.eilenburg",
    "sp-ba" => "spain.barcelona",
    "sp-ma" => "spain.madrid",
    "sw-ge" => "switzerland.geneva",
    "sw-zu" => "switzerland.zurich",
    "it-mi" => "italy.milan",
    "it-to" => "italy.torino",
    "ne-am" => "netherlands.amsterdam",
    "cz-pr" => "czechia.prague",
    "hu-bu" => "hungary.budapest",
    "no-os" => "norway.oslo",
    "sw-st" => "sweden.stockholm",
    "tu-is" => "turkey.istanbul",
    "au-sy" => "australia.sydney",
    "au-me" => "australia.melbourne",
    "sa-ri" => "saudi-arabia.riyadh",
    "ua-du" => "uae.dubai",
    "ku-ku" => "kuwait.kuwait-city",
    "qa-do" => "qatar.doha",
    "br-sp" => "brazil.sao-paulo",
    "sk-se" => "south-korea.seoul"
);


if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {

    ############################
    # SIGN THE MANIFESTO
    ############################
    if ($_REQUEST['type'] == "manifesto") {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email'])) {
            $messageBody = "<p><strong>Name:</strong> {$_REQUEST['name']}</p>";
            $messageBody .= "<p><strong>email:</strong> {$_REQUEST['email']}</p>";
            if (isset($_REQUEST['message']))
                $messageBody .= "<p><strong>Why are you signing:</strong> {$_REQUEST['message']}</p>";
            // $sent = sendMail("rita.rouhban@gmail.com", "", "Manifesto signature", $messageBody);
            $sent = sendMail($tech_team, "", "", $messageBody);
            if ($sent)
                echo "sent successfully";
            else
                echo "Error occured";
        }
    }

    ############################
    # CONTACT US
    ############################
    if ($_REQUEST['type'] == "contact") {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['subject']) && isset($_REQUEST['message'])) {
            $messageBody = "<p><strong>Name:</strong> {$_REQUEST['name']}</p>";
            $messageBody .= "<p><strong>email:</strong> {$_REQUEST['email']}</p>";
            $messageBody .= "<p><strong>Message:</strong> {$_REQUEST['message']}</p>";
            // $sent = sendMail("rita.rouhban@gmail.com", "", $_REQUEST['subject'], $messageBody);
            $sent = sendMail($communication_committee, "", $_REQUEST['subject'], $messageBody);
            if ($sent)
                echo "sent successfully";
            else
                echo "Error occured";
        }
    }

    ############################
    # JOIN THE GLOBAL MOVEMENT
    ############################
    if ($_REQUEST['type'] == "join") {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['city'])) {
            $messageBody = "<p><strong>Name:</strong> {$_REQUEST['name']}</p>";
            $messageBody .= "<p><strong>email:</strong> {$_REQUEST['email']}</p>";
            if (isset($_REQUEST['message']))
                $messageBody .= "<p><strong>Message:</strong> {$_REQUEST['message']}</p>";
            if ($_REQUEST['city'] == "other") {
                // $sent = sendMail("rita.rouhban@gmail.com", "", "New Member", $messageBody . "city email = " . $city_email);
                $sent = sendMail($networking_committee, "", "New Member", $messageBody);
                if ($sent)
                    echo "sent successfully";
                else
                    echo "Error occured";
            } else {
                $city_email = $cities[$_REQUEST['city']] . "@meghterbin-mejtemiin.com";
                //$sent = sendMail("rita.rouhban@gmail.com", "", "New Member", $messageBody . "city email = " . $city_email);
                $sent = sendMail($city_email, "", "New Member", $messageBody);
                sendMail($networking_committee, "", "New Member", $messageBody);
                if ($sent)
                    echo "sent successfully";
                else
                    echo "Error occured";
            }
        }
    }
}
