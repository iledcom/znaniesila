<?php
//Начните создавать функцию.
function create_form_input($name, $type, $label = '', $errors = array (), $options = array ()) {

	//Проверьте значение и выполните его обработку.
	$value = false;
	if (isset($_POST[$name])) $value = $_POST[$name]; 
	if ($value && get_magic_quotes_gpc()) $value = stripslashes($value);
	//При выполнении этой функции сначала предполагается, что значение отсутствует. Если же существует значение для данных, вводимых с помощью переменной $_POST, то оно присваивается переменной $value.Затем удаляются избыточные символы косой черты, присвоенные значению при включенных “волшебных кавычках”.

	//Создайте теги <DIV>, в которые заключается текущий элемент.
	echo '<div class="form-group';

	if (array_key_exists($name, $errors)) echo 'has-error';
	
	echo '">';

	if (!empty($label)) echo '<label for="' . $name . '" class="control-label">' . $label . '</label>';

	//Создайте условное выражение, применяемое для проверки типа поля ввода данных.
	if ( ($type === 'text') || ($type === 'password') || ($type === 'email')) {
		//Начните создавать поля ввода данных.
		echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control"';
		//Добавьте значение поля ввода данных (при наличии):
		if ($value) echo ' value="' . htmlspecialchars($value) . '"'; //Значение, присвоенное переменной $value, будет добавлено в поток ввода данных с помощью функции htmlspecialchars ().
		//Проверьте наличие дополнительных параметров.
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		} //В результате выполнения этих действий появляется возможность добавить заполнители или другие атрибуты элемента
		//Завершите элемент:
		echo ' >';

		//Отобразите сообщение об ошибке (в случае появления ошибки).
		if (array_key_exists($name, $errors)) echo '<span class="hеlр blоск">' . $errors[$name] . '</span>';
			//Этот код сначала проверяет значение переменной $errors, чтобы идентифицировать ошибку. При наличии ошибки соответствующее сообщение добавляется после поля ввода данных (см. рис. 3.14).
	//Проверьте, будет ли тип вводимых данных textarea:
	} elseif ($type === 'textarea') {
	//Синтаксис, применяемый при создании областей ввода текста, отличается от синтаксиса, используемого для создания других типов вводимых данных. Поэтому текстовые области генерируются особым образом с помощью этой функции.
		//Сначала отобразите сообщение об ошибке.
		if (array_key_exists($name, $errors)) echo '<span class="help-block">' . $errors [$name] . '</span>';
		//В отличие от ввода текста и паролей, когда сообщение об ошибке отображается ниже вводимых данных, при вводе данных в текстовые области сообщения об ошибках отображаются выше области. Благодаря этому ошибку легче заметить.
			//Начните создавать область ввода текста.
			echo '<textarea name="' . $name . '" id="' . $name . '" class="form-control"';
			//В результате выполнения этого кода создается открывающий тег текстовой области, поддерживающий динамические значения name и id.
			//Проверьте наличие дополнительных параметров.
			if (!empty($options) && is_array($options)) {
				foreach ($options as $k => $v) {
					echo " $k=\"$v\"";
				}
			}
			//С помощью подобных параметров можно, например, установить количество строк и столбцов.
			//Закройте открывающий тег:
			echo '>';
		//Добавьте значение в текстовую область:
		if ($value) echo $value;
		//Значение для текстовых областей записывается между открывающим и закрывающим тегами текстовой области. 
	//Завершите создание области ввода текста:
		echo '</textarea>';
//Завершите формирование функции.
	} // завершение основной конструкции IF-ELSE echo '</div>';
} // завершение функции create_form_input()