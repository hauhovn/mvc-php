<link rel="stylesheet" href="/public/css/dashboard/ingredients.css">
<table id="import_ingredient">
    <thead></thead>
    <tbody></tbody>
</table>
<div id="table-data" style="display:none;">
    <?php echo $data['ingredientsDetail'] ?>
</div>
<div id="table-config" style="display:none;">
{
    "table_name": "import_ingredient",
    "columns": [
        {
            "display": "ID",
            "id": "import_ingredient_id"
        },
        {
            "display": "Ing ID",
            "id": "ingredient_id"
        },
        {
            "display": "SL",
            "id": "quantity"
        },
        {
            "display": "Price",
            "id": "real_price"
        },
        {
            "display": "Status",
            "id": "status"
        }
    ]
}
</div>
<script src="/public/js/renderTalbe.js" type="module"></script>