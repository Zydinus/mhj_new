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
          // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
          $users[] = $row;
      }
    }

    return $users;
  }

  function getProductCategories($conn, $option='all') {
    $productCategories = [];

    if ($option==='all') {
      $sql = "SELECT * FROM product_categories";
    } else {
      $sql = "SELECT * FROM product_categories WHERE id = $option";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
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
          // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
          $products[] = $row;
      }
    }

    return $products;
  }

  function getProductsWithPrice($conn, $option='all') {
    $products = [];

    $sql = "SELECT
                p.*,
                (SELECT
                        price
                    FROM
                        product_sale_prices psp
                    WHERE
                        psp.product_id = p.id
                            AND psp.created_at IN (SELECT
                                MAX(psp2.created_at)
                            FROM
                                product_sale_prices psp2
                            WHERE
                                psp2.product_id = p.id)) sale_price,
                (SELECT
                        created_at
                    FROM
                        product_sale_prices psp
                    WHERE
                        psp.product_id = p.id
                            AND psp.created_at IN (SELECT
                                MAX(psp2.created_at)
                            FROM
                                product_sale_prices psp2
                            WHERE
                                psp2.product_id = p.id)) sale_price_updated_at,
                (SELECT
                        price
                    FROM
                        product_buy_prices pbp
                    WHERE
                        pbp.product_id = p.id
                            AND pbp.created_at IN (SELECT
                                MAX(pbp2.created_at)
                            FROM
                                product_buy_prices pbp2
                            WHERE
                                pbp2.product_id = p.id)) buy_price,
                (SELECT
                        created_at
                    FROM
                        product_buy_prices pbp
                    WHERE
                        pbp.product_id = p.id
                            AND pbp.created_at IN (SELECT
                                MAX(pbp2.created_at)
                            FROM
                                product_buy_prices pbp2
                            WHERE
                                pbp2.product_id = p.id)) buy_price_updated_at
            FROM
                products p
            ";

    if ($option==='all') {
      $sql .= "";
    } else {
      $sql .= " WHERE p.category_id = $option";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
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
          // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
          $price = $row;
      }
    }
    return $price;
  }
?>
