  <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="mb-4"><i class="fas fa-globe-americas me-2"></i>My World</h3>
                    <p>A personal website to share my journey through photos, stories, and experiences. Built with Laravel and Bootstrap.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h4 class="mb-4">Quick Links</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{route('frontend.home')}}" class="text-light text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#gallery" class="text-light text-decoration-none">Gallery</a></li>
                        <li class="mb-2"><a href="{{route('frontend.posts')}}" class="text-light text-decoration-none">Posts</a></li>
                        <li class="mb-2"><a href="{{route('frontend.about')}}" class="text-light text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="{{route('frontend.contact')}}" class="text-light text-decoration-none">Contact</a></li>

                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h4 class="mb-4">Get In Touch</h4>
                    <p><i class="fas fa-envelope me-2"></i> contact@myworld.com</p>
                    <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Personal Street, Memory City, MC 12345</p>
                    <div class="mt-4">
                        <p>Subscribe to my newsletter for updates</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row mt-4">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} My World. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>Built with <i class="fas fa-heart text-danger"></i> using Laravel & Bootstrap</p>
                </div>
            </div>
        </div>
    </footer>