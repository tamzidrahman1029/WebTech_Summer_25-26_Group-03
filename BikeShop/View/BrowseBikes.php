<?php
session_start();
include "../Model/db.php";

$database = new db();
$connection = $database->connection();

$keyword = trim($_GET["keyword"] ?? "");

if (!empty($keyword))
{
    $result = $database->searchBikes($connection, $keyword);
}
else
{
    $result = $database->getAllBikes($connection);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Browse Bikes - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <h1>Browse Bikes</h1>
            <p class="subtitle">Find your next bike from what's currently available.</p>

            <form class="search-bar" method="get" action="BrowseBikes.php">
                <input type="text" name="keyword" placeholder="Search by name, brand or model..." value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit" class="btn">Search</button>
                <?php if (!empty($keyword)): ?>
                    <a class="btn btn-secondary" href="BrowseBikes.php">Clear</a>
                <?php endif; ?>
            </form>

            <?php if ($result && $result->num_rows > 0): ?>

                <div class="bike-grid">
                    <?php while ($bike = $result->fetch_assoc()): ?>
                        <div class="bike-card">
                            <a href="BikeDetails.php?id=<?php echo $bike['id']; ?>">
                                <img src="<?php echo htmlspecialchars($bike['bike_image']); ?>" alt="<?php echo htmlspecialchars($bike['bike_name']); ?>">
                            </a>
                            <h3><a href="BikeDetails.php?id=<?php echo $bike['id']; ?>"><?php echo htmlspecialchars($bike['bike_name']); ?></a></h3>
                            <div class="bike-meta"><?php echo htmlspecialchars($bike['brand']); ?> &middot; <?php echo htmlspecialchars($bike['model']); ?></div>
                            <div class="bike-price"><?php echo number_format($bike['price'], 2); ?></div>

                            <?php if ($bike['quantity'] <= 0): ?>
                                <div class="stock-out">Out of stock</div>
                            <?php elseif ($bike['quantity'] <= 2): ?>
                                <div class="stock-low">Only <?php echo $bike['quantity']; ?> left</div>
                            <?php endif; ?>

                            <a href="BikeDetails.php?id=<?php echo $bike['id']; ?>" class="btn btn-small" style="margin-top:8px;">View Details</a>
                        </div>
                    <?php endwhile; ?>
                </div>

            <?php else: ?>
                <div class="empty-state">No bikes found.</div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>
