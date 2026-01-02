@extends('frontend.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-3">Let's Connect</h1>
                <p class="lead mb-4">Have questions, ideas, or just want to say hello? I'd love to hear from you.</p>
                <p>I typically respond within 24-48 hours on weekdays.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="section-padding">
    <div class="container">
        <div class="contact-form-section">
            <div class="row ">
                <div class="col-lg-8">
                    <h2 class="section-title mb-4">Send Me a Message</h2>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required">Your Name</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="John Doe"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required">Email Address</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="john@example.com"
                                    required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label required">Subject</label>
                            <input type="text"
                                class="form-control @error('subject') is-invalid @enderror"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                placeholder="What would you like to discuss?"
                                required>
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label required">Your Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Tell me what's on your mind..."
                                required>{{ old('message') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span> / 2000 characters
                            </div>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Google reCAPTCHA (Optional) -->
                        <!-- 
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                            </div>
                            -->

                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <div class="col-lg-4 ">
                    <h3 class="mb-4 mob">Get In Touch</h3>

                    <div class="contact-card mb-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-envelope contact-icon me-2"></i>
                            <h5> Email</h5>
                        </div>
                        <p class="text-muted mb-2">Drop me a line anytime</p>
                        <a href="mailto:{{ $contactInfo['email'] }}" class="text-primary">
                            {{ $contactInfo['email'] }}
                        </a>
                    </div>

                    <div class="contact-card mb-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-phone contact-icon me-2"></i>
                            <h5> Phone</h5>
                        </div>

                        <p class="text-muted mb-2">Available during business hours</p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactInfo['phone']) }}" class="text-primary">
                            {{ $contactInfo['phone'] }}
                        </a>
                    </div>

                    <div class="contact-card">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-marker-alt contact-icon me-2"></i>
                            <h5> Location</h5>
                        </div>

                        <p class="text-muted mb-2">Based in</p>
                        <p class="mb-0">{{ $contactInfo['address'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Map Section -->
<section class="section-padding">
    <div class="container">
        <h2 class="section-title text-center mb-5">Find Me Here</h2>
        <div class="map-section">
            <div id="contactMap"></div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding faq-section">
    <div class="container">
        <h2 class="section-title text-center mb-5">Frequently Asked Questions</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    @foreach($contactInfo['faqs'] as $index => $faq)
                    <div class="accordion-item mb-3 border-0">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq{{ $index }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $faq['question'] }}
                            </button>
                        </h3>
                        <div id="faq{{ $index }}"
                            class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>




@endsection
@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map (using default coordinates - change to your location)
        const map = L.map('contactMap').setView([40.7128, -74.0060], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);

        // Add marker (customize with your location)
        const marker = L.marker([40.7128, -74.0060]).addTo(map)
            .bindPopup('<b>My World Headquarters</b><br>Creative Street, Inspiration City')
            .openPopup();

        // Character counter for message textarea
        const messageInput = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        if (messageInput && charCount) {
            messageInput.addEventListener('input', function() {
                charCount.textContent = this.value.length;

                // Add warning color when approaching limit
                if (this.value.length > 1800) {
                    charCount.style.color = '#dc3545';
                } else if (this.value.length > 1500) {
                    charCount.style.color = '#ffc107';
                } else {
                    charCount.style.color = '';
                }
            });

            // Initialize count
            charCount.textContent = messageInput.value.length;
        }

        // Form submission handler
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        if (contactForm && submitBtn) {
            contactForm.addEventListener('submit', function() {
                // Show loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            });
        }



        // Auto-fill subject based on email content (optional feature)
        const emailInput = document.getElementById('email');
        const subjectInput = document.getElementById('subject');

        if (emailInput && subjectInput) {
            emailInput.addEventListener('blur', function() {
                if (!subjectInput.value && this.value.includes('@')) {
                    const domain = this.value.split('@')[1];
                    const commonSubjects = {
                        'gmail.com': 'Question from Gmail User',
                        'yahoo.com': 'Inquiry from Yahoo User',
                        'outlook.com': 'Message from Outlook User',
                        'hotmail.com': 'Question from Hotmail User'
                    };

                    if (commonSubjects[domain]) {
                        subjectInput.value = commonSubjects[domain];
                    }
                }
            });
        }

        // Form validation enhancement
        const formInputs = contactForm.querySelectorAll('input, textarea, select');
        formInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Copy email to clipboard
        const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
        emailLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth > 768) { // Desktop only
                    e.preventDefault();
                    const email = this.href.replace('mailto:', '');

                    navigator.clipboard.writeText(email).then(() => {
                        const originalText = this.textContent;
                        this.textContent = 'Copied to clipboard!';
                        this.style.color = '#198754';

                        setTimeout(() => {
                            this.textContent = originalText;
                            this.style.color = '';
                        }, 2000);
                    });
                }
            });
        });


    });
</script>

@endsection