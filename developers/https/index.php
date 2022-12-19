<?php

require "bootstrap.php";

// check if uploadPath is writable
if (!is_writable($config['uploadPath'])) {
    throw new \RuntimeException(sprintf('"%s" must be writable', $config['uploadPath']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors  = [];
    $success = false;

    if (!$domain = Validator::domain($_POST['domain'])) {
        $errors['domain'] = 'Должен быть указан правильный домен вида example.com';
    } else {
        $_POST['domain'] = $domain;
    }

    if (empty($errors)) {

        // check file uploading
        if (($certFile = Validator::uploadFile('certFile', $config)) !== true) {
            $errors['certFile'] = $certFile;
        } elseif (($privateFile = Validator::uploadFile('privateFile', $config)) !== true) {
            $errors['privateFile'] = $privateFile;
        }

        if (empty($errors)) {
            $domainDir   = $config['uploadPath'] . '/' . $domain .'_tmp';
            $certFile    = $domainDir . '/' . basename($_FILES['certFile']['name']);
            $privateFile = $domainDir . '/' . basename($_FILES['privateFile']['name']);

            if (!is_writable($domainDir)
                && !mkdir($domainDir)
                && !is_dir($domainDir)) {
                throw new \RuntimeException(sprintf('Директория "%s" не была создана', $domainDir));
            }

            if (!is_uploaded_file($_FILES['certFile']['tmp_name']) || !move_uploaded_file($_FILES['certFile']['tmp_name'],
                    $certFile)) {
                $errors['certFile'] = 'Файл не был перемещен в нужную директорию. Обратитесь к разработчикам';
                //error_log(sprintf('Файл "%s" не был перемещён в нужную директорию', $certFile), 3, 'logs/errors.log');
            }

            if (!is_uploaded_file($_FILES['privateFile']['tmp_name']) || !move_uploaded_file($_FILES['privateFile']['tmp_name'],
                    $privateFile)) {
                $errors['privateFile'] = 'Файл не был перемещен в нужную директорию. Обратитесь к разработчикам';
                //error_log(sprintf('Файл "%s" не был перемещён в нужную директорию', $privateFile), 3, 'logs/errors.log');
            }

            if (!empty($errors)) {
                // прибираем за собой
                array_map('unlink', glob("$domainDir/*.*"));
                rmdir($domainDir);
            } else {
                // переименовываем директорию из временной в постоянную
                rename($domainDir, $config['uploadPath'] . '/' . $domain);

                // говорим, что всё прекрасно
                header('Location: /index.php?success=true');
                exit();
            }
        }
    }
}

require 'views/index.view.php';
