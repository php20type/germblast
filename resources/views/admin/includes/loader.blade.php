<style>
/* Yellow bubbling dots animation */
.unified-loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.unified-loader-overlay.active {
    opacity: 1;
    visibility: visible;
}
.unified-loader {
    display: flex;
    gap: 8px;
}
.unified-loader .dot {
    width: 16px;
    height: 16px;
    background-color: #ffc107; /* Yellow */
    border-radius: 50%;
    animation: bubbling 0.6s infinite alternate cubic-bezier(0.5, 0, 0.5, 1);
}
.unified-loader .dot:nth-child(1) { animation-delay: 0s; }
.unified-loader .dot:nth-child(2) { animation-delay: 0.2s; }
.unified-loader .dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes bubbling {
    0% {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    100% {
        transform: translateY(-20px) scale(1.2);
        opacity: 0.4;
    }
}
</style>

<div class="unified-loader-overlay" id="unifiedLoader">
    <div class="unified-loader">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<script>
    // Global helper object for the loader to be reused throughout the application
    window.AppLoader = {
        show: function() {
            const loader = document.getElementById('unifiedLoader');
            if(loader) loader.classList.add('active');
        },
        hide: function() {
            const loader = document.getElementById('unifiedLoader');
            if(loader) loader.classList.remove('active');
        }
    };
</script>
