<section id="ingredient-section">
    <span class="title">ingredients</span>
    <div class="action-container">
        <div class="add-box">
        <button id="add">Add</button>
        <input id="num-of-row-input" type="number" min="1" max="100" value="1">
        <span>rows</span>
        </div>
        <button id="edit">Edit</button>
        <button id="delete">Delete</button>
        <button id="confirm">Confirm</button>
    </div>
    <table id="add-ing-table">
        <caption>Add ingredients table info</caption>
        <thead>
            <td>Name</td>
            <td>Inventory</td>
            <td>Price</td>
            <td>Unit</td>
        </thead>
    </table>
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
            $ingList = isset($data['ingredientList'])?$data['ingredientList']:[];
            foreach($ingList as $ing){
                $tr = "<tr class='ing-tr' id=".$ing['id'].">";
                foreach($ing as $key=>$value){
                    $tr.="<td class='td-".$key."'>".$value."</td>";
                }
            echo $tr.="</tr>";
            }
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
</section>