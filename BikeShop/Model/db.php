<?php
class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "sell_bike";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($connection->connect_error) 
                {
                    die("Please connect the database");
                }

                return $connection;
        
    }

    function addBike($connection, $tablename, $bike_name, $brand, $model, $price, $quantity, $description, $bike_image)
        {
            $sql = "INSERT INTO ".$tablename."
        (bike_name, brand, model, price, quantity, description, bike_image)
        VALUES
        ('".$bike_name."', '".$brand."', '".$model."', '".$price."', '".$quantity."', '".$description."', '".$bike_image."')";

        $result = $connection->query($sql);

        return $result;
        }

        function signin($connection, $tablename, $username, $password)
        {
            $sql="SELECT * FROM ".$tablename."
        WHERE username = '".$username."'
        AND password ='".$password."'";

        $result=$connection->query($sql);

        return $result;
        }

    // ============================================================
    // CUSTOMER MODULE METHODS (added for the Customer part)
    // Everything below is new. Nothing above this line was changed.
    // These use prepared statements (bind_param) instead of raw
    // string concatenation, since they handle customer-submitted
    // login/registration input.
    // ============================================================

    function registerCustomer($connection, $name, $email, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    function getCustomerByEmail($connection, $email)
    {
        $stmt = $connection->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();

        return $customer;
    }

    function getAllBikes($connection)
    {
        $sql = "SELECT * FROM bikes ORDER BY id DESC";
        return $connection->query($sql);
    }

    function searchBikes($connection, $keyword)
    {
        $like = "%".$keyword."%";

        $stmt = $connection->prepare("SELECT * FROM bikes WHERE bike_name LIKE ? OR brand LIKE ? OR model LIKE ? ORDER BY id DESC");
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    function getBikeById($connection, $bike_id)
    {
        $stmt = $connection->prepare("SELECT * FROM bikes WHERE id = ?");
        $stmt->bind_param("i", $bike_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bike = $result->fetch_assoc();
        $stmt->close();

        return $bike;
    }

    function addToCart($connection, $customer_id, $bike_id, $quantity)
    {
        $bike = $this->getBikeById($connection, $bike_id);

        if (!$bike)
        {
            return false;
        }

        // one row per (customer, bike): if it already exists, increase quantity instead
        $stmt = $connection->prepare("SELECT id, quantity FROM cart_items WHERE customer_id = ? AND bike_id = ?");
        $stmt->bind_param("ii", $customer_id, $bike_id);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $already_in_cart = $existing ? $existing["quantity"] : 0;
        $new_quantity = $already_in_cart + $quantity;

        // total quantity (already in cart + newly requested) must not exceed current stock
        if ($new_quantity > $bike["quantity"])
        {
            return false;
        }

        if ($existing)
        {
            $stmt = $connection->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_quantity, $existing["id"]);
            $result = $stmt->execute();
            $stmt->close();

            return $result;
        }
        else
        {
            $stmt = $connection->prepare("INSERT INTO cart_items (customer_id, bike_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $customer_id, $bike_id, $quantity);
            $result = $stmt->execute();
            $stmt->close();

            return $result;
        }
    }

    function getCartItems($connection, $customer_id)
    {
        $stmt = $connection->prepare(
            "SELECT cart_items.id AS cart_item_id, cart_items.quantity, bikes.id AS bike_id,
                    bikes.bike_name, bikes.price, bikes.bike_image, bikes.quantity AS stock
             FROM cart_items
             JOIN bikes ON cart_items.bike_id = bikes.id
             WHERE cart_items.customer_id = ?
             ORDER BY cart_items.added_at DESC"
        );
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc())
        {
            $items[] = $row;
        }
        $stmt->close();

        return $items;
    }

    function updateCartItemQuantity($connection, $cart_item_id, $customer_id, $quantity)
    {
        // look up the bike's current stock for this cart item, scoped to this customer
        $stmt = $connection->prepare(
            "SELECT bikes.quantity AS stock
             FROM cart_items
             JOIN bikes ON cart_items.bike_id = bikes.id
             WHERE cart_items.id = ? AND cart_items.customer_id = ?"
        );
        $stmt->bind_param("ii", $cart_item_id, $customer_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$row)
        {
            return false;
        }

        // do not allow a quantity greater than the current bike stock
        if ($quantity > $row["stock"])
        {
            return false;
        }

        $stmt = $connection->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("iii", $quantity, $cart_item_id, $customer_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    function removeCartItem($connection, $cart_item_id, $customer_id)
    {
        $stmt = $connection->prepare("DELETE FROM cart_items WHERE id = ? AND customer_id = ?");
        $stmt->bind_param("ii", $cart_item_id, $customer_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    function placeOrder($connection, $customer_id)
    {
        $cartItems = $this->getCartItems($connection, $customer_id);

        if (empty($cartItems))
        {
            return false;
        }

        // check stock is still available for every item before committing
        foreach ($cartItems as $item)
        {
            if ($item["quantity"] > $item["stock"])
            {
                return false;
            }
        }

        $connection->begin_transaction();

        try
        {
            $total = 0;
            foreach ($cartItems as $item)
            {
                $total += $item["price"] * $item["quantity"];
            }

            $stmt = $connection->prepare("INSERT INTO orders (customer_id, total, status) VALUES (?, ?, 'Placed')");
            $stmt->bind_param("id", $customer_id, $total);
            $stmt->execute();
            $order_id = $connection->insert_id;
            $stmt->close();

            foreach ($cartItems as $item)
            {
                $subtotal = $item["price"] * $item["quantity"];

                $stmt = $connection->prepare(
                    "INSERT INTO order_items (order_id, bike_id, bike_name, price, quantity, subtotal)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param(
                    "iisdid",
                    $order_id,
                    $item["bike_id"],
                    $item["bike_name"],
                    $item["price"],
                    $item["quantity"],
                    $subtotal
                );
                $stmt->execute();
                $stmt->close();

                // reduce bike stock
                $stmt = $connection->prepare("UPDATE bikes SET quantity = quantity - ? WHERE id = ?");
                $stmt->bind_param("ii", $item["quantity"], $item["bike_id"]);
                $stmt->execute();
                $stmt->close();

                // remove purchased item from cart
                $stmt = $connection->prepare("DELETE FROM cart_items WHERE id = ?");
                $stmt->bind_param("i", $item["cart_item_id"]);
                $stmt->execute();
                $stmt->close();
            }

            $connection->commit();
            return $order_id;
        }
        catch (Exception $e)
        {
            $connection->rollback();
            return false;
        }
    }

    function getOrdersByCustomer($connection, $customer_id)
    {
        $stmt = $connection->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY order_date DESC");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc())
        {
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    function getOrderItems($connection, $order_id, $customer_id)
    {
        // join through orders to make sure this order actually belongs to this customer
        $stmt = $connection->prepare(
            "SELECT order_items.* FROM order_items
             JOIN orders ON order_items.order_id = orders.id
             WHERE order_items.order_id = ? AND orders.customer_id = ?"
        );
        $stmt->bind_param("ii", $order_id, $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc())
        {
            $items[] = $row;
        }
        $stmt->close();

        return $items;
    }
}

?>
