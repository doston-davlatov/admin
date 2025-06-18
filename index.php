<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ./login/');
    exit;
}
?>
<?php include './template/header.php'; ?>

<style>
    .dashboard-card {
        border-radius: 1rem;
        color: #fff;
        padding: 1.2rem;
        position: relative;
        overflow: hidden;
        transition: 0.3s;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }
    .dashboard-icon {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 3rem;
        opacity: 0.3;
    }
    .dashboard-footer {
        margin-top: 1rem;
        font-weight: 500;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.9rem;
        color: #fff;
        opacity: 0.9;
        text-decoration: none;
    }
    .dashboard-footer:hover {
        opacity: 1;
    }
</style>

<div class="row g-4">

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-primary shadow">
            <div>
                <h2>1500</h2>
                <p>Umumiy foydalanuvchilar</p>
            </div>
            <i class="fas fa-users dashboard-icon"></i>
            <a href=".#" class="dashboard-footer">Batafsil <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-success shadow">
            <div>
                <h2>245</h2>
                <p>Yangi buyurtmalar</p>
            </div>
            <i class="fas fa-shopping-cart dashboard-icon"></i>
            <a href="#" class="dashboard-footer">Batafsil <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-warning shadow">
            <div>
                <h2>678</h2>
                <p>Bugungi tashriflar</p>
            </div>
            <i class="fas fa-chart-line dashboard-icon"></i>
            <a href="#" class="dashboard-footer">Batafsil <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card bg-danger shadow">
            <div>
                <h2>25</h2>
                <p>Online foydalanuvchilar</p>
            </div>
            <i class="fas fa-signal dashboard-icon"></i>
            <a href="#" class="dashboard-footer">Batafsil <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>


<?php include './template/footer.php'; ?>