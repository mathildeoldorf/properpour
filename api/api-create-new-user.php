<?php
if ($_POST) {

  require_once(__DIR__ . '/../components/functions.php');

  if (empty($_POST['inputEmail'])) {
  }
  if (!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['inputName'])) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['inputLastName'])) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (empty($_POST['inputPhone'])) {
    sendErrorMessage('phone is empty', __LINE__);
  }

  if (empty($_POST['inputAddress'])) {
    sendErrorMessage('address is empty', __LINE__);
  }

  if (strlen($_POST['inputAddress']) < 10) {
    sendErrorMessage('must be more than 10 characters', __LINE__);
  }

  if (empty($_POST['inputLoginName'])) {
    sendErrorMessage('login is empty', __LINE__);
  }

  if (strlen($_POST['inputLoginName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputLoginName']) > 255) {
    sendErrorMessage('email is too long', __LINE__);
  }

  if (strlen($_POST['inputLastName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputLastName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['password_1'])) {
    sendErrorMessage('password is empty', __LINE__);
  }
  if (strlen($_POST['inputPhone']) !== 8) {
    sendErrorMessage('phone must be 8 characters', __LINE__);
  }

  if (strlen($_POST['password_1']) < 8) {
    sendErrorMessage('password length is too small', __LINE__);
  }

  if (empty($_POST['password_2'])) {
    sendErrorMessage('password is empty', __LINE__);
  }

  if (empty($_POST['cityInput'])) {
    sendErrorMessage('city is empty', __LINE__);
  }

  if (strlen($_POST['password_2']) < 8) {
    sendErrorMessage('password too short', __LINE__);
  }

  if($_POST['password_2'] !== $_POST['password_1']){
    sendErrorMessage('pasword not a match', __LINE__);
  }

  if (strlen($_POST['password_1']) != strlen($_POST['password_2'])) {
    sendErrorMessage('passwords do not match', __LINE__);
  }

  $passwordLoggedUser = $_POST['password_1'];
  $emailInput = $_POST['inputEmail'];

  require_once(__DIR__ . '/../connection.php');

  $sqlCheckUser = "SELECT * FROM tuser WHERE dDeleteUser IS NULL AND cEmail = :emailCheckUser OR cUsername = :usernameCheckUser";
  $statementCheckUser = $connection->prepare($sqlCheckUser);

    $dataCheckUser = [
      ':emailCheckUser' => $emailInput,
      ':usernameCheckUser' => $emailInput
    ];

      if ($statementCheckUser->execute($dataCheckUser)) {
        $user = $statementCheckUser->fetchAll(PDO::FETCH_ASSOC);
        // echo json_encode($user);

        if(empty($user)){

          $sql = "INSERT INTO tuser(cName, cSurname, cEmail, cUserName, cPassword, cAddress, nCityID, cPhoneNo) VALUES (:name, :surname, :email, :username, :password, :address, :cityID, :phone)";

          $statement = $connection->prepare($sql);

          $data = [
            ':name' => $_POST['inputName'],
            ':surname' => $_POST['inputLastName'],
            ':email' => $emailInput,
            ':username' => $_POST['inputLoginName'],
            ':password' => $passwordLoggedUser,
            ':address' => $_POST['inputAddress'],
            ':phone' => $_POST['inputPhone'],
            ':cityID' => $_POST['cityInput']
          ];

          if ($statement->execute($data)) {
            // echo ;

                $dataLoggedUser = [
                ':emailLoggedUser' => $emailInput,
                ':usernameLoggedUser' => $emailInput
              ];

            $sqlLoggedUser = "SELECT * FROM tuser WHERE dDeleteUser IS NULL AND cEmail = :emailLoggedUser OR cUsername = :usernameLoggedUser";
            $statementLoggedUser = $connection->prepare($sqlLoggedUser);

            if($statementLoggedUser->execute($dataLoggedUser)){
              $loggedUser = $statementLoggedUser->fetch(PDO::FETCH_ASSOC);
              unset($loggedUser['cPassword']);
              session_start();
              $_SESSION['user'] = $loggedUser;
              echo 1;
              // echo json_encode($_SESSION['user']);
              $connection = null;
              exit;
            }
            else{
              echo 0;
              $connection = null;
              exit;
            }

          }

        }
        else{
          $connection = null;
          echo 0;
          // sendErrorMessage('User already exists', __LINE__);
        }

      }

$connection = null;
exit;

}
