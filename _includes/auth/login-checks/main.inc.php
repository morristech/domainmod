<?php
// Domain Manager - A web-based application written in PHP & MySQL used to manage a collection of domain names.
// Copyright (C) 2010 Greg Chetcuti
// 
// Domain Manager is free software; you can redistribute it and/or modify it under the terms of the GNU General
// Public License as published by the Free Software Foundation; either version 2 of the License, or (at your
// option) any later version.
// 
// Domain Manager is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
// implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
// for more details.
// 
// You should have received a copy of the GNU General Public License along with Domain Manager. If not, please 
// see http://www.gnu.org/licenses/
?>
<?php
session_start();
include("../../config.inc.php");
include("../../database.inc.php");
include("../../software.inc.php");
include("../../auth/auth-check.inc.php");
include("../../timestamps/current-timestamp-basic.inc.php");

$_SESSION['session_running_login_checks'] = 1;

// Check to see if it's a new password
include("../../auth/login-checks/new-password-check.inc.php");

unset($_SESSION['session_running_login_checks']);

$sql_user_update = "update users
					set last_login = '$current_timestamp',
					number_of_logins = number_of_logins+1,
					update_time = '$current_timestamp'
					where id = '" . $_SESSION['session_user_id'] . "'
					and email_address = '" . $_SESSION['session_email_address'] . "'";
$result_user_update = mysql_query($sql_user_update,$connection);

if (isset($_SESSION['session_user_redirect'])) {

	$temp_redirect = $_SESSION['session_user_redirect'];
	unset($_SESSION['session_user_redirect']);

	header("Location: $temp_redirect");
	exit;

} else {


 	header("Location: ../../../domains.php");
	exit;

}
?>