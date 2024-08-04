<?php
// Define receiving email address
$receiving_email_address = 'obuliabraham@gmail.com';

// Load PHP Email Form library
$php_email_form_path = '../assets/vendor/php-email-form/php-email-form.php';
if (file_exists($php_email_form_path)) {
    include $php_email_form_path;
} else {
    // Log error and display user-friendly message
    error_log('Unable to load the "PHP Email Form" Library!');
    echo 'Error: Unable to load the email form library. Please try again later.';
    exit;
}

// Create PHP Email Form instance
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Set email recipient and sender information
$contact->to = $receiving_email_address;
$contact->from_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$contact->from_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$contact->subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

// Set SMTP configuration (use environment variables or a secure config file instead)
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);

// Add message fields
$contact->add_message($contact->from_name, 'From');
$contact->add_message($contact->from_email, 'Email');
$contact->add_message(filter_var($_POST['message'], FILTER_SANITIZE_STRING), 'Message', 10);

// Send email
echo $contact->send();