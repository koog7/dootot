<?php
// Проверяем, что форма была отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Проверяем, что обязательные поля не пустые
  $requiredFields = array('Organization', 'Phone', 'Email', 'link');
  $missingFields = array();
  foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
      $missingFields[] = $field;
    }
  }

  // Если есть пустые поля, возвращаем ошибку
  if (!empty($missingFields)) {
    $errorMessage = 'Пожалуйста, заполните все обязательные поля: ' . implode(', ', $missingFields);
    echo json_encode(array('error' => $errorMessage));
    exit;
  }

  // Если все поля заполнены, отправляем форму на почту
  $to = 'ognev_k@auca.kg';
  $subject = 'Запрос на добавление организации';
  $message = 'Организация: ' . $_POST['Organization'] . "\n";
  $message .= 'Номер телефона: ' . $_POST['Phone'] . "\n";
  $message .= 'Email: ' . $_POST['Email'] . "\n";
  $message .= 'Веб-сайт или ссылка на соц.сети: ' . $_POST['link'] . "\n";
  $headers = 'From: ' . $_POST['Email'] . "\r\n" .
    'Reply-To: ' . $_POST['Email'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

  if (mail($to, $subject, $message, $headers)) {
    echo json_encode(array('success' => 'Ваш запрос отправлен'));
    exit;
  } else {
    echo json_encode(array('error' => 'Произошла ошибка, попробуйте позже'));
    exit;
  }
}
