<?php
$page_title = "Add Book";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Add Book</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-add" method="post" action="process_add.php">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
        </div>
        <div>
            <label for="author">Author</label>
            <input type="text" id="author" name="author">
        </div>
        <div>
            <label for="year">Year</label>
            <input type="number" id="year" name="year">
        </div>
        <div>
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn">
        </div>
        <div>
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock">
        </div>
        <div>
            <label for="category">Category</label>
            <input type="text" id="category" name="category">
        </div>
        <button type="submit">Save</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>