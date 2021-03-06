<?php
require_once ('system/csrfmagic/csrf-magic.php');
require_once("models/config.php");
if(!isUserLoggedIn())
{
echo '<meta http-equiv="refresh" content="0; URL=index.php?page=login">';
die();
}
$user = addslashes(strip_tags($loggedInUser->user_id));
$act_name = addslashes(strip_tags($loggedInUser->display_username));
?>
<div style="margin: 0 auto;">
<h1>All History for <?php echo $act_name; ?></h1>
<div class="top">
<center>Your Trade History</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
	<th style="width: 15%;">Coin</th>
    <th style="width: 10%;">Type</th>
	<th style="width: 25%;">Price</th>
	<th style="width: 25%;">Quantity</th>	
	<th style="width: 25%;">Total (BTC)</th>	
</tr>
<?php
$sqlz = mysql_query("SELECT * FROM Trade_History WHERE (`Buyer`='$user' OR `Seller`='$user')");
while ($row = mysql_fetch_assoc($sqlz)) {
	if($row["Buyer"] == $user)
	{
		$info = "Bought";
	}
	else
	{
		$info = "Sold";
	}
	$mid = mysql_real_escape_string($row["Market_Id"]);
	$getcn = mysql_query("SELECT * FROM Wallets WHERE `Id`='$mid'");
	$cname = mysql_result($getcn, 0, "Acronymn");
?>
<tr>
	<td style="width: 15%;"><?php echo $cname; ?></td>
	<td style="width: 10%;"><?php echo $info; ?></td>
	<td style="width: 25%;"><?php echo sprintf('%.9f',$row["Price"]);?></td>
    <td style="width: 25%;"><?php echo $row["Quantity"];?></td>
	<td style="width: 25%;"><?php echo sprintf('%.9f',$row["Quantity"] * $row["Price"]);?></td>
</tr>
	<?php
}
?>
</thead>
</table>
</div>
<div class="top">
<center>Your Deposit History</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
	<th style="width: 25%;">Coin</th>
	<th style="width: 25%;">Quantity</th>	
	<th style="width: 25%;">Tx ID</th>	
</tr>
<?php
$sqlz = mysql_query("SELECT * FROM deposits WHERE `Account`='$act_name'");
while ($row = mysql_fetch_assoc($sqlz)) {
?>
<tr>
	<td style="width: 25%;"><?php echo $row["Coin"];?></td>
    <td style="width: 25%;"><?php echo sprintf('%.9f',$row["Amount"]);?></td>
	<td style="width: 25%;"><?php echo $row["Transaction_Id"];?></td>
</tr>
<?php
}
?>
</thead>
</table>
</div>

<div class="top">
<center>Your Pending Withdrawals</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
	<th style="width: 25%;">Coin</th>
	<th style="width: 25%;">Quantity</th>	
	<th style="width: 25%;">Address</th>	
</tr>
<?php
$sqlza = mysql_query("SELECT * FROM Withdraw_Requests WHERE `User_Id`='$user'");
while ($row = mysql_fetch_assoc($sqlza)) {

?>
<tr>
	<td style="width: 25%;"><?php echo $row["CoinAcronymn"];?></td>
    <td style="width: 25%;"><?php echo sprintf('%.9f',$row["Amount"]);?></td>
	<td style="width: 25%;"><?php echo $row["Address"];?></td>
</tr>
<?php
}
?>
</thead>
</table>
</div>

<div class="top">
<center>Your Withdraw History</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
	<th style="width: 25%;">Coin</th>
	<th style="width: 25%;">Quantity</th>	
	<th style="width: 25%;">Address</th>	
</tr>
<?php
$sqlz = mysql_query("SELECT * FROM Withdraw_History WHERE `User`='$user'");
while ($row = mysql_fetch_assoc($sqlz)) {
?>
<tr>
	<td style="width: 25%;"><?php echo $row["Coin"];?></td>
    <td style="width: 25%;"><?php echo sprintf('%.9f',$row["Amount"]);?></td>
	<td style="width: 25%;"><?php echo $row["Address"];?></td>
</tr>
<?php
}
?>
</thead>
</table>
</div>


</div>