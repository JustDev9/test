<!-- <?php
require_once 'vendor/autoload.php';
require_once 'config.php';

header('Content-Type: application/json');

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get the request body
$requestBody = file_get_contents('php://input');
$eventData = json_decode($requestBody, true);

if (!$eventData) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data']);
    exit;
}

try {
    // Create Google Client
    $client = new Google_Client();
    $client->setApplicationName('Pawfect Adoption System');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');

    // Create Calendar Service
    $service = new Google_Service_Calendar($client);

    // Create Event
    $event = new Google_Service_Calendar_Event([
        'summary' => $eventData['summary'],
        'location' => $eventData['location'],
        'description' => $eventData['description'],
        'start' => [
            'dateTime' => $eventData['start']['dateTime'],
            'timeZone' => $eventData['start']['timeZone'],
        ],
        'end' => [
            'dateTime' => $eventData['end']['dateTime'],
            'timeZone' => $eventData['end']['timeZone'],
        ],
        'attendees' => $eventData['attendees'],
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60],
                ['method' => 'popup', 'minutes' => 30],
            ],
        ],
    ]);

    // Insert the event
    $calendarId = $_ENV['GOOGLE_CALENDAR_ID'];
    $event = $service->events->insert($calendarId, $event);

    // Return success response
    echo json_encode([
        'success' => true,
        'eventId' => $event->getId(),
        'htmlLink' => $event->getHtmlLink()
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to create calendar event',
        'message' => $e->getMessage()
    ]);
} -->