<?php
/**
 * KRYEFAQJA (Homepage)
 * ====================
 * Faqja kryesore e platformës.
 */

// Nis aplikacionin - ngarko konfigurimet dhe klasat
require_once __DIR__ . '/includes/init.php';

$pageTitle = SITE_NAME . ' - Platformë Web E-Commerce';
require_once __DIR__ . '/views/partials/header.php';

$productObj = new Product();
$db = Database::getInstance();

// Produktet e fundit
$latestProducts = $productObj->getAllProducts(1, 8);
$categories = $productObj->getAllCategories();

// Produktet në ofertë (me sale_price)
$saleProducts = $db->fetchAll(
    "SELECT * FROM products WHERE sale_price IS NOT NULL AND is_active = 1 ORDER BY RAND() LIMIT 4"
);
?>

<!-- Hero Section -->
<section class="bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-4 fade-in">
                    Mirësevjen në <br><?= SITE_NAME ?>
                </h1>
                <p class="lead mb-4 opacity-75">
                    Platformë moderne e-commerce me të gjitha funksionalitetet:
                    regjistrimi, login, profili, shporta, pagesa online dhe shumë më tepër.
                </p>
                <div class="d-flex gap-3">
                    <a href="views/products.php" class="btn btn-light btn-lg">
                        <i class="bi bi-bag me-2"></i>Shfleto Produktet
                    </a>
                    <?php if (!isLoggedIn()): ?>
                        <a href="views/auth/register.php" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Regjistrohu
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://via.placeholder.com/500x400/ffffff/0d6efd?text=E-Commerce"
                     alt="Hero"
                     class="img-fluid rounded shadow fade-in"
                     style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-truck text-primary fs-3"></i>
                    </div>
                    <h6>Transport Falas</h6>
                    <p class="text-muted small mb-0">Mbi porosi 50€</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-shield-check text-primary fs-3"></i>
                    </div>
                    <h6>Pagesa e Sigurt</h6>
                    <p class="text-muted small mb-0">SSL e enkriptuar</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-arrow-repeat text-primary fs-3"></i>
                    </div>
                    <h6>Kthim i Lehtë</h6>
                    <p class="text-muted small mb-0">30 ditë garanci</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-headset text-primary fs-3"></i>
                    </div>
                    <h6>Support 24/7</h6>
                    <p class="text-muted small mb-0">Ndihmë e dedikuar</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<?php if (!empty($categories)): ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Shfleto sipas Kategorisë</h2>
            <p class="text-muted">Gjej produktet që të duhen</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($categories, 0, 6) as $category): ?>
                <div class="col-md-4 col-sm-6">
                    <a href="views/products.php?category=<?= $category['id'] ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body text-center py-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-tag text-primary fs-2"></i>
                                </div>
                                <h5 class="card-title"><?= htmlspecialchars($category['name']) ?></h5>
                                <p class="text-muted mb-0"><?= $category['product_count'] ?> produkte</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Produktet e Reja</h2>
                <p class="text-muted mb-0">Shiko produktet më të fundit</p>
            </div>
            <a href="views/products.php" class="btn btn-outline-primary">
                Shiko të gjitha <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <?php if (empty($latestProducts['products'])): ?>
            <div class="text-center py-5">
                <i class="bi bi-box-seam display-4 text-muted"></i>
                <p class="text-muted mt-3">Ende nuk ka produkte. Vizito më vonë!</p>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($latestProducts['products'] as $product): ?>
                    <div class="col">
                        <div class="card product-card h-100">
                            <?php if ($product['sale_price']): ?>
                                <span class="badge badge-sale bg-danger">Ofertë</span>
                            <?php endif; ?>
                            <a href="views/product-detail.php?slug=<?= $product['slug'] ?>">
                                <img src="<?= SITE_URL ?>/assets/images/uploads/<?= $product['image'] ?? 'products/default.png' ?>"
                                     class="card-img-top"
                                     alt="<?= htmlspecialchars($product['name']) ?>">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title text-truncate">
                                    <a href="views/product-detail.php?slug=<?= $product['slug'] ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h6>
                                <div>
                                    <?php if ($product['sale_price']): ?>
                                        <span class="price"><?= formatPrice($product['sale_price']) ?></span>
                                        <span class="old-price ms-2"><?= formatPrice($product['price']) ?></span>
                                    <?php else: ?>
                                        <span class="price"><?= formatPrice($product['price']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <button class="btn btn-primary w-100 add-to-cart"
                                        data-product-id="<?= $product['id'] ?>">
                                    <i class="bi bi-cart-plus me-2"></i>Shto
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Regjistrohu Sot!</h2>
        <p class="lead mb-4 opacity-75">
            Krijo një llogari falas dhe fillo të blesh me ne.
            Përfito oferta ekskluzive dhe transport falas!
        </p>
        <?php if (!isLoggedIn()): ?>
            <a href="views/auth/register.php" class="btn btn-light btn-lg">
                <i class="bi bi-person-plus me-2"></i>Krijo Llogari Falas
            </a>
        <?php else: ?>
            <a href="views/products.php" class="btn btn-light btn-lg">
                <i class="bi bi-bag me-2"></i>Shfleto Produktet
            </a>
        <?php endif; ?>
    </div>
</section>

<script>
window.SITE_URL = '<?= SITE_URL ?>';
window.CSRF_TOKEN = '<?= generateCSRFToken() ?>';
</script>

<style>
.hover-lift {
    transition: transform 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
}
.min-vh-50 {
    min-height: 50vh;
}
</style>

<?php require_once __DIR__ . '/views/partials/footer.php'; ?>
