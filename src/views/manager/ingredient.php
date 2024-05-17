<section>
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
                // Hien cac key sau
                // $tbHeadList = ['id','name','price','unit','inventory'];
                // in_array($key,$tbHeadList)&&
                $tr.="<td>".$value."</td>";
            }
            echo $tr.="</tr>";
            }
            ?>
        </tbody>
    </table>
</section>