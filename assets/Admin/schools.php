<?php
require_once 'config.php';
$sql = "SELECT s.id, s.name, s.address, s.phone, s.email,
(SELECT COUNT(*) FROM users u WHERE u.school_id = s.id) AS user_count
FROM schools s 
ORDER BY s.id DESC";
$schools = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدارس</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Tahoma, sans-serif; }
        body { background: #f4f6f9; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #1e293b; padding: 20px 0; flex-shrink: 0; }
        .sidebar h2 { color: #38bdf8; font-size: 16px; text-align: center; margin-bottom: 20px; }
        .sidebar ul { list-style: none; }
        .sidebar ul li a { display: block; padding: 12px 20px; text-decoration: none; color: #cbd5e1; font-size: 14px; transition: 0.2s; }
        .sidebar ul li a:hover { background: #334155; color: #fff; border-right: 4px solid #38bdf8; }
        .main { flex: 1; padding: 30px; max-width: 1000px; margin: 0 auto; }
        h1 { font-size: 22px; margin-bottom: 20px; color: #1e293b; }
        .btn-add {
            display: inline-block; background: #0284c7; color: #fff;
            padding: 8px 16px; border-radius: 8px; text-decoration: none;
            font-size: 14px; margin-bottom: 12px; transition: 0.2s;
        }
        .btn-add:hover { background: #0369a1; }
        table {
            width: 100%; border-collapse: collapse; background: #fff;
            border-radius: 10px; overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06); font-size: 14px;
        }
        th, td { padding: 12px 14px; text-align: right; border-bottom: 1px solid #eef2f6; }
        th { background: #f8fafc; color: #475569; font-weight: bold; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }
        .empty { text-align: center; color: #94a3b8; padding: 20px; }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar ul { display: flex; flex-wrap: wrap; justify-content: center; }
            .main { padding: 20px 15px; }
            table { font-size: 12px; }
            th, td { padding: 8px 6px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>پنل مدیریت</h2>
        <ul>
            <li><a href="panel.php">داشبورد</a></li>
            <li><a href="add_user.php">کاربران</a></li>
            <li><a href="schools.php">مدارس</a></li>
            <li><a href="roles.php">نقش‌ها</a></li>
            <li><a href="#">تنظیمات</a></li>
            <li><a href="#">خروج</a></li>
        </ul>
    </div>

    <div class="main">
        <h1>مدارس</h1>
        <a href="add_school.php" class="btn-add">➕ افزودن مدرسه</a>

        <table>
            <tr>
                <th>نام مدرسه</th>
                <th>آدرس</th>
                <th>تلفن</th>
                <th>ایمیل</th>
                <th>تعداد کاربران</th>
            </tr>
                <?php if (count($schools) > 0): ?>
                    <?php $i = 1; foreach ($schools as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['name']) ?></td>
                            <td><?= htmlspecialchars($s['address'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($s['phone'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($s['email'] ?? '-') ?></td>
                            <td><?= $s['user_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty">هیچ مدرسه ای ثبت نشده است</td>
                    </tr>
                <?php endif; ?>
        </table>
    </div>

</body>
</html>