<!-- App Bottom Menu -->
<style>
    <style>
/* -----------------------------
   APP BOTTOM MENU
----------------------------- */
.appBottomMenu {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    background-color: #fff;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 999;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.appBottomMenu .item {
    flex: 1;
    text-align: center;
    color: #555;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.appBottomMenu .item strong {
    display: block;
    font-size: 11px;
    margin-top: 2px;
}

.appBottomMenu .item ion-icon {
    font-size: 24px;
    display: block;
    margin: 0 auto;
    transition: transform 0.3s ease, color 0.3s ease;
}

.appBottomMenu .item:hover ion-icon {
    transform: scale(1.2);
    color: #0f3a7e;
}

.appBottomMenu .item.active {
    color: #0f3a7e !important;
}

.appBottomMenu .item.active ion-icon {
    color: #0f3a7e !important;
    transform: scale(1.3);
}

/* -----------------------------
   ACTION BUTTON (TENGAH)
----------------------------- */
.appBottomMenu .action-button {
    background: #0f3a7e;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(15,58,126,0.4);
    position: relative;
    bottom: 10px; /* sedikit naik dari menu */
    transition: all 0.3s ease;
}

.appBottomMenu .action-button ion-icon {
    color: #fff;
    font-size: 28px;
}

.appBottomMenu .action-button:hover {
    transform: scale(1.1) translateY(-2px);
    box-shadow: 0 6px 20px rgba(15,58,126,0.5);
}

/* -----------------------------
   RESPONSIVE
----------------------------- */
@media (max-width: 480px) {
    .appBottomMenu {
        height: 55px;
    }
    .appBottomMenu .item ion-icon {
        font-size: 20px;
    }
    .appBottomMenu .item strong {
        font-size: 10px;
    }
    .appBottomMenu .action-button {
        width: 45px;
        height: 45px;
        bottom: 8px;
    }
    .appBottomMenu .action-button ion-icon {
        font-size: 24px;
    }
}
</style>

</style>
    <div class="appBottomMenu">
        <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
               <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="/presensi/histori" class="item {{ request()->is('presensi/histori') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>
        <a href="/presensi/create" class="item {{ request()->is('presensi/create') ? 'active' : '' }}">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/presensi/izin" class="item {{ request()->is('presensi/izin') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated"
                    aria-label="calendar-outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="/editprofile" class="item {{ request()->is('editprofile') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->