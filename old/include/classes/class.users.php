<?php
class users {
	protected $loginInfo = array();

	public function showLoginForm() {
		$template = new template(api::setTemplate("api/auth.html"));
		$template->stop(1);

	}

	public function checkLogin() {
		global $_POST, $API, $sql;
		if (isset($_POST['authLogin']) && isset($_POST['authPassword'])) {
			// create template variables;
			$login = $API['config']['admin']['login'];
			$password = $API['config']['admin']['password'];

			// check for suid
			if ($login === trim($_POST['authLogin']) && $password === $_POST['authPassword']) {
				// is suid
				$this->saveAuthDataToSession(
												0,
												$login,
												"Super user access",
												"root@localhost",
												1,
												array(),
												time(),
												"0000-00-00 00:00:00",
												"Super user account",
												0,
												true);
				return true;
			} else {

				// check for others users;
				$sql->query("
								SELECT
										*
								FROM
										`#__#users_v2`
								WHERE
										`login` = '".$sql->escape(sl(trim($_POST['authLogin'])))."'
										",
										true);

				if ($sql->num_rows() !== 1) {
					return false;
				}

				if ($sql->result['password'] !== crypt($_POST['authPassword'], $sql->result['password'])) {
					return false;
				}

				$this->saveAuthDataToSession(
												$sql->result['userId'],
												$sql->result['login'],
												$sql->result['fio'],
												$sql->result['email'],
												$sql->result['accessRights'],
												explode(",", $sql->result['accessModules']),
												$sql->result['lastLogin'],
												$sql->result['regTime'],
												$sql->result['addedBy'],
												false
				);

				return true;
			}
		}


		if ($this->getSinginUserInfo() === true) {
			//echo "Auth is true";
			return true;
		}

	}

	function saveAuthDataToSession(
									$userId,
									$userLogin,
									$userFio,
									$userEmail,
									$accessRights,
									$accessModules,
									$lastLogin,
									$regTime,
									$addedBy,
									$isSu = false
									) {


	$this->loginInfo = array(
								"auth" => true,
								"userId" => $userId,
								"userLogin" => $userLogin,
								"userFio" => $userFio,
								"userEmail" => $userEmail,
								"accessRight" => $accessRights,
								"accessModules" => $accessModules,
								"lastLogin" => $lastLogin,
								"regTime" => $regTime,
								"addedBy" => $addedBy,
								"isSu" => $isSu
								);

	return true;

	}

	public function getSinginUserInfo($key = "auth") {
		return isset($this->loginInfo[$key]) ? $this->loginInfo[$key] : false;
	}

	public function checkAccessToModule($moduleDir, $lang = 'ru') {
		if (@$this->loginInfo['isSu'] === true) return true;
		if ((int)@$this->loginInfo['accessRight'] === 1) return true;
		if (isset($this->loginInfo['accessModules']) && is_array($this->loginInfo['accessModules']) && array_search($moduleDir.":".$lang, $this->loginInfo['accessModules'], true) !== false) {
			return true;
		}
		return false;
	}

	public function clearAuth() {
		$this->loginInfo = array();
	}

	function __construct() {
		global $_SESSION;
		if (!isset($_SESSION['auth'])) {
			$_SESSION['auth'] = array();
		}

		$this->loginInfo = &$_SESSION['auth'];
		//var_dump($this->loginInfo);
	}

}
?>