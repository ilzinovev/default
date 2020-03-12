<?php
include 'PDOAdapter.php'; // подключаем компонент
$my= new PDOAdapter('mysql:host=localhost;dbname=test','root','','');
$array_age=$my -> execute('selectAll','SELECT max(age) FROM person');
$max=$array_age[0]->{'max(age)'}; // получаем максимальный возраст
// по задумке следующие две строки должны были находить людей у кого возрас меньше максимального и у кого mother_id NULL но пока
//по неизвестной мне причине функция prepare у меня не сработала а сработала только в execute которую я поставил в конце
//$sql="UPDATE person SET age='$max' WHERE (age<'$max' AND mother_id IS NULL) LIMIT 1 ";
//$my -> prepare($sql);

$array_person=$my -> execute('selectAll',"SELECT lastname,firstname,age FROM person WHERE age='$max' ORDER BY lastname");//запрос на получение всех людей чей возраст максимальный
echo "Максимальный возраст ".$max."<br>";
echo "Список персон максимального возраста<br>";
foreach ($array_person as $key => $value) {
  echo $array_person[$key]->lastname." ".$array_person[$key]->firstname." возраст ".$array_person[$key]->age."<br>"; // вывод фамилии имени и возраста
}

$my->execute('selectOne',"UPDATE person SET age='$max' WHERE (age<'$max' AND mother_id IS NULL) LIMIT 1");


?>
