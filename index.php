<?php
echo "´: [";
/*
SELECT id, name, category, points,
(SELECT COUNT(*) +1
        from (select points from jl_incentive_campaign_sellers_extract WHERE category_code=2 AND quarter=1 group by points) a 
        WHERE a.points > b.points) as rankPosition
FROM
    jl_incentive_campaign_sellers_extract b
    WHERE b.category_code=2 AND b.quarter=1

    ORDER BY rankPosition asc 
    LIMIT 5
 */
?>