<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*** preferences for sending the E-mail	***/
/*
//The mail sending protocol.
$config['protocol'] = 'sendmail';

//The server path to Sendmail.
$config['mailpath'] = '/usr/sbin/sendmail';

//Character set
$config['charset'] = 'utf-8';

//Type of mail(text or html). If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
$config['mailtype'] = 'html';

//Enable word-wrap.TRUE or FALSE (boolean)
$config['wordwrap'] = TRUE;*/

/*$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'dbcorpltd1@gmail.com';
$config['smtp_pass'] = 'dbcorp@123';
$config['mailtype'] = 'html';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = true;
$config['charset'] = 'utf-8';*/

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'mytravel@dbcorp.in';
$config['smtp_pass'] = 'Password@123';
$config['mailtype'] = 'html';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = true;
$config['charset'] = 'utf-8';

/*$config['useragent']        = 'PHPMailer';              
// Mail engine switcher: 'CodeIgniter' or 'PHPMailer'
$config['protocol']         = 'smtp';                   
// 'mail', 'sendmail', or 'smtp'
$config['mailpath']         = '/usr/sbin/sendmail';
$config['smtp_host']        = 'smtp.gmail.com';
$config['smtp_user']        = 'abhishek.kumar@dbcorp.in';
$config['smtp_pass']        = 'ABHI$%1122';
$config['smtp_port']        = 465;
$config['smtp_timeout']     = 30;                       
// (in seconds)
$config['smtp_crypto']      = 'ssl';                    
// '' or 'tls' or 'ssl'
$config['smtp_debug']       = 0;                        
// PHPMailer's SMTP debug info level: 0 = off, 1 = commands, 2 = commands and data, 3 = as 2 plus connection status, 4 = low level data output.
$config['smtp_auto_tls']    = false;                    
// Whether to enable TLS encryption automatically if a server supports it, even if `smtp_crypto` is not set to 'tls'.
$config['smtp_conn_options'] = array();                 
// SMTP connection options, an array passed to the function stream_context_create() when connecting via SMTP.
$config['wordwrap']         = true;
$config['wrapchars']        = 76;
$config['mailtype']         = 'html';                   
// 'text' or 'html'
$config['charset']          = null;                     
// 'UTF-8', 'ISO-8859-15', ...; NULL (preferable) means config_item('charset'), i.e. the character set of the site.
$config['validate']         = true;
$config['priority']         = 3;                        
// 1, 2, 3, 4, 5; on PHPMailer useragent NULL is a possible option, it means that X-priority header is not set at all, see https://github.com/PHPMailer/PHPMailer/issues/449
$config['crlf']             = "\n";                     // "\r\n" or "\n" or "\r"
$config['newline']          = "\n";                     // "\r\n" or "\n" or "\r"
$config['bcc_batch_mode']   = false;
$config['bcc_batch_size']   = 200;
$config['encoding']         = '8bit';                   // The body encoding. For CodeIgniter: '8bit' or '7bit'. For PHPMailer: '8bit', '7bit', 'binary', 'base64', or 'quoted-printable'.
*/