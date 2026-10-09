<?php
$page_title = "Home";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/connection.php';

$totalBuku = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
?>

<section>
    <h2>Welcome to the Mini Library System</h2>
    <p>A simple application for managing library book and member data.</p>
</section>

<section>
    <h2>Summary</h2>
    <article>
        <h3>Total Books</h3>
        <p><?php echo $totalBuku; ?></p>
    </article>
    <article>
        <h3>Total Members</h3>
        <p><?php echo $totalAnggota; ?></p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>