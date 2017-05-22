<?php
/**
 * @param $lastname
 * @param $name
 * @param $phone
 * @return bool
 */
function save($lastname, $name, $phone)
{
    unset($result);

    if (!$lastname || (ctype_space ( $lastname) == true))  $result[0] = 'нет фамилии';
    if (!$name || (ctype_space ( $name) == true)) $result[1] = 'нет имени';
    if (strlen($phone)!=11 || strpos($phone, '8') != 0) $result[2] = 'нет номера';//11 simbol with 8
    if (!$result) {
        $result = true;
        file_put_contents('addressbook.txt', ucfirst($name) . "|" . ucfirst($lastname) . "|" . $phone . "\n", FILE_APPEND | LOCK_EX);
        header("Location:index.php");//здесь ли
    }
    return $result;
}

/**
 * @param $lastname
 * @return bool or massive
 */
function search($lastname)
{
    $result = false;
    $lines = file('addressbook.txt');
    if (strlen($lastname) <= 3) echo 'нужно не менее трех символов';
    else {
        foreach ($lines as $line_num => $line) {
            list($name, $lname, $phone) = explode("|", $line);

            if (strpos($lname, ucfirst($lastname)) === 0) {
                $result[$line_num]['LAST_NAME'] = $lname;
                $result[$line_num]['NAME'] = $name;
                $result[$line_num]['PHONE'] = $phone;
            }
        }
        if (!$lines  || $result == false) echo 'не найдено';
    }
    return $result;
}

/**
 * @return bool
 */
function getList()
{
    $lines = file('addressbook.txt');
    if (!$lines) $result = true;
    else {
        foreach ($lines as $line_num => $line) {
            list($name, $lastname, $phone) = explode("|", $line);

            $result[$line_num]['LAST_NAME'] = $lastname;
            $result[$line_num]['NAME'] = $name;
            $result[$line_num]['PHONE'] = $phone;
        }
    }
    return $result;
}
?>
