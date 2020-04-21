<div class="header">
    <div class="search">
        <form action="" method="post">
            <input type="search" name="" id="" placeholder="Zoek jouw vr-bril!" />
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="brand-container">
        <a href="./">
            <img class="brand" src="./view/assets/img/vr.svg" alt="Multiversum" />
        </a>
    </div>
    <div class="nav">
        <nav class="nav-fullscreen">
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="./?op=contact">Contact</a></li>
            </ul>
        </nav>
        <div class="nav-burger">
            <button onclick="mobileNavDown()">Menu</button>
        </div>
    </div>
    <div id="nav-move" class="nav-mobile">
        <div class="header-mobile">
            <img src="./view/assets/img/vr.svg" alt="Multiversum" />
            <button onclick="mobileNavUp()">X</button>
        </div>
        <div class="menu-mobile">
            <ul>
                <li><a href="./">Home</a></li>
                <li><a href="./?op=contact">Contact</a></li>
            </ul>
        </div>
    </div>
</div>