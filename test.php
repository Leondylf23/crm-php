<?php 
    if(isset($_POST['test'])) {
        $data = $_POST['data'];

        $t = $data[0];

        echo("<script> alert('$t'); </script>");
    }
?>

<form method="post">
    <input type="hidden" name="data" value="[1,3,1,2]">
    <button type="submit" name="test">Test</button>
</form>