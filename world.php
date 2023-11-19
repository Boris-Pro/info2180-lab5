<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries ");

//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the 'country' parameter is set in the GET request
if (isset($_GET['country'])) {
  // Get the value of the 'country' parameter and sanitize it
  $country = filter_var($_GET['country'], FILTER_SANITIZE_STRING);

  // Establish a database connection
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

  // Use a prepared statement to avoid SQL injection
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
  $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  $stmt->execute();
  
  // Fetch the results as an associative array
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Output the results as an HTML table
if ($results) {
  echo "<table border='1'>";
  echo "<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";

  foreach ($results as $row) {
      echo "<tr>";
      echo "<td>{$row['name']}</td>";
      echo "<td>{$row['continent']}</td>";
      echo "<td>{$row['independence_year']}</td>";
      echo "<td>{$row['head_of_state']}</td>";
      echo "</tr>";
  }

  echo "</table>";
} else {
  echo "No matching countries found";
}
} else {
echo "Please provide a country parameter in the URL (e.g., world.php?country=Jamaica)";


}
?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
