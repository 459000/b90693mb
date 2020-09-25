<?php
$query = "SELECT * FROM goods WHERE hit=1";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($dan = []; $row = mysqli_fetch_assoc($result); $dan[] = $row);
$_SESSION['hit'] = $dan;