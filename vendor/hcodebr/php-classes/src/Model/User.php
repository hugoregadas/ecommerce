<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

/**
 * 
 */
class User extends Model
{
	const SESSION = "User";
	
	public static function login($login, $password)
	{
		$sql =  new Sql();

		$results = $sql -> select("SELECT * FROM tb_users WHERE deslogin = :Login", array(":Login" => $login));

		if (count($results) === 0) {
			# code...
			throw new \Exception("Usuario inexistente ou senha inválida", 1);
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"])){
			$user = new User();

			$user ->setData($data);

			$_SESSION[User::SESSION] = $user-> getValues();
			return $user;

		}else {
			throw new \Exception("Usuario inexistente ou senha inválida", 1);
			
		}
	}

	public static function verifyLogin($inadmin = true)
	{
		if (!isset($_SESSION[User::SESSION]) 
			|| 
			!$_SESSION[User::SESSION] 
			|| 
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 
			|| (bool)$_SESSION[User::SESSION]["inadmin"] 
			!== $inadmin){
			header("Location: /admin/login");
			exit;
		}
	}

	public static function logout(){
		$_SESSION[User::SESSION] = Null;
	}
}

 ?>