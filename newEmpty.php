<?php

date_default_timezone_set("Asia/Bangkok");
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/application/third_party/google-api-php/vendor/autoload.php';

//require_once __DIR__ . '/application/third_party/google-api-php1/src/google/autoload.php';
//require_once __DIR__ . '/application/third_party/calendar/client_secret.json';
//require_once __DIR__ . '/application/third_party/calendar/travelportal-calendar.json';
//die();
//define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
//define('CREDENTIALS_PATH', __DIR__ .'/application/third_party/calendar/travelportal-calendar.json');
//define('CLIENT_SECRET_PATH', __DIR__ . '/application/third_party/calendar/client_secret.json');

$client_id = '1089837507234-uq6ns2enj390is5au6coepok1ahk97h8.apps.googleusercontent.com'; //Client ID
$service_account_name = 'travelportal-calendar@plexiform-notch-178011.iam.gserviceaccount.com'; //Email Address
//$service_account_name = 'alimaknojiya14@gmail.com'; //Email Address
$key_file_location = __DIR__ . '/application/third_party/calendar/travelportal-calendar.json'; //key.p12

$client = new Google_Client(); //AUTHORIZE OBJECTS
$client->setApplicationName("Google Calendar API PHP Quickstart");
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/application/third_party/calendar/client_secret.json');
$client->useApplicationDefaultCredentials();
$data = file_get_contents($key_file_location);

$client->setScopes(array('https://www.googleapis.com/auth/drive'));
$client->setScopes(array('https://www.googleapis.com/auth/calendar'));

$client->setAuthConfig(array(
    'type' => 'service_account',
    'client_email' => $service_account_name,
    'client_id' => $client_id,
//    'private_key' => $data->private_key
    'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDNsxipIb4ZaRrL\ndayk6HaoyeAfzmfqaFqjQ/ZqYVdIVuUm+yymAEPaav8E7/E+U1EHHiYWKRsIKOgw\nNhIjecET9ebO55zW5wynZnFZNrPVXIi+6uj/qC7n8Ow96evtPGirARhKKuclOTA/\nWELkR2ONEB81AUc7L4sVS0JkEzVxs6aG9KgFzBrQo09hbB37/pW4smDfLbeSuVhE\n65wqr8KKJgtK5riiNxSg8u0RNAXrWMXS4A7vtwCxoshm5EBI7GaMRkS5E2EJwBHq\noAquBjFDWJE6HqxK+umlE2d9asPAJ3taLGf5ZhE+MjzU5NS5q+pxCIXwRkBOALhG\nr+ng3IerAgMBAAECggEAPEoQYc4egiMgs96HHgR2du1Ib/oW0gkI+85ZJH/oTa8O\nVfkLcpIkURnIKiHLgvl3h88J2bftkNwwhaTrdxNiCGAr6JvRB9nLhysK8NuMJO6M\ns+x1Iy2fpeKi01jDChMJGInnHSHrAql63y4W2QKlhnxhsS7xOkMqkDCxQlSw9uRq\nNypMUmFeePYNEp9RIWaEdeyVOwwMFe5NLPqo0J0tJfRhuzQsk1L90rGe8CGdW8AM\njj5xahiN1HbAwnOC7FzdBJMF/4G1k6PtbaAwhaveNZLCqRDTHni4uLNy0R/BcVII\nqvq+yTQTSlD49CAidJ5iNly0FvuTA2Gy5U6vChxFkQKBgQD8t+M0+5XMfrf8T3Tv\nDapjoM9t6pgt4+YaEmvP+o8QorGCbvzPtmAmCBjGb5mxHoAD4qPagZvaSCL807VN\nV7A9TFLqzRT7mLWowGnttS0uV199io3xXW+PJAcIR3EskfxpnkXA2j+E3jYfC/XN\nIW3qphkVU3R/UyqImjJiBdTF0QKBgQDQXueAXyHKUhlNvlnIcKtRp0hPC9Y4gzFR\n5DdP/GraGRDxYNfBEMn7gka25AT4iUIDeN/sbZmbvyB5dIo+W3bSy6sOPdrPlwRi\nyXj+s13Y98E7Wb5Y96Kltjqr0pdhOtl/tjfOgvfefJhnT6BRF5TPRw+9VFezhQvF\nqtR80QmIuwKBgQDDupBIisocVdCdo9SHCWh8PSIqmVU/xZCDhNznecGwOrGMufUn\n0rJpAkBeADVizqKLX89T/qn8x34Bnt5+hnnDIAfgPvIPYtjfWBcyue3CRH16uALz\ne1BZ5qdjrCFlSbPbAXA4y1AC0i/Mn/DB7TA6WmZ28+n4ays4HWUEMkv24QKBgBNF\nQ6m2opxgfWCYQxtreBykGObelGBDmdMWBRuLn6IuAUghibKcR+HPyZRugBswLn+9\ntQ/bjwI9adZxtbtQoCuclGRLyim6sLgmI9+CXSKMvz0q7pSxykQDF2f+oOtoEudh\nxcV+jUfxQ/MCBTSatrN4wfbjjvzWSCFuzBoDBxuzAoGBAKc1aRB1OvgS4OlocxHz\nwGED8TN+r+j8AaWcuIkN8XTHcEoU3Hh/mxlxZBapCl4P/YdCIeLBKESWhkokgINi\ngXc31va3Qvk+7b2XIRbFfoaI01SM3/4j7F5FbAX8OvM96RPTMQeuS1obsliPtnuD\nDjbGf+t/1e5eRLZz+Gnc1ogQ\n-----END PRIVATE KEY-----\n"
));

$service = new Google_Service_Calendar($client);

//$calendarId = 'primary';
//pushAppointmentToGoogleCalendar($calendarId,$service);
//get_event($calendarId);


$event = new Google_Service_Calendar_Event(array(
    'summary' => 'ULT Meeting',
    'location' => '800 Howard St., San Francisco, CA 94103',
    'description' => 'Hello Guys, can we have meeting please.',
    "sendNotifications" => true,
    "ID" => "alimaknojiya14@gmail.com",
    'start' => array(
        'dateTime' => '2017-08-30T09:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'end' => array(
        'dateTime' => '2017-08-31T17:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'recurrence' => array(
        'RRULE:FREQ=DAILY;COUNT=2'
    ),
    'attendees' => array(
        array('email' => 'alimaknojiya14@gmail.com'),
        array('email' => 'maknojiya440@gmail.com'),
        array('email' => 'jafaraliwork14@gmail.com'),
    ),
    'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
            array('method' => 'email', 'minutes' => 24 * 60),
            array('method' => 'popup', 'minutes' => 10),
        ),
    ),
        ));


$optionaArguments = array("sendNotifications" => true);
$calendarId = 'primary';
//$calendarId = '27mp178bcbqb5oqh8v9n0ve6qo@group.calendar.google.com';
$event = $service->events->insert($calendarId, $event, $optionaArguments);
echo "<pre>";
print_r($event);

//printf('Event created: %s\n', $event->htmlLink);
//$calendarId = 'primary';
//$calendarId = '27mp178bcbqb5oqh8v9n0ve6qo@group.calendar.google.com';

function get_event($calendarId) {
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => TRUE,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);

    if (count($results->getItems()) == 0) {
        print "No upcoming events found.\n";
    } else {
        print "Upcoming events:\n";
        foreach ($results->getItems() as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s)\n<br>", $event->getSummary(), $start);
        }
    }
//echo "<pre>";
//print_r($results);
}

function pushAppointmentToGoogleCalendar($googleCalId) {

    $event = new Google_Service_Calendar_Event(array(
        'summary' => 'Final Event',
        'location' => '800 Howard St., San Francisco, CA 94103',
        'description' => 'This is final event for meeting',
        'start' => array(
            'dateTime' => '2017-05-01T09:00:00-07:00',
            'timeZone' => 'America/Los_Angeles',
        ),
        'end' => array(
            'dateTime' => '2017-05-02T17:00:00-07:00',
            'timeZone' => 'America/Los_Angeles',
        ),
        'recurrence' => array(
            'RRULE:FREQ=DAILY;COUNT=2'
        ),
        'attendees' => array(
            array('email' => 'lpage@example.com'),
            array('email' => 'sbrin@example.com'),
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));

    $calendarId = $googleCalId;
    $event = $service->events->insert($calendarId, $event);
    echo "<pre>";
    print_r($event);

//    printf('Event created: %s\n', $event->htmlLink);
}
