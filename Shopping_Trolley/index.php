<?php
	session_start();
	$database_name = "items_database";
	$conn = mysqli_connect("localhost", "root", "root", "items_database");

	if(isset($_POST["add"])){
		if(isset($_SESSION["cart"])){
			$item_array_id = array_column($_SESSION["cart"], "product_id");
			if(!in_array($_GET["id"], $item_array_id)){
				$count = count($_SESSION["cart"]);
				$item_array = array(
					'product_id' => $_GET["id"],
					'item_name' => $_POST["hidden_name"],
					'product_cost' => $_POST["hidden_cost"],
					'item_quantity' => $_POST["quantity"],
				);
				$_SESSION["cart"][$count] = $item_array;
				echo '<script>window.location="index.php"</script>';
			}else{
				echo '<script>alert("Product is already added to cart")</script>';
				echo '<script>window.location="index.php"</script>';
			} 
		}else{
			$item_array = array(
				'product_id' => $_GET["id"],
				'item_name' => $_POST["hidden_name"],
				'product_cost' => $_POST["hidden_cost"],
				'item_quantity' => $_POST["quantity"],
			);
			$_SESSION["cart"][0] = $item_array;
		}
	}

	if(isset($_GET["action"])){
		if($_GET["action"] == "delete"){
			foreach ($_SESSION["cart"] as $keys => $value) {
				if($value["product_id"] == $_GET["id"]){
					unset($_SESSION["cart"][$keys]);
					echo '<script> alert("Product has been removed")</script>';
					echo '<script>window.location="index.php"</script>';

				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css" href="style.css">
<head>
	<style type="text/css">
		
</style>
	<title id="title">Shopping Trolley</title>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


</head>
<body>
	<h1>Gym Equipment</h1>
	
	<div class="content">
		<div class="all_items">
			<h2>Shopping Trolley</h2>
			<?php
				$query = "SELECT * FROM shop ORDER BY id ASC";
				$result = mysqli_query($conn,$query);
				if(mysqli_num_rows($result) > 0){

					while ($row = mysqli_fetch_array($result)){


			?>
						<div class="item">
							<form method="post" action="index.php?action=add&id=<?php echo $row["id"] ?>">
								<div>
									<img class="image" src="<?php echo $row['image']; ?>">
									<h5 class="name"> <?php echo $row['name']; ?> </h5>
									<h5 class="cost"> £<?php echo $row['cost']; ?></h5>
									<input type="text" name="quantity" class="control" value="1">
									<input type="hidden" name="hidden_name" value="<?php echo $row['name'];?>">
									<input type="hidden" name="hidden_cost" value="<?php echo $row['cost'];?>">
									<input type="submit" name="add" style="margin-top: 5px;" class="btn" value="Add to Cart">
								</div>
							</form>
						</div>
						<?php
					}
				}
			?>
		</div>
		
		<div class="cart">
		<h3 class="cart_title"> Shopping Cart Details</h3>
			<table>
			<tr>
				<th width="25%"> Product Name </th>
				<th width="25%"> Quantity </th>
				<th width="25%"> Total Cost </th>
				<th width="25%"> Remove Item</th>
			</tr>

			<?php
				if(!empty($_SESSION["cart"])){
					$total = 0;
					foreach ($_SESSION["cart"] as $key => $value) {
					?>
						<tr>
							<td><?php echo $value["item_name"]; ?></td>
							<td><?php echo $value["item_quantity"]; ?></td>
							<td> £ <?php echo number_format($value["item_quantity"] * $value["product_cost"], 2); ?></td>
							<td><a href="index.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
									 class="text-danger"> X </span></a></td>
						</tr>
						<?php
							$total = $total + ($value["item_quantity"] * $value["product_cost"]);
						}
						?>
						<tr>
							<td colspan="3" align="right">Total</td>
							<th align="right"> £ <?php echo number_format($total, 2); ?> </th>
							<td></td>
						</tr>
						<?php
					}
				
			?>
			</table>
		</div>
	</div>
		

</body>
</html>