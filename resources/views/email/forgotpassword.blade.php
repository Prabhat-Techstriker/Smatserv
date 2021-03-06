<!-- <html>

<body>
    <h3>Hello, {{ $get_user_data->name }}</h3>

    <p>You are reciving this email because we recived a forgot password request for your account.</p>
    <p>Your new password is below:</p>
    <h5>{{ $password }}</h5>

    <p>Thank you</p>
</body>

</html> -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Forgot Password</title>

    <style>

        body {

            background-color: #FFFFFF; padding: 0; margin: 0;

        }

    </style>

</head>

<body style="background-color: #FFFFFF; padding: 0; margin: 0;">

<table border="0" cellpadding="0" cellspacing="10" height="100%" bgcolor="#FFFFFF" width="100%" style="max-width: 650px;" id="bodyTable">

    <tr>

        <td align="center" valign="top">

            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">

                <!-- Logo -->

                <tr>

                    <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">

                        <img alt="${site-name}" border="0" src="${site-url-secure}/assets/images/common/demo/logo.png" title="${site-name}" class="sitelogo" width="60%" style="max-width:250px;" />

                    </td>

                </tr>

                <!-- Title -->

                <tr>

                    <td align="left" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">

                        <span style="font-size: 18px; font-weight: normal;">FORGOT PASSWORD</span>

                    </td>

                </tr>

                <!-- Messages -->

                <tr>

                    <td align="left" valign="top" colspan="2" style="padding-top: 10px;">

                        <span style="font-size: 12px; line-height: 1.5; color: #333333;">

                        	Hello {{ $get_user_data->name }}

                            We have sent you this email in response to your request to forgot your password on {sitename}.
                            <br/><br/>

                            your new password is : {{ $password }}

                            <br/><br/>

                            We recommend that you keep your password secure and not share it with anyone.
                            <br/><br/>

                            If you need help, or you have any other questions, feel free to email : {customer-service-email}.

                            <br/><br/>

                        </span>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>

</body>

</html>