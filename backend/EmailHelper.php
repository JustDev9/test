<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper {
    private $mailer;
    private $config;

    public function __construct($config) {
        $this->config = $config;
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $config['smtp_host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $config['smtp_username'];
        $this->mailer->Password = $config['smtp_password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $config['smtp_port'];

        // Default sender
        $this->mailer->setFrom($config['smtp_username'], 'Pawfect Adoption System');
    }

    public function sendApplicationConfirmation($application) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['full_name']);
            $this->mailer->Subject = 'Adoption Application Received - Pawfect';

            // Create email body
            $body = $this->getApplicationConfirmationTemplate($application);
            $this->mailer->isHTML(true);
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    public function sendApplicationStatusUpdate($application) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($application['email'], $application['full_name']);
            $this->mailer->Subject = "Application Status Update - {$application['status']}";

            // Create email body
            $body = $this->getStatusUpdateTemplate($application);
            $this->mailer->isHTML(true);
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    private function getApplicationConfirmationTemplate($application) {
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #f7871f;'>Adoption Application Received</h2>
                <p>Dear {$application['full_name']},</p>
                <p>Thank you for your interest in adopting {$application['pet_name']} from Pawfect. We have received your application and will review it shortly.</p>

                <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                    <h3 style='color: #333; margin-top: 0;'>Application Details</h3>
                    <p><strong>Pet Name:</strong> {$application['pet_name']}</p>
                    <p><strong>Appointment Date:</strong> {$application['appointment_date']}</p>
                    <p><strong>Appointment Time:</strong> {$application['appointment_time']}</p>
                </div>

                <p>We will contact you within 24-48 hours to discuss your application and confirm your appointment.</p>

                <p>Best regards,<br>The Pawfect Team</p>
            </div>
        ";
    }

    private function getStatusUpdateTemplate($application) {
        $statusMessage = '';
        switch ($application['status']) {
            case 'Approved':
                $statusMessage = "Congratulations! Your application for {$application['pet_name']} has been approved.";
                break;
            case 'Rejected':
                $statusMessage = "We regret to inform you that your application for {$application['pet_name']} has not been approved at this time.";
                break;
            default:
                $statusMessage = "Your application for {$application['pet_name']} is currently being reviewed.";
        }

        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #f7871f;'>Application Status Update</h2>
                <p>Dear {$application['full_name']},</p>
                <p>{$statusMessage}</p>

                <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                    <h3 style='color: #333; margin-top: 0;'>Application Details</h3>
                    <p><strong>Pet Name:</strong> {$application['pet_name']}</p>
                    <p><strong>Status:</strong> {$application['status']}</p>
                    <p><strong>Application Date:</strong> {$application['created_at']}</p>
                </div>

                <p>If you have any questions, please don't hesitate to contact us.</p>

                <p>Best regards,<br>The Pawfect Team</p>
            </div>
        ";
    }
}