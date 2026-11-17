// هدر و فوتر سایت
// اینجا یه بار نوشتیمشون که توی همه صفحه ها یکی باشن
// هر صفحه ای که <div id="header"></div> و <div id="footer"></div> داشته باشه
// هدر و فوتر توش قرار میگیره


// ===== هدر =====
var header = `
<header class="header">
  <a href="index.html" class="logo">
    <img src="./assets/img/icons/white/book.svg" class="icon" alt="">
    <p>هنرستان <br>نیکان کاوه بناب</p>
  </a>

  <!-- منوی موبایل با چک باکس -->
  <input type="checkbox" id="menu-btn">

  <div class="menu">
    <!-- دکمه بستن منو (فقط توی موبایل دیده میشه) -->
    <label for="menu-btn" class="close-btn"><img src="./assets/img/icons/white/close.svg" class="icon" alt="بستن"></label>

    <ul class="nav">
      <li><a href="index.html"><img src="./assets/img/icons/white/home.svg" class="icon" alt=""> صفحه اصلی</a></li>
      <li><a href="about.html">معرفی مدرسه</a></li>
      <li><a href="reshte.html">رشته‌ها</a></li>
      <li><a href="elan.html">اطلاعیه‌ها</a></li>
      <li><a href="gallery.html">گالری</a></li>
      <li><a href="faq.html">سوالات متداول</a></li>
    </ul>

    <!-- دکمه های ورود و ثبت نام -->
    <div class="header-btns">
      <a href="login.html" class="btn-login"><img src="./assets/img/icons/white/user.svg" class="icon" alt=""> ورود</a>
      <a href="signup.html" class="btn-signup">ثبت‌نام</a>
    </div>
  </div>

  <a href="soon.html" class="search-btn"><img src="./assets/img/icons/white/search.svg" class="icon" alt="جستجو"></a>
  <label for="menu-btn" class="menu-icon"><img src="./assets/img/icons/white/menu.svg" class="icon" alt="منو"></label>

  <!-- پس زمینه تیره پشت منوی موبایل، با کلیک روش منو بسته میشه -->
  <label for="menu-btn" class="overlay"></label>
</header>
`;


// ===== فوتر =====
var footer = `
<footer class="footer">
  <div class="logo">
    <img src="./assets/img/icons/white/book.svg" class="icon" alt="">
    <p>هنرستان <br>نیکان کاوه بناب<br><small>آموزش، فناوری، موفقیت</small></p>
  </div>
  <div class="footer-links">
    <a href="about.html">معرفی مدرسه</a> | <a href="reshte.html">رشته‌ها</a> | <a href="elan.html">اطلاعیه‌ها</a> | <a href="gallery.html">گالری</a> | <a href="faq.html">سوالات متداول</a> | <a href="about.html#contact">تماس با ما</a>
  </div>
  <p>© تمامی حقوق محفوظ است.</p>
</footer>
`;


// گذاشتن هدر و فوتر توی صفحه
document.getElementById("header").innerHTML = header;
document.getElementById("footer").innerHTML = footer;


// لینک صفحه ای که توش هستیم رو پررنگ میکنیم
var page = location.pathname.split("/").pop();
if (page == "") {
  page = "index.html";
}

var links = document.querySelectorAll(".nav a");
for (var i = 0; i < links.length; i++) {
  if (links[i].getAttribute("href") == page) {
    links[i].classList.add("active");
  }
}
