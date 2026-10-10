<?php
$page_title = "Member List";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/connection.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM members WHERE name ILIKE :kw OR member_id ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM members WHERE name ILIKE :kw OR member_id ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM members ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
    <h2>Member List</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box" style="margin-bottom: 1rem;">
        <form method="get" action="list.php">
            <label for="search-input">Search Member Name/ID:</label><br>
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
                        <td colspan="5">No member data found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarMembers as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['address']); ?></td>
                            <td><?php echo htmlspecialchars($member['phone'] ?? '-'); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $member['id']; ?>" class="btn-edit">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

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