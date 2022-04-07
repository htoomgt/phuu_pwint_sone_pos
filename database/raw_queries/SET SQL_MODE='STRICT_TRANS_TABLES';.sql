SET SQL_MODE='STRICT_TRANS_TABLES';
/*purchase quantity*/
DROP TABLE IF EXISTS `product_purchase_in`;
CREATE TEMPORARY TABLE IF NOT EXISTS `product_purchase_in` AS (
select 
    prd.id as 'product_id',
	prd.name as 'product_name',
	pd.product_code,    
    pmu.name as 'product_unti',
    sum(pd.quantity) as 'total_purchased'
from purchase_details pd
LEFT JOIN purchases p on pd.purchase_id = p.id
INNER JOIN products prd on pd.product_id = prd.id
INNER JOIN product_measure_units pmu on  prd.measure_unit_id = pmu.id
group by pd.product_code
);
select * from `product_purchase_in`;



/*break down quantity in*/
DROP TABLE IF EXISTS `product_break_down_in`;
CREATE TEMPORARY TABLE IF NOT EXISTS product_break_down_in AS (
select 
    pt.id as 'product_from_id',
	pt.name as 'product_form_name',
    sum(pd.quantity_to_add) as 'total_breakdown_to',
    pt.id as 'product_to_id'
from product_breakdown pd
LEFT JOIN products pt ON pd.product_to = pt.id
group by pt.id
);
select * from product_break_down_in;

/*break down quantity out*/
DROP TABLE IF EXISTS `product_break_down_out`;
CREATE TEMPORARY TABLE IF NOT EXISTS product_break_down_out AS (
select 
    pf.id as 'product_from_id',
	pf.name as 'product_form_name',
    sum(pd.quantity_to_breakdown) as 'total_breakdown_from'    
from product_breakdown pd
LEFT JOIN products pf ON pd.product_from = pf.id
group by pf.id
);
select * from product_break_down_in;


/*sale quantity*/
DROP TABLE IF EXISTS `product_sale_out`;
CREATE TEMPORARY TABLE IF NOT EXISTS product_sale_out AS (
select 
    prd.id as 'product_id',
	prd.name,
	prd.product_code,
    pmu.name as 'sale_product_measure_unit',
    sum(sd.quantity) as 'total_sold'
from sale_details sd
LEFT JOIN sales s on sd.sale_id = s.id
INNER JOIN products prd on sd.product_id = prd.id
INNER JOIN product_measure_units pmu on prd.measure_unit_id = pmu.id 
group by sd.product_id);
select * from product_sale_out;


/*Balance Raw*/
select
	p.id as 'product_id',
    p.name as 'product_name',
    pbi.product_to_id,    
    pbo.product_from_id,
	coalesce(pbi.total_breakdown_to, 0) as 'total_break_down_to_qty',    
    coalesce(pbo.total_breakdown_from, 0) as 'total_break_down_from_qty',    
    coalesce(ppi.total_purchased, 0) as 'total_purchased_qty',
    coalesce(pso.total_sold, 0) as 'total_sold_qty',
    ((coalesce(pbi.total_breakdown_to, 0) + coalesce(ppi.total_purchased, 0)) -
    (coalesce(pso.total_sold, 0) + coalesce(pbo.total_breakdown_from, 0))) as 'balance'   
    
from products p
LEFT JOIN product_purchase_in  as ppi ON p.id = ppi.product_id
LEFT JOIN product_sale_out as pso ON p.id = pso.product_id
LEFT JOIN product_break_down_in as pbi ON p.id = pbi.product_to_id
LEFT JOIN product_break_down_out as pbo ON p.id = pbo.product_from_id;


