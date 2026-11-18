<style>
/* ===== Internal CSS - Car Rental System ===== */
/* Colour variables. Change a value here once and it updates everywhere the variable is used with var(--name). */
:root{
    --primary:#6d28d9;
    --primary2:#4f46e5;
    --accent:#0ea5e9;
    --teal:#14b8a6;
    --orange:#f59e0b;
    --rose:#f43f5e;
    --dark:#1e1b4b;
    --bg:#f3f4fb;
    --card:#fff;
    --text:#1f2937;
    --muted:#6b7280;
    --line:#e5e7eb;
}
/* Reset: remove default browser spacing and make width calculations include padding and border. */
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}
/* Page-wide defaults: font, background colour, text colour and line spacing. */
body{
    font-family:'Segoe UI',Tahoma,Arial,sans-serif;
    background:var(--bg);
    color:var(--text);
    line-height:1.5;
}
/* Links: no underline and they inherit the colour of their parent element. */
a{
    text-decoration:none;
    color:inherit;
}
/* Layout */
/* Left navigation panel: fixed to the left side of the screen with a purple gradient background. */
.sidebar{
    position:fixed;
    top:0;
    left:0;
    bottom:0;
    width:250px;
    background:linear-gradient(180deg,#1e1b4b,#3730a3 70%,#4c1d95);
    color:#fff;
    padding:24px 16px;
    display:flex;
    flex-direction:column;
}
/* Logo text at the top of the sidebar, separated from the menu by a thin line. */
.brand{
    font-size:21px;
    font-weight:700;
    padding:0 10px 22px;
    border-bottom:1px solid rgba(255,255,255,.15);
    margin-bottom:18px;
}
/* Highlights the word 'Rental' in the logo with the orange colour. */
.brand span{
    color:var(--orange);
}
/* Each sidebar menu link (icon + text) as a rounded button. */
.nav a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 14px;
    margin-bottom:6px;
    border-radius:10px;
    color:#c7d2fe;
    font-size:15px;
    transition:.25s;
}
/* HOVER: when the mouse is over a menu link it lightens and slides slightly to the right. */
.nav a:hover{
    background:rgba(255,255,255,.14);
    color:#fff;
    transform:translateX(5px);
}
/* The menu link of the page you are currently on (blue-purple gradient). */
.nav a.active{
    background:linear-gradient(90deg,var(--accent),var(--primary2));
    color:#fff;
    box-shadow:0 6px 16px rgba(14,165,233,.35);
}
/* Logout link: pushed to the bottom of the sidebar and tinted red. */
.nav .logout{
    margin-top:auto;
    background:rgba(244,63,94,.18);
    color:#fecdd3;
}
/* HOVER: logout turns solid red when the mouse is over it. */
.nav .logout:hover{
    background:var(--rose);
    color:#fff;
}
/* Main content area: moved right so it does not hide behind the fixed sidebar. */
.main{
    margin-left:250px;
    padding:26px 32px;
}
/* White header bar at the top of every page (page title on the left, user info on the right). */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:var(--card);
    padding:16px 24px;
    border-radius:16px;
    box-shadow:0 4px 18px rgba(79,70,229,.08);
    margin-bottom:26px;
}
/* Page title inside the top bar. */
.topbar h1{
    font-size:22px;
    color:var(--dark);
}
/* Today's date under the page title (small grey text). */
.topbar small{
    color:var(--muted);
}
/* Container for the user avatar and name, placed side by side. */
.user-chip{
    display:flex;
    align-items:center;
    gap:10px;
}
/* Round circle that shows the first letter of the user's name. */
.avatar{
    width:42px;
    height:42px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--primary),var(--accent));
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}
/* Small rounded label showing the user's role (Admin / Customer). */
.role{
    font-size:12px;
    background:#ede9fe;
    color:var(--primary);
    padding:2px 10px;
    border-radius:20px;
    text-transform:capitalize;
}
/* Stat cards */
/* Helper class: turns a container into a grid with space between items. */
.grid{
    display:grid;
    gap:20px;
}
/* Row of statistic cards that automatically fits as many columns as the screen allows. */
.stats{
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    margin-bottom:26px;
}
/* One coloured statistic card on the dashboard (e.g. Total Cars). */
.stat{
    color:#fff;
    padding:22px;
    border-radius:16px;
    transition:.3s;
    box-shadow:0 8px 20px rgba(0,0,0,.1);
    position:relative;
    overflow:hidden;
}
/* HOVER: the stat card lifts up and gets a bigger shadow. */
.stat:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 28px rgba(0,0,0,.18);
}
/* Large faded emoji placed in the top-right corner of a stat card. */
.stat .icon{
    position:absolute;
    right:16px;
    top:12px;
    font-size:38px;
    opacity:.3;
}
/* The big number inside a stat card. */
.stat h3{
    font-size:34px;
}
/* The label text under the number inside a stat card. */
.stat p{
    opacity:.9;
    font-size:14px;
}
/* Stat card colour 1: purple to indigo gradient. */
.s1{
    background:linear-gradient(135deg,#6d28d9,#4f46e5);
}
/* Stat card colour 2: green to teal gradient. */
.s2{
    background:linear-gradient(135deg,#059669,#14b8a6);
}
/* Stat card colour 3: yellow to orange gradient. */
.s3{
    background:linear-gradient(135deg,#f59e0b,#f97316);
}
/* Stat card colour 4: red to pink gradient. */
.s4{
    background:linear-gradient(135deg,#e11d48,#f43f5e);
}
/* Stat card colour 5: blue to sky-blue gradient. */
.s5{
    background:linear-gradient(135deg,#0284c7,#0ea5e9);
}
/* Cards & tables */
/* White box with rounded corners and a soft shadow used to group content. */
.card{
    background:var(--card);
    border-radius:16px;
    padding:22px;
    box-shadow:0 4px 18px rgba(79,70,229,.08);
    margin-bottom:24px;
    transition:.3s;
}
/* HOVER: the card shadow becomes stronger. */
.card:hover{
    box-shadow:0 10px 28px rgba(79,70,229,.15);
}
/* Heading inside a card. */
.card h2{
    font-size:18px;
    color:var(--dark);
    margin-bottom:16px;
}
/* Two-column layout (left column twice as wide as the right one). */
.two{
    grid-template-columns:2fr 1fr;
}
/* Wrapper that lets wide tables scroll sideways on small screens. */
.table-wrap{
    overflow-x:auto;
}
/* Tables fill the full width and have no gaps between cells. */
table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}
/* Table header cells: purple gradient background with white text. */
th{
    background:linear-gradient(90deg,#4f46e5,#6d28d9);
    color:#fff;
    text-align:left;
    padding:12px 14px;
    font-weight:600;
}
/* Rounds the left corners of the first header cell. */
th:first-child{
    border-radius:10px 0 0 10px;
}
/* Rounds the right corners of the last header cell. */
th:last-child{
    border-radius:0 10px 10px 0;
}
/* Table data cells: padding and a thin line under each row. */
td{
    padding:12px 14px;
    border-bottom:1px solid var(--line);
}
/* Table body rows: prepared to animate smoothly on hover. */
tbody tr{
    transition:.2s;
}
/* HOVER: the row under the mouse gets a light blue background and grows slightly. */
tbody tr:hover{
    background:#eef2ff;
    transform:scale(1.005);
}
/* Badges */
/* Small rounded label used to show a car status. */
.badge{
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
    text-transform:capitalize;
}
/* Status 'available': green badge. */
.b-available{
    background:#d1fae5;
    color:#047857;
}
/* Status 'rented': red badge. */
.b-rented{
    background:#fee2e2;
    color:#be123c;
}
/* Status 'maintenance': yellow badge. */
.b-maintenance{
    background:#fef3c7;
    color:#b45309;
}
/* Buttons */
/* Main button style (also used on links that look like buttons). */
.btn{
    display:inline-block;
    border:none;
    cursor:pointer;
    padding:10px 20px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    color:#fff;
    background:linear-gradient(135deg,var(--primary2),var(--primary));
    transition:.25s;
}
/* HOVER: the button moves up a little and shows a glowing shadow. */
.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 18px rgba(79,70,229,.4);
}
/* Smaller version of a button (used inside tables and cards). */
.btn-sm{
    padding:6px 14px;
    font-size:13px;
    border-radius:8px;
}
/* Edit button: blue gradient. */
.btn-edit{
    background:linear-gradient(135deg,#0284c7,#0ea5e9);
}
/* HOVER: blue glow for the edit button. */
.btn-edit:hover{
    box-shadow:0 8px 18px rgba(14,165,233,.4);
}
/* Delete button: red gradient. */
.btn-del{
    background:linear-gradient(135deg,#e11d48,#f43f5e);
}
/* HOVER: red glow for the delete button. */
.btn-del:hover{
    box-shadow:0 8px 18px rgba(244,63,94,.4);
}
/* Save / Add button: green gradient. */
.btn-green{
    background:linear-gradient(135deg,#059669,#14b8a6);
}
/* HOVER: green glow for the green button. */
.btn-green:hover{
    box-shadow:0 8px 18px rgba(20,184,166,.4);
}
/* Cancel / Reset button: grey. */
.btn-gray{
    background:#9ca3af;
}
/* HOVER: the grey button becomes darker. */
.btn-gray:hover{
    background:#6b7280;
    box-shadow:none;
}
/* Forms */
/* Form layout: fields are arranged in columns that adapt to the screen width. */
.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:18px;
}
/* Text label shown above each form field. */
label{
    display:block;
    font-size:13px;
    font-weight:600;
    color:var(--dark);
    margin-bottom:6px;
}
/* All form fields: full width, rounded corners and a light border. */
input,select,textarea{
    width:100%;
    padding:11px 14px;
    border:2px solid var(--line);
    border-radius:10px;
    font-size:14px;
    font-family:inherit;
    transition:.25s;
    background:#fff;
}
/* HOVER: the border of a form field turns light purple. */
input:hover,select:hover,textarea:hover{
    border-color:#a5b4fc;
}
/* FOCUS: when you click inside a field it gets a purple border and glow. */
input:focus,select:focus,textarea:focus{
    outline:none;
    border-color:var(--primary2);
    box-shadow:0 0 0 4px rgba(79,70,229,.15);
}
/* Makes a form field span all columns (used for the description box). */
.full{
    grid-column:1/-1;
}
/* Message box (base style) shown for success or error messages. */
.alert{
    padding:13px 18px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
    font-weight:500;
}
/* Success message: green background. */
.alert-success{
    background:#d1fae5;
    color:#065f46;
    border-left:5px solid #10b981;
}
/* Error message: red background. */
.alert-error{
    background:#ffe4e6;
    color:#9f1239;
    border-left:5px solid #f43f5e;
}
/* Search and filter bar above the cars list; items wrap to the next line if needed. */
.filters{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom:18px;
}
/* Search and filter fields keep their natural width instead of stretching. */
.filters input,.filters select{
    width:auto;
    min-width:180px;
}
/* Customer car cards */
/* Customer car list: grid of cards that fills the available width. */
.cars{
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
}
/* One car card (customer view). */
.car{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 18px rgba(79,70,229,.1);
    transition:.3s;
}
/* HOVER: the car card lifts up with a stronger purple shadow. */
.car:hover{
    transform:translateY(-8px);
    box-shadow:0 16px 32px rgba(79,70,229,.25);
}
/* Coloured top part of a car card that contains the car emoji. */
.car-top{
    height:120px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:56px;
    color:#fff;
    position:relative;
}
/* Places the status badge in the top-right corner of the car card. */
.car-top .badge{
    position:absolute;
    top:12px;
    right:12px;
}
/* Top colour for the Economy category: teal to blue. */
.c-Economy{
    background:linear-gradient(135deg,#14b8a6,#0ea5e9);
}
/* Top colour for the SUV category: indigo to purple. */
.c-SUV{
    background:linear-gradient(135deg,#6d28d9,#4f46e5);
}
/* Top colour for the Luxury category: orange to red. */
.c-Luxury{
    background:linear-gradient(135deg,#f59e0b,#e11d48);
}
/* Top colour for the Van category: green to lime. */
.c-Van{
    background:linear-gradient(135deg,#059669,#84cc16);
}
/* Top colour for the Pickup category: blue to purple. */
.c-Pickup{
    background:linear-gradient(135deg,#0284c7,#6d28d9);
}
/* White lower part of a car card that contains the details. */
.car-body{
    padding:18px;
}
/* Car name (brand + model). */
.car-body h3{
    color:var(--dark);
    font-size:18px;
}
/* Small grey line with year, colour and plate number. */
.car-body .meta{
    color:var(--muted);
    font-size:13px;
    margin:6px 0 12px;
}
/* Small rounded tags (category, seats, transmission, fuel). */
.tags span{
    display:inline-block;
    background:#eef2ff;
    color:var(--primary2);
    font-size:12px;
    padding:3px 10px;
    border-radius:20px;
    margin:0 4px 4px 0;
    transition:.2s;
}
/* HOVER: a tag turns purple with white text. */
.tags span:hover{
    background:var(--primary2);
    color:#fff;
}
/* Daily price shown in large purple text. */
.price{
    font-size:22px;
    font-weight:700;
    color:var(--primary);
}
/* The '/ day' text next to the price (smaller and grey). */
.price small{
    font-size:13px;
    color:var(--muted);
    font-weight:400;
}
/* Pagination */
/* Row of page buttons centred under the list. */
.pagination{
    display:flex;
    gap:8px;
    justify-content:center;
    margin-top:24px;
    flex-wrap:wrap;
}
/* Each pagination item (Prev, page numbers, Next) as a white rounded button. */
.pagination a,.pagination span{
    padding:9px 15px;
    border-radius:10px;
    background:#fff;
    color:var(--primary2);
    font-weight:600;
    box-shadow:0 2px 8px rgba(0,0,0,.06);
    transition:.25s;
}
/* HOVER: the page button turns purple and moves up slightly. */
.pagination a:hover{
    background:var(--primary2);
    color:#fff;
    transform:translateY(-3px);
}
/* The page you are on now (purple gradient). */
.pagination .current{
    background:linear-gradient(135deg,var(--primary2),var(--primary));
    color:#fff;
}
/* Prev/Next buttons that cannot be used (faded). */
.pagination .disabled{
    opacity:.4;
}
/* Bars */
/* One row of the 'Cars by Category' chart on the admin dashboard. */
.bar-row{
    margin-bottom:14px;
}
/* Row of text above a bar: category name on the left, number on the right. */
.bar-row div.lbl{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    margin-bottom:5px;
}
/* The grey-blue track of a progress bar. */
.bar{
    height:10px;
    background:#e0e7ff;
    border-radius:10px;
    overflow:hidden;
}
/* The coloured part of a bar; its width is set in PHP as a percentage. */
.bar i{
    display:block;
    height:100%;
    border-radius:10px;
    background:linear-gradient(90deg,var(--accent),var(--primary));
    transition:.3s;
}
/* HOVER: the coloured bar becomes brighter. */
.bar-row:hover .bar i{
    filter:brightness(1.15);
}
/* Message shown when no cars are found. */
.empty{
    text-align:center;
    padding:40px;
    color:var(--muted);
}
/* Extra styles: warning message, menu badge and the login page links */
/* Yellow warning message (used for 'waiting for approval'). */
.alert-warning{
    background:#fef3c7;
    color:#92400e;
    border-left:5px solid #f59e0b;
}
/* Small red number bubble on the 'Manage Users' menu link (pending approvals). */
.nav-badge{
    margin-left:auto;
    background:var(--rose);
    color:#fff;
    font-size:12px;
    font-weight:700;
    padding:1px 9px;
    border-radius:20px;
}
/* Row of extra links under the login button (Forgot password / Create new account). */
.login-links{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-top:18px;
    flex-wrap:wrap;
}
/* Each link in that row. */
.login-links a{
    color:var(--primary2);
    font-size:14px;
    font-weight:600;
    padding:8px 14px;
    border-radius:10px;
    transition:.25s;
}
/* HOVER: the link gets a light background and moves up slightly. */
.login-links a:hover{
    background:#eef2ff;
    color:var(--primary);
    transform:translateY(-2px);
}
/* The 'Create new account' link looks like an outlined button. */
.login-links .create{
    border:2px solid var(--primary2);
}
/* HOVER: the outlined button fills with the main colour. */
.login-links .create:hover{
    background:var(--primary2);
    color:#fff;
}
/* Login page */
/* Login page background: full-screen gradient with the login box centred. */
.login-body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#1e1b4b,#4f46e5 55%,#0ea5e9);
    padding:20px;
}
/* The white login card that holds the art panel and the form. */
.login-box{
    display:flex;
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    max-width:880px;
    width:100%;
    box-shadow:0 25px 60px rgba(0,0,0,.35);
}
/* Left coloured panel of the login page. */
.login-art{
    flex:1;
    background:linear-gradient(160deg,#6d28d9,#4f46e5 60%,#0ea5e9);
    color:#fff;
    padding:48px 36px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}
/* Heading in the left panel of the login page. */
.login-art h2{
    font-size:30px;
    margin-bottom:12px;
}
/* Large car emoji in the left panel. */
.login-art .big{
    font-size:80px;
    margin-bottom:10px;
}
/* Short description text in the left panel. */
.login-art p{
    opacity:.9;
}
/* Right side of the login page that contains the form. */
.login-form{
    flex:1;
    padding:48px 40px;
}
/* 'Welcome Back' heading. */
.login-form h2{
    color:var(--dark);
    font-size:26px;
    margin-bottom:6px;
}
/* Grey sentence under the heading. */
.login-form .sub{
    color:var(--muted);
    margin-bottom:24px;
}
/* Space between the username and password fields. */
.login-form .field{
    margin-bottom:18px;
}
/* Login button stretches to the full width of the form. */
.login-form .btn{
    width:100%;
    padding:13px;
    font-size:16px;
}
/* Light blue information box (not used on the login page now but kept for reuse). */
.hint{
    margin-top:20px;
    background:#eef2ff;
    border-radius:12px;
    padding:12px 16px;
    font-size:13px;
    color:var(--dark);
}
/* HOVER: the information box becomes slightly darker. */
.hint:hover{
    background:#e0e7ff;
}
/* Reserved for a mobile menu button. It is hidden for now. */
.menu-toggle{
    display:none;
}
/* RESPONSIVE: the rules below only apply on screens 850px wide or smaller (tablets and phones). */
@media(max-width:850px){
    /* PHONE: sidebar stops being fixed and becomes a bar at the top of the page. */
    .sidebar{
        position:static;
        width:100%;
        flex-direction:row;
        flex-wrap:wrap;
        padding:12px;
    }
    /* PHONE: logo takes the full width with no divider line. */
    .brand{
        border:none;
        padding:0 10px;
        margin:0;
        width:100%;
    }
    /* PHONE: menu links sit side by side and wrap to the next line. */
    .nav{
        display:flex;
        flex-wrap:wrap;
        width:100%;
    }
    /* PHONE: smaller spacing around each menu link. */
    .nav a{
        margin:3px;
    }
    /* PHONE: content uses the full width (no left space for the sidebar). */
    .main{
        margin-left:0;
        padding:16px;
    }
    /* PHONE: the two columns stack into one column. */
    .two{
        grid-template-columns:1fr;
    }
    /* PHONE: hide the left art panel on the login page. */
    .login-art{
        display:none;
    }
    /* PHONE: smaller padding for the login form. */
    .login-form{
        padding:32px 24px;
    }
}
</style>
