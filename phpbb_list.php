<?php
function xmlspecialchars($text) {
   return str_replace('-' , ' ' , str_replace('&#039;', '&apos;', htmlspecialchars($text, ENT_QUOTES)));
}


include "settings.php";
include ($configPath);


// get DB creds from forum config, AWS creds are in config as well but we don't rename them
$f_username=$dbuser;
$f_password=$dbpasswd;
$f_database=$dbname;
$f_server=$dbhost;

// define forum mysqli connection
// TODO Move this to SSL 
$f_mysqli = new mysqli($f_server, $f_username, $f_password, $f_database);
 // Check forum connection
if (mysqli_connect_errno($f_mysqli))
  {
		echo logEvent("Failed to connect to forum MySQL $f_server/$f_database: " . mysqli_connect_error());
		exit();
  } else {
		echo nl2br ("Connected to forum database: $f_server/$f_database \n" ) ; 
	} ;


// $mode = $_GET[mode];

$query = 'select '
        . ' phpbb_users.user_id ,'
        . ' phpbb_users.username ,'
        . ' phpbb_users.user_email, '
        . ' phpbb_users.user_sig, '
        . ' phpbb_users.user_occ, '
        . ' phpbb_users.user_interests, '
        . ' from_unixtime(phpbb_users.user_lastvisit) as lastvisit, ' 
        . ' phpbb_profile_fields_data.user_id ,'
        . ' phpbb_profile_fields_data.pf_airport_id ,'
        . ' airports.apt_id ,'
        . ' airports.apt_name ,'
        . ' airports.lat ,'
        . ' airports.city ,'
        . ' airports.state ,'
        . ' airports.lon'
        . ' from phpbb_users,'
        . ' phpbb_profile_fields_data ,'
        . ' airports'
        . ' where ' 
        . ' phpbb_profile_fields_data.pf_pilot_yn = 1 and'
        . ' phpbb_profile_fields_data.user_id = phpbb_users.user_id and '
        . ' airports.apt_id = UCASE(phpbb_profile_fields_data.pf_airport_id) ' 
				. ' order by airports.state, phpbb_users.user_lastvisit desc ;'
        . ' ';


// create table headers
echo	'<html><body><table border=1><tr><th>UserName</th><th>State</th><th>Last Visit</th><th>City</th>'
    	 . '<th>Airport</th><th>Email</th><th>Sig</th><th>Occ</th><th>Interests</th></tr>';

// run query
$result=$f_mysqli->query($query);

if(!$result) { 
		echo logEvent("Error $f_mysqli->error to get max user id from forum, exiting. Query: $queryMaxUserForum");
	} else {
		while($row = $result->fetch_assoc()) {
			echo '<tr><td>' . $row['username'] . '</td>'
       . '<td>' . $row["state"]  . '</td>'
       . '<td>' . $row["lastvisit"]  . ' &nbsp</td>'
       . '<td>' . $row["city"]  . '</td>'
       . '<td>' . $row["apt_id"]  . '</td>'
       . '<td>' . $row["user_email"]  . '</td>'
       . '<td>' . $row["user_sig"]  . ' &nbsp</td>'
       . '<td>' . $row["user_occ"]  . ' &nbsp</td>'
       . '<td>' . $row["user_interests"]  . ' &nbsp</td>'
       . '</tr>' ;

		}
	}


		   echo 
		   '</table><br>'. $i . ' Pilots Listed<br></body></html>';
       ?>
