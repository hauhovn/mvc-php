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
    </div>
    <span class="num-rows-info">Num of rows selected: <span id="num-of-row-selected">0</span></span>
    <table id="ing-table">
        <thead>
            <td>ID</td>
            <td>Name</td>
            <td>Price</td>
            <td>Unit</td>
            <td>Inventory</td>
        </thead>
        <tbody>
            <?php 
            $ingList = isset($data['ingredientList'])?$data['ingredientList']:[];
            foreach($ingList as $ing){
                $tr = "<tr class='ing-tr' id=".$ing['id'].">";
                foreach($ing as $key=>$value){
                    $tr.="<td>".$value."</td>";
                }
            echo $tr.="</tr>";
            }
            ?>
        </tbody>
    </table>
</section>