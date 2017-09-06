<?php

class Hangout_meet extends Admin_Controller {

    public $data;

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
        //render template
        $header_data = array(
        );
        $this->load->library('form_validation');

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        require_once __DIR__ . '/../third_party/google-api-php/vendor/autoload.php';
        $client_id = '712538589380-94b7o8fgrh9pgh1usj2gokvkgl8spej0.apps.googleusercontent.com'; //Client ID
        $service_account_name = 'mytravel-calendar@astral-name-178306.iam.gserviceaccount.com'; //Email Address

        $key_file_location = __DIR__ . '/../third_party/mytravel/mytravel-calendar.json'; //key.p12        

        $client = new Google_Client(); //AUTHORIZE OBJECTS
        $client->setApplicationName("Google Calendar My Travel API");
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../third_party/mytravel/client_secret_my_travel.json');
        $client->useApplicationDefaultCredentials();
        $data = file_get_contents($key_file_location);

        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setScopes(array('https://www.googleapis.com/auth/calendar'));

        $client->setAuthConfig(array(
            'type' => 'service_account',
            'client_email' => $service_account_name,
            'client_id' => $client_id,
            'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDTTfYj1zAMsERO\nOm/BHLFVOp4cREuSpxowY9AqDa9g5EVP0CjPHsEX1a6X/uTFczjU0JO0dfjelMBB\n7QORyFzAlgW+14ekCpStkEh+WsS0CW8PjS/6quUQm0fOtxguCn+ZIurnvCwIIKyM\nKiejyiYMX7L4dSkQH4mG4qLAheRWtubL08STUyoM9r7IAu3EM5/BlTlCBqJmG1BR\nmAJQ8jJtjs83amPQ4yBs6nZ+WnK+3nvwpAlTq/c5nuDWIaseM98NUC9lIZC2K86j\njAnUOubMqYtrXsXQ6ze6k/jqVoeVdKF818mPsEfGMXlxuAPL/np8VnJJVqbw1HP8\nhZnMmaVHAgMBAAECggEABw+d4Ai61FG3lp2hSmS5EE4LJoqps9bdqyxKsn0OlUBL\niKU+F93BOhir4uxjnK2DAqmNpgQjMtzpp8pRyjdV0iGxQ3VUVQj9eudNZNuHozSF\nf5GKPugjC3EE70VzC2bSaL2f9+pz1jmxSmXGOVTx/IveIStZGe7T26wLID/ZJ4SZ\nmkSY5xsVvDK+EieOPjzbuhv9oqwV6VzvwdpqfxDRx4s2xpN9GIB4D9QssfFF1Xsy\nFANf1dBBNZ8fY8w4BhQJJQtqOVztlizk7UePAmvrnKvqqvvJ6OTu12etNJsx65bA\n7ADBg115uuxUAq/OqI4jvRsOe4iiINSw3uObufUmYQKBgQDq80i+Vl55Za2sEJiI\nX4Wt4p5AzA+zd1wAEMMXj1AEyb82v1skBgUAqvOQW40yuwjXvHCJuhOlRKPqxY6I\n+b2QcSCvOINuZfGcmM+/C8FNL9ntTxZyihJmFOP3eq/ZzRyJrMErpFBoi0xKeyKB\nUwegJKIGSdhLsqsptOd5gRjiHwKBgQDmPFkXGw7GtqjlQaEOcpP/jSvWP/3g+DvK\n5pGLbkAfGjnuwxNDEQ44CXn+b7jvvKRc/Y7tk4GF327NgvGa+iOi4cofD346Q8e+\nS6wgeC0llWKD0h4jgPZOr3I2tQo2OWtwGNWuCWr3Q4nlbz2uYfWmS7BDBAn38dma\nSPbk9ojn2QKBgCeQaEOFD8upj6FV+hmc3En3y2Zl9o7mHpv0NqYVAAiOYKC7gIGE\ncfs2zmUUxaYxUL/jf5/xsbU25dN3CRWP2JgmNLbM8XT5vcH9CZ7GP/rbf/syQjlv\nfsGp6umVw18N5yxX5v+OX+v66RHxwlG8xZ/2C0K71KyKncAcMo6HasVJAoGAFv1P\nqA77mrwCgWHcQyUNwibGic45+4zN66S6Q8HuhSyJPF4ePkQlt1K6670cKlQb1W08\nKFziQgvddIfuuBriFBGXrSJO6GJ8P3Qu688UMvyHqcIBYGowLgs2zF+ndWKmZ7sT\nGx21oJsN2esRraf6b3B/WTG+DRQJNm6yuIolgYECgYAHRliZSb2t2ntFUhwZM20r\nwM3NQL8a5wgpVSuJ9MOpahBGiZF8wiOOkFoHdpI8Epcit5OjyAWK9gqRIYKnNlrS\nWH3tAJSE2Y5gmRDDJE4qlOFLuhLqr+nXOOJIb0QOBUsv4Rn5GfLve8wQLoevNzm5\n0r9wBw5v+qeTqksx51RS+w==\n-----END PRIVATE KEY-----\n"
        ));

        $this->data['client'] = $client;
    }

    public function index($travel_request_id = '') {
        $employee_id = $this->session->userdata('employee_id');
        $array = array(
            "emp_list" => ''
        );
        $this->session->set_userdata($array);
        $view_data = array();
        $this->template->write_view('content', 'hangout_meet/index_hangout_meet', $view_data);
        $this->template->render();
    }

    function create() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        $this->form_validation->set_rules('end_date', 'end_date', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please follow all validation rules.');
            redirect('hangout_meet', 'refresh');
        } else {
            $employee_id = $this->session->userdata('employee_id');
            $this->load->model('employee_model');
            $employee = $this->employee_model->get_employee_by_id_new($employee_id);
            $email_address = $employee['gi_email'];

            $title = $this->input->post('title');
            $location = $this->input->post('location');
            $description = $this->input->post('description');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $startDateTime = date(DATE_ATOM, strtotime($start_date));
            $endDateTime = date(DATE_ATOM, strtotime($end_date));
            $attendees = array();
            $attendees_email = array();
            $attendees[] = array('email' => $email_address);

            $employee_email = $this->input->post('email');
            if (!empty($employee_email)) {
                foreach ($employee_email as $key => $value) {
                    if (trim($value) != '') {
                        if (!in_array(trim($value), $attendees_email)) {
                            $attendees[] = array('email' => trim($value));
                            $attendees_email[] = trim($value);
                        }
                    }
                }
            }

            $emp_list = $this->session->userdata('emp_list');

            if (!empty($emp_list)) {
                foreach ($emp_list as $key => $value) {
                    if (trim($value['email']) != '') {
                        if (!in_array(trim($value['email']), $attendees_email)) {
                            $attendees[] = array('email' => trim($value['email']));
                            $attendees_email[] = trim($value['email']);
                        }
                    }
                }
            }

            $service = new Google_Service_Calendar($this->data['client']);

            $event = new Google_Service_Calendar_Event(array(
                'summary' => $title,
                'location' => $location,
                'description' => $description,
                "sendNotifications" => true,
                'start' => array(
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Asia/Kolkata',
                ),
                'end' => array(
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Asia/Kolkata',
                ),
                'attendees' => $attendees,
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
            try {
                $event = $service->events->insert($calendarId, $event, $optionaArguments);
                $htmlLink = $event->htmlLink;
                if ($htmlLink != '') {
                    $this->session->set_flashdata('success', "Hangout Meeting Created Successfully");
                    redirect('hangout_meet', 'refresh');
                } else {
                    redirect('hangout_meet', 'refresh');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Something Went Wrong.');
                redirect('hangout_meet', 'refresh');
            }
        }
    }

}
