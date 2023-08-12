<?php
$connection = mysqli_connect("localhost", "root", "", "ev");

$query = "SELECT S_ID, R_ID,
                 COUNT(*) as 'Total Reservations',
                 AVG(TIMESTAMPDIFF(MINUTE, START_TIME, END_TIME)) as 'Average Time Spent'
          FROM reservations
          WHERE DATE = '2023-01-13'
          GROUP BY R_ID";
$result = mysqli_query($connection, $query);
echo '<table border="1">';
echo '<tr>';
echo '<th>S_ID</th>';
echo '<th>Total Reservations</th>';
echo '<th>Average Time Spent</th>';
echo '</tr>';

while($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>'.$row['S_ID'].'</td>';
    echo '<td>'.$row['Total Reservations'].'</td>';
    echo '<td>'.$row['Average Time Spent'].'</td>';
    echo '</tr>';
}

echo '</table>';
mysqli_close($connection);


?>