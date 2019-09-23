<?PHP

session_start();
if (!isset($_SESSION['valid_admin'])) { header("Location: setup.php"); exit(); }
require("templates/header.php");

//$balance = 1;

if (isset($_POST['archive'])) {

//$result = mysql_query("select sum(payment) as total, id from idevaff_sales where approved = '1' and bonus != '1' group by id having sum(payment) >= $balance");
$result = mysql_query("select sum(payment) as total, id from idevaff_sales where approved = '1' group by id having sum(payment) >= $balance");
while($row = mysql_fetch_assoc($result)) { 
    $result_pp = mysql_query("select id, pp from idevaff_affiliates where id = " . $row['id'] . " and pp=1 and not(paypal = '')");
    if(mysql_num_rows($result_pp) > 0) {
        $result_pp = mysql_fetch_array($result_pp);

        $id = $result_pp['id'];

        $datadetails = mysql_query("select SUM(payment) AS total from idevaff_sales where id = '$id' and approved = '1'");
        $dqry = mysql_fetch_array($datadetails);
        $amount = $dqry['total'];

        if (!isset($stampnow)) { $stampnow = $paystamp; }
        mysql_query("insert into idevaff_payments (id, date, amount, stamp) values ('$id', '$cdate', '$amount', '$stampnow')");

        $lastrec=mysql_query("select max(record) as latest from idevaff_payments");
        $lastres=mysql_fetch_array($lastrec);
        $lastres=$lastres['latest'];
        mysql_query("update idevaff_payments set stamp = stamp+1 where record = '$lastres'");

        $q1 = mysql_query("SELECT * FROM idevaff_sales WHERE id = '$id' and approved = '1'");
        $number = mysql_num_rows($q1);
        $count = 0;
        while ($count < $number) {
            $data=mysql_fetch_array($q1);
            $id=$data['id'];
            $date=$data['date'];
            $time=$data['time'];
            $payment=$data['payment'];
            $tier=$data['tier'];
            $top_tier_tag=$data['top_tier_tag'];
            $bonus=$data['bonus'];
            $recurring=$data['recurring'];
            $ti=$data['tier_id'];
            $tracking=$data['tracking'];
            $op1=$data['op1'];
            $op2=$data['op2'];
            $op3=$data['op3'];
            $amount=$data['amount'];
            $type=$data['type'];
            $split=$data['split'];
            $profile=$data['profile'];
            $tid1=$data['tid1'];
            $tid2=$data['tid2'];
            $tid3=$data['tid3'];
            $tid4=$data['tid4'];
            $target_url=$data['target_url'];
            $sub_id=$data['sub_id'];
            $payment_rec = $lastres;
            $referring_url = $data['referring_url'];

mysql_query("INSERT INTO idevaff_archive (id, date, time, payment, tier, top_tier_tag, bonus, stamp, recurring, tier_id, tracking, op1, op2, op3, amount, type, split, profile, tid1, tid2, tid3, tid4, target_url, sub_id, payment_rec, referring_url) VALUES ('$id', '$date', '$time', '$payment', '$tier', '$top_tier_tag', '$bonus', '$paystamp', '$recurring', '$ti', '$tracking', '$op1', '$op2', '$op3', '$amount', '$type', '$split', '$profile', '$tid1', '$tid2', '$tid3', '$tid4', '$target_url', '$sub_id', '$payment_rec', '$referring_url')");


            $count = $count + 1; 
}
mysql_query("delete from idevaff_sales where id = '$id' and approved = '1'");
            $stampnow = $stampnow+1;
if ($notify == 1) { include ($path . "/templates/email/affiliate.payment.php");





        }
    }
}

}


?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="orangeHeading">
<tr><td width="100%"><b>PayPal Mass Payment</b></td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%"><img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; These are affiliates who have a balance of more than <font color="#CC0000"><b>$<?PHP echo $balance; ?></b></font>.
<br /><img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; Only affiliates with a PayPal account will be paid using this feature.<br /><img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; After making this Mass Payment, you'll want to <a href="pay_list.php">check for other affiliates</a> that might need paid also.
</td></tr>
</table>




<?PHP

$accounts_under_balance = false;
$accounts_due = false;
$accounts_wo_paypal = false;

// Check for accounts under balance
$result =  mysql_query("select sum(payment) as total, id from idevaff_sales where approved = '1' and bonus != '1' group by id having sum(payment) < $balance");
if(mysql_num_rows($result)) {
    $accounts_under_balance = true;
}

$datadetails = mysql_query("select sum(payment) as total, id from idevaff_sales where approved = '1' and bonus != '1' group by id having sum(payment) >= $balance");
if (mysql_num_rows($datadetails)) {
    $header_printed = false;

    while ($dqry = mysql_fetch_array($datadetails)) {
        // Retrieve total payments including bonuses
        $payment_result =  mysql_query("select sum(payment) as total from idevaff_sales where approved = '1' and id = " . $dqry['id']);
        $payment_row = mysql_fetch_assoc($payment_result);
        $amt = $payment_row['total'];

        //$amt = $dqry['total'];
        $uid=$dqry['id'];

        $checkppstatus = mysql_query("select id from idevaff_affiliates where pp = 1 and paypal != '' and id = $uid");
        if (mysql_num_rows($checkppstatus)) {
            // Found account to display, output header if it hasn't already happened
            if(!$header_printed) {
                echo('<table border="0" cellpadding="0" cellspacing="0" width="100%" class="yellowHeading">
                    <tr>
                    <td width="10%"><b>ID</b></td>
                    <td width="30%"><b>Username</b></td>
                    <td width="30%" align="right"><b>Current Balance Owed</b></td>
                    <td width="30%" align="right"><b>PayPal Conversion Balance</b></td>
                    </tr>
                    </table>');
                $header_printed = true;
            }

            $accounts_due = true;

            $getaff = mysql_query("select username from idevaff_affiliates where id = $uid");
            $getaff = mysql_fetch_array($getaff);
            $uname = $getaff['username'];
            $sales = mysql_query("select id from idevaff_sales where id = $uid and bonus != 1 and tier = 0");
            $sales = number_format(mysql_num_rows($sales));
            $tier_sales = mysql_query("select id from idevaff_sales where id = $uid and bonus != 1 and tier > 0");
            $tier_sales = number_format(mysql_num_rows($tier_sales));
            $total_sales = $sales + $tier_sales;
            $amtd = (number_format($amt,2));

            if (($paypal_cur == "USD") || ($paypal_cur == "AUD") || ($paypal_cur == "HKD") || ($paypal_cur == "SGD") || ($paypal_cur == "NZD") || ($paypal_cur == "CAD")) { $newsym = "$"; }
            if ($paypal_cur == "EUR") { $newsym = "€"; }
            if ($paypal_cur == "GBP") { $newsym = "£"; }
            if ($paypal_cur == "CZK") { $newsym = ""; }
            if ($paypal_cur == "DKK") { $newsym = ""; }
            if ($paypal_cur == "HUF") { $newsym = ""; }
            if ($paypal_cur == "NOK") { $newsym = ""; }
            if ($paypal_cur == "PLN") { $newsym = ""; }
            if ($paypal_cur == "SEK") { $newsym = ""; }
            if ($paypal_cur == "CHF") { $newsym = ""; }
            if ($paypal_cur == "JPY") { $newsym = "¥"; }
            $paypal_amount_to_pay = $amt * $paypal_rate;
            if (($paypal_cur == "JPY") || ($paypal_cur == "HUF")) { $paypal_amount_to_pay = round($paypal_amount_to_pay);
            } else {
                $paypal_amount_to_pay = number_format($paypal_amount_to_pay,2); }

            if (($use_rate == 1) && (!isset($bad))) { $amountnow = "$paypal_amount_to_pay"; } else { $amountnow = "$amtd"; }

            print "<table border=0 cellpadding=2 cellspacing=0 width=100% class=main><tr>";
            print "<td width=10%>$uid</td>";
            print "<td width=30%><a href=account_details.php?id=$uid>$uname</a></td>";
            print "<td width=30% align=right>"; if($cur_sym_location == 1) { echo $cur_sym; } echo $amtd; if($cur_sym_location == 2) { echo " " . $cur_sym . " "; }echo " $currency"; echo "</td>";
            print "<td width=30% align=right>$newsym$amountnow $paypal_cur</td>";
            print "</tr></table>";
        } else {
            $accounts_wo_paypal = true;
        }
    }
}

if (($use_rate == 1) && (!isset($bad))) {
?>
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="main">
<tr><td width="100%">
<font color="#CC0000">Payments will be converted from <?PHP echo $currency; ?> to <?PHP echo $paypal_cur; ?>.</font>&nbsp; <a href="setup.php?action=35">Rate: <?PHP echo $paypal_rate; ?></a>
</td></tr>
</table>
<?PHP
}
?>

<?PHP
if (!isset($_POST['mp_action'])) {

if (($accounts_under_balance) || ($accounts_wo_paypal)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="blueHeading">
<tr><td width="100%"><b>Payment Notification</b></td></tr>
</td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<?PHP
    if($accounts_under_balance) {
        echo('<tr><td width="100%">Some affiliates don\'t meet your balance requirement for payout.<BR />Balances will carry over from month-to-month until met.</td></tr>');
    }

    if($accounts_wo_paypal) {
        echo('<tr><td width="100%">You have affiliates due for payment that do not have a PayPal account added to their affiliate account.<br />These affiliates will need paid using the <a href=\'pay_list.php\'>Pay Affiliates</a> link instead.</td></tr>');
    }
?>
</table>

<?PHP } ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="purpleHeading">
<?PHP
    if(!$accounts_due) {
        echo('<tr><td width="100%"><b>No Accounts Available For A PayPal Mass Payment</b></td></tr>');
    } else {
        echo('<tr><td width="100%"><b>Continue To Step 1 of 2</b></td></tr>');

   }
?>
</table>

<table border="0" cellpadding="2" cellspacing="0" width="100%" class="main_padded"><tr>
<td width="100%">
<?php 
if($accounts_due) {
    echo('<form method="post" action="paypal_mass_pay.php">
        <input type="hidden" name="mp_action" value="2">
        <input type="submit" value="Continue" />');
}
?>
</td>
</tr>
</table>
<?PHP  } elseif ($_POST['mp_action'] == 2) { ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="greenHeading">
<tr>
<td width="100%"><b>Download Payment File</b></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">

<form method="POST" action="export.php">
<input type="hidden" name="export" value="1">
<input type="hidden" name="masspay" value="1">
<input type="submit" value="Download Payment File">
</td></form>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">Save the file to your local computer system.  You'll need it for the next steps below.

</td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="blueHeading">
<tr>
<td width="100%"><b>Payment Instructions</b></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">
<img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; Login to your <a href="http://www.paypal.com" target=_blank>PayPal</a> account.<br />
<img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; Click Mass Pay in the footer.<br />
<img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; Click Make a Mass Payment.<br />
<img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; The recipient type is <b>email address</b>.<br />
<img border="0" src="../images/bullet_arrow.gif" width="9" height="9">&nbsp; Use the above payment file and continue the payment process.<br /><br />
<font color="#CC0000">After you have made the payments, continue to step 2.</font>
</td></tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" width="100%" class="purpleHeading">
<tr><td width="100%"><b>Continue To Step 2 of 2</b></td></tr>
</table>
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="main_padded"><tr>
<td width="100%">
<form method="post" action="paypal_mass_pay.php">
<input type="hidden" name="mp_action" value="3">
<input type="submit" value="Continue" />
</td>
</tr>
</table>

<?PHP } elseif ($_POST['mp_action'] == 3) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="blueHeading">
<tr><td width="100%"><b>Archive Payments</b></td></tr>
</td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="main_padded">
<tr><td width="100%">After your PayPal mass payment has been made, click the button below to complete the payment process.</td></tr>
<tr><td width="100%">
<form action="paypal_mass_pay.php" method="post">
<input type="submit" name="submit" value="Archive Payments">
<input type="hidden" name="archive" value="1">
</td></form></tr>
</table>
<?PHP  }

include("templates/footer.php");
?>
