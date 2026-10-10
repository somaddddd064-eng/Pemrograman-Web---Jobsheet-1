<?php
$page_title = "Edit Member";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/connection.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM members WHERE id = :id");
$stmt->execute(['id' => $id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Member</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form method="post" action="process_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($member['id']); ?>">
        
        <p>
            <label for="member_no">Member No / ID *</label><br>
            <input type="text" id="member_no" name="member_no" value="<?php echo htmlspecialchars($member['member_id']); ?>" required>
        </p>
        <p>
            <label for="name">Full Name *</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
        </p>
        <p>
            <label for="address">Address *</label><br>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($member['address']); ?></textarea>
        </p>
        <p>
            <label for="phone_no">Phone No</label><br>
            <input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($member['phone'] ?? ''); ?>">
        </p>
        <p>
            <button type="submit">Save Changes</button>
            <a href="list.php">Cancel</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>