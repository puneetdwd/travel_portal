<?php
/** 
* Cron Controller Class 
* 
* @package CRG
* @filename cron.php
* @category Cron
**/

if (! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
		

//        if(!$this->input->is_cli_request()) {
//            die('Permission denied.');
//        }

        //ini_set('memory_limit', '-1');
    }
    public function test() {        
        $this->load->library('email');        
        $this->email->clear(TRUE);               
        $this->email->from('mytravel@dbcorp.in', 'My Travel');        
        $this->email->to('mytravel@dbcorp.in');        
        //$this->email->subject('Cron Test - '.date('jS F, Y H:i:s', strtotime('now')));        
        $this->email->subject('Test Mail');        
        $this->email->message('This is a test mail. Please ignore.');        
        $this->email->send();        
        echo "here <br>".$this->email->print_debugger();    
    
    } 
    
    public function employee_test(){
        
       $msg = "Dear Team,<br><br>
                Team HR take this opportunity to join you all in extending a warm welcome to
                <b>Nishant Dwivedi</b>,
                who has joined 
                <b style='color:#337ab7;'>Corporate</b> <b style='color:#f26e22;'>Renaissance</b> <b style='color:#337ab7;'>Group</b> 
                <b>Mumbai</b> as <b>Consultant</b>.
                <br><br><p style='text-align:center;'><img src='http://intra.crgroup.co.in/assets/emp_photos/-ND1hXP.jpg' height='100' width='100' /></p>
                We look forward to your support and cooperation to Mr <b>Nishant Dwivedi</b>,
                in his current assignment and wish him a happy association with the CRG Family.<br><br>
                You can all reach him at ndwivedi@crgroup.co.in<br><br>
                Best Regards,<br><br>
                Team HR.<br>";
       /*if(preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $msg)){
           echo "One or more special characters are found";
           echo htmlspecialchars($msg);
       }*/
       
       echo htmlspecialchars($msg);
    }
    
    public function index() {
        echo "You are not allowed to open this page.";
        $subject = 'Cron Test - '.date('jS F, Y H:i:s', strtotime('now'));
        $to = "puneet.dwivedi@crgroup.co.in";
        $this->sendMail($to, $subject, 'Testing');
    }
    
    public function generate_travel_pdf($booking_id){
        //$booking_id = 37;
        $this->load->model('Booking_model');
        $request = $this->Booking_model->get_booking($booking_id);
        $travel_array= $request;

        $view_data= array('booking' => $travel_array);

        $pas_details = $this->Booking_model->get_passenger_details($booking_id);
        $view_data['pas_details'] = $pas_details;

        require_once APPPATH .'libraries/pdfcrowd.php';
        $file_name = $travel_array['code'].'Travel-Booking-request.pdf';
        $location = 'assets/Travel-booking-requests/';
        try {
            // create an API client instance
            $client = new Pdfcrowd("ajay12345", "3cb15e4f23796d58f6ba35eae6d8f421"); 

            $html = $this->load->view('booking/download', $view_data, true);
            // convert a web page and store the generated PDF into a $pdf variable
            $pdf = $client->convertHtml($html);


            file_put_contents($location.$file_name, $pdf);
            //echo $pdf;
            echo "Success";
        } catch(PdfcrowdException $why) {
            $data['error'] = "Pdfcrowd Error: " . $why;
            echo $data['error'];
        }
        
        return false;
    }
    
    public function monthly_leave_allotment(){ // on last day of month
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $all_employees = $this->employee_model->get_all_employees();
        
        foreach($all_employees as $employee){
            
            /*$d1 = new DateTime($employee['doj']);
            $d2 = new DateTime(date('Y-m-d'));
            $interval = $d2->diff($d1);
            $doj_day=$d1->format('d');*/
            
            $date1=date_create($employee['doj']);
            $date2=date_create(date('Y-m-d'));
            //$date2=date_create('2017-03-01');
            $diff=date_diff($date1,$date2);
            $doj_day = $diff->format("%a");
            
            $emp_duration_years=$diff->format('%y');
            //$emp_duration_months=$diff->format('%m');
            $emp_duration_months = $diff->m+($diff->y*12);
            $emp_duration_days=$diff->format('%d');
            
            //echo $diff->format('%ma months')."<br>";
            //echo $diff->m + ($diff->y * 12)."<br>";
            
            //echo $employee['id']." -> ".$emp_duration_years." -> ".$emp_duration_months." -> ".$emp_duration_days." -> ".$doj_day." -> ".$diff->format("%a")."<br/>";
            
            if($emp_duration_months >= 3 || $emp_duration_years >= 1 || $doj_day > 90){
                
                $extra_leave=0;
                if($emp_duration_months==3 && $emp_duration_days > 0 && $emp_duration_years == 0){
                    if($doj_day >= 1 && $doj_day <= 10){
                        $extra_leave=1.75;
                    }else if($doj_day > 10 && $doj_day <= 20){
                        $extra_leave=1.2;
                    }else if($doj_day > 20 && $doj_day <= 31){
                        $extra_leave=0.60;
                    }
                }
                
                if($emp_duration_months > 3 || $emp_duration_years >= 1){
                    $extra_leave = $extra_leave + 1.75;
                }
            
                $available_leave = $this->leave_model->get_available_leave_by_id($employee['id']);
                if(date('m-d')=='01-01' && $available_leave['available_leaves'] > 0){

                    $leave_to_add=($available_leave['available_leaves']/2)+$extra_leave;
                    $carry_forward=($available_leave['available_leaves']/2);
                    $sql="update available_leaves set available_leaves = ?, carry_forward=?, modified_date=now() where emp_id= ?";
                    //echo "1. ".$sql."<br/>";
                    $result = $this->db->query($sql,array($leave_to_add, $carry_forward, $employee['id']));

                }else if(date('m-d')=='01-01' && $available_leave['available_leaves'] <= 0){

                    $sql="update available_leaves set available_leaves = 0 + ".$extra_leave.", carry_forward=0, modified_date=now() where emp_id= ?";
                    //echo "2. ".$sql."<br/>";
                    $result = $this->db->query($sql,array($employee['id']));

                }else{

                    $leave_to_add=$extra_leave;
                    $sql="update available_leaves set available_leaves = (available_leaves + ?), modified_date=now() where emp_id= ?";
                    //echo "3. update available_leaves set available_leaves = (available_leaves + ".$leave_to_add."), modified_date=now() 
                          //where emp_id= ".$employee['id']."<br/>";
                    $result = $this->db->query($sql,array($leave_to_add, $employee['id']));
                    echo $employee['id']." ".$leave_to_add."<br>";
                }
            }
        }
        return true;
    }
    
    public function quaterly_half_leave_allotment(){ // on last day of every month
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $all_employees = $this->employee_model->get_all_employees();
        
        foreach($all_employees as $employee){
            
            $d1 = new DateTime($employee['doj']);
            $d2 = new DateTime(date('Y-m-d'));
            $interval = $d2->diff($d1);
            $doj_day=$d1->format('d');

            $emp_duration_months=$interval->format('%m');
            
            if($emp_duration_months == 3){
                if($doj_day >=1 && $doj_day <= 25){
                    $sql="update available_leaves set available_half_leaves=0.5, modified_date=now() where emp_id= ?";
                    $result = $this->db->query($sql,array($employee['id']));
                }
            }else if($emp_duration_months > 3){
                if(date('m-d')=='01-01'){
                    $sql="update available_leaves set available_half_leaves=1.5, modified_date=now() where emp_id= ?";
                    $result = $this->db->query($sql,array($employee['id']));
                }else if((date('m-d')=='04-01') || (date('m-d')=='07-01') || (date('m-d')=='10-01')){
                    $sql="update available_leaves set available_half_leaves=available_half_leaves + 1.5, modified_date=now() where emp_id= ?";
                    $result = $this->db->query($sql,array($employee['id']));
                }
            }
        }
        return true;
    }
    
    public function monthly_leave_reminder(){ // on 25th of every month
        $this->load->model('employee_model');
        $all_employees = $this->employee_model->get_all_employees();
        
        foreach($all_employees as $employee){

            $subject = "Reminder to Manage leave - ".$employee['first_name']." ".$employee['last_name'];
            $message="Dear ".$employee['first_name']." ".$employee['last_name'].",<br><br><br>
            This is to remind you that we are in proceeding for Monthly salary calculation in next 2 Days.<br> 
            You are requested to update your leave information for the month before end of tomorrow. <br><br>
            Thank You.<br><br>
            Finance Team";
            $this->sendMail('puneet.dwivedi@crgroup.com', $subject, 'Testing');
            echo "<br>".$subject."<br>".$message."<br>";
            break;

        }
        return true;
    }
    
    public function timesheet_reminder_1(){ // Timesheet reminder (first day) - To employee only
        
        $first_date=date('Y-m-d');
        //$first_date = '2016-04-07';
        $dw = date( "w", strtotime($first_date));
        
        if($dw >=1 && $dw <= 5){
            
            $this->load->model('Work_model');
            $emp_with_no_timesheet = $this->Work_model->get_employees_without_timesheet_one_day($first_date);
            
            $this->load->model('leave_model');
            $this->load->model('employee_model');
            //$i=1;
            foreach($emp_with_no_timesheet as $employee){
                
                $is_leave=$this->leave_model->get_date_wise_leave($first_date,$employee['id']);
                
                
                if((!isset($is_leave) || empty($is_leave))){
                    
                    $festival = $this->employee_model->get_festival($first_date);
                    if( (!isset($festival) || empty($festival)) && $employee['id'] != 30 ){
                        
                        $subject = "Timesheet submission reminder for today";
                        $msg="Hi ".$employee['first_name']." ".$employee['last_name'].",<br>You have not submitted timesheet for today.<br>
                        Kindly submit the same asap.<br><br>
                        Regards<br>
                        Admin";

                        //echo $employee['gi_email']."<br>";
                        $this->sendMail($employee['gi_email'], $subject, $msg);
                        //$this->sendMail('puneet.dwivedi@crgroup.com', $subject, $msg);
                        //$i++;
                    }
                }
            }
        }
        return true;
    }
    
    public function timesheet_reminder_2(){ // Timesheet reminder (Second day) - To employee and reporting head
        
        $date=date('Y-m-d');
        $second_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
        //$second_date = '2016-04-07';
        $dw = date( "w", strtotime($second_date));
        
        if($dw >=1 && $dw <= 5){
            
            $this->load->model('Work_model');
            $emp_with_no_timesheet_2 = $this->Work_model->get_employees_without_timesheet_two_day($second_date);
            
            $this->load->model('leave_model');
            $this->load->model('employee_model');

            foreach($emp_with_no_timesheet_2 as $employee){
                
                $is_leave=$this->leave_model->get_date_wise_leave($second_date,$employee['id']);
                
                if(!isset($is_leave) || empty($is_leave)){
                    
                    $festival = $this->employee_model->get_festival($second_date);
                    if( (!isset($festival) || empty($festival)) ){

                        $cc=$employee['reporting_person_email'];
                        $subject = "Timesheet submission reminder for date - ".$second_date;
                        $msg = "Hi ".$employee['first_name']." ".$employee['last_name'].",<br>
                        You have not submitted timesheet for date ".$second_date.". <br>Kindly submit the same asap.<br><br>
                        Regards<br>
                        Admin";
                        $this->sendMail($employee['gi_email'], $subject, $msg, $cc);
                        //$this->sendMail('puneet.dwivedi@crgroup.com', $subject, $msg, $cc);
                    }
                }
            }
        }
        return true;
    }
    
    public function timesheet_reminder_3(){ // Timesheet reminder (Third day) - To employee, reporting head and department lead
        
        $date = date('Y-m-d');
        $third_date = date('Y-m-d',(strtotime ( '-2 day' , strtotime ( $date) ) ));
        //$third_date = '2016-04-06';
        $dw = date( "w", strtotime($third_date));
        //echo $third_date.$dw."hii "; exit;
        if($dw >=1 && $dw <= 5) {
        
            $this->load->model('Work_model');
            $emp_with_no_timesheet_3 = $this->Work_model->get_employees_without_timesheet_three_day($third_date);
            //echo $third_date."<pre>"; print_r($emp_with_no_timesheet_3); exit;
            $this->load->model('leave_model');
            $this->load->model('employee_model');
            
            foreach($emp_with_no_timesheet_3 as $employee) {
                
                $needed_array = array('employee_id', 'date', 'timesheet_for', 'project_id', 'hours', 'minutes', 'tasks', 
                    'challanges', 'next_action', 'created','modified');
                    
                $data = array();
                $data['employee_id'] = $employee['id'];
                $data['date'] = $third_date;
                $data['timesheet_for'] = 'Working';
                $data['project_id'] = 0;
                $data['hours'] = 0;
                $data['minutes'] = 0;
                $data['tasks'] = '';
                $data['challanges'] = '';
                $data['next_action'] = '';
                $data['created'] = date('Y-m-d H:m:s');
                $data['modified'] = '0000-00-00 00:00:00';
                
                $is_leave = $this->leave_model->get_date_wise_leave($third_date, $employee['id']);
                if(!isset($is_leave) || empty($is_leave)) {
                    $data['timesheet_for'] = 'on_leave';
                }
                    
                $festival = $this->employee_model->get_festival($third_date);
                if( (!isset($festival) || empty($festival)) ) {
                    $data['timesheet_for'] = 'holiday';
                }

                $data = array_intersect_key($data, array_flip($needed_array));
                echo "<pre>"; print_r($data); echo "</pre>";
                //$this->db->insert('timesheets', $data);

//              if($employee['reporting_person_id'] == $employee['dept_lead']){
//                  $cc=$employee['reporting_person_email'];
//              }else{
//                  $cc=$employee['reporting_person_email'].",".$employee['dept_lead_email'];
//              }

                if(empty($festival) && empty($is_leave)) {
                    if($employee['reporting_person_id'] == $employee['department_head']) {
                        $cc=$employee['reporting_person_email'];
                    } else {
                        $cc=$employee['reporting_person_email'].",".$employee['department_head_email'];
                    }

                    $subject = "Timesheet submission reminder for date - ".$third_date;
                    $msg = "Hi ".$employee['first_name']." ".$employee['last_name'].",<br>
                    You have not submitted timesheet for date ".$third_date.". <br>Kindly submit the same asap.<br><br>
                    Regards<br>
                    Admin";

                    //echo "To : ".$employee['gi_email']." CC : ".$cc."<br>";
                    //$this->sendMail($employee['gi_email'], $subject, $msg, $cc);
                    //$this->sendMail('puneet.dwivedi@crgroup.com', $subject, $msg);
                }
            }
        }
        return true;
    }
    
    public function timesheet_block(){ // Daily - To block Editing of timesheet after 3 days
        $date = date('Y-m-d');
        $third_date = date('Y-m-d',(strtotime ( '-3 day' , strtotime ( $date) ) ));
        
        $this->db->where('date', $third_date);
        $this->db->set('modified', date('Y-m-d H:m:s'));
        $this->db->set('can_edit','No');
        
        $this->db->update('timesheets');

        return true;
    }
    
    public function Daily_consolidated_timesheet_report(){ // Consolidated Timesheet Report - To Reporting Head
        
        $date=date('Y-m-d');
        //$date = '2016-04-29';
        //$last_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
        $dw = date( "w", strtotime($date));
        //echo "hello";
        if($dw >=1 && $dw <= 5){
            //echo "hi<br>";
        
            $this->load->model('employee_model');
            $reporting_heads = $this->employee_model->get_all_reporting_heads();
            $this->load->model('Work_model');
            $this->load->model('leave_model');
            
            //echo "hi  <pre>"; print_r($reporting_heads); echo "</pre>";
            //exit;
            foreach($reporting_heads as $employee){
                
                $this->load->model("employee_model");
                    
                $sub_dept_head = $this->employee_model->get_sub_dept_lead_by_id($employee['id']);
                $dept_head = $this->employee_model->get_dept_head_by_id($employee['id']);
                //print_r($dept_head);
                //print_r($sub_dept_head);
                //exit;
                if(!empty($dept_head)){
                    //echo "dept<br>";
                    $gen_timesheet = $this->Work_model->get_general_timesheet_by_department_id($dept_head['id'], $date);
                    
                }else if(!empty($sub_dept_head)) {
                    //echo "sub_dept<br>";
                    $gen_timesheet = $this->Work_model->get_general_timesheet_by_sub_department_id($sub_dept_head['id'], $date);
                    
                }else{
                    //echo "All<br>";
                    $gen_timesheet = $this->Work_model->get_general_timesheet_by_reporting_person_id($employee['id'], $date);
                    
                }
                
                //echo "<pre>";print_r($gen_timesheet);echo "</pre>"; exit;
                
                $subject="Daily Consolidated Timesheet Report";
                $msg ="<p>";
                $msg.="<b>Hi ".$employee['first_name']." ".$employee['last_name'].",</b><br><br>";
                $msg.="Kindly find the daily timesheet report in the attachment. Thanks!<br><br>";
                $msg.="This is a system generated email, please do not reply.<br><br>";
                $msg.="</p>";
                $msg.='<table border="1"  style="width:90%;margin-top:20px;margin-left:30px;margin-right:30px;">
		
                    <thead> 
                        <th>Name</th>
                        <th>Project</th>
                        <th colspan="2">Task</th>
                        <th>Hours</th>
                        <th>Minutes</th>
                        <th>Total</th>
                        <th> Challenges Faced</th>
                        <th>Next action Plan</th>
                    </thead>
                    <tbody>';
                $cnt=0;
                
                foreach($gen_timesheet as $gen_sheet){
                    $total_hours = 0;
                    $total_minutes = 0;
                    //echo "hi ".$cnt."<br>";  
                    $timesheet = $this->Work_model->get_timesheet_by_reporting_person_id($gen_sheet['id'],$gen_sheet['project_id'], $date);
                    //echo "<pre>"; print_r($timesheet);echo "</pre>";
                    $emp_count = $this->Work_model->get_employee_wise_timesheet_count($gen_sheet['id'], $date);
                    
                    $project_count = $this->Work_model->get_employee_wise_timesheet_project_count($gen_sheet['id'], $date);
                    
                    $total_hours = $emp_count['total_hours'];
                    $total_minutes = $emp_count['total_minutes'];

                    if($total_minutes >= 60){
                        $total_hours = $total_hours + 1;
                        $total_minutes = $total_minutes - 60;
                    }
                    
                    $msg .= '<tr>';
                    if($cnt == 0){
                        $msg .= '<td rowspan="'.$emp_count["count"].'">'.$gen_sheet["employee_name"].'</td>';
                        //if($project_count['project_count'] > 1){ $cnt++; }
                    }
                    $msg .=    '<td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["project_name"].'</td>
                                <td colspan="2">'.$timesheet[0]["tasks"].'</td>
                                <td>'.$timesheet[0]["hours"].'</td>
                                <td>'.$timesheet[0]["minutes"].'</td>';
                    if($cnt == 0){
                        $msg .= '<td rowspan="'.$emp_count["count"].'">'.$total_hours.' Hrs '.$total_minutes.' Mins</td>';
                        //if($project_count['project_count'] > 1){ $cnt++; }
                    }
                    
                    
                    $msg .=    '<td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["challanges"].'</td>
                               <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["next_action"].'</td>
                            </tr>';
                    
                    for($j=1; $j < sizeof($timesheet); $j++){
                        
                        $msg .= '<tr>
                                    <td colspan="2">'.$timesheet[$j]["tasks"].'</td>
                                    <td>'.$timesheet[$j]["hours"].'</td>
                                    <td>'.$timesheet[$j]["minutes"].'</td>
                                </tr>';
                        
                        $cnt++;
                    }
                    if($project_count['project_count'] > 1){ 
                        //$cnt++; 
                        if($cnt == $emp_count['count']-1 || $emp_count['count'] == 1){
                            $cnt = 0;
                        }else{
                            $cnt++;
                        }
                    }else if($cnt == ($emp_count['count']-1) || $emp_count['count'] == 1){
                        $cnt = 0;
                    }
                }
                $msg .='</tbody>

                </table>';
                
                $msg.= "<br><br>Regards,<br>";
                $msg.= "Admin<br><br>";
                
                if(!empty($gen_timesheet)){
                    //echo $msg;
                    $to = $employee['gi_email'];
                    //$to = 'puneet.dwivedi@crgroup.com';
                    $this->sendMail($to, $subject, $msg);
                }
            }
        }
        return true;
    }
    
    public function Daily_consolidated_timesheet_report_client_based(){ // Consolidated Timesheet Report - To Reporting Head
        
        $date_array = array();
        //$date_array[0]=date('Y-m-d',strtotime('-3 days'));
        //$date_array[1]=date('Y-m-d',strtotime('-2 days'));
        $date_array[0]=date('Y-m-d',strtotime('-1 days'));
        $date_array[1]=date('Y-m-d');
        //$date_array[2]=date('Y-m-d');
        //$date = '2016-12-06';

        $this->load->model('Work_model');
        $this->load->model('leave_model');

        $project_ids = array();
        $project_ids[0][0] = 34;
        $project_ids[0][1] = 'Tata Trent';

        $project_ids[1][0] = 87;
        $project_ids[1][1] = 'Deloitte';
        
        $project_ids[2][0] = 89;
        $project_ids[2][1] = 'Pidilite Industries BI';
        
        for($d_cnt = 0; $d_cnt < sizeof($date_array); $d_cnt++){
            
            $date = $date_array[$d_cnt];
            
            for($i=0;$i<=sizeof($project_ids); $i++){

                $gen_timesheet = $this->Work_model->get_general_timesheet_by_project($project_ids[$i][0], $date);

                $subject="Daily Consolidated Timesheet Report - ".$project_ids[$i][1];
                $msg ="<p>";
                $msg.="<b>Hi Rupali,</b><br><br>";
                $msg.="Please find timesheets below - <br><br>";
                $msg.="</p>";
                $msg.='<table border="1"  style="width:90%;margin-top:20px;margin-left:30px;margin-right:30px;">

                    <thead> 
                        <th>Name</th>
                        <th>Project</th>
                        <th>Date</th>
                        <th colspan="2">Task</th>
                        <th>Hrs</th>
                        <th>Min</th>
                        <th>Total</th>

                        <th>Dashboard</th>
                        <th>Phase</th>
                        <th>Action Type</th>
                        <th>Challenge Type</th>
                        <th>Wait Time</th>
                        <th>Task Status</th>
                        <th>Assigned To</th>
                        <th>Action On</th>
                        <th>Solution For Challenge</th>
                        <th>Customer Feedback</th>
                        <th>Remarks</th>

                        <th>Challenges Faced</th>
                        <th>Next action Plan</th>
                    </thead>
                    <tbody>';
                $cnt=0;

                foreach($gen_timesheet as $gen_sheet){
                    $total_hours = 0;
                    $total_minutes = 0;

                    $timesheet = $this->Work_model->get_timesheet_by_reporting_person_id($gen_sheet['id'],$gen_sheet['project_id'], $date);

                    $emp_count = $this->Work_model->get_employeen_project_wise_timesheet_count($gen_sheet['id'], $date, $gen_sheet['project_id']);

                    //$project_count = $this->Work_model->get_employee_wise_timesheet_project_count($gen_sheet['id'], $date);
                    $project_count['project_count'] = 1;

                    $total_hours = $emp_count['total_hours'];
                    $total_minutes = $emp_count['total_minutes'];

                    if($total_minutes >= 60){
                        $total_hours = $total_hours + 1;
                        $total_minutes = $total_minutes - 60;
                    }

                    $msg .= '<tr>';
                    if($cnt == 0){
                        $msg .= '<td rowspan="'.$emp_count["count"].'">'.$gen_sheet["employee_name"].'</td>';

                    }
                    $msg .=    '<td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["project_name"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$date.'</td>
                                <td colspan="2">'.$timesheet[0]["tasks"].'</td>
                                <td>'.$timesheet[0]["hours"].'</td>
                                <td>'.$timesheet[0]["minutes"].'</td>';
                    if($cnt == 0){
                        $msg .= '<td rowspan="'.$emp_count["count"].'">'.$total_hours.':'.$total_minutes.'</td>';

                    }


                    $msg .=    '<td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["dashboard"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["phase"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["action_type"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["challenge_type"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["time_wait"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["task_status"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["assigned_to"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["action_on"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["challenges_sol"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["customer_feedback"].'</td>
                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["remarks"].'</td>

                                <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["challanges"].'</td>
                               <td rowspan="'.sizeof($timesheet).'">'.$gen_sheet["next_action"].'</td>
                            </tr>';

                    for($j=1; $j < sizeof($timesheet); $j++){

                        $msg .= '<tr>
                                    <td colspan="2">'.$timesheet[$j]["tasks"].'</td>
                                    <td>'.$timesheet[$j]["hours"].'</td>
                                    <td>'.$timesheet[$j]["minutes"].'</td>
                                </tr>';

                        $cnt++;
                    }
                    if($project_count['project_count'] > 1){ 

                        if($cnt == $emp_count['count']-1 || $emp_count['count'] == 1){
                            $cnt = 0;
                        }else{
                            $cnt++;
                        }
                    }else if($cnt == ($emp_count['count']-1) || $emp_count['count'] == 1){
                        $cnt = 0;
                    }
                }
                $msg .='</tbody>

                </table>';

                $msg.= "<br><br>Regards,<br>";
                $msg.= "Admin<br><br><br>";
                $msg.="<i>This is a system generated email, please do not reply.</i><br><br>";

                if(!empty($gen_timesheet)){
                    //echo $msg;
                    //$to = $employee['gi_email'];
                    $to = 'rrege@crgroup.co.in';
                    if($project_ids[$i][0] == 89){
                        $cc = 'ssharma@crgroup.co.in';
                    }else{
                        $cc = 'ssharma@crgroup.co.in,ajay.singh@crgroup.co.in';
                    }
                    $this->sendMail($to, $subject, $msg, $cc);
                }
            }
        }
        
        return true;
    }
    
    public function salary_reminder1(){ // 26th of every month
        
        $cur_month = date('m');
        $cur_year = date('Y');
        
        $last_month = date('m', strtotime('-1 month'));
        
        if($cur_month == 1){
            $year = $cur_year-1;
        }else{
            $year = $cur_year;
        }
        
        //$num_days = cal_days_in_month(CAL_GREGORIAN, $cur_month, $cur_year);
        $num_days1 = cal_days_in_month(CAL_GREGORIAN, $last_month, $year);
        $day_array = array();
        $j=0;
        
        for($k=27; $k <= $num_days1; $k++){
            $date = $year."-".$last_month."-".$k;
            $weekDay = date('w', strtotime($date));
            
            $this->load->model('employee_model');
            $festival = $this->employee_model->get_festival($date);
            
            if($weekDay == 0 || $weekDay == 6){
                //echo $k."<br>";
            }else if (!empty ($festival)){
                //echo $k."<br>";
            }else{
                $day_array[$j] = $date;
                $j++;
            }
        }
        
        for($i=1; $i<= 26; $i++){
            
            $date = $cur_year."-".$cur_month."-".$i;
            $weekDay = date('w', strtotime($date));
            
            $this->load->model('employee_model');
            $festival = $this->employee_model->get_festival($date);
            
            if($weekDay == 0 || $weekDay == 6){
                //echo $i."<br>";
            }else if (!empty ($festival)){
                //echo $i."<br>";
            }else{
                $day_array[$j] = $date;
                $j++;
            }
            
        }
        //echo "<pre>";print_r($day_array); exit;
        
        $employees = $this->employee_model->get_all_employees();
        
        $this->load->model('leave_model');
        $this->load->model('work_model');
        $this->load->model('short_leave_model');
        
        foreach($employees as $employee){
            $days = 0;
            $hours = 0;
            //echo "hi".sizeof($day_array)."<br><pre>".print_r($employee);
            $info = '';
            $msg = '';
            $info.= '<table border="1">';
            $info.= '<tr>';
            $info.= '<th>Date</th>';
            $info.= '<th>Deduction</th>';
            $info.= '</tr>';
            
            for($i=0; $i < sizeof($day_array); $i++){
                
                $date1=date_create($employee['doj']);
                $date2=date_create($day_array[$i]);
                $diff=date_diff($date1,$date2);
                $num_days = $diff->format("%R%a days");
                //echo $employee['emp_name']." ".$employee['doj']." ".$day_array[$i]." ".$num_days."<br>";
                if($num_days >= 0){
                    $is_leave=$this->leave_model->get_date_wise_leave($day_array[$i], $employee['id']);

                    if((!isset($is_leave) || empty($is_leave))){
                        //echo "here"; exit;
                        $timesheet = $this->work_model->get_approved_timesheet($day_array[$i], $employee['id']);

                        //echo "<pre>"; print_r($timesheet); exit;

                        if( (isset($timesheet) && !empty($timesheet)) ){
                            if($timesheet['hours'] < 7){

                                $is_half_day=$this->leave_model->get_date_wise_half_day($day_array[$i], $employee['id']);

                                if((!isset($is_half_day) || empty($is_half_day))){

                                    $is_short_leave=$this->short_leave_model->get_date_wise_short_leave($day_array[$i], $employee['id']);

                                    if((!isset($is_short_leave) || empty($is_short_leave))){
                                        $hours = $hours + (8-$timesheet['hours']);
                                        
                                        if($hours >= 8){
                                            //echo "here ".$days." ".($days+floor($hours/8))."<br>";
                                            
                                            $days = ($days+floor($hours/8));
                                            $hours = $hours%8;
                                            //echo $days."<br>"; exit;
                                        }

                                        $info.= '<tr>';

                                        $info.= '<td>';
                                        $info.= $day_array[$i];
                                        $info.= '</td>';

                                        $info.= '<td>';
                                        $info.= ((8-$timesheet['hours']) > 1) ? (8-$timesheet['hours'])." Hrs" : (8-$timesheet['hours'])." Hr";
                                        $info.= '</td>';

                                        $info.= '</tr>';
                                    }else{
                                        if($timesheet['hours'] < 6){
                                            $hours = $hours + (6-$timesheet['hours']);
                                            
                                            if($hours >= 8){
                                                
                                                $days = $days + floor($hours/8);
                                                $hours = $hours%8;
                                            }

                                            $info.= '<tr>';

                                            $info.= '<td>';
                                            $info.= $day_array[$i];
                                            $info.= '</td>';

                                            $info.= '<td>';
                                            $info.= ((6-$timesheet['hours']) > 1) ? (6-$timesheet['hours'])." Hrs" : (6-$timesheet['hours'])." Hr";
                                            $info.= '</td>';

                                            $info.= '</tr>';
                                        }
                                    }

                                }else{
                                    if($timesheet['hours'] < 3){
                                        $hours = $hours + (4-$timesheet['hours']);
                                        
                                        if($hours >= 8){
                                            
                                            $days = $days + floor($hours/8);
                                            $hours = $hours%8;
                                        }
                                        
                                        $info.= '<tr>';

                                        $info.= '<td>';
                                        $info.= $day_array[$i];
                                        $info.= '</td>';

                                        $info.= '<td>';
                                        $info.= ((4-$timesheet['hours']) > 1) ? (4-$timesheet['hours'])." Hrs" : (4-$timesheet['hours'])." Hr";
                                        $info.= '</td>';

                                        $info.= '</tr>';
                                    }
                                }


                            }
                        }else{
                            $days = $days +1;

                            $info.= '<tr>';

                            $info.= '<td>';
                            $info.= $day_array[$i];
                            $info.= '</td>';

                            $info.= '<td>';
                            $info.= "1 Day";
                            $info.= '</td>';

                            $info.= '</tr>';
                        }

                    }
                }
            }
            $info.= '</table>';
            
            if($days > 0 || $hours > 0){
                
                if($days > 1){
                    $day_print = $days." Days";
                }else{
                    $day_print = $days." Day";
                }
                
                if($hours > 1){
                    $hour_print = $hours." Hrs";
                }else{
                    $hour_print = $hours." Hr";
                }
                
                $msg.= "Hi ".$employee['emp_name'].", <br><br>";
                $msg.= "Your salary calculation is going to process and your salary for below mentioned date/dates will be deducted.<br><br>";
                $msg.= $info;
                $msg.= "<br>Total of ".$day_print." and ".$hour_print.".<br>";
                $msg.= "<br>Please take necessary action to prevent the deduction.<br><br>";
                $msg.= "Regards<br>";
                $msg.= "HR Department<br><br>";
                $msg.= "This is a system generated email. Please do not reply.<br>";
                //echo $msg;
                $to = $employee['gi_email'];
                $subject = "Salary Calculation";
                $this->sendMail($to, $subject, $msg);
            }
        }
        
    }
    
    public function salary_reminder_new(){
        
        $this->load->model('dept_model');
        $dept_heads_array = $this->dept_model->get_all_dept_heads_ids();
        
        $this->load->model('employee_model');
        //echo "hi2 "; exit;
        $dept_heads = array();
        $in =0 ;
        foreach($dept_heads_array as $dha){
            $dept_heads[$in] = $dha['dept_head'];
            $in++;
        }
        //echo "hii";
//        $cur_month = date('m');
//        $cur_year = date('Y');
//        
//        $last_month = date('m', strtotime('-1 month'));
//        
//        if($cur_month == 1){
//            $year = $cur_year-1;
//        }else{
//            $year = $cur_year;
//        }
        
        $start_range = '2016-04-27';
        $end_range = '2016-05-26';
        //$employee_id = $this->input->post('employee_id');

        $date_array = array();

        $date = $start_range;
        while (strtotime($date) <= strtotime($end_range)) {
            $date_array[$date] = array();
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        $period = new DatePeriod(new DateTime($start_range), new DateInterval('P1D'), new DateTime($end_range.' +1 day'));
        foreach ($period as $date) {
            $diff_dates[] = $date->format("Y-m-d");
        }

        $festival_dates = $this->employee_model->get_festival_dates($start_range, $end_range);

        $i=0;
        if(!empty($festival_dates)){
            foreach($festival_dates as $fd){
                $festival_array[$i] = $fd['festival_date'];
                $i++;
            }
        }else{
            $festival_array = array();
        }

        $weekend_array = array();
        $l=0;
        for($k=0; $k < sizeof($diff_dates); $k++){
            $date = $diff_dates[$k];
            $weekDay = date('w', strtotime($date));

            if($weekDay == 0 || $weekDay == 6){
                $weekend_array[$l] = $date;
                $l++;
            }
        }
        
        $employees = $this->employee_model->get_all_employees();
        //print_r($employees); exit;
        foreach($employees as $em){  
        
        $msg = '';
        $employee_id = $em['id'];
        $employee_attendance = $this->employee_model->get_employee_attendence($start_range, $end_range, $employee_id);
        //echo "<pre>"; print_r($employee_attendance); exit;
        $this->load->model('leave_model');
        $this->load->model('short_leave_model');

        $dates = array();
        $i=0;

        if(empty($employee_attendance)){
                    
            $emp_details = $this->employee_model->get_all_employees($employee_id);

            foreach($emp_details as $emp_dtl){

                for($dt=0; $dt< sizeof($diff_dates); $dt++){

                    if(!in_array($emp_dtl['id'], $dept_heads)){

                        $dates[$emp_dtl['empID']][$i][0] = $diff_dates[$dt];
                        $dates[$emp_dtl['empID']][$i][1] = $emp_dtl['first_name']." ".$emp_dtl['last_name'];
                        $dates[$emp_dtl['empID']][$i][2] = $emp_dtl['empID'];
                        $dates[$emp_dtl['empID']][$i][3] = 0;
                        $dates[$emp_dtl['empID']][$i][4] = 0;
                        $dates[$emp_dtl['empID']][$i][5] = $emp_dtl['id'];
                        $dates[$emp_dtl['empID']][$i][10] = $emp_dtl['reporting_person_name'];
                        $dates[$emp_dtl['empID']][$i][11] = $emp_dtl['doj'];
                        
                        $available_leaves = $this->leave_model->get_available_leave_by_employee_id($emp_dtl['id']);
                        
                        $total_pending = $this->employee_model->get_pending_leave_count($start_range, $end_range, $emp_dtl['id']);

                        $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$dt], $emp_dtl['id']);

                        if(!empty($is_leave)){
                            $dates[$emp_dtl['empID']][$i][6] = '<b style="color:blue;">L</b>';
                            $dates[$emp_dtl['empID']][$i][8] = "L";
                        }else{
                            $dates[$emp_dtl['empID']][$i][6] = '<b style="color:red;">A</b>';
                            $dates[$emp_dtl['empID']][$i][8] = "A";
                        }
                        
                        if($available_leaves['available_leaves'] < 0){
                        
                            $dates[$emp_dtl['empID']][$i][9] = $total_pending['total_pending'] + $available_leaves['available_leaves'];
                        }else{
                            $dates[$emp_dtl['empID']][$i][9] = $available_leaves['available_leaves'];
                        }
                        
                        $dates[$emp_dtl['empID']][$i][7] = 0;
                        $i++;
                    }
                }
            }

        }else{

            foreach($employee_attendance as $ea){

                if(!in_array($ea['id'], $dept_heads)){

                    $dates[$ea['empID']][$i][0] = $ea['date'];
                    $dates[$ea['empID']][$i][1] = $ea['first_name']." ".$ea['last_name'];
                    $dates[$ea['empID']][$i][2] = $ea['empID'];
                    $dates[$ea['empID']][$i][3] = $ea['hours'];
                    $dates[$ea['empID']][$i][4] = $ea['minutes'];
                    $dates[$ea['empID']][$i][5] = $ea['id'];
                    $dates[$ea['empID']][$i][10] = $ea['reporting_person_name'];
                    $dates[$ea['empID']][$i][11] = $ea['doj'];

                    $available_leaves = $this->leave_model->get_available_leave_by_employee_id($ea['id']);
                    
                    $total_pending = $this->employee_model->get_pending_leave_count($start_range, $end_range, $ea['id']);
                    //echo $total_pending['total_pending']; exit;
                    //echo $ea['date']."<pre>"; print_r($diff_dates); echo "</pre>";

                    $is_leave=$this->leave_model->get_date_wise_leave($ea['date'], $ea['id']);

                    $total_count = 0;

                    if((!isset($is_leave) || empty($is_leave))){

                        $time = $ea['hours']*60 + $ea['minutes'];
                        if($time >= 420){
                            $attendance = '<b style="color:green;">P</b>';
                            $attendance1 = "P";
                            $total_count = $total_count + 1;
                        }else{
                            if($time >= 360){

                                $is_short_leave=$this->short_leave_model->get_date_wise_short_leave($ea['date'], $ea['id']);
                                if((!isset($is_short_leave) || empty($is_short_leave))){
                                    $attendance = '<b style="color:#6698FF;">0.75D</b>';
                                    $attendance1 = "0.75D";
                                    $total_count = $total_count + 0.75;
                                }else{
                                    $attendance = '<b style="color:green;">P</b>';
                                    $attendance1 = "P";
                                    $total_count = $total_count + 1;
                                }
                            }else if($time >= 180){

                                $is_half_day=$this->leave_model->get_date_wise_half_day($ea['date'], $ea['id']);
                                if((!isset($is_half_day) || empty($is_half_day))){
                                    $attendance = '<b style="color:#6698FF;">0.5D</b>';
                                    $attendance1 = "0.5D";
                                    $total_count = $total_count + 0.5;
                                }else{
                                    $attendance = '<b style="color:green;">P</b>';
                                    $attendance1 = "P";
                                    $total_count = $total_count + 1;
                                }
                            }else{
                                $attendance = '<b style="color:red;">A</b>';
                                $attendance1 = "A";
                            }
                        }
                    }else{
                        $attendance = '<b style="color:blue;">L</b>';
                        $attendance1 = "L";
                    }

                    $dates[$ea['empID']][$i][6] = $attendance;
                    $dates[$ea['empID']][$i][8] = $attendance1;
                    $dates[$ea['empID']][$i][7] = $total_count;
                    if($available_leaves['available_leaves'] < 0){
                        
                        $dates[$ea['empID']][$i][9] = $total_pending['total_pending'] + $available_leaves['available_leaves'];
                    }else{
                        $dates[$ea['empID']][$i][9] = $available_leaves['available_leaves'];
                    }

                    $i++;
                }
            }
        }
        
        //print_r($dates); exit;
        
        if(!empty($dates)){
        $msg .= "<table border='1'>";
        $msg .= "<thead>
                    <tr>
                        <th>Employee Name</th>";
                        for($j=0; $j< sizeof($diff_dates); $j++) { 
                        $msg .= "<th align='center'>".$diff_dates[$j]."</th>";
                        }
                        $msg .= "<th align='center'>Total</th>
                    </tr>
                </thead>";
        
        $msg .= "<tbody>";
        $i=0;
        foreach($dates as $employee) {
            $msg .= "<tr>
                        <td>".$employee[$i][1]."</td>";
            $ip = $i;
            $j=0;
            $total_count = 0;
            foreach($employee as $emp){

                $date1=date_create($emp[11]);
                $date2=date_create($diff_dates[$j]);
                $diff=date_diff($date1,$date2);
                $num_days = $diff->format("%R%a days");
                
                while($diff_dates[$j] != $emp[0]){

                    $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);
                    if(in_array($diff_dates[$j],$festival_array)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:orange;'>F</b></td>";
                    }else if(in_array($diff_dates[$j],$weekend_array)){
                        $msg .= "<td align='center'><b style='color:#FF6B49;'>W</b></td>";
                    }else if(!empty ($is_leave)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:blue;'>L</b></td>";
                    }else{
                        $msg .= "<td align='center'><b style='color:red;'>A</b></td>";
                    }
                    $j++;
                }
                
                if($diff_dates[$j] == $emp[0]){
                    $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);
                    //echo "<td>".$emp[6]."(".sprintf('%02d',$emp[3])." : ".sprintf('%02d',$emp[4]).")</td>"; 
                    if(in_array($diff_dates[$j],$festival_array)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:orange;'>F</b></td>";
                    }else if(in_array($diff_dates[$j],$weekend_array)){
                        $msg .= "<td align='center'><b style='color:#FF6B49;'>W</b></td>";
                    }else if(!empty ($is_leave)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:blue;'>L</b></td>";
                    }else{
                        $total_count = $total_count + $emp[7];
                        $msg .= "<td align='center'>".$emp[6]."</td>"; 
                    }

                }else{
                    //echo "<td>A(00 : 00)</td>";
                    $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);

                    if(in_array($diff_dates[$j],$festival_array)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:orange;'>F</b></td>";
                    }else if(in_array($diff_dates[$j],$weekend_array)){
                        $msg .= "<td align='center'><b style='color:#FF6B49;'>W</b></td>";
                    }else if(!empty ($is_leave)){
                        if($num_days >= 0){
                            $total_count = $total_count + 1;
                        }
                        $msg .= "<td align='center'><b style='color:blue;'>L</b></td>";
                    }else{
                        $msg .= "<td align='center'><b style='color:red;'>A</b></td>";
                    }
                }
                $i++; $j++; 
            }
            
            for($k=$j ;$k< sizeof($diff_dates);$k++){
                                            
                $date1=date_create($employee[$ip][11]);
                $date2=date_create($diff_dates[$k]);
                $diff=date_diff($date1,$date2);
                $num_days = $diff->format("%R%a days");

                $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$k], $employee[$ip][5]);

                if(in_array($diff_dates[$k],$festival_array)){
                    if($num_days >= 0){
                        $total_count = $total_count + 1;
                    }
                    $msg .= "<td align='center'><b style='color:orange;'>F</b></td>";
                }else if(in_array($diff_dates[$k],$weekend_array)){
                    $msg .= "<td align='center'><b style='color:#FF6B49;'>W</b></td>";
                }else if(!empty ($is_leave)){
                    if($num_days >= 0){
                        $total_count = $total_count + 1;
                    }
                    $msg .= "<td align='center'><b style='color:blue;'>L</b></td>";
                }else{
                    $msg .= "<td align='center'><b style='color:red;'>A</b></td>";
                }
            } 
            
            if($employee[$ip][9] < 0){
                $avl_leaves = $employee[$ip][9];
            }else{
                $avl_leaves = 0;
            }
            $msg .= "<td align='center'><b style='color:black;'>".($total_count+$avl_leaves)."</b></td>";
            $msg .= "</tr>";
        }
        $msg .= "</tbody>";
        $msg .= "</table>";
        
        echo $msg;
        
        $full_msg = '';
        
        $full_msg.= "Hi ".$employee['emp_name'].", <br><br>";
        $full_msg.= "Your salary calculation is going to process and your salary for below mentioned date/dates will be calculated.<br><br>";
        $full_msg.= $msg;
        //$full_msg.= "<br>Total of ".$day_print." and ".$hour_print.".<br>";
        $full_msg.= "<br><br>Please take necessary action to complete your attendance.<br><br>";
        $full_msg.= "Regards<br>";
        $full_msg.= "HR Department<br><br>";
        $full_msg.= "This is a system generated email. Please do not reply.<br>";
        //echo $msg;
        $to = 'puneet.dwivedi@crgroup.com';
        //$to = $employee['gi_email'];
        $subject = "Salary Calculation";
        $this->sendMail($to, $subject, $full_msg);
        
        exit;
        }
        }
    }
    
    public function salary_calculation(){ // 28th of every month
        
        $cur_month = date('m');
        $cur_year = date('Y');
        
        $last_month = date('m', strtotime('-1 month'));
        
        if($cur_month == 1){
            $year = $cur_year-1;
        }else{
            $year = $cur_year;
        }
        
        $num_days1 = cal_days_in_month(CAL_GREGORIAN, $last_month, $year);
        $day_array = array();
        $j=0;
        
        for($k=27; $k <= $num_days1; $k++){
            $date = $year."-".$last_month."-".$k;
            $weekDay = date('w', strtotime($date));
            
            $this->load->model('employee_model');
            $festival = $this->employee_model->get_festival($date);
            
            if($weekDay == 0 || $weekDay == 6){
                //echo $k."<br>";
            }else if (!empty ($festival)){
                //echo $k."<br>";
            }else{
                $day_array[$j] = $date;
                $j++;
            }
        }
        
        for($i=1; $i<= 26; $i++){
            
            $date = $cur_year."-".$cur_month."-".$i;
            $weekDay = date('w', strtotime($date));
            
            $this->load->model('employee_model');
            $festival = $this->employee_model->get_festival($date);
            
            if($weekDay == 0 || $weekDay == 6){
                //echo $i."<br>";
            }else if (!empty ($festival)){
                //echo $i."<br>";
            }else{
                $day_array[$j] = $date;
                $j++;
            }
            
        }
        
        $data_array = array();
        $array_count = 0;
        $employees = $this->employee_model->get_all_employees();
        
        $this->load->model('leave_model');
        $this->load->model('work_model');
        $this->load->model('short_leave_model');
        
        foreach($employees as $employee){
            $days = 0;
            $hours = 0;
            $msg = '';
            
            for($i=0; $i < sizeof($day_array); $i++){
                
                $date1=date_create($employee['doj']);
                $date2=date_create($day_array[$i]);
                $diff=date_diff($date1,$date2);
                $num_days = $diff->format("%R%a days");
                
                if($num_days >= 0){
                    $is_leave=$this->leave_model->get_date_wise_leave($day_array[$i], $employee['id']);

                    if((!isset($is_leave) || empty($is_leave))){
                        
                        $timesheet = $this->work_model->get_approved_timesheet($day_array[$i], $employee['id']);

                        if( (isset($timesheet) && !empty($timesheet)) ){
                            if($timesheet['hours'] < 7){

                                $is_half_day=$this->leave_model->get_date_wise_half_day($day_array[$i], $employee['id']);

                                if((!isset($is_half_day) || empty($is_half_day))){

                                    $is_short_leave=$this->short_leave_model->get_date_wise_short_leave($day_array[$i], $employee['id']);

                                    if((!isset($is_short_leave) || empty($is_short_leave))){
                                        $hours = $hours + (8-$timesheet['hours']);
                                        
                                        if($hours >= 8){
                                            
                                            $days = ($days+floor($hours/8));
                                            $hours = $hours%8;
                                        }
                                    }else{
                                        if($timesheet['hours'] < 6){
                                            $hours = $hours + (6-$timesheet['hours']);
                                            
                                            if($hours >= 8){
                                                
                                                $days = $days + floor($hours/8);
                                                $hours = $hours%8;
                                            }
                                        }
                                    }

                                }else{
                                    if($timesheet['hours'] < 3){
                                        $hours = $hours + (4-$timesheet['hours']);
                                        
                                        if($hours >= 8){
                                            
                                            $days = $days + floor($hours/8);
                                            $hours = $hours%8;
                                        }
                                    }
                                }


                            }
                        }else{
                            
                            $days = $days +1;
                        }

                    }
                }
            }
            
            if($days > 0 || $hours > 0){
                
                if($days > 1){
                    $day_print = $days." Days";
                }else{
                    $day_print = $days." Day";
                }
                
                if($hours > 1){
                    $hour_print = $hours." Hrs";
                }else{
                    $hour_print = $hours." Hr";
                }
                
                $data_array[$array_count] = array(
                    'Employee ID' => $employee['empID'],
                    'Employee Name' => $employee['emp_name'],
                    'Deduction' => $day_print." ".$hour_print
                );
                $array_count++;
                
//                $msg.= "Hi ".$employee['emp_name'].", <br><br>";
//                $msg.= "Your salary calculation is going to process and your salary for below mentioned date/dates will be deducted.<br><br>";
//                $msg.= $info;
//                $msg.= "<br>Total of ".$day_print." and ".$hour_print.".<br>";
//                $msg.= "<br>Please take necessary action to prevent the deduction.<br><br>";
//                $msg.= "Regards<br>";
//                $msg.= "HR Department<br>";
//                echo $msg;

            }
        }
        
        //echo "<pre>"; print_r($data_array); echo "</pre>";
        
        $start_date = $day_array[0];
        $end_date = $day_array[sizeof($day_array)-1];
        $filename='Salary_Calculation_CRG_'.time().'.xls';

        $headers = array('Employee ID', 'Employee Name', 'Deduction');

        $title = 'Salary Deduction for Period '.date('jS M, Y', strtotime($start_date)).' to '.date('jS M, Y', strtotime($end_date));

        $this->create_excel_general($headers, $data_array, $filename, $title, 'assets/salary_calc/');
        
//        $attachment = 'assets/salary_calc/'.$filename;
//        $to = punet.dwivedi@crgroup.com;
//        $subject = "Salary Calculation";
//        $this->sendMail($to, $subject, $msg, '', $attachment);
        
    }
    
    public function notification_reminder_1(){
        
        $date = date('Y-m-d');

        $date1 = $date.' 00:00:00';
        $date2 = $date.' 23:59:59';

        $this->load->model('employee_model');
        $reporting_heads = $this->employee_model->get_all_reporting_heads();

        foreach($reporting_heads as $heads){
            
            //echo $heads['id']." ".$heads['first_name']." ".$heads['last_name']." ".$heads['gi_email']."<br>";
            
            $this->load->model('notification_model');
            $notifications = $this->notification_model->get_noti_count($heads['id'], $date1, $date2);
            
            $subject = "Notification Reminder - 1st Day(Date - ".$date.")";
            
            if(!empty($notifications)){
            
                $msg = "Hi ".$heads['first_name']." ".$heads['last_name'].", <br><br>";
                $msg.= "You have below requests to look out. Kindly check them and take some action.<br><br>"; 
                $i=1;

                $msg.= "<table border='1'>";
                $msg.= "<tr>";
                $msg.= "<th>Notification For</th>";
                $msg.= "<th>Request Count</th>";
                $msg.= "</tr>";
                foreach($notifications as $noti){
                    $msg.="<tr>";
                    $msg.="<td>".ucfirst(implode(" ",explode("_",$noti['type'])))."</td>";
                    $msg.="<td align='center'>".$noti['count']."</td>";
                    $msg.="</tr>";
                    $i++;
                }

                $msg.= "</table>";
                
                $msg.= "<br><br>";
                $msg.= "Regards,<br>";
                $msg.= "Admin<br>";
                
                //echo $msg;
                //$to = 'puneet.dwivedi@crgroup.com';
                $to = $heads['gi_email'];
                $this->sendMail($to, $subject, $msg);
            }
            
        }
    }
    
    public function notification_reminder_2(){
        
        $date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date('Y-m-d')) ) ));

        $date1 = $date.' 00:00:00';
        $date2 = $date.' 23:59:59';

        $this->load->model('employee_model');
        $reporting_heads = $this->employee_model->get_all_reporting_heads();

        foreach($reporting_heads as $heads){
            
            //echo $heads['id']." ".$heads['first_name']." ".$heads['last_name']." ".$heads['gi_email']."<br>";
            
            $this->load->model('notification_model');
            $notifications = $this->notification_model->get_noti_count($heads['id'], $date1, $date2);
            
            $subject = "Notification Reminder - 1st Day(Date - ".$date.")";
            
            if(!empty($notifications)){
            
                $msg = "Hi ".$heads['first_name']." ".$heads['last_name'].", <br><br>";
                $msg.= "You have below requests to look out. Kindly check them and take some action.<br><br>"; 
                $i=1;

                $msg.= "<table border='1'>";
                $msg.= "<tr>";
                $msg.= "<th>Notification For</th>";
                $msg.= "<th>Request Count</th>";
                $msg.= "</tr>";
                foreach($notifications as $noti){
                    $msg.="<tr>";
                    $msg.="<td>".ucfirst(implode(" ",explode("_",$noti['type'])))."</td>";
                    $msg.="<td align='center'>".$noti['count']."</td>";
                    $msg.="</tr>";
                    $i++;
                }

                $msg.= "</table>";
                
                $msg.= "<br><br>";
                $msg.= "Regards,<br>";
                $msg.= "Admin<br>";
                
                //echo $msg;
                $to = 'puneet.dwivedi@crgroup.com';
                //$to = $heads['gi_email'];
                $this->sendMail($to, $subject, $msg);
            }
            
        }
    }
    
    public function notification_reminder_3(){
        
        $date = date('Y-m-d',(strtotime ( '-2 day' , strtotime ( date('Y-m-d')) ) ));

        $date1 = $date.' 00:00:00';
        $date2 = $date.' 23:59:59';

        $this->load->model('employee_model');
        $reporting_heads = $this->employee_model->get_all_reporting_heads();

        foreach($reporting_heads as $heads){
            
            //echo $heads['id']." ".$heads['first_name']." ".$heads['last_name']." ".$heads['gi_email']."<br>";
            
            $this->load->model('notification_model');
            $notifications = $this->notification_model->get_noti_count($heads['id'], $date1, $date2);
            
            $subject = "Notification Reminder - 1st Day(Date - ".$date.")";
            
            if(!empty($notifications)){
            
                $msg = "Hi ".$heads['first_name']." ".$heads['last_name'].", <br><br>";
                $msg.= "You have below requests to look out. Kindly check them and take some action.<br><br>"; 
                $i=1;

                $msg.= "<table border='1'>";
                $msg.= "<tr>";
                $msg.= "<th>Notification For</th>";
                $msg.= "<th>Request Count</th>";
                $msg.= "</tr>";
                foreach($notifications as $noti){
                    $msg.="<tr>";
                    $msg.="<td>".ucfirst(implode(" ",explode("_",$noti['type'])))."</td>";
                    $msg.="<td align='center'>".$noti['count']."</td>";
                    $msg.="</tr>";
                    $i++;
                }

                $msg.= "</table>";
                
                $msg.= "<br><br>";
                $msg.= "Regards,<br>";
                $msg.= "Admin<br>";
                
                echo $msg;
                //$to = 'puneet.dwivedi@crgroup.com';
                //$to = $heads['gi_email'];
                //$this->sendMail($to, $subject, $msg);
            }
            
        }
    }
    
    public function claim_submission_reminder(){ // on 25th , 28th & Last day of the month
        
        $this->load->model('employee_model');
        $all_employees = $this->employee_model->get_all_employees();
        
        if(date('d') >= 1 && date('d') <= 5){
            //echo "hello";
            $month = date('F', mktime(0, 0, 0, date('m',strtotime(date('Y-m')." -1 month")), 10));
        }else{
            $month = date('F', mktime(0, 0, 0, date('m'), 10));
        }
        foreach($all_employees as $employee){

            $subject = "Monthly Expense Submission Reminder";
            $message = "Hi ".$employee['first_name']." ".$employee['last_name'].",<br>
                     <br>Kindly submit your expenses for the month of ".$month.".
                     <br>Please ignore this email if already submitted.<br><br>
                     Regards<br>
                     Admin<br>";
            $this->sendMail($employee['gi_email'], $subject, $message);
            //echo "<br>".$subject."<br>".$message."<br>"; exit;

        }
        return true;
    }
    
    public function claim_review_reminder(){ // on 1st & 3rd of Subsequent Month
        
        $this->load->model('employee_model');
        $all_employees = $this->employee_model->get_all_reporting_heads();
        
        foreach($all_employees as $employee){

            $subject = "Monthly Claim Review Remider";
            $message="Hi ".$employee['first_name']." ".$employee['last_name'].",<br>
                     Kindly review all claims of employees who reports you. <br>";
            //$this->sendMail($employee['gi_email'], $subject, 'Testing');
            echo "<br>".$subject."<br>".$message."<br>";

        }
        return true;
    }
    
    public function claim_report_to_finance_dept(){ // on 5th of Subsequent Month, report to Finance department
        
        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date = date('Y-m-d', strtotime('last day of last month'));
        
        $this->load->model('expenses_model');
        $travel_expenses = $this->expenses_model->get_approved_travel_expense_details($start_date, $end_date, '', '');
        $other_expenses = $this->expenses_model->get_approved_other_expense_details($start_date, $end_date, '');
        
        $filename='Expenses_'.time().'.xls';
        
        $headers = array('Employee ID', 'Employee Name', 'Project Code', 'Project Name', 'Department', 'Total Amount');
        $others_headers = array('Employee ID', 'Employee Name', 'Department', 'Total Amount');
        $title = 'Total expenses of employees for Period '.date('jS M, Y', strtotime($start_date)).' to '.date('jS M, Y', strtotime($end_date));
        
        $this->create_excel($headers, $travel_expenses, $others_headers, $other_expenses, $filename, $title);
        
        $subject="Monthly Claim Report - ".date('jS M, Y', strtotime($start_date))." to ".date('jS M, Y', strtotime($end_date));
        $msg ="<p>";
        $msg.="<b>Hi,</b><br><br>";
        $msg.="Kindly find the monthly claim report in the attachment. Thanks!<br><br>";
        $msg.="This is a system generated email, please do not reply.<br><br>";
        $msg.="</p>";
        $attachment = "assets/expenseFiles/".$filename;
        
        $to = 'puneet.dwivedi@crgroup.com';
        //$to = 'finance';
        $this->sendMail($to, $subject, $msg, '', $attachment);
        
        return true;
    }
    
    public function claim_report_to_finance_dept_n_dept_head(){ // on 4th of Subsequent Month, report to Finance department and dept. head
        
        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date = date('Y-m-d', strtotime('last day of last month'));
        
        $this->load->model('dept_model');
        $departments = $this->dept_model->get_all_dept();
        
        $this->load->model('expenses_model');
        
        foreach($departments as $dept){
            
            $travel_expenses = $this->expenses_model->get_travel_expense_details($start_date, $end_date, $dept['id']);
            $other_expenses = $this->expenses_model->get_other_expense_details($start_date, $end_date, $dept['id']);

            $filename='Expenses_Dept'.time().'.xls';
    //        $base_url=base_url();
    //        foreach($travel_expenses as $key => &$te){
    //            if(!empty($te['bill_file_name'])){
    //                
    //                $te['bill_file_name']=$base_url.$te['bill_file_name']." ";
    //            }
    //        }
    //        
    //        foreach($other_expenses as $key => $oe){
    //            if(!empty($oe['bill_file_name'])){
    //                $oe['bill_file_name']=$base_url.$oe['bill_file_name']." ";
    //            }
    //        }

            //$headers = array('Employee ID', 'Employee Name', 'Project Code', 'Project Name', 'Start Date', 'End Date', 'Has Bill', 'Approved', 'Pending', 'Declined', 'Document Link');
            $headers = array('Employee ID', 'Employee Name', 'Project Code', 'Project Name', 'Department', 'Approved', 'Pending', 'Declined');
            //$others_headers = array('Employee ID', 'Employee Name', 'Date', 'Description', 'Has Bill', 'Approved', 'Pending', 'Declined', 'Document Link');
            $others_headers = array('Employee ID', 'Employee Name', 'Department', 'Approved', 'Pending', 'Declined');
            $title = 'Total Expenses of '.$dept["dept_head"].' department for Period '.date('jS M, Y', strtotime($start_date)).' to '.date('jS M, Y', strtotime($end_date));

            $this->create_excel($headers, $travel_expenses, $others_headers, $other_expenses, $filename, $title);

            $subject="Monthly Claim Report - ".date('jS M, Y', strtotime($start_date))." to ".date('jS M, Y', strtotime($end_date));
            $msg ="<p>";
            $msg.="<b>Hi,</b><br><br>";
            $msg.="Kindly find the monthly claim report in the attachment. Thanks!<br><br>";
            $msg.="This is a system generated email, please do not reply.<br><br>";
            $msg.="</p>";
            $attachment = '';
            $attachment = "assets/expenseFiles/".$filename;
            //$this->sendMail('finance_department@crgroup.com', $subject, $msg, $dept['gi_email'], $attachment);
            $this->sendMail('puneet.dwivedi@crgroup.com', $subject, $msg, 'puneetdiwedi19@gmail.com', $attachment);
            
        }
        
        return true;
    }
    
    public function Birthday_Email(){ // Daily
        
        $date = date('Y-m-d');
        //$date = '2016-05-06';
        $this->load->model('employee_model');
        $birthday_employees = $this->employee_model->get_employee_birthday($date);

        foreach($birthday_employees as $employee){

            $subject = "Happy Birthday - ".$employee['first_name']." ".$employee['last_name'];
            $img_num = mt_rand(0,11);
            if($img_num == 0){
                $img_name = '1.jpg';
            }elseif($img_num == 11 || $img_num == 10){
                $img_name = '10.gif';
            }else{
                $img_name = $img_num.'.jpg';
            }
            
            
            $img_path = 'assets/birthday_images/';
            $bday_img = $img_path.'birthday_'.$img_name;
            
            $message="Dear ".$employee['first_name']." ".$employee['last_name'].",<br><br>
            <b>Congrats!!!...</b><br><br>
            Heard you're getting promoted to another more year in your life!<br><br>
            <b>HaPpY BiRtHdAy!</b><br>
            May all your wishes come true.<br><br>
            <img src='".base_url().$bday_img."' alt='Birthday Image' /><br>
            Regards<br>
            HR Team<br><br>";
            
            $to_emp = $employee['gi_email'];
            $cc = 'all@crgroup.co.in';
            //$to_emp = 'puneet.dwivedi@crgroup.co.in';
            $this->sendMail($to_emp, $subject, $message, $cc);
            //echo "<br>".$message."<br>";
            
            /*if($employee['gender'] == 'Male'){
                
                $gender1 = 'Mr';
                $gender2 = 'him';
                $gender3 = 'his';
                
            }elseif($employee['gender'] == 'Female'){
                
                $gender1 = 'Ms';
                $gender2 = 'her';
                $gender3 = 'her';
                
            }else{
                
                $gender1 = '';
                $gender2 = '';
                $gender3 = '';
                
            }
            
            $sub_all = "Birthday Notification - ".$employee['first_name']." ".$employee['last_name'];
            $msg_all = "<b style='color : #6698FF;'>Dear Team,</b><br><br>
            This is a reminder mail that today is <b style='color:#f37121;'>".$gender1." ".$employee['first_name']." ".$employee['last_name']."</b> Birthday.<br> 
            So lets every one come together as a family & wish ".$gender2." <b style='color:#6698FF;'>HaPpY BiRtHdAy</b> & make ".$gender3." day a RoCkInG DaY!!...<br><br>
            You can reach ".$gender2." at <b>".$employee['gi_email'].".</b><br><br>
            Regards<br>
            HR Team<br><br>";
            $to_all = 'all@crgroup.co.in';
            $this->sendMail($to_all, $sub_all, $msg_all);*/
            
            //echo "<br>".$msg_all."<br>";
            //break;
        }
        return true;
    }
    
    public function thought_of_the_day(){ // Daily
        
        $this->load->model('employee_model');
        $thought = $this->employee_model->get_thought_of_the_day_image();
        
        echo "<pre>"; print_r($thought); exit;

        $subject = "Thought Of The Day";

        $img_path = 'assets/Quotes/';
        $thought_img = $img_path.$thought['image_name'];

        $message="<img src='".base_url().$thought_img."' alt='Thought Of The Day' style='max-width:600px;' /><br><br>
        Regards<br>
        HR Team<br><br>";

        $to = 'all@crgroup.co.in';
        //$to = 'puneet.dwivedi@crgroup.co.in';
        $this->sendMail($to, $subject, $message);
        //echo $subject."<br><br>".$message."<br>";
        
        $mark_thought = $this->employee_model->update_thought($thought['id']);
        
        return true;
    }
    
    public function Festival_Email(){ // Daily
        
        $date = date('Y-m-d');
        $this->load->model('employee_model');
        $festival = $this->employee_model->get_festival($date);

        $subject = "Happy ".$festival['festival_name'];
        $message ="Dear Employee,<br><br>
                  Thanks for being a part of <b>CRG Solutions Pvt. Ltd.</b> as we know how hard you work, so enjoy the break at fullest.<br><br>
                  <b>HaPpY GaNeSh ChAturthi!...</b><br><br>
                  <img src='".base_url()."assets/festival_images/happy-ganesh-chaturthi-2016-wide.jpg' alt='".$festival['festival_name']."' style='max-width:600px;' />";
        $to='all@crgroup.co.in';
        //$to='puneet.dwivedi@crgroup.com';
        $this->sendMail($to, $subject, $message);
        //echo $subject."<br><br>".$message;
        return true;
    }

    private function sendMail($to, $subject, $message, $cc = '', $attachment = '') {
        
        //echo "CC Email ID : ".$cc; exit;
        $bcc = '';
        $is_multi_attach = 0;
        $from_email = 'info@crgroup.co.in';
        
        $this->load->model('employee_model');
        $response = $this->employee_model->save_mail_to_DB($to, $subject, $message, $is_multi_attach, $from_email, $cc, $bcc, $attachment);
        
        return $response;
//        $this->load->library('email');
//        $this->email->clear(TRUE);
//        
//        $this->email->from('info@crgroup.co.in','CRG Solutions Pvt. Ltd.');
//        //$this->email->from('abhishukla1690@gmail.com');
//        $this->email->to($to);
//        $this->email->subject($subject);
//
//        if(!empty($cc)) {
//            $this->email->cc($cc);
//        }
//        
//        if(!empty($attachment)) {
//            $this->email->attach($attachment);
//        }
//
//        $this->email->message($message);
//
//        $this->email->send();
//        
//        echo $this->email->print_debugger();
    }
    
    function sendMailFromDB() {
        
        $to         = '';
        $cc         = '';
        $bcc        = '';
        $subject    = '';
        $message    = '';
        $attachment = '';
        
        $this->load->model('employee_model');
        $emails = $this->employee_model->get_email_content();
        
        if(!empty($emails)){
            foreach($emails as $email){
                
                $to         = $email['to_email'];
                $cc         = $email['cc_email'];
                $bcc        = $email['bcc_email'];
                $subject    = $email['subject'];
                $message    = $email['message'];
                $attachment = $email['attachment'];
                
                $this->load->library('email');
                $this->email->clear(TRUE);

                $this->email->from('info@crgroup.co.in', 'CRG Solutions Pvt. Ltd.');
                $this->email->to($to);
                $this->email->subject($subject);

                if(!empty($bcc)) {
                    $this->email->bcc($bcc);
                }

                if(!empty($cc)) {
                    $this->email->cc($cc);
                }
                
                if($email['is_multi_attachment'] == 1){
                    $attachment_array = explode(',',$attachment);
                    for($i=0; $i< sizeof($attachment_array); $i++){
                        $this->email->attach($attachment_array[$i]);
                    }
                }else{
                    if(!empty($attachment)) {
                        $this->email->attach($attachment);
                    }
                }

                $this->email->message($message);

                if($this->email->send()){
                    $status = 'Send';
                    $this->employee_model->update_send_mail($email['id'], $status);
                }else{
                    $status = 'Not Send';
                    $this->employee_model->update_send_mail($email['id'], $status);
                }
                
            }
        }
        
        return true;
    }
    
    function sendMailFromDB_by_id($id) {
        
        $to         = '';
        $cc         = '';
        $bcc        = '';
        $subject    = '';
        $message    = '';
        $attachment = '';
        
        $this->load->model('employee_model');
        $email = $this->employee_model->get_email_content_by_id($id);
        
        if(!empty($email)){
            //foreach($emails as $email){
                
                $to         = $email['to_email'];
                $cc         = $email['cc_email'];
                $bcc        = $email['bcc_email'];
                $subject    = $email['subject'];
                $message    = $email['message'];
                $attachment = $email['attachment'];
                
                $this->load->library('email');
                $this->email->clear(TRUE);

                $this->email->from('info@crgroup.co.in', 'CRG Solutions Pvt. Ltd.');
                $this->email->to($to);
                $this->email->subject($subject);

                if(!empty($bcc)) {
                    $this->email->bcc($bcc);
                }

                if(!empty($cc)) {
                    $this->email->cc($cc);
                }
                
                if($email['is_multi_attachment'] == 1){
                    $attachment_array = explode(',',$attachment);
                    for($i=0; $i< sizeof($attachment_array); $i++){
                        $this->email->attach($attachment_array[$i]);
                    }
                }else{
                    if(!empty($attachment)) {
                        $this->email->attach($attachment);
                    }
                }

                $this->email->message($message);

                if($this->email->send()){
                    $status = 'Send';
                    $this->employee_model->update_send_mail($email['id'], $status);
                }else{
                    $status = 'Not Send';
                    $this->employee_model->update_send_mail($email['id'], $status);
                }
                
            //}
        }
        
        return true;
    }
    
    function create_excel($headers, $expenses, $others_headers, $others, $name, $title, $type='') {
        $this->load->library('excel');
        $this->config->load('excel');
        $row = 1;
        $last_letter =  PHPExcel_Cell::stringFromColumnIndex(count($headers)-1);
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($this->config->item('defaultStyle'));
        $this->excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
        
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        
        $this->excel->getActiveSheet()->mergeCells('A1:'.$last_letter.'1');
        $this->excel->getActiveSheet()->setCellValue('A1', $title);
        $this->excel->getActiveSheet()->getStyle('A1:'.$last_letter.'1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:'.$last_letter.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->mergeCells('A2:'.$last_letter.'2');
        $this->excel->getActiveSheet()->setCellValue('A2', '**Generated on '.date('d.m.Y H:i:s'));
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_letter.'2')->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_letter.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $row = 4;
        
        $this->excel->getActiveSheet()->fromArray($headers, NULL, 'A'.$row);
        $this->excel->getActiveSheet()->getStyle('A'.$row.':'.$last_letter.$row)
                            ->applyFromArray($this->config->item('headerStyle'));
        $row++;
        
        foreach($expenses as $expense) {
            $row_data = array_values($expense);

            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A'.$row, true);
            $row++;
        }
        
        $row++;
        $last_letter =  PHPExcel_Cell::stringFromColumnIndex(count($others_headers)-1);
        $this->excel->getActiveSheet()->mergeCells('A'.$row.':'.$last_letter.$row);
        $this->excel->getActiveSheet()->setCellValue('A'.$row, 'Other Expenses');
        $this->excel->getActiveSheet()->getStyle('A'.$row.':'.$last_letter.$row)->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A'.$row.':'.$last_letter.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $row++;
        $this->excel->getActiveSheet()->fromArray($others_headers, NULL, 'A'.$row);
        $this->excel->getActiveSheet()->getStyle('A'.$row.':'.$last_letter.$row)
                            ->applyFromArray($this->config->item('headerStyle'));
        $row++;
        
        foreach($others as $other) {
            $row_data = array_values($other);
            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A'.$row, true);
            $row++;
        }
        
        $filename = $name ;

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save('php://output');
        if($type == 'timesheet'){
            //$objWriter->save(str_replace(__FILE__,'D:\Projects/crg-intra/assets/timesheet/'.$filename,__FILE__));
            $objWriter->save(str_replace(__FILE__,'assets/timesheet/'.$filename,__FILE__));
        }else{
            //$objWriter->save(str_replace(__FILE__,'D:\Projects/crg-intra/assets/expenseFiles/'.$filename,__FILE__));
            $objWriter->save(str_replace(__FILE__,'assets/expenseFiles/'.$filename,__FILE__));
        }
    }
    
    function create_excel_general($headers, $data_array, $name, $title, $path) {
        $this->load->library('excel');
        $this->config->load('excel');
        $row = 1;
        $last_letter =  PHPExcel_Cell::stringFromColumnIndex(count($headers)-1);
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($this->config->item('defaultStyle'));
        $this->excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
        
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        
        $this->excel->getActiveSheet()->mergeCells('A1:'.$last_letter.'1');
        $this->excel->getActiveSheet()->setCellValue('A1', $title);
        $this->excel->getActiveSheet()->getStyle('A1:'.$last_letter.'1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:'.$last_letter.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->mergeCells('A2:'.$last_letter.'2');
        $this->excel->getActiveSheet()->setCellValue('A2', '**Generated on '.date('d.m.Y H:i:s'));
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_letter.'2')->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_letter.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $row = 4;
        
        $this->excel->getActiveSheet()->fromArray($headers, NULL, 'A'.$row);
        $this->excel->getActiveSheet()->getStyle('A'.$row.':'.$last_letter.$row)
                            ->applyFromArray($this->config->item('headerStyle'));
        $row++;
        
        foreach($data_array as $da) {
            $row_data = array_values($da);

            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A'.$row, true);
            $row++;
        }
        
        $row++;
        
        $filename = $name ;

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save('php://output');
        
        $objWriter->save(str_replace(__FILE__,$path.$filename,__FILE__));
    }
}
