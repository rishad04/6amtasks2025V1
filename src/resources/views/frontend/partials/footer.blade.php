</main>

<!-- Footer -->
<footer id="footer" class="footer dark-background">
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="logo d-flex align-items-center"><span class="sitename">Sailor</span></a>
                <div class="footer-contact pt-3">
                    <p>A108 Adam Street</p>
                    <p>New York, NY 535022</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>info@example.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Product Management</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Graphic Design</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>Our Newsletter</h4>
                <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                <form action="forms/newsletter.php" method="post" class="php-email-form">
                    <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe">
                    </div>
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                </form>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>&copy; <span>2024</span> <strong class="px-1 sitename">Sailor</strong> <span>All Rights Reserved</span></p>
        <div class="credits">Designed by <a href="https://themewagon.com">ThemeWagon</a></div>
    </div>
</footer>

<!-- Scroll Top Button -->
<a href="#" class="scroll-top"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Main JS File -->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<script>
    function SwalFlashMiddlelert(result, title, text, icon = 'success', position = 'center') {
        Swal.fire({
            toast: result,
            position: position,
            icon: icon, /// 'warning', 'error', 'success', 'info', 'question'
            title: title,
            text: text,
            showConfirmButton: false, // Hide the confirmation button
            timer: 3000 // Auto-close after 3 seconds
        });
    }

    function SwalFlashNotificationAlert(result, title, text, icon = 'success', position = 'top-right') {
        Swal.fire({
            toast: result,
            position: position,
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 2200,
            customClass: {
                popup: 'fade-toast' // custom fade animation class
            },
            willClose: () => {
                fetch('/get-latest-notification-back-to-set-broadcasted')
                    .then(res => res.json())
                    .then(backToSetData => {
                        console.log(backToSetData);
                    })
                    .catch(error => {
                        console.error('Error setting notification as seen:', error);
                    });
            }
        });
    }
</script>

<script>
    let notificationTimeout;

    function showNotification(message) {
        const notification = document.getElementById('notification');
        const messageBox = document.getElementById('notification-message');

        messageBox.textContent = message;
        notification.classList.add('show');

        clearTimeout(notificationTimeout);
        notificationTimeout = setTimeout(() => {
            hideNotification();
        }, 5000);
    }

    function hideNotification() {
        document.getElementById('notification').classList.remove('show');
    }
</script>

@stack('frontend_scripts')

</body>
<script>
    window.addEventListener('load', function() {
        const loadTime = performance.now() - window.startTime;
        const displayTime = loadTime < 1000 ?
            `${Math.round(loadTime)} ms` :
            `${(loadTime / 1000).toFixed(2)} s`;

        document.getElementById('loading-time').textContent = displayTime;
    });
</script>

</html>
