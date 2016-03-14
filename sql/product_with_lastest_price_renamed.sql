SELECT
    `id`, `category_id`, `name` as product_name, `short_name` as name, 
    `custom_id`, `unit`, `weight`, `product_group`,
    `created_at`, `updated_at`,
    (SELECT
            price
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 1
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 1)) sale_price_1,
    (SELECT
            created_at
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 1
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 1)) sale_price_updated_at_1,
    (SELECT
            price
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 2
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 2)) sale_price_2,
    (SELECT
            created_at
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 2
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 2)) sale_price_updated_at_2,
    (SELECT
            price
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 3
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 3)) sale_price_3,
    (SELECT
            created_at
        FROM
            product_sale_prices psp
        WHERE
            psp.product_id = p.id
                AND psp.price_level = 3
                AND psp.created_at IN (SELECT
                    MAX(psp2.created_at)
                FROM
                    product_sale_prices psp2
                WHERE
                    psp2.product_id = p.id
                        AND psp2.price_level = 3)) sale_price_updated_at_3,
    (SELECT
            price
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 1
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 1)) buy_price_1,
    (SELECT
            created_at
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 1
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 1)) buy_price_updated_at_1,
                        (SELECT
            price
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 2
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 2)) buy_price_2,
    (SELECT
            created_at
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 2
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 2)) buy_price_updated_at_2,
                        (SELECT
            price
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 3
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 3)) buy_price_3,
    (SELECT
            created_at
        FROM
            product_buy_prices pbp
        WHERE
            pbp.product_id = p.id
                AND pbp.price_level = 3
                AND pbp.created_at IN (SELECT
                    MAX(pbp2.created_at)
                FROM
                    product_buy_prices pbp2
                WHERE
                    pbp2.product_id = p.id
                        AND pbp2.price_level = 3)) buy_price_updated_at_3
FROM
    products p
