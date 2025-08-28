<?php
session_start();
include('header/header.php');
include('header/connection.php');
if(isset($_SESSION['loggedin'])==true){
    include('header/navadmin.php');
}
else {
    include('header/navuser.php');
}
?>

<!DOCTYPE html>
<head>
<title>Donor List | Welcome</title>

<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 90%;
    margin: 5px;
  text-align: center;
}
#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 18px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #FF5733;
  color: white;
}
.blood {
    margin-left: 500px;
    margin-top: 20px;
}
</style>
</head>
<body>
  <br>
  <div class="blood">
    <h1>DONATE BLOOD</h1>
    <br>
    <label>Search The Donors</label>
    <br><br>
    <form action="" method="post">
      <label>Blood Group: </label>
      <select name="bgroup">
        <option>Select</option>
        <option>A+</option>
        <option>A-</option>
        <option>B+</option>
        <option>B-</option>
        <option>AB+</option>
        <option>AB-</option>
        <option>O+</option>
        <option>O-</option>
      </select>
      <br><br>
      <input type="submit" name="sub" value="Search Donors" style="padding:10px 20px; font-size:16px; background:#27ae60; color:white; border:none; cursor:pointer;" />
    </form>
  </div>
  <br><br>

<?php
if(isset($_POST['sub']))
{
    $bgroup=@$_POST['bgroup'];
?>
    <h1 align="center">Donor List</h1>
    <br>
    <table id="customers" style="margin: 0px auto;">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Blood Group</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Weight</th>
        <th>Last Donated</th>
        <th>Phone Number</th>
        <th>Address</th>
      </tr>
    <?php
    $q=$db->query("SELECT * FROM donor WHERE bgroup='$bgroup'");
    $count=0;
    while ($p=$q->fetch(PDO::FETCH_OBJ)) {
        $d=$p->date;
        $current=date("Y/m/d");
        $month=((strtotime($current) - strtotime($d))/60/60/24)/30;

        if($month>=3.0) {
    ?>
        <tr>
            <td><?= $p->id; ?></td>
            <td><?= $p->name; ?></td>
            <td><?= $p->bgroup; ?></td>
            <td><?= $p->gender; ?></td>
            <td><?= $p->age; ?></td>
            <td><?= $p->weight; ?></td>
            <td><?= $p->date; ?></td>
            <td><?= $p->number; ?></td>
            <td><?= $p->address; ?></td>
        </tr>
    <?php
        }
    }
    ?>
    </table>
<?php
}
?>
</body>
</html>