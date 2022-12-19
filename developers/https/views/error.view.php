<?php require "partials/header.view.php"; ?>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:col-span-2 md:mt-0">

                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"
                         role="alert">
                        <span class="font-medium">Ошибка на сервере!</span> Мы уже оповещены о ней, и принимаем меры по
                        её устранению.
                    </div>

                    <?php if ($config['environment'] === 'development') : ?>
                        <code class="text-sm block whitespace-pre overflow-x-scroll"><?= $message ?></code>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>


<?php require "partials/footer.view.php"; ?>