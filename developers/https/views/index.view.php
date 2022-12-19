<?php require "partials/header.view.php"; ?>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:col-span-2 md:mt-0">

                    <?php if (isset($_GET['success'])) : ?>
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg"
                             role="alert">
                            <span class="font-medium">Файлы добавлены в систему!</span> В скором времени мы обновим
                            сервера и всё заработает! Вы можете продолжить добавлять сертификаты для других доменов
                        </div>
                    <?php endif; ?>

                    <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg"
                         role="alert">
                        Все поля должны быть заполнены
                    </div>

                    <form action="/" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $config['uploadMaxFilesize'] ?>">
                        <div class="shadow sm:overflow-hidden sm:rounded-md">
                            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                                <div>
                                    <label for="domain"
                                           class="block mb-2 text-sm font-medium text-gray-900 <?= isset($errors['domain']) ? 'text-red-500' : '' ?>">Домен</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">https://</span>
                                        <input type="text" name="domain" id="domain"
                                               class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                               placeholder="example.com" value="<?= $_POST['domain'] ?? '' ?>"
                                               required>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500" id="cert-file-help">пример:
                                        example.com</p>
                                    <p class="mt-1 text-sm text-gray-500" id="cert-file-help"><span class="font-medium">Внимание!</span>
                                        поддерживаются только англоязычные домены</p>

                                    <?php if (isset($errors['domain'])) : ?>
                                        <p class="text-red-500 text-xs mt-2">
                                            <?= $errors['domain'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 <?= isset($errors['certFile']) ? 'text-red-500' : '' ?>"
                                           for="certFile">Файл
                                        сертификата</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                           aria-describedby="certFile-help" type="file" id="certFile"
                                           name="certFile"
                                           required
                                           accept="<?= implode(', ', $config['certFile']['extension']) ?>"
                                    >
                                    <p class="mt-1 text-sm text-gray-500" id="certFile-help">файл с одним из
                                        расширений: <?= implode(', ', $config['certFile']['extension']) ?></p>
                                    <p class="mt-1 text-sm text-gray-500">максимальный размер файла должен быть не
                                        более <?= $config['uploadMaxFilesize'] ?> килобайт</p>

                                    <?php if (isset($errors['certFile'])) : ?>
                                        <p class="text-red-500 text-xs mt-2">
                                            <?= $errors['certFile'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 <?= isset($errors['privateFile']) ? 'text-red-500' : '' ?>"
                                           for="private-file">Private
                                        файл</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                           aria-describedby="private-file-help" type="file" id="private-file"
                                           name="privateFile"
                                           required
                                           accept="<?= implode(', ', $config['privateFile']['extension']) ?>">
                                    <p class="mt-1 text-sm text-gray-500" id="private-file-help">файл с расширением
                                        <?= implode(', ', $config['privateFile']['extension']) ?></p>
                                    <p class="mt-1 text-sm text-gray-500">максимальный размер файла должен быть не
                                        более <?= $config['uploadMaxFilesize'] ?> килобайт</p>

                                    <?php if (isset($errors['privateFile'])) : ?>
                                        <p class="text-red-500 text-xs mt-2">
                                            <?= $errors['privateFile'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

<?php require "partials/footer.view.php"; ?>