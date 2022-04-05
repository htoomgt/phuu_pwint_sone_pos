SET SQL_MODE='STRICT_TRANS_TABLES';
/*purchase quantity*/
select 
    prd.id,
	prd.name,
	pd.product_code,
    pmu.name,
    sum(pd.quantity) as 'total_purchased'
from purchase_details pd
LEFT JOIN purchases p on pd.purchase_id = p.id
INNER JOIN products prd on pd.product_id = prd.id
INNER JOIN product_measure_units pmu on pmu.id = prd.category_id
group by pd.product_code;


/*break down quantity*/
select 
	pf.name,
    pd.quantity_to_breakdown,
    pt.name,
    pd.quantity_to_add
from product_breakdown pd
LEFT JOIN products pf ON pd.product_from = pf.id
LEFT JOIN products pt ON pd.product_to = pt.id
group by pf.id, pt.id;


/*sale quantity*/
select 
    prd.id,
	prd.name,
	prd.product_code,
    pmu.name,
    sum(sd.quantity) as 'total_sold'
from sale_details sd
LEFT JOIN sales s on sd.sale_id = s.id
INNER JOIN products prd on sd.product_id = prd.id
INNER JOIN product_measure_units pmu on pmu.id = prd.category_id
group by sd.product_id;




