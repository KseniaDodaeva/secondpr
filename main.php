<form method="post" enctype="multipart/form-data">
    <input type="file" name="test"></br>
    <textarea name="text"></textarea></br>
    <input type="submit">
</form>

<?php
function count_word($str)
{
    $strF = explode(" ", preg_replace("/[^a-z\']+/", ' ', strtolower($str)));
    $text = array_filter($strF, fn($elem) => $elem!='');
    $count = count($text);


    $count_values = array();
    foreach ($text as $a) {
        $count_values[$a]++;
    }


    if(!file_exists("files_csv")){
        mkdir("files_csv");
    }
    $od = opendir("files_csv");


    $date = (string)date('d-m-Y_His');
    $ref = fopen("files_csv/"."text"."$date".".csv", 'w');
    fputcsv($ref,["Words_in_text".';'.$count]);


    foreach ($count_values as $key => $value){
        fputcsv($ref,[$key.';'.$value]);
    }


    fclose($ref);
    closedir($od);
    sleep(1);
}

if (!empty($_FILES['test']['name'])) {
    count_word(file_get_contents($_FILES['test']['tmp_name']));
}

if (!empty($_POST['text'])) {
    count_word($_POST['text']);
}

