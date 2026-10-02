<?php
$page_title = "Add Member";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Add Member</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-add" method="post" action="process_add.php">
        <div>
            <label for="member_no">Member No</label>
            <input type="text" id="member_no" name="member_no">
        </div>
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="address">Address</label>
            <input type="text" id="address" name="address">
        </div>
        <div>
            <label for="phone_no">Phone No</label>
            <input type="text" id="phone_no" name="phone_no">
        </div>
        <button type="submit">Save</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>