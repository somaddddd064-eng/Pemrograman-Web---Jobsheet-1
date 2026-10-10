<?php
$page_title = "Edit Book";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/connection.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Book</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form method="post" action="process_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($buku['id']); ?>">
        
        <p>
            <label for="title">Title *</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($buku['title']); ?>" required>
        </p>
        <p>
            <label for="author">Author *</label><br>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($buku['author']); ?>" required>
        </p>
        <p>
            <label for="year">Year *</label><br>
            <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($buku['year']); ?>" required>
        </p>
        <p>
            <label for="isbn">ISBN</label><br>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">
        </p>
        <p>
            <label for="stock">Stock *</label><br>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($buku['stock']); ?>" required>
        </p>
        <p>
            <label for="category">Category</label><br>
            <select id="category" name="category">
                <?php foreach (['Fiksi' => 'Fiksi', 'Non-Fiksi' => 'Non-Fiksi', 'Referensi' => 'Referensi'] as $val => $label): ?>
                    <option value="<?php echo $val; ?>" <?php echo ($buku['category'] ?? '') === $val ? 'selected' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Save Changes</button>
            <a href="list.php">Cancel</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>