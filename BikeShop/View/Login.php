<?php
include "../Controller/CustomerLoginController.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <h1>Login</h1>
            <p class="subtitle">Log in to browse bikes, manage your cart and view your orders.</p>

            <?php if (!empty($message)): ?>
                <div class="message error"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form class="form-box" method="post" action="Login.php">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <button type="submit" class="btn">Login</button>

                <p class="form-footer-text">Don't have an account? <a href="Register.php">Register here</a></p>

            </form>

        </div>
    </main>

</body>
</html>
