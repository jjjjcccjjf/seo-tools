<?php

class Login_model extends Admin_core_model
{

  function __construct()
  {
    parent::__construct();

    $this->table = 'admin'; # Replace these properties on children
    $this->upload_dir = 'admin'; # Replace these properties on children
    $this->per_page = 15;

    $this->load->library('email');
    $config_mail['protocol'] = getenv('MAIL_PROTOCOL');
    $config_mail['smtp_host'] = getenv('SMTP_HOST');
    $config_mail['smtp_port'] = getenv('SMTP_PORT');
    $config_mail['smtp_user'] = getenv('SMTP_EMAIL');
    $config_mail['smtp_pass'] = getenv('SMTP_PASS');
    $config_mail['mailtype'] = "html";
    $config_mail['charset'] = "utf-8";
    $config_mail['newline'] = "\r\n";
    $config_mail['wordwrap'] = TRUE;

    $this->email->initialize($config_mail);
  }

  public function getByEmail($email)
  {
    return $this->db->get_where($this->table, array('email' => $email))->row();
  }

  /**
   * get user depends if user or admin 
   * @param  [type] $email [description]
   * @param  [type] $type  users | admin
   * @return [type]        [description]
   */
  function getRowByType($email, $type)
  {
    return $this->db->get_where($type, ['email' => $email])->row();
  }

  function forgotPassword($email, $type)
  {
    $user = $this->getRowByType($email, $type);
    if (!$user) {
      return false;
    }

    $html = $this->generatePasswordResetMessage($email, $type, $user->name);
    return $this->sendMail($email, 'Forgot Password - [SEO Tool - MyOptimind]', $html);
  }

  public function generatePasswordResetMessage($email, $type, $name = 'User')
  {

    $link = base_url('reset_password/') . urlencode(base64_encode($email . ":" . $type));

    $html = '<table class="container" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
    <tbody>
    <tr bgcolor="7087A3"><td height="15"></td></tr>

    <tr bgcolor="7087A3">
        <td align="center">
            <table class="container-middle" align="center" border="0" cellpadding="0" cellspacing="0" width="560">
                <tbody><tr>
                    <td>
                        <table class="top-header-left" align="left" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center">
                                    <table class="date" border="0" cellpadding="0" cellspacing="0">
                                        <tbody><tr>
                                            <td style="color: #fff; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;"> 
                                            Forgot Password
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                                <singleline>
                                                </singleline>
                                            </td>
                                        </tr>

                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>

                        <table class="top-header-right" align="left" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr><td height="20" width="30"></td></tr>
                            </tbody></table>

                        <table class="top-header-right" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td align="center">
                                    <table class="tel" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tbody><tr>
                                            <td style="color: #fff; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;"> 
                                            SEO Tool - MyOptimind
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                                <singleline>
                                                </singleline>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>

    <tr bgcolor="7087A3"><td height="10"></td></tr>

    </tbody>
</table>

<!--  end top header  -->


<!-- main content -->
<table class="container" align="center"  border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="ffffff">


<!--Header-->
<tbody>

<!--section 1 -->
<tr>
    <td>
        <table class="container-middle" align="center" border="0" cellpadding="0" cellspacing="0" width="560" bgcolor="F1F2F7">
            <tr >
                <td>
                    <table class="mainContent" align="center" border="0" cellpadding="0" cellspacing="0" width="528">
                        <tbody><tr><td height="20"></td></tr>
                        <tr>
                            <td>
                                 

                                <table class="section-item" align="left" border="0" cellpadding="0" cellspacing="0" width="360">
                                    <tbody><tr>
                                        <td style="color: #484848; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">

                                            Forgot Password

                                        </td>
                                    </tr>
                                    <tr><td height="15"></td></tr>
                                    <tr>
                                        <td style="color: #a4a4a4; line-height: 25px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">

                                            Howdy '.$name.'! If you are trying to reset your passsword, please click on the button below. Otherwise, please ignore this email.

                                        </td>
                                    </tr>
                                    <tr><td height="15"></td></tr>
                                    <tr>
                                        <td>
                                            <a href="'.$link.'" style="background-color: #7087A3; font-size: 12px; padding: 10px 15px; color: #fff; text-decoration: none">Reset Password</a>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>

                        <tr><td height="20"></td></tr>

                        </tbody></table>
                </td>
            </tr>



            </table>
    </td>
</tr>
<!-- end section 1-->

<!-- footer -->
<table class="container" border="0" cellpadding="0" cellspacing="0" width="600">
    <tbody>
    <tr bgcolor="7087A3"><td height="15"></td></tr>
    <tr bgcolor="7087A3">
        <td  style="color: #fff; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" align="center">

            MyOptimind © Copyright 2020 . All Rights Reserved

        </td>
    </tr>

    <tr>
        <td bgcolor="7087A3" height="14"></td>
    </tr>
    </tbody></table>';

    return $html;
  }

  public function sendMail($to, $subject, $message)
  {
    $this->email->from('noreply@myoptimind.com', 'SEO Tool - MyOptimind');
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);
    return $this->email->send();
  }

}
