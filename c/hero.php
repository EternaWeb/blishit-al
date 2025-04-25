<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Eksploro Tregun Online</h1>
        <p class="hero-subtitle">This is a superThis is a super hero things about hero</p>
        <a href="#" class="explore-button">Explore</a>
    </div>
</section>

<style>
    .hero-section {
        position: relative;                       /* establish stacking context */
        background: url('hero.png') center/cover no-repeat;
        color: white;
        padding: 80px 40px;
        width: calc(100% - 80px);
        box-sizing: border-box;
        margin: 20px auto;
        border-radius: 8px;
        overflow: hidden;                         /* clip any overflow */
    }

    /* full-cover overlay inside .hero-section */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .hero-content {
        position: relative;                       /* above the overlay */
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .hero-title {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 15px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 18px;
        margin: 0 0 30px;
        opacity: 0.9;
        max-width: 600px;
    }

    .explore-button {
        display: inline-block;
        background-color: #3665f3;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
        transition: background-color 0.2s;
    }
    .explore-button:hover {
        background-color: #2b4fb4;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section { padding: 60px 15px; margin-top: 10px; }
        .hero-content { padding: 20px 10px; }
        .hero-title { font-size: 28px; }
        .hero-subtitle { font-size: 16px; margin-bottom: 25px; }
        .explore-button { padding: 10px 25px; font-size: 14px; }
    }
    @media (max-width: 480px) {
        .hero-section { padding: 40px 10px; }
        .hero-title { font-size: 24px; }
        .hero-subtitle { font-size: 14px; margin-bottom: 20px; }
    }
</style>
