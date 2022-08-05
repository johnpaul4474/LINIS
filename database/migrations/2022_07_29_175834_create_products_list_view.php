<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("
                CREATE VIEW paul.linen_products_list AS
                SELECT products.id ,
                    products.raw_material_id,		
                    products.raw_material_stock_number,
                    raw_material.unit, 
                    raw_material.description as material_used,
                    products.product_bulk_id,
                    products.product_stock_id,
                    products.product_name,
                    stocks.stock_room,
                    storages.storage_name,
                    products.product_unit,
                    products.product_quantity,
                    products.product_available_quantity,
                    products.product_condemned_quantity,
                    products.product_losses_quantity,
                    products.product_unit_cost,
                    raw_material.quantity as raw_material_quantity,
                    products.stock_room_id,
                    products.storage_room_id,
                    products.is_available,
                    products.is_condemned,
                    products.is_lossed,
                    products.is_returned,
                    products.issued_office_id,
                    office.office_name,
                    products.issued_ward_id,
                    ward.ward_name,
                    products.create_date,
                    products.updated_at,
                    (products.product_quantity *
                        products.product_unit_cost) as total_cost
                FROM paul.linen_products as products 
                inner join paul.linen_stock_rooms as stocks
                on products.stock_room_id = stocks.id
                inner join paul.linen_storage as storages
                on products.storage_room_id = storages.id
                inner join paul.linen_raw_materials as raw_material
                on products.raw_material_id = raw_material.id  
                left join paul.linen_ward as ward
                on products.issued_ward_id = ward.id
                left join paul.linen_office as office
                on products.issued_office_id = office.id
                where products.deleted_at is null
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("DROP VIEW paul.linen_products_list");
    }
}
