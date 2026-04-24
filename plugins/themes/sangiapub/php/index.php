<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dropdown Menu with Notifications and Search</title>
    <style>
        .u-js-hide {
            display: none;
        }

        .c-account-nav__menu,
        .c-search--background {
            position: absolute;
            right: 0;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            width: 250px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .c-account-nav__menu.show,
        .c-search--background.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .c-account-nav__menu-header {
            padding: 10px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }

        .c-account-nav__menu-header img {
            border-radius: 50%;
            margin-right: 10px;
            width: 50px;
            height: 50px;
        }

        .c-account-nav__menu-header .notification-icon {
            margin-left: auto;
        }

        .c-account-nav__menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .c-account-nav__menu-item {
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .c-account-nav__menu-item a {
            text-decoration: none;
            color: black;
            display: block;
            transition: background-color 0.3s ease;
        }

        .c-account-nav__menu-item a:hover {
            background-color: #f1f1f1;
        }

        .chevron {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            transform: rotate(45deg);
            transition: transform 0.3s ease;
        }

        .chevron.up {
            transform: rotate(-135deg);
        }

        .avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            vertical-align: middle;
            margin-left: 8px;
            margin-right: 8px;
        }

        .account-title {
            display: flex;
            align-items: center;
        }

        .notification-icon {
            width: 20px;
            height: 20px;
            background-color: red;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-left: 8px;
            position: relative;
        }

        .notification-icon.hidden {
            display: none;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes blink {
            0%, 49% {
                opacity: 1;
            }
            50%, 100% {
                opacity: 0;
            }
        }

        .tooltip {
            display: none;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px;
            border-radius: 3px;
            font-size: 12px;
            white-space: nowrap;
        }

        .c-account-nav__menu-item:hover .tooltip {
            display: block;
        }

        .c-search--background {
            display: none;
            padding: 10px;
        }

        .c-search__input-container,
        .c-search__select-container,
        .c-search__button-container {
            margin-bottom: 10px;
        }

        .c-search__input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .c-search__select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .c-search__button {
            width: 100%;
            padding: 8px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .c-search__button:hover {
            background-color: #0056b3;
        }

        .my-account-svg {
            margin-right: 8px;
        }

        /* Custom CSS for positioning the dropdown menu */
        .c-account-nav__menu.custom-position {
            right: auto;
            left: 0;
            top: 50px; /* Adjust this value to change the vertical position */
            transform: translateY(0) translateX(0);
        }
    </style>
</head>
<body>
<ul>
    <li class="c-header__item">
        <a id="my-account" class="c-header__link placeholder c-header__item--sangia-research" href="#" data-test="login-link" data-track="click" data-track-action="my account" data-track-category="sangia-150-split-header" data-track-label="link" aria-expanded="false">
            <span>My Account</span>
            <svg id="my-account-icon" role="img" aria-hidden="true" focusable="false" height="22" width="22" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="my-account-svg">
                <path d="M10.238 16.905a7.96 7.96 0 003.53-1.48c-.874-2.514-2.065-3.936-3.768-4.319V9.83a3.001 3.001 0 10-2 0v1.277c-1.703.383-2.894 1.805-3.767 4.319A7.96 7.96 0 009 17c.419 0 .832-.032 1.238-.095zm4.342-2.172a8 8 0 10-11.16 0c.757-2.017 1.84-3.608 3.49-4.322a4 4 0 114.182 0c1.649.714 2.731 2.305 3.488 4.322zM9 18A9 9 0 119 0a9 9 0 010 18z" fill="#333" fill-rule="evenodd"></path>
            </svg>
            <img id="user-avatar" class="avatar" src="" alt="User Avatar" style="display: none;">
            <span class="chevron" id="chevron-icon" style="display: none;"></span>
        </a>
        <div class="tooltip">View your account information</div>
        <div class="c-account-nav__menu custom-position u-js-hide" id="account-nav-menu" hidden>
            <div class="c-account-nav__menu-header">
                <img id="dropdown-user-avatar" src="" alt="User Avatar">
                <div>
                    <span>Logged in as: <br></span>
                    <span id="user-email">rochmady@sangia.org</span>
                </div>
                <span class="notification-icon hidden" id="notification-count">0</span>
            </div>
            <ul class="c-account-nav__menu-list">
                <li class="c-account-nav__menu-item">
                    <a href="https://link.springernature.com/home" data-track="site_navigation" data-track-value="Your research" data-track-context="widget">Your research</a>
                    <span class="tooltip">View your research activities</span>
                </li>
                <li class="c-account-nav__menu-item">
                    <a href="https://my-profile.springernature.com" data-track="site_navigation" data-track-value="Manage account" data-track-context="widget">Manage account</a>
                    <span class="tooltip">Manage your account settings</span>
                </li>
                <li class="c-account-nav__menu-item">
                    <a href="https://my-profile.springernature.com/subscriptions-purchases" data-track="site_navigation" data-track-value="Subscriptions and purchases" data-track-context="widget">Subscriptions and purchases</a>
                    <span class="tooltip">View and manage your subscriptions</span>
                </li>
                <li class="c-account-nav__menu-item">
                    <a data-test="logoutLink" class="u-mt-16" href="https://idp.nature.com/logout/personal/springernature?redirect_uri=https://www.nature.com/nature" data-track="site_navigation" data-track-value="Log out" data-track-context="widget">Log out</a>
                    <span class="tooltip">Log out of your account</span>
                </li>
            </ul>
        </div>
    </li>
    <li class="c-header__item c-header__item--pipe">
        <a class="c-header__link" id="search-widget" href="#" data-header-expander="" data-test="search-link" data-track="click" data-track-action="open search tray" data-track-label="button" role="button" aria-haspopup="true" aria-expanded="false">
            <span>Search</span>
            <svg role="img" aria-hidden="true" focusable="false" height="22" width="22" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.48 15.455c.283.282.29.749.007 1.032a.738.738 0 01-1.032-.007l-3.045-3.044a7 7 0 111.026-1.026zM8 14A6 6 0 108 2a6 6 0 000 12z"></path>
            </svg>
        </a>
        <div class="s-search c-search--background u-js-hide" id="search-menu" hidden>
            <form action="https://www.journals.sangia.org/ISLE/search/search" method="post" role="search" autocomplete="off" data-track="submit" data-track-action="search" data-track-label="form" data-track-category="inline search 150">
                <input type="hidden" value="aps" name="journal">
                <label class="c-search__input-label" for="keywords-1">Search Akuatikisle: Jurnal Akuakultur, Pesisir dan Pulau-Pulau Kecil</label>
                <div class="c-search__field">
                    <div class="c-search__input-container c-search__input-container--md">
                        <input class="c-search__input" type="text" id="query" name="query" value="" placeholder="Search">
                    </div>
                    <div class="c-search__select-container">
                        <label for="subject" class="u-visually-hidden">Subject</label>
                        <select class="c-search__select" data-track="change" data-track-action="search" data-track-label="subject" data-track-category="inline search 150" name="subject" id="subject">
                            <option value="">All Subjects</option>
                        </select>
                    </div>
                    <div class="c-search__button-container">
                        <button type="submit" class="c-search__button" value="Search">
                            <span class="c-search__button-text c-search__button-text--hide-at-sm">Search</span>
                            <svg class="u-flex-static" role="img" aria-hidden="true" focusable="false" height="16" width="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.48 15.455c.283.282.29.749.007 1.032a.738.738 0 01-1.032-.007l-3.045-3.044a7 7 0 111.026-1.026zM8 14A6 6 0 108 2a6 6 0 000 12z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
            <form class="u-hide lm-site-search" method="GET" id="search-bar" action="https://www.journals.sangia.org/ISLE/search/search">
                <div class="ms-search-field">
                    <input type="text" id="query" name="query" value="" placeholder="Search" class="lm-search-term">
                </div>
                <button type="submit" value="Search" class="uk-button uk-button-primary btn-search">
                    <svg class="lm-icon-search" viewBox="0 0 32 32">
                        <path fill="inherit" d="M31.1 26.9l-8.8-8.8c1.1-1.8 1.7-3.9 1.7-6.1 0-6.6-5.4-12-12-12s-12 5.4-12 12 5.4 12 12 12c2.2 0 4.3-0.6 6.1-1.7l8.8 8.8c0.6 0.6 1.4 0.9 2.1 0.9s1.5-0.3 2.1-0.9c1.2-1.2 1.2-3.1 0-4.2zM3 12c0-5 4-9 9-9s9 4 9 9c0 5-4 9-9 9s-9-4-9-9z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </li>
</ul>

<script>
    var userLoggedIn = true;  // Gantilah sesuai kondisi apakah pengguna sudah login atau belum
    var userHasAvatar = true;  // Gantilah sesuai kondisi apakah pengguna memiliki avatar atau tidak
    var userAvatarUrl = 'https://loop.frontiersin.org/images/profile/503632/74'; // URL foto pengguna jika ada
    var userEmail = 'rochmady@sangia.org'; // Email pengguna

    document.addEventListener('DOMContentLoaded', function() {
        var accountWidget = document.querySelector('#my-account');
        var accountIcon = document.querySelector('#my-account-icon');
        var userAvatar = document.querySelector('#user-avatar');
        var dropdownUserAvatar = document.querySelector('#dropdown-user-avatar');
        var userEmailElement = document.querySelector('#user-email');
        var chevronIcon = document.querySelector('#chevron-icon');

        if (userLoggedIn) {
            accountWidget.href = '#';
            accountWidget.setAttribute('aria-expanded', 'false');
            userEmailElement.textContent = userEmail;
            chevronIcon.style.display = 'inline-block';

            if (userHasAvatar) {
                accountIcon.style.display = 'none';
                userAvatar.src = userAvatarUrl;
                userAvatar.style.display = 'inline-block';
                dropdownUserAvatar.src = userAvatarUrl;
            } else {
                userAvatar.style.display = 'none';
                dropdownUserAvatar.style.display = 'none';
            }
        } else {
            accountWidget.href = 'https://www.journals.sangia.org/ISLE/user';
            accountIcon.style.display = 'block';
            userAvatar.style.display = 'none';
            dropdownUserAvatar.style.display = 'none';
            chevronIcon.style.display = 'none';
        }
    });

    document.querySelector('#my-account').addEventListener('click', function(event) {
        if (userLoggedIn) {
            event.preventDefault();
            event.stopPropagation();
            var dropdown = document.querySelector('#account-nav-menu');
            var chevron = document.querySelector('#chevron-icon');
            var searchMenu = document.querySelector('#search-menu');
            var isExpanded = this.getAttribute('aria-expanded') === 'true';

            if (searchMenu.classList.contains('show')) {
                searchMenu.classList.remove('show');
                searchMenu.hidden = true;
                document.querySelector('#search-widget').setAttribute('aria-expanded', 'false');
            }

            if (isExpanded) {
                dropdown.classList.remove('show');
                dropdown.hidden = true;
                chevron.classList.remove('up');
                this.setAttribute('aria-expanded', 'false');
            } else {
                dropdown.classList.add('show');
                dropdown.hidden = false;
                chevron.classList.add('up');
                this.setAttribute('aria-expanded', 'true');
            }
        }
    });

    document.querySelector('#search-widget').addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        var searchMenu = document.querySelector('#search-menu');
        var dropdown = document.querySelector('#account-nav-menu');
        var chevron = document.querySelector('#chevron-icon');
        var isExpanded = this.getAttribute('aria-expanded') === 'true';

        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            dropdown.hidden = true;
            document.querySelector('#my-account').setAttribute('aria-expanded', 'false');
            chevron.classList.remove('up');
        }

        if (isExpanded) {
            searchMenu.classList.remove('show');
            searchMenu.hidden = true;
            this.setAttribute('aria-expanded', 'false');
        } else {
            searchMenu.classList.add('show');
            searchMenu.hidden = false;
            this.setAttribute('aria-expanded', 'true');
        }
    });

    window.addEventListener('click', function(event) {
        var dropdown = document.querySelector('#account-nav-menu');
        var chevron = document.querySelector('#chevron-icon');
        var searchMenu = document.querySelector('#search-menu');

        if (!event.target.closest('.c-account-nav') && !event.target.closest('#my-account')) {
            dropdown.classList.remove('show');
            dropdown.hidden = true;
            document.querySelector('#my-account').setAttribute('aria-expanded', 'false');
            chevron.classList.remove('up');
        }

        if (!event.target.closest('.c-header__item--pipe') && !event.target.closest('#search-widget')) {
            searchMenu.classList.remove('show');
            searchMenu.hidden = true;
            document.querySelector('#search-widget').setAttribute('aria-expanded', 'false');
        }
    });

    function fetchNotifications() {
        // Gantilah URL di bawah ini dengan URL endpoint yang sesuai dari server Wizdam Anda
        fetch('https://your-wizdam-server.com/api/notifications')
            .then(response => response.json())
            .then(data => {
                var notificationCount = data.count || 0;
                var notificationIcon = document.querySelector('#notification-count');
                notificationIcon.textContent = notificationCount;
                if (notificationCount > 0) {
                    notificationIcon.classList.remove('hidden');
                    notificationIcon.style.animation = 'blink 1s infinite';
                } else {
                    notificationIcon.classList.add('hidden');
                    notificationIcon.style.animation = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
            });
    }

    // Panggil fungsi fetchNotifications secara berkala
    setInterval(fetchNotifications, 300000); // 5 menit
    fetchNotifications(); // Panggil sekali saat halaman dimuat
</script>
</body>
</html>
