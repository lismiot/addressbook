<html>
<head>
    <title>Адресная книга</title>
    <style type="text/css">
        P.line {
            border-bottom: 1px dotted #ff922c;
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
file_put_contents('addressbook.txt', '', FILE_APPEND | LOCK_EX);
require 'action.php';
?>

<form action="index.php" method="post">
    <p>Ваше имя: <input type="text" name="name"/></p>
    <p>Ваша фамилия: <input type="text" name="lastname"/></p>
    <p>Ваш номер телефона: <input type="text" name="phone"/></p>
    <p><input type="submit" name="sSave" value="сохранить" /></p>
</form>
<p class="line">
</p>

<?php
if(isset($_POST['sSave'])) {
    $result = save($_POST['lastname'], $_POST['name'], $_POST['phone']);
    if ($result !== true){
        foreach($result  as  $num_res => $res)
        {
            echo $result[$num_res];
            echo '<br/>';
        }
        ?><p class="line"></p><?
    }
    $result = true; //чтоб дальше не выводилось?

}
?>


<form action="index.php" method="post">
    <p>Поиск по фамилии: <input type="text" name="lname" /></p>
    <p><input type="submit" name="sSearch" value="найти" /></p>
</form>
<p class="line">
</p>



<?php
if(isset($_POST['sSearch'])) {
    $result = search($_POST['lname']);
}
else {
    $result = getList();
}

if (gettype($result) == 'array') {
    sort($result);//сортировка
    
    echo '<table>';
    foreach ($result as $num => $res) {
        echo '<tr>';
        foreach ($res as $n => $r) {
            echo '<td><p>' . htmlspecialchars($result[$num][$n] . ' ') . '</p></td>';
        }
        echo '<td><p><form action="index.php" method="post"><input type="submit" name="sDel[]" value="удалить" /></form></p></p></td>';

        echo '</tr>';//'<br/>';
        }
    echo '</table>';
}

//удаление
/*
for ($id = 0; $id <= $num; $id++) {
    if (isset($_POST['sDel'][$id])) {
        echo $id;
        if ($id != "") {
            $id--;
            $file = file("addressbook.txt");
            $fp = fopen("addressbook.txt", "w");
            for ($i = 0; $i < sizeof($file); $i++) {
                if ($num == $id) {
                    unset($file[$i]);
                }
            }
            fputs($fp, implode("", $file));
            fclose($fp);
        }
    }
}
*/
?>

</body>
</html>
