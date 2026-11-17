<?php
require_once 'config.php';
$sql = "SELECT u.id, u.name, u.email, u.phone, u.status, u.created_at, s.name AS school_name,
r.name AS role_name FROM users u 
LEFT JOIN schools s on u.school_id = s.id
LEFT JOIN roles r on u.role_id = r.id
ORDER BY u.created_at DESC
LIMIT 5";
$result = $conn->query($sql);

if (!$result) {
    die("خطا در کوئری: " . implode(", ", $conn->errorInfo()));
}
function statusLabel($status) {
    switch ($status) {
        case 'active':   return ['فعال', 'active'];
        case 'inactive': return ['غیرفعال', 'inactive'];
        case 'blocked':  return ['مسدود', 'blocked'];
        default:         return [$status, ''];
    }
}
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
$totalusers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Tahoma, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: #1e293b;
            padding: 20px 0;
            flex-shrink: 0;
        }

        .sidebar h2 {
            color: #38bdf8;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
            padding: 0 10px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #cbd5e1;
            font-size: 14px;
            transition: 0.2s;
        }

        .sidebar ul li a:hover {
            background: #334155;
            color: #fff;
            border-right: 4px solid #38bdf8;
        }
        .main {
            flex: 1;
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto; 
        }

        h1 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #1e293b;
        }

        h2 {
            font-size: 16px;
            margin: 25px 0 12px;
            color: #475569;
            border-right: 4px solid #38bdf8;
            padding-right: 10px;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .stats p {
            background: #fff;
            padding: 14px 18px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            font-size: 14px;
            color: #475569;
            flex: 1;
            min-width: 150px;
        }

        .stats p strong {
            display: block;
            margin-top: 6px;
            font-size: 20px;
            color: #1e293b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            font-size: 14px;
        }

        th, td {
            padding: 12px 14px;
            text-align: right;
            border-bottom: 1px solid #eef2f6;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-weight: bold;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .active {
            color: #16a34a;
            font-weight: bold;
        }

        .inactive {
            color: #dc2626;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .sidebar ul li a {
                padding: 10px 14px;
            }
            .main {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

    <!-- سایدبار -->
    <div class="sidebar">
        <h2>پنل مدیریت</h2>
        <ul>
            <li><a href="panel.php">داشبورد</a></li>
            <li><a href="users.php">کاربران</a></li>
            <li><a href="schools.php">مدارس</a></li>
            <li><a href="roles.php">نقش ها</a></li>
            <li><a href="#">تنظیمات</a></li>
            <li><a href="#">خروج</a></li>
        </ul>
    </div>
    <div class="main">
        <h1>داشبورد</h1>

        <!-- آمار -->
        <h2>آمار</h2>
        <div class="stats">
            <p>کل کاربران<strong><?= $totalusers ?></strong></p>
            <p>تیکت‌های باز<strong>0</strong></p>
        </div>
        <h2>آخرین کاربران</h2>
        <table>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>ایمیل</th>
                <th>موبایل</th>
                <th>مدرسه</th>
                <th>نقش</th>
                <th>وضعیت</th>
                <th>تاریخ ثبت</th>
            </tr>

           <?php if (count($rows) > 0): ?>
    <?php $i = 1; foreach ($rows as $row): ?>
        <?php 
        $st = statusLabel($row["status"]); 
        $label = $st[0]; 
        $class = $st[1]; 
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['phone'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['school_name'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['role_name'] ?? '-') ?></td>
            <td class="<?= $class ?>"><?= $label ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="empty">هیچ کاربری ثبت نشده است</td>
    </tr>
<?php endif; ?>    
        </table>
    </div>

</body>
</html>
