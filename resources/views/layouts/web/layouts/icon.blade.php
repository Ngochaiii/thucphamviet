<div class="social-icons-vertical">
    <a href="https://zalo.me/817022106017" aria-label="Zalo" class="social-icon" title="Zalo">
        <img src="/assets/web/images/7044033_zalo_icon.png" alt="Zalo" style="width:38px; height:38px;">
    </a>
    <a href="https://www.facebook.com/share/1BnACKsAch/?mibextid=wwXIfr" aria-label="Facebook" class="social-icon" title="Facebook">
        <svg width="38" height="38" viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.406.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.41c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.466.099 2.796.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.406 24 22.674V1.326C24 .593 23.406 0 22.675 0z" />
        </svg>
    </a>
</div>


<style>
    .social-icons-vertical {
        position: fixed;
        bottom: 20px;
        right: 25px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        z-index: 9999;
    }

    .social-icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        transition: transform 0.3s ease;
    }

    .social-icon img,
    .social-icon svg {
        width: 100%;
        height: 100%;
    }

    .social-icon:hover {
        transform: scale(1.1);
    }

    @media (max-width: 480px) {
        .social-icons-vertical {
            bottom: 15px;
            right: 20px;
            gap: 12px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
        }
    }
</style>

<!-- Nút gọi điện thoại góc màn hình -->
<a href="tel:+81 7022106017" class="call-button" aria-label="Gọi điện thoại">
    <div class="call-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" width="20px" height="20px">
            <path
                d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21c1.2.48 2.5.74 3.83.74a1 1 0 011 1v3.5a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h3.5a1 1 0 011 1c0 1.33.26 2.63.74 3.83a1 1 0 01-.21 1.11l-2.2 2.2z" />
        </svg>
    </div>
    <span class="call-text">+81 7022106017
    </span>
</a>

<style>
    .call-button {
        position: fixed;
        bottom: 100px;
        left: 20px;
        display: flex;
        align-items: center;
        background-color: #d94c4c;
        color: white;
        padding: 10px 20px 10px 10px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(217, 76, 76, 0.4);
        transition: background-color 0.3s ease;
        z-index: 9999;
    }

    .call-button:hover {
        background-color: #bf3c3c;
    }

    .call-icon {
        background-color: #bf3c3c;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
        box-shadow: 0 2px 6px rgba(191, 60, 60, 0.6);
    }

    /* Responsive cho mobile nhỏ */
    @media (max-width: 480px) {
        .call-button {
            bottom: 80px;
            left: 10px;
            padding: 8px 15px 8px 8px;
            font-size: 0.9rem;
        }

        .call-icon {
            width: 35px;
            height: 35px;
            margin-right: 10px;
        }
    }
</style>
