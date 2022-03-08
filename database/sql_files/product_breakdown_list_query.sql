SELECT
	pb.id,
	pb.product_from AS product_from_id,
	pf.name AS product_from_name,
	pb.product_to  AS product_to_id,
	pt.name AS product_to_name,
	pb.quantity_to_breakdown,
	pb.quantity_to_add,
	cu.full_name as creator_name,
   uu.full_name as updater_name
FROM product_breakdown pb
	LEFT JOIN products pf
		ON pb.product_from = pf.id
	LEFT JOIN products pt
		ON pb.product_to = pt.id
	LEFT JOIN users cu
		ON pb.created_by = cu.full_name
	LEFT JOIN users uu
		ON pb.updated_by = uu.full_name;
