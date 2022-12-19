<?php

require 'bootstrap.php';

$config = require 'config.php';

/**
 * метод вывода на экран cli скрипта информации.
 * тут можно поменять на отправку куда-то во внешнюю систему
 *
 * @param $message
 *
 * @return void
 */
function verbose($message)
{
    echo "$message\n";
}

// getting all directories from "certs"
$nginxTemplate = $config['nginx']['configDirectory'] . '/' . $config['nginx']['templateConfig'];
$domains       = new DirectoryIterator($config['uploadPath']);
$newDomains    = [];

foreach ($domains as $domain) {
    // need to be directory, not 'dot' directory, and not ended with _tmp - php8 needed
    if ($domain->isDir() && !$domain->isDot() && !str_ends_with($domainName = $domain->getFilename(), '_tmp')) {

        verbose('working with domain: '. $domainName);

        // getting all files from directory
        $files = new FilesystemIterator($config['uploadPath'] . '/' . $domainName);

        $certFileExtension    = null;
        $privateFileExtension = null;

        foreach ($files as $file) {
            $extension = $file->getExtension();

            // maybe it is cert file?
            if (in_array('.' . $extension, $config['certFile']['extension'], true)) {
                $certFileExtension = '.' . $extension;
                // maybe it is key file?
            } elseif (in_array('.' . $extension, $config['privateFile']['extension'], true)) {
                $privateFileExtension = '.' . $extension;
            }

            // copy files
            $fileFrom = $file->getPathInfo() . '/' . $file->getFilename();
            $fileTo   = $config['nginx']['sslDirectory'] . '/' . $domainName . '.' . $extension;

            copy($fileFrom, $fileTo);

            verbose("copy: $fileFrom --> $fileTo");
        }

        if (is_file($nginxTemplate)) {
            $template = file_get_contents($nginxTemplate);

            $filledTemplate = str_replace(
                ['[domain]', '[cert]', '[key]'],
                [$domainName, $domainName . $certFileExtension, $domainName . $privateFileExtension],
                $template
            );

            file_put_contents($config['nginx']['configDirectory'] . '/' . $domainName . '.conf', $filledTemplate);

            verbose("New config file for $domainName created\n");
        }

        $newDomains[] = $domainName;
    }
}

$newDomainsCnt = count($newDomains);

verbose("New domains: $newDomainsCnt");

if (count($newDomains) > 0) {
    // check configs
    $checkNginx = exec($config['nginx']['checkCommand'], $checkNginxOutput, $checkNginxCode);
//    $checkNginx     = true;
//    $checkNginxCode = 0;

    // there php8 needed too
    if ($checkNginx && $checkNginxCode === 0) {
        verbose("Check nginx config: ok");

        // restart nginx
        $restartNginx = exec($config['nginx']['restartCommand'], $restartNginxOutput, $restartNginxCode);
//        $restartNginx     = true;
//        $restartNginxCode = 0;

        if ($restartNginx && $restartNginxCode === 0) {
            verbose("Reload nginx: ok");

            // прибираем за собой
            foreach ($newDomains as $domainName) {
                array_map('unlink', glob($config['uploadPath'] . '/' . $domainName . '/*.*'));
                rmdir($config['uploadPath'] . '/' . $domainName);

                verbose("$domainName uploaded certs deleted");
            }

            verbose("\nEverything is well done!");

            // выходим с "положительным" результатом
            exit(0);
        }

        verbose("Reload nginx: fail. ALARM!!!");

        // тут происходит что-то что триггерит админа. смс, телеграм, автоматический звонок...
        // но ничего удалять не нужно, так как вроде бы проверили
        exit(-1);
    }

    verbose("Check nginx config: fail");

    // something goes wrong and revert all work
    foreach ($newDomains as $domainName) {
        // remove conf file for domain
        unlink($config['nginx']['configDirectory'] .'/'. $domainName .'.conf');
        verbose("Remove nginx config: $domainName.conf");

        // get all ssl files
        $sslFiles = new FilesystemIterator($config['nginx']['sslDirectory']);

        foreach ($sslFiles as $sslFile) {
            // find our domains files and remove
            if (str_starts_with($sslFile->getFilename(), $domainName)) {
                verbose("Remove ssl file: ". $sslFile->getFilename());
                unlink($config['nginx']['sslDirectory'] .'/'. $sslFile->getFilename());
            }
        }
    }

    exit(-1);
}