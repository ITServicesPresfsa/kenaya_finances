<footer class="bg-navy text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('home') }}" class="d-inline-block bg-white rounded p-2 mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Kenaya Finances" height="40" style="width:auto">
                </a>
                <p class="text-white-50">Proximité, sécurité et rapidité au cœur de chaque service.</p>
                <div class="d-flex gap-3 fs-5">
                    <a class="text-light" href="https://www.facebook.com/kenayacg/about?locale=fr_FR" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a class="text-light" href="https://www.instagram.com/kenayafinances" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a class="text-light" href="https://www.tiktok.com/@kenaya_finances" target="_blank" rel="noopener" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a class="text-light" href="https://cg.linkedin.com/company/kenaya-finances" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    <a class="text-light" href="https://youtube.com/@kenayafinances" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="h6 text-uppercase">Liens utiles</h2>
                <ul class="list-unstyled">
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('home') }}">Accueil</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('about') }}">À propos de nous</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('services') }}">Services</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('news.index') }}">Actualités</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="h6 text-uppercase">Contact</h2>
                <ul class="list-unstyled text-white-50">
                    <li><i class="bi bi-envelope me-2"></i><a class="text-white-50" href="mailto:contact@kenayafinances.com">contact@kenayafinances.com</a></li>
                    <li><i class="bi bi-telephone me-2"></i><a class="text-white-50" href="tel:+242064973349">+242 06 497 3349</a></li>
                    <li><i class="bi bi-geo-alt me-2"></i>219 Avenue Nelson Mandela, Brazzaville, République du Congo</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center text-white-50 small mb-0">© {{ date('Y') }} Kenaya Finances. Tous droits réservés.</p>
    </div>
</footer>