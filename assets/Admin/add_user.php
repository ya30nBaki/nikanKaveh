<?php 
require_once 'config.php';

$message = '';
$error = '';

$schools = $conn->query("SELECT id, name FROM schools ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$roles = $conn->query("SELECT id, name FROM roles ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $school_id = $_POST['school_id'] ?? '';
    $role_id = $_POST['role_id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $status = $_POST['status'] ?? 'active';
    
    if($school_id === '' || $role_id === '' || $name === '' || $password === '') {
        $error = 'لطفا فیلد های اجباری را پر کنید';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO users (school_id, role_id, name, email, phone, password, status) 
            VALUES (:school_id, :role_id, :name , :email , :phone, :password, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':school_id' => $school_id,
                ':role_id' => $role_id,
                ':name' => $name,
                ':email' => $email ?: null,
                ':phone' => $phone ?: null,
                ':password' => $hashed,
                ':status' => $status,
            ]);
            $message = 'کاربر با موفیقت اضافه شد';
            $_POST = [];
        } catch (PDOException $e) {
            if($e->getcode() == 23000) {
                $error = 'این ایمیل ثبلا ثبت شده است';
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
    <title>افزودن کاربر</title>
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
        }
        .sidebar ul { list-style: none; }
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
            max-width: 700px;
            margin: 0 auto;
        }
        h1 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .form-box {
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #475569;
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
            font-family: inherit;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #38bdf8;
        }
        button {
            background: #0284c7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }
        button:hover {
            background: #0369a1;
        }
        .msg {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .msg-success { background: #dcfce7; color: #166534; }
        .msg-error   { background: #fee2e2; color: #991b1b; }
        .back-link {
            display: inline-block;
            margin-top: 16px;
            color: #0284c7;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover { text-decoration: underline; }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
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
        <h1>افزودن کاربر جدید</h1>

        <div class="form-box">
            <?php if ($message): ?>
                <div class="msg msg-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <label>مدرسه *</label>
                <select name="school_id" required>
                    <option value="">— انتخاب مدرسه —</option>
                    <?php foreach ($schools as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= ($_POST['school_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>نقش *</label>
                <select name="role_id" required>
                    <option value="">— انتخاب نقش —</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= ($_POST['role_id'] ?? '') == $r['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>نام و نام خانوادگی *</label>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

                <label>ایمیل</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

                <label>موبایل</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

                <label>رمز عبور *</label>
                <input type="password" name="password" required>

                <label>وضعیت</label>
                <select name="status">
                    <option value="active" <?= ($_POST['status'] ?? '') === 'active' ? 'selected' : '' ?>>فعال</option>
                    <option value="inactive" <?= ($_POST['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>غیرفعال</option>
                    <option value="blocked" <?= ($_POST['status'] ?? '') === 'blocked' ? 'selected' : '' ?>>مسدود</option>
                </select>

                <button type="submit">ثبت کاربر</button>
            </form>

            <a href="panel.php" class="back-link">← برگشت به داشبورد</a>
        </div>
    </div>

</body>
</html>