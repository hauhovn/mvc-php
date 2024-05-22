<section id="ingredient-section">
    <span class="title">ingredients</span>
    <div class="action-container">
        <div class="add-box">
        <button id="add">Add</button>
        <input id="num-of-row-input" type="number" min="1" max="100" value="1">
        <span>rows</span>
        </div>
        <button id="edit" disabled>Edit</button>
        <button id="delete" disabled>Delete</button>
        <button id="confirm" disabled>Confirm</button>
    </div>
    <div class="add-table-container">
    <table id="add-ing-table">
        <caption></caption>
        <thead>
        </thead>
        <tbody></tbody>
    </table>
    </div>
    <div class="table-container">
    <span class="num-rows-info">Num of rows selected: <span id="num-of-row-selected">0</span></span>
    <table id="ing-table">
        <thead>
            <td>ID</td>
            <td>Name</td>
            <td>Inventory</td>
            <td>Price</td>
            <td>Unit</td>
            <td>Total</td>
        </thead>
        <tbody>
            <?php 
            // $ingList = isset($data['ingredientList'])?$data['ingredientList']:[];
            // foreach($ingList as $ing){
            //     $tr = "<tr class='ing-tr' id=".$ing['id'].">";
            //     foreach($ing as $key=>$value){
            //         $tr.="<td class='".$key."'>".$value."</td>";
            //     }
            // echo $tr.="</tr>";
            // }
            ?>
        </tbody>
        <tfoot>
            <td colspan="2">...</td>
            <td id="sum-inventory">0</td>
            <td id="sum-price">0</td>
            <td>-</td>
            <td id="sum-total">0</td>
        </tfoot>
    </table>
    </div>
</section>