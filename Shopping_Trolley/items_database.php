 <?php
	$conn = mysqli_connect("localhost", "root", "root",);

	$sql = "CREATE DATABASE items_database";
	if (mysqli_query($conn, $sql)) echo "<p> DATABASE SUCCESSFULLY CREATED </p>";
	else echo ("<p>" . mysqli_error($conn) . "</p>");

	$sql = "USE items_database";
	mysqli_query($conn, $sql);

	$sql = "CREATE TABLE shop(
				id INT AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(250) NOT NULL,
				cost DEC(5,2) NOT NULL,
				image text NOT NULL

			)";

	if (mysqli_query($conn, $sql)) echo "<p> TABLE ITEMS SUCCESSFULLY CREATED </p>";
	else die(mysqli_error($conn));

	$conn = mysqli_connect("localhost", "root", "root", "items_database");

	$sql = "INSERT INTO shop(name, cost, image)
			VALUES('5kg Plate', '9.99', 'images/5kg_plate.jpg' ),
				('10kg Plate', '20.99', 'images/10kg_plate.jfif' ),
				('20kg Plate', '30.99', 'images/20kg_plate.jpg' ),
				('25kg Plate', '40.99', 'images/25kg_plate.jfif' ),
				('Barbell', '15.00', 'images/barbell.jpg' ),
				('bench', '15.00', 'images/bench.jpg' )
			";

	if (mysqli_query($conn, $sql)) echo "<p> DATA SUCCESSFULLY INSERTED </p>";
	else die(mysqli_error($conn));

?>