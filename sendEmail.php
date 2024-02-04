<?php

interface EmailInterface
{
    public function composeEmail($to);
}

class Mail
{
    private $authentication = true;
    private $host;
    private $user;
    private $password;

    public function __construct($host, $user, $password, $authentication)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->authentication = $authentication;
    }

    public function sendEmail($to, $subject, $body, $isHtml = false, $cc = [], $bcc = [])
    {
        // ... Sends the email and returns true if everything went well
        // or throws an exception if it fails
        return "Mail has been sent successfully";
    }
}

class RegistrationEmail implements EmailInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function composeEmail($to)
    {
        $subject = "Welcome to our Web Application";
        $body = "<p>Welcome <strong>%name%</strong>,<br>
            your registration has been successfully completed.<p>
            <p>We hope that our services will be to your liking</p>
            <p>Best regards</p>";

        $body = str_replace("%name%", $this->name, $body);

        return [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'isHtml' => true,
        ];
    }
}

class UnsubscribeEmail implements EmailInterface
{
    public function composeEmail($to)
    {
        $subject = "Unsubscribe from our Web Application";
        $body = "This is an unsubscribe email. You can customize the text.";

        return [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
        ];
    }
}

class PasswordReminderEmail implements EmailInterface
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function composeEmail($to)
    {
        $subject = "Password Reminder";
        $body = "Dear user,
            we remind you that your access data are as follows:
            user: %username%
            password: %password%.
            Best regards.";

        $body = str_replace("%username%", $this->username, $body);
        $body = str_replace("%password%", $this->password, $body);

        return [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
        ];
    }
}

$mailRegistration = new Mail("192.168.1.66", "registration", "r3g1str0", true);
$registrationEmail = new RegistrationEmail("John Doe");
$emailDetails = $registrationEmail->composeEmail("user@example.com");
$mailRegistration->sendEmail($emailDetails['to'], $emailDetails['subject'], $emailDetails['body'], $emailDetails['isHtml']);

$mailUnsubscribe = new Mail("192.168.33", "user", "pAss12345", true);
$unsubscribeEmail = new UnsubscribeEmail();
$emailDetails = $unsubscribeEmail->composeEmail("user@example.com");
$mailUnsubscribe->sendEmail($emailDetails['to'], $emailDetails['subject'], $emailDetails['body']);

$mailPassword = new Mail("192.168.1.22", "", "", false);
$passwordReminderEmail = new PasswordReminderEmail("john_doe", "my_password");
$emailDetails = $passwordReminderEmail->composeEmail("user@example.com");
$mailPassword->sendEmail($emailDetails['to'], $emailDetails['subject'], $emailDetails['body']);

?>
