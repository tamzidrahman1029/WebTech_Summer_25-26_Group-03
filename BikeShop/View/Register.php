<?php
include "../Controller/CustomerRegisterController.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <h1>Create an account</h1>
            <p class="subtitle">Register to browse bikes, place orders and track your order history.</p>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form class="form-box" method="post" action="Register.php">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <button type="submit" class="btn">Register</button>

                <p class="form-footer-text">Already have an account? <a href="Login.php">Login here</a></p>

            </form>

        </div>
    </main>

</body>
</html>
