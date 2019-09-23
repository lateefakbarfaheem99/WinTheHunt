<?PHP

$error = null;

// ------------------------------------------------------------------
// Check Username Exists
// ------------------------------------------------------------------
$check_username = mysql_query("select id from idevaff_affiliates where username = '$username'");
if (mysql_num_rows($check_username)) { $error .= "- Username is taken.\r\n"; }

// ------------------------------------------------------------------
// Check Username Is Short
// ------------------------------------------------------------------
function username_short($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if ((strlen($credential) >= 4)) {
$rtn_value=true; } return $rtn_value; }
if (!username_short($username)) { $error .= "- Username is too short or missing. 4 charaters min.\r\n"; }

// ------------------------------------------------------------------
// Check Username Is Long
// ------------------------------------------------------------------
function username_long($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if((strlen($credential) <= 12)) {
$rtn_value=true; } return $rtn_value; }
if (!username_long($username)) { $error .= "- Username is too long. 12 characters max.\r\n"; }

// ------------------------------------------------------------------
// Check Username Is Valid
// ------------------------------------------------------------------
function username_valid($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if (!(preg_match("/[^a-z0-9_]/i", $credential))) {
$rtn_value=true; } return $rtn_value; }
if (!username_valid($username)) { $error .= "- Username is invalid.  Can only be letters, numbers and underscores."; }

// ------------------------------------------------------------------
// Check Password Is Short
// ------------------------------------------------------------------
function password_short($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if ((strlen($credential) >= 4)) {
$rtn_value=true; } return $rtn_value; }
if (!password_short($password)) { $error .= "- Password is too short or missing. 4 charaters min.\r\n"; }

// ------------------------------------------------------------------
// Check Password Is Long
// ------------------------------------------------------------------
function password_long($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if((strlen($credential) <= 12)) {
$rtn_value=true; } return $rtn_value; }
if (!password_long($password)) { $error .= "- Password is too long. 12 characters max.\r\n"; }

// ------------------------------------------------------------------
// Check Password Is Valid
// ------------------------------------------------------------------
function password_valid($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if (!(preg_match("/[^a-z0-9_]/i", $credential))) {
$rtn_value=true; } return $rtn_value; }
if (!password_valid($password)) { $error .= "- Password is invalid.  Can only be letters, numbers and underscores.\r\n"; }

// ------------------------------------------------------------------
// Check Email Address Is Present
// ------------------------------------------------------------------
// if (!$email) { $error .= "- Missing email address.\r\n"; }

// ------------------------------------------------------------------
// Check Email Is Valid
// ------------------------------------------------------------------
function email_valid($credential) {
$rtn_value = false;
if (get_magic_quotes_gpc()) {
$credential = stripslashes($credential); }
if ((preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-zA-Z0-9_]|\\-)+\\.)+[a-z]{2,4}\$/i", $credential))) {
$rtn_value=true; } return $rtn_value; }
if (!email_valid($email)) { $error .= "- Email address is missing or invalid.\r\n"; }

// ------------------------------------------------------------------
// ALL OTHER VALUES ARE SANITIZED BUT NOT CHECKED AGAINST RULES.
// You can do that below if you want.
// ------------------------------------------------------------------

?>