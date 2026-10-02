<?php
$page_title = "Home";
include __DIR__ . '/includes/header.php';

$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['members'] ?? []);
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