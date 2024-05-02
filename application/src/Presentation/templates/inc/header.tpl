<header class="header">
    <div class="header__logo">
        <a class="header__logolink" href="/">&nbsp;</a>
    </div>
    <div class="header__freearea"></div>
    <div class="header__user"><?=$this->user->fio ?? "Гость"?></div>
    <div class="header__out">
        <a href="/?logout">
            <i class="header__outicon fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
</header>