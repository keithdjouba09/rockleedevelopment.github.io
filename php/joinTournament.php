<?php
session_start();
//user id
//tournament id
if(!isset($message)) {
  require_once("DBController.php");
  $db_handle = new DBController();
  $email = $_SESSION["email"];
  $query = "SELECT UserID FROM User WHERE email='$email'";
$current_id = $db_handle->getUserID($query);

  //if it is a team game
if(!empty($_POST["TeamName"]))
{
 $TMname =  $_POST["TMname"];
 $TeamName= $_POST["TeamName"];

    //check limit size
    $result1 = "SELECT COUNT(*) FROM TeamMembers WHERE TeamID = '$TeamName'";
    $row_count = $db_handle->getCount($result1);

    $result2 = "SELECT TeamLimit FROM Team WHERE TournamentID ='$TMname' AND TeamID = '$TeamName'";
    $team_limit=$db_handle->getTeamLimit($result2);

    if($row_count<$team_limit) //number of UserID rows in Teammbers table
    {
      $query2 ="INSERT INTO TeamMembers (TeamID,UserID) VALUES
      ('" . $_POST["TeamName"] . "', '$current_id')";
      $insideTable = $db_handle->insertQuery($query2);

       if(!empty($insideTable)){
      $query1 = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
      ('" . $_POST["TMname"] . "', '$current_id')";
      $insideTable2 = $db_handle->insertQuery($query1);
      echo "<script> alert('You successfuly join the team');
     window.location.href='../index.html'; </script>";
        }else{
            echo "<script> alert('something wrong');
           window.location.href='../index.html'; </script>";
         }

}else{
  $query = "SELECT UserID FROM User WHERE email='$email'";
$current_id = $db_handle->getUserID($query);
$query = "INSERT INTO UserTournaments (TournamentID, UserID) VALUES
('" . $_POST["TMname"] . "', '$current_id')";
$insideTable = $db_handle->insertQuery($query);
echo "<script> alert('you successfulyuuuuuuuu join this tournament');
         window.location.href='../index.html'; </script>";
}

}else{
  echo "<script> alert('something wrong');
           window.location.href='../index.html'; </script>";
}
}else{
  echo "<script> alert('something wrong');
           window.location.href='../index.html'; </script>";
}
?>
