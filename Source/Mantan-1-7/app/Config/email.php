<?php 
						class EmailConfig {
							public $default = array(
								"transport" => "Smtp", 
								"from" => array("mantansource@gmail.com" => "Mantan Source"), 
								"host" => "ssl://smtp.gmail.com", 
								"port" => 465, 
								"timeout" => 30, 
								"emailFormat" => "html", 
								"username" => "mantansource@gmail.com", 
								"password" => "************", 
								"tls" => false, 
								"log" => false, 
								"charset" => "utf-8", 
								"headerCharset" => "utf-8", 
								
							);
						}
					?>