<div id="preloader-container">
    <!-- Paste the preloader HTML here -->

    <div class="preloader" id="preloader">
        <!-- <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div> -->

        <div class="logo-container">
            <div class="logo-text">BitGoSpace</div>
        </div>

        <div class="loader-container">
            <div class="orbit-loader">
                <!-- <div class="orbit">
                    <div class="planet planet1"></div>
                </div> -->
                <div class="orbit">
                    <div class="planet planet2"></div>
                </div>
                <div class="orbit">
                    <div class="planet planet3"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background: #151412 !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }



    .logo-container {
        position: relative;
        z-index: 2;
        text-align: center;
        /* margin-bottom: 30px; */
    }

    .logo-text {
        font-size: 3.1rem !important;
        font-weight: 700;
        background: linear-gradient(90deg, #FF3BFF 0%, #ECBFBF 38.02%, #4986DB 75.83%, #D94FD5 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 2s ease-in-out infinite;
        letter-spacing: 2px;
        /* font-family: var(--cabinet-font); */
        z-index: 5;
        /* text-shadow: 0 0 30px rgba(255, 255, 255, 0.3); */
    }

    @media only screen and(max-width: 767px) {
        .logo-text {
            font-size: 3rem;
        }
    }

    @keyframes shimmer {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    .subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
        margin-top: 10px;
        letter-spacing: 1px;
        animation: fadeInUp 1s ease-out 0.5s both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .loader-container {
        position: relative;
        z-index: 2;
    }

    .orbit-loader {
        position: relative;
        width: 100px;
        height: 100px;
        /* margin: 0 auto 30px; */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        margin-top: -34px;
    }

    .orbit {
        position: absolute;
        border: 0.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: spin 3s linear infinite;
    }

    /*
    .orbit:nth-child(1) {
        width: 100px;
        height: 100px;
        animation-duration: 3s;
    } */

    .orbit:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 10px;
        left: 10px;
        animation-duration: 2s;
        animation-direction: reverse;
    }

    .orbit:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 20px;
        left: 20px;
        animation-duration: 1.5s;
    }

    .planet {
        position: absolute;
        width: 12px;
        height: 12px;
        background: linear-gradient(45deg, #ffd700, #ffed4e);
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
    }

    .planet1 {
        top: -6px;
        left: 44px;
    }

    .planet2 {
        top: 34px;
        right: -6px;
    }

    .planet3 {
        bottom: -6px;
        left: 24px;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }



    @keyframes progressFill {

        0%,
        100% {
            width: 10%;
        }

        50% {
            width: 90%;
        }
    }

    @keyframes progressShine {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    .loading-text {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        text-align: center;
        margin-top: 20px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.7;
        }

        50% {
            opacity: 1;
        }
    }

    .particles {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.4);
        /* background: #214799; */
        border-radius: 50%;
        animation: float 6s infinite linear;
    }

    .particle:nth-child(1) {
        left: 10%;
        animation-delay: 0s;
    }

    .particle:nth-child(2) {
        left: 20%;
        animation-delay: 1s;
    }

    .particle:nth-child(3) {
        left: 30%;
        animation-delay: 2s;
    }

    .particle:nth-child(4) {
        left: 40%;
        animation-delay: 3s;
    }

    .particle:nth-child(5) {
        left: 50%;
        animation-delay: 4s;
    }

    .particle:nth-child(6) {
        left: 60%;
        animation-delay: 5s;
    }

    .particle:nth-child(7) {
        left: 70%;
        animation-delay: 0.5s;
    }

    .particle:nth-child(8) {
        left: 80%;
        animation-delay: 1.5s;
    }

    .particle:nth-child(9) {
        left: 90%;
        animation-delay: 2.5s;
    }

    @keyframes float {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* Fade out animation */
    .preloader.fade-out {
        animation: fadeOut 0.8s ease-in-out forwards;
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
            visibility: hidden;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .logo-text {
            font-size: 2.5rem;
        }

        .progress-bar {
            width: 250px;
        }

        .orbit-loader {
            width: 80px;
            height: 80px;
        }

        .orbit:nth-child(1) {
            width: 80px;
            height: 80px;
        }

        .orbit:nth-child(2) {
            width: 65px;
            height: 65px;
            top: 7.5px;
            left: 7.5px;
        }

        .orbit:nth-child(3) {
            width: 50px;
            height: 50px;
            top: 15px;
            left: 15px;
        }
    }
</style>
