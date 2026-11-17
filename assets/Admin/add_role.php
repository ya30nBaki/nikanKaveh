<?php 
require_once 'config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '') {
        $error = 'نام نقش اجباری می باشد';
    } else {
        try {
            $sql = "INSERT INTO roles (name , description)
            VALUES (:name , :description)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description ?: null,
            ]);
            $message = 'نقش با موفقیت اضافه شد';
            $_POST = [];
        } catch (PDOException $e) {
            if ($e->getcode() == 23000) {
                $error = 'این نقش قبلا ثبت شد است';
            } else {
                $error = 'خطا در ثبت :' . $e->getMessage();     
            }
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن نقش</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Tahoma, sans-serif; }
        body { background: #f4f6f9; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #1e293b; padding: 20px 0; flex-shrink: 0; }
        .sidebar h2 { color: #38bdf8; font-size: 16px; text-align: center; margin-bottom: 20px; }
        .sidebar ul { list-style: none; }
        .sidebar ul li a { display: block; padding: 12px 20px; text-decoration: none; color: #cbd5e1; font-size: 14px; transition: 0.2s; }
        .sidebar ul li a:hover { background: #334155; color: #fff; border-right: 4px solid #38bdf8; }
        .main { flex: 1; padding: 30px; max-width: 700px; margin: 0 auto; }
        h1 { font-size: 22px; margin-bottom: 20px; color: #1e293b; }
        .form-box { background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
        label { display: block; margin-bottom: 6px; font-size: 14px; color: #475569; }
        input, textarea {
            width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1;
            border-radius: 8px; font-size: 14px; margin-bottom: 16px;
            font-family: inherit; resize: vertical;
        }
        input:focus, textarea:focus { outline: none; border-color: #38bdf8; }
        button { background: #0284c7; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; cursor: pointer; transition: 0.2s; }
        button:hover { background: #0369a1; }
        .msg { padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .msg-success { background: #dcfce7; color: #166534; }
        .msg-error   { background: #fee2e2; color: #991b1b; }
        .back-link { display: inline-block; margin-top: 16px; color: #0284c7; text-decoration: none; font-size: 14px; }
        .back-link:hover { text-decoration: underline; }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar ul { display: flex; flex-wrap: wrap; justify-content: center; }
            .main { padding: 20px 15px; }
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
        <h1>افزودن نقش جدید</h1>

        <div class="form-box">
            <?php if ($message): ?>
                <div class="msg msg-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <label>نام نقش *</label>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

                <label>توضیحات</label>
                <textarea name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

                <button type="submit">ثبت نقش</button>
            </form>

            <a href="roles.php" class="back-link">← برگشت به لیست نقش‌ها</a>
        </div>
    </div>

</body>
</html>