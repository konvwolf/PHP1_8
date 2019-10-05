<?php
if (!empty($productHURL)) {
    $description = getSQLdata(
        PRODUCTS,
        PRODUCTS . '.id, prod_brand, prod_name, prod_desc, prod_price, '.PHOTOS.'.file_name, '.PHOTOS.'.image_name',
        'JOIN '.PHOTOS.' ON '.PRODUCTS.'.id = '.PHOTOS.'.prod_id AND '.PRODUCTS.'.prod_hurl = '.'\''.$productHURL.'\''
    );
    
    $picturesArr = []; // массив с картинками продукта
    foreach ($description as $val) {
        array_push($picturesArr, $val['file_name']);
    }

    $characteristics = json_decode($description[0]['prod_desc']);

    $comments = getSQLdata(
        COMMENTS,
        'user_name, user_comment, comment_time',
        'WHERE prod_name = ' . '\'' . $productHURL . '\''
    );
}
?>
<!-- Страница с подробным описанием товара -->
<section class="product_description">
    <?php if (!empty($productHURL)): ?>
        <a href="/">На главную</a>
        <div class="product_images">
            <?php foreach ($picturesArr as $fileName): ?>
                <img src="/public/img/<?= $fileName ?>" alt="<?= $fileName ?>" onmouseover="this.style='transform: scale(1.1);'" onmouseout="this.style='transform: scale(1)'">
            <?php endforeach; ?>
        </div>
        <div class="full_description" data-id="<?= $description[0]['id'] ?>">
            <h2 class="product_brand"><?= $description[0]['prod_brand'] ?></h1>
            <h2 class="product_name"><?= $description[0]['prod_name'] ?></h2>
            <ul class="product_characteristics">
                <?php foreach ($characteristics as $key => $charcs): ?>
                    <li>
                        <b><?= $key ?></b>: <?= $charcs ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <i class="fas fa-ruble-sign"></i> <span class="product_price product_descr_price"><?= $description[0]['prod_price'] ?></span>
            <a class="to_cart"><i class="fas fa-shopping-basket"></i></a>
        </div>
        <?php foreach ($comments as $comment): ?>
                <div class="user_comment">
                    <div class="comment_date"><?= $comment['comment_time'] ?></div>
                    <div class="user_name"><?= $comment['user_name'] ?></div>
                    <div class="comment_text"><?= $comment['user_comment'] ?></div>
                </div>
        <?php endforeach; ?>
        <?php if (isset($_SESSION['login']) && isset($_SESSION['logged'])): ?>
            <form method="post" action="/comment/" class="comments_form">
                <input type="hidden" name="name" class="name" value="<?= $_SESSION['login'] ?>">
                <input type="hidden" name="prod_name" class="prod_name" value="<?= $productHURL ?>">
                <textarea name="comm" class="comment" placeholder="Напишите комментарий"></textarea>
                <button type="submit" class="comments_button">Отправить</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($productHURL)): ?>
        <ul class="prod_list_cover">
            <li><a href="/">На главную</a></li>
            <h1 class="prod_h1_cover">Вот, что у нас есть:</h1>
            <?php foreach (getSQLdata (PRODUCTS, 'prod_name, prod_hurl', 'ORDER BY id DESC LIMIT 10') as $prods): ?>
                <li><a href="/product/<?= $prods['prod_hurl'] ?>/"><?= $prods['prod_name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>