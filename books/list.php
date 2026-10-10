<?php
$page_title = "Book List";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/connection.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Konfigurasi Pagination & Search
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM books WHERE title ILIKE :kw OR author ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM books WHERE title ILIKE :kw OR author ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
    <h2>Book List</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <!-- Form Pencarian Server-Side -->
    <div class="search-box" style="margin-bottom: 1rem;">
        <form method="get" action="list.php">
            <label for="search-input">Search Book Title/Author:</label><br>
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Type keyword...">
            <button type="submit">Search</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="6">No book data found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($buku['title']); ?></td>
                            <td><?php echo htmlspecialchars($buku['author']); ?></td>
                            <td><?php echo htmlspecialchars($buku['year']); ?></td>
                            <td><?php echo htmlspecialchars($buku['stock']); ?></td>
                            <td><?php echo htmlspecialchars($buku['category'] ?? '-'); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Navigasi Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="pagination" style="margin-top: 1rem;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>