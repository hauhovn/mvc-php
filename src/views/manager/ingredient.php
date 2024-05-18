<section>
    <span>ingredients</span>
    <div class="action-container">
        <div class="add-box">
        <button class="add">Add</button>
        <input id="num-of-row-input" type="number" min="1" max="100" value="1">
        <span>rows</span>
        </div>
        <button class="edit">Edit</button>
        <button class="delete">Delete</button>
    </div>
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
                $tr = "<tr>";
                foreach($ing as $key=>$value){
                    $tr.="<td>".$value."</td>";
                }
            echo $tr.="</tr>";
            }
            ?>
        </tbody>
    </table>
</section>