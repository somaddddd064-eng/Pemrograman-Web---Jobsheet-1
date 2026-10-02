<?php
$page_title = "Member List";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarMembers = $_SESSION['members'] ?? [];
?>

<section>
    <h2>Member List</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Search Member Name</label>
        <input type="text" id="search-input" placeholder="Type a member name...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Member No</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarMembers)): ?>
                    <tr>
                        <td colspan="5">No member data yet. Please add one via the "Add Member" menu.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarMembers as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['member_no']); ?></td>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['address']); ?></td>
                            <td><?php echo htmlspecialchars($member['phone_no']); ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-delete">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>