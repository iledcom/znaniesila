<?php

// На этой странице отображаются статьи, относящиеся к данной категории
// Этот сценарий создан в главе 5

// Чтобы управлять отображением сообщений об ошибках, требуется подключение файла конфигурации перед выполнением любого кода PHP
require('./includes/config.inc.php');
// Файл конфигурации также запускает сеанс

//Выполняется подключение к базе данных
require(MYSQL);

// Верификация кода категории

if(filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	//filter_var — Фильтрует переменную с помощью определенного фильтра
	//FILTER_VALIDATE_INT Проверяет, что значение является корректным целым числом, и, при необходимости, входит
	// в определенный диапазон, при успешной проверке преобразует в целое число.
	$cat_id = $_GET['id'];

	// Получение заголовка категории
	$q = 'SELECT category FROM categories WHERE id=' . $cat_id;
	$r = mysqli_query($dbc, $q);

	//Если в результате выполнения запроса не возвращается единственная строка, то отображается сообщение об ошибке.
	if (mysqli_num_rows($r) !== 1) {
		//mysqli_num_rows — Получает число рядов в результирующей выборке
		$page_title = 'Ошибка!';
		include('./includes/header.html');
		echo '<div class="alert alert-danger">Ошибка при попытке доступа к странице.</div>';
		include('./includes/footer.html');
		exit();
	}

	// Выборка заголовка категории и использование его в качестве заголовка страницы
	list($page_title) = mysqli_fetch_array($r, MYSQLI_NUM);
	//С помощью функции list() фрагменты массива присваиваются отдельным переменным
	include('./includes/header.html');
	echo '<h1>' . htmlspecialchars($page_title) . '</h1>';
	//Если в результате выполнения кода была возвращена ровно одна запись, то содержимое выбранного столбца
	//присваивается переменной $page_title, а затем включается заголовок и отображается заголовок страницы.


	// Печать сообщения в случае отсутствия активного пользователя
	// Изменение сообщения на основании статуса пользователя
	if (isset($_SESSION['user_id']) && !isset($_SESSION['user_not_expired'])) {
		echo '<div class="alert"><h4>Срок действия учетной записи истек</h4>Спасибо, что вы заинтересовались контентом нашего сайта. К сожалению, срок действия вашей учетной записи истек. Пожалуйста, <a href="renew.php">обновите вашу учетную запись</a>, чтобы получить доступ к контенту сайта.</div>';
	} elseif (!isset($_SESSION['user_id'])) {
		echo '<div class="alert">Спасибо, что вы заинтересовались контентом нашего сайта. Чтобы просматривать контент сайта, следует войти в качестве зарегистрированного пользователя.</div>';
	}

	// Получение страниц, связанных с этой категорией
	$q = 'SELECT id, title, description FROM pages WHERE categories_id=' . $cat_id . ' ORDER BY date_created DESC';
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) > 0) { // доступные страницы
	
		// Выборка каждой страницы
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			// Отображение каждой записи
			echo '<div><h4><a href="page.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h4><p>' . htmlspecialchars($row['description']) . '</p></div>';

		} // завершение цикла WHILE
		
	} else { // отсутствуют доступные страницы
		echo '<p>Отсутствуют страницы контента, связанные с данной категорией. Пожалуйста, выполните повторную проверку!</p>';
	}

} else { // отсутствует корректный код
	$page_title = 'Ошибка!';
	include('./includes/header.html');
	echo '<div class="alert alert-danger">Ошибка при доступе к странице.</div>';
} // завершение основного блока IF

// Включение футера HTML
include('./includes/footer.html');
?>

