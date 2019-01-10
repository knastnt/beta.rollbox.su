<?php
//Проверяем, index.php ли меня зовут
if( pathinfo(__FILE__, PATHINFO_BASENAME) != 'index.php'){
	echo "Если я не index.php, то я бакапный файл и работать мне не надо.";
	return;
}


//Смотрим где запущен сайт: в опенсервере или в продакшене
//if (false) {
if (strpos(strtolower($_SERVER ["DOCUMENT_ROOT"]), 'openserver') !== false) {
    //Это OpenServer.
	// Всё нормально, можно расслабиться.
	
}else{
	//Это продакшн.
	
	/*Какого хрена я делаю в продакшене??!!
	  Видимо меня только что перенесли в продакшен!
	  В таком случае срочно берём рядом лежащую базу данных и импортируем её,
	   заменяем себя нормальным файлом
	   и чистим мусор
	 */
	 

	//Стартуем перехват вывода
	ob_clean();
	ob_start();

	 
	//копируем продакшенский wp-config.php
	$copied = $_SERVER ["DOCUMENT_ROOT"] . "/-migrations-/wp-config-original-for-production-1gb.ru.php";
	$replaced = $_SERVER ["DOCUMENT_ROOT"] . "/wp-config.php";
	if (!copy($copied, $replaced)) {
		echo "не удалось скопировать $copied\n";
	}
	
	//переименовываем себя в index-.php
	$copied = __FILE__;
	$replaced = $_SERVER ["DOCUMENT_ROOT"] . "/index-.php";
	if (!copy($copied, $replaced)) {
		echo "не удалось переименовать $copied...\n";
	}
	
	//Помещаем на свое место нормальный продакшенский index.php
	$copied = $_SERVER ["DOCUMENT_ROOT"] . "/-migrations-/index-original-for-production.php";
	$replaced = __FILE__;
	if (!copy($copied, $replaced)) {
		echo "не удалось скопировать $copied...\n";
	}
	
	
	//Распаковываем архив базы данных
	
	// try and get database values using regex approach
	$db_details = define_find( $_SERVER ["DOCUMENT_ROOT"] . '/wp-config.php' );
	
	//var_dump($db_details);
	/*
	array(6) { 
		["host"]=> string(14) "mysql93.1gb.ru" 
		["name"]=> string(11) "gb_tst102bd" 
		["user"]=> string(11) "gb_tst102bd" 
		["pass"]=> string(10) "c2zfc8ezyu" 
		["char"]=> string(7) "utf8mb4" 
		["coll"]=> string(0) "" 
	}
	*/
	
	//Script to restore
	$restore_file  = $_SERVER ["DOCUMENT_ROOT"] . "/-migrations-/db.sql";
	//$server_name   = "localhost";
	$server_name   = $db_details["host"];
	//$username      = "root";
	$username      = $db_details["user"];
	//$password      = "root";
	$password      = $db_details["pass"];
	//$database_name = "test_world_copy";
	$database_name = $db_details["name"];
	
	
	
	
	//Удаляем все таблицы в базе данных перед импортом
	try {
		$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
		
		$sql = 'SHOW TABLES';
		$stmt = $conn->query($sql);
		while ($row = $stmt->fetch()) {
			//echo $row[0]."<br />\n";
			$conn->query("DROP TABLE `$database_name`.`$row[0]`;");
		}
		
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	finally	{
		$conn = null; 
	}
	
		

	//https://dev.mysql.com/doc/refman/8.0/en/mysql-command-options.html
	$cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
	//$cmd = "notepad";
	
	
	//Скрипт остановится пока не будут возвращены результаты выполнения exec
	exec($cmd,$output,$result); 
	
	if($result != 0){
		echo "проблемы с импортом БД\r\n";
		echo "status:\n";
		var_dump( $status );
		echo "\noutput:\n";
		var_dump( $output );
		echo "\n";
	}
	
	
	//Удаляем файл базы данных
	unlink($restore_file);

	
	
	//Обрабатываем перехваченный вывод
	$t=ob_get_contents();
	if ( strlen ($t) != 0){
		//Выводились какие-то сообщения, хотя всё должно быть гладко.
		//Отображаем их и прекращаем работу.
		echo $t;
		
		
		//Возвращаем index-.php на прежнее место
		$copied = $_SERVER ["DOCUMENT_ROOT"] . "/index-.php";
		$replaced = $_SERVER ["DOCUMENT_ROOT"] . "/index.php";
		if (!copy($copied, $replaced)) {
			echo "не удалось обратно переименовать $copied...\n";
		}
		unlink($copied);
		
		return;
	}else{
		//Удаляем index-.php
		unlink($_SERVER ["DOCUMENT_ROOT"] . "/index-.php");
		
		echo "Migration completed. Refresh page";
		
		return;
	}

	
}



/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool 
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );























	/**
	 * Search through the file name passed for a set of defines used to set up
	 * WordPress db access.
	 *
	 * @param string $filename The file name we need to scan for the defines.
	 *
	 * @return array    List of db connection details.
	 */
	function define_find( $filename = 'wp-config.php' ) {

		if ( $filename == 'wp-config.php' ) {
			$filename = dirname( __FILE__ ) . '/' . basename( $filename );

			// look up one directory if config file doesn't exist in current directory
			if ( ! file_exists( $filename ) )
				$filename = dirname( __FILE__ ) . '/../' . basename( $filename );
		}

		if ( file_exists( $filename ) && is_file( $filename ) && is_readable( $filename ) ) {
			$file = @fopen( $filename, 'r' );
			$file_content = fread( $file, filesize( $filename ) );
			@fclose( $file );
		}

		preg_match_all( '/define\s*?\(\s*?([\'"])(DB_NAME|DB_USER|DB_PASSWORD|DB_HOST|DB_CHARSET|DB_COLLATE)\1\s*?,\s*?([\'"])([^\3]*?)\3\s*?\)\s*?;/si', $file_content, $defines );

		if ( ( isset( $defines[ 2 ] ) && ! empty( $defines[ 2 ] ) ) && ( isset( $defines[ 4 ] ) && ! empty( $defines[ 4 ] ) ) ) {
			foreach( $defines[ 2 ] as $key => $define ) {

				switch( $define ) {
					case 'DB_NAME':
						$name = $defines[ 4 ][ $key ];
						break;
					case 'DB_USER':
						$user = $defines[ 4 ][ $key ];
						break;
					case 'DB_PASSWORD':
						$pass = $defines[ 4 ][ $key ];
						break;
					case 'DB_HOST':
						$host = $defines[ 4 ][ $key ];
						break;
					case 'DB_CHARSET':
						$char = $defines[ 4 ][ $key ];
						break;
					case 'DB_COLLATE':
						$coll = $defines[ 4 ][ $key ];
						break;
				}
			}
		}

		return array(
			'host' => $host,
			'name' => $name,
			'user' => $user,
			'pass' => $pass,
			'char' => $char,
			'coll' => $coll
		);
	}