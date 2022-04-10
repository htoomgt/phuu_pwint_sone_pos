<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrentInventoryStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlStatement = "        
        DROP TABLE IF EXISTS `current_inventory`; 
        CREATE DEFINER=`db_user`@`%` PROCEDURE `current_inventory`(
            IN `filter_products` TEXT
        )
        LANGUAGE SQL
        NOT DETERMINISTIC
        CONTAINS SQL
        SQL SECURITY DEFINER
        COMMENT ''
        BEGIN
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
        
        
        
        /*Balance Raw*/
        select
            p.id as 'product_id',
           p.name as 'product_name',
           p.product_code AS 'product_code',   
            pbi.product_to_id,    
            pbo.product_from_id,
            pc.name AS 'product_category',
            pmu.name AS 'product_measure_unit',
            FORMAT(p.unit_price, 0) AS 'unit_price',
            coalesce(pbi.total_breakdown_to, 0) as 'total_break_down_to_qty',    
           coalesce(pbo.total_breakdown_from, 0) as 'total_break_down_from_qty',    
           coalesce(ppi.total_purchased, 0) as 'total_purchased_qty',
            coalesce(pso.total_sold, 0) as 'total_sold_qty',
            FORMAT(((coalesce(pbi.total_breakdown_to, 0) + coalesce(ppi.total_purchased, 0)) -
           coalesce(pso.total_sold, 0) + coalesce(pbo.total_breakdown_from, 0)), 0) as 'balance'   
            
        from products p
        LEFT JOIN product_purchase_in  as ppi ON p.id = ppi.product_id
        LEFT JOIN product_sale_out as pso ON p.id = pso.product_id
        LEFT JOIN product_break_down_in as pbi ON p.id = pbi.product_to_id
        LEFT JOIN product_break_down_out as pbo ON p.id = pbo.product_from_id
        LEFT JOIN product_categories AS pc ON p.category_id = pc.id
        LEFT JOIN product_measure_units AS pmu ON p.measure_unit_id = pmu.id
        WHERE FIND_IN_SET(p.id, filter_products);
        
        END
        ";

        DB::unprepared($sqlStatement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TABLE IF EXISTS `current_inventory`; ");   
    }
}
