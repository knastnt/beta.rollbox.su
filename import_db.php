<?php
//Проверяем, import_db.php ли меня зовут
if( pathinfo(__FILE__, PATHINFO_BASENAME) != 'import_db.php'){
	echo "Если я не import_db.php, то я бакапный файл и работать мне не надо.";
	return;
}


//Смотрим где запущен сайт: в опенсервере или в продакшене
//if (false) {
if (strpos(strtolower($_SERVER ["DOCUMENT_ROOT"]), 'openserver') !== false) {
    //Это OpenServer.


	
	
	//Распаковываем архив базы данных
	
	// try and get database values using regex approach
	$db_details = define_find( $_SERVER ["DOCUMENT_ROOT"] . '/wp-config.php' );
	
	
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
	
		

	$cmd = "G:\OpenServer\modules\database\MySQL-5.7\bin\mysql.exe -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
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
	

	echo "Import completed.";

	
}











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