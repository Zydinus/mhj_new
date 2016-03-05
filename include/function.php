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
                p.category_id,
                p.id,
                p.short_name,
                p.custom_id,
                p.name,
                p.unit,
                p.weight,
                psp.price sale_price,
                psp.created_at sale_price_updated_at,
                pbp.price buy_price,
                pbp.created_at buy_price_updated_at
            FROM
                products p
                    LEFT JOIN
                product_sale_prices psp ON p.id = psp.product_id
                    LEFT JOIN
                product_buy_prices pbp ON pbp.product_id
            WHERE
                psp.created_at IN (SELECT
                        MAX(psp.created_at)
                    FROM
                        product_sale_prices psp
                    GROUP BY psp.product_id)
                    AND pbp.created_at IN (SELECT
                        MAX(pbp.created_at)
                    FROM
                        product_buy_prices pbp
                    GROUP BY pbp.product_id)
            ";

    if ($option==='all') {
      $sql .= "";
    } else {
      $sql .= " AND category_id = $option";
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
?>
