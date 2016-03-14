<?php
  function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function getUsers($conn, $option='all') {
    $users = [];

    switch ($option) {
      case 'all':
        $sql = "SELECT * FROM users";
        break;
      case 'admin':
        $sql = "SELECT * FROM users WHERE level=0";
        break;
      case 'normal':
        $sql = "SELECT * FROM users WHERE level<>0";
        break;
      default:
        return $users;
        break;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $users[] = $row;
      }
    }

    return $users;
  }

  function getProductCategories($conn, $option='all') {
    $productCategories = [];

    if ($option==='all') {
      $sql = "SELECT
                  pc.*, COUNT(p.id) product_count
              FROM
                  product_categories pc
                      INNER JOIN
                  products p ON pc.id = p.category_id
              GROUP BY pc.id";
    } else {
      $sql = "SELECT
                  pc.*, COUNT(p.id) product_count
              FROM
                  product_categories pc
                      INNER JOIN
                  products p ON pc.id = p.category_id
              GROUP BY pc.id
              WHERE id = $option";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $productCategories[] = $row;
      }
    }

    return $productCategories;
  }

  function getProducts($conn, $option='all') {
    $products = [];

    if ($option==='all') {
      $sql = "SELECT * FROM products";
    } else {
      $sql = "SELECT * FROM products WHERE category_id = $option";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }

    return $products;
  }

  function getProductsWithPrice($conn, $option='all') {
    $products = [];

    $sql = file_get_contents("sql/product_with_lastest_price.sql");

    if ($option==='all') {
      $sql .= "";
    } else {
      $sql .= " WHERE p.category_id = $option";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }

    return $products;
  }

  function getPriceById($conn, $id, $type) {

    if ($type==="sale") {
      $sql = "SELECT * FROM product_sale_prices WHERE id=$id";
    } elseif ($type==="buy") {
      $sql = "SELECT * FROM product_buy_prices WHERE id=$id";
    }

    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $price = $row;
      }
    }
    return $price;
  }

  function getPricesByProductIdLevel($conn, $id, $type, $level) {
    $prices = [];

    if ($type==="sale") {
      $sql = "SELECT * FROM product_sale_prices WHERE product_id=$id AND price_level=$level";
    } elseif ($type==="buy") {
      $sql = "SELECT * FROM product_buy_prices WHERE product_id=$id AND price_level=$level";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $prices[] = $row;
      }
    }
    return $prices;
  }

  function getProductById($conn, $id) {

    $sql = "SELECT p.*, pc.name category_name
            FROM products p INNER JOIN product_categories pc on p.category_id=pc.id
            WHERE p.id=$id";

    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $product = $row;
      }
    }
    return $product;
  }

  function getAllCustomers($conn) {
    $customers = [];

    $sql = "SELECT * FROM customers";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $customers[] = $row;
      }
    }
    return $customers;
  }

  function getAllCustomersRenamed($conn) {
    $customers = [];

    $sql = "SELECT 
      `id`, `short_name` as name, `title`, `name` as customer_name,
      `first_contact_date`, `contact_name`, `tax_vat`, `address_text`,
      `region`, `province`, `district`, `zip`,
      `distance`, `tel`, `fax`, `mobile_tel`,
      `email`, `customer_type`, `payment`, `credit`,
      `created_at`, `updated_at` FROM `customers`";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $customers[] = $row;
      }
    }
    return $customers;
  }
?>
