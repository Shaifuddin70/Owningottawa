<?php include 'components/header.php'; ?>
<main class="main-content modern-redesign">

    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="hero-background">
            <img src="https://via.placeholder.com/1920x600/1a1a1a/d3ae77?text=Get+in+Touch" alt="Contact Us Background">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="contact-hero-content scroll-animate">
                <span class="hero-badge">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Contact Us</span>
                </span>
                <h1 class="contact-hero-title">Let's Start Your Property Journey</h1>
                <p class="contact-hero-subtitle">Have questions? Ready to buy, sell, or invest? We're here to help. Reach out and let's discuss how we can turn your real estate goals into reality.</p>
            </div>
        </div>
    </section>

    <!-- Contact Information Cards -->
    <section class="contact-info-section">
        <div class="container">
            <div class="contact-info-grid">
                <div class="contact-info-card scroll-animate">
                    <div class="contact-info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="contact-info-title">Phone</h3>
                    <p class="contact-info-text">Call us anytime during business hours</p>
                    <a href="tel:6133186478" class="contact-info-link">613-318-6478</a>
                </div>

                <div class="contact-info-card scroll-animate delay-1">
                    <div class="contact-info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="contact-info-title">Email</h3>
                    <p class="contact-info-text">Send us a message anytime</p>
                    <a href="mailto:info@owningottawa.ca" class="contact-info-link">info@owningottawa.ca</a>
                </div>

                <div class="contact-info-card scroll-animate delay-2">
                    <div class="contact-info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="contact-info-title">Location</h3>
                    <p class="contact-info-text">Serving Ottawa and surrounding areas</p>
                    <p class="contact-info-address">Ottawa, ON, Canada</p>
                </div>

                <div class="contact-info-card scroll-animate delay-3">
                    <div class="contact-info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="contact-info-title">Business Hours</h3>
                    <div class="contact-hours">
                        <p class="contact-hours-item">
                            <span class="hours-day">Monday - Friday</span>
                            <span class="hours-time">9:00 AM - 5:00 PM</span>
                        </p>
                        <p class="contact-hours-item">
                            <span class="hours-day">Saturday</span>
                            <span class="hours-time">By Appointment</span>
                        </p>
                        <p class="contact-hours-item">
                            <span class="hours-day">Sunday</span>
                            <span class="hours-time">Closed</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-form-grid">
                <div class="contact-form-content scroll-animate">
                    <span class="section-tag"><i class="fas fa-paper-plane"></i> Send a Message</span>
                    <h2 class="section-title-modern">Get in Touch</h2>
                    <p class="section-description">Fill out the form below and we'll get back to you as soon as possible. Whether you're looking to buy, sell, or invest, we're here to help.</p>

                    <div class="contact-form-features">
                        <div class="contact-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Quick Response Time</span>
                        </div>
                        <div class="contact-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Expert Consultation</span>
                        </div>
                        <div class="contact-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Free Initial Assessment</span>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper scroll-animate delay-1">
                    <form class="contact-form" id="contactForm" method="POST" action="#">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i>
                                <span>Full Name</span>
                            </label>
                            <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                <span>Email Address</span>
                            </label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email address" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone"></i>
                                <span>Phone Number</span>
                            </label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="Enter your phone number" required>
                        </div>

                        <div class="form-group">
                            <label for="service" class="form-label">
                                <i class="fas fa-briefcase"></i>
                                <span>Service Interested In</span>
                            </label>
                            <select id="service" name="service" class="form-select" required>
                                <option value="">Select a service</option>
                                <option value="real-estate">Real Estate</option>
                                <option value="mortgage">Mortgage Solutions</option>
                                <option value="property-management">Property Management</option>
                                <option value="bookkeeping">Bookkeeping & Accounting</option>
                                <option value="permits">Building Permits & Design</option>
                                <option value="general">General Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment-alt"></i>
                                <span>Message</span>
                            </label>
                            <textarea id="message" name="message" class="form-textarea" rows="5" placeholder="Tell us about your needs..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="consent" required>
                                <span>I agree to be contacted regarding my inquiry</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-modern-primary form-submit">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>

                        <div id="formMessage" class="form-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="contact-map-section">
        <div class="container">
            <div class="map-header scroll-animate text-center">
                <span class="section-tag"><i class="fas fa-map"></i> Our Location</span>
                <h2 class="section-title-modern">Find Us in Ottawa</h2>
                <p class="section-description">We serve clients throughout Ottawa and the surrounding areas. Get in touch to schedule an in-person meeting or virtual consultation.</p>
            </div>

            <div class="map-wrapper scroll-animate delay-1">
                <div class="map-placeholder">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2800.523065776666!2d-75.6971930844444!3d45.42152997909955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cce05b25f5113af%3A0x8a6a51e131dd15ed!2sOttawa%2C%20ON!5e0!3m2!1sen!2sca!4v1234567890123!5m2!1sen!2sca"
                        width="100%"
                        height="450"
                        style="border:0; border-radius: 20px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Alternative Contact Methods -->
    <section class="contact-alternative">
        <div class="container">
            <div class="alternative-grid">
                <div class="alternative-card scroll-animate">
                    <div class="alternative-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="alternative-title">Book an Appointment</h3>
                    <p class="alternative-text">Schedule a one-on-one consultation at your convenience</p>
                    <a href="tel:6133186478" class="btn-modern-outline">
                        <span>Schedule Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="alternative-card scroll-animate delay-1">
                    <div class="alternative-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="alternative-title">Quick Chat</h3>
                    <p class="alternative-text">Have a quick question? Give us a call for immediate assistance</p>
                    <a href="tel:6133186478" class="btn-modern-outline">
                        <span>Call Now</span>
                        <i class="fas fa-phone"></i>
                    </a>
                </div>

                <div class="alternative-card scroll-animate delay-2">
                    <div class="alternative-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <h3 class="alternative-title">Email Us</h3>
                    <p class="alternative-text">Send us a detailed email and we'll respond within 24 hours</p>
                    <a href="mailto:info@owningottawa.ca" class="btn-modern-outline">
                        <span>Send Email</span>
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    // Contact Form Validation and Submission
    document.addEventListener('DOMContentLoaded', () => {
        const contactForm = document.getElementById('contactForm');
        const formMessage = document.getElementById('formMessage');
        const submitButton = contactForm?.querySelector('.form-submit');

        // Real-time validation
        function setupFieldValidation() {
            const inputs = contactForm.querySelectorAll('.form-input, .form-select, .form-textarea');

            inputs.forEach(input => {
                // Remove validation on input
                input.addEventListener('input', function() {
                    if (this.classList.contains('error')) {
                        this.classList.remove('error');
                    }
                });

                // Validate on blur
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });
        }

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            // Remove existing error class
            field.classList.remove('error');

            // Remove any existing error message
            const existingError = field.parentElement.querySelector('.field-error');
            if (existingError) {
                existingError.remove();
            }

            // Validate based on field type
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'This field is required.';
            } else if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
            } else if (field.type === 'tel' && value) {
                const phoneRegex = /^[\d\s\-\+\(\)]+$/;
                const phoneDigits = value.replace(/\D/g, '');
                if (!phoneRegex.test(value) || phoneDigits.length < 10) {
                    isValid = false;
                    errorMessage = 'Please enter a valid phone number (at least 10 digits).';
                }
            } else if (field.tagName === 'TEXTAREA' && value && value.length < 10) {
                isValid = false;
                errorMessage = 'Message must be at least 10 characters.';
            }

            // Show error if invalid
            if (!isValid) {
                field.classList.add('error');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${errorMessage}`;
                field.parentElement.appendChild(errorDiv);
            }

            return isValid;
        }

        if (contactForm) {
            setupFieldValidation();

            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form values
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const service = document.getElementById('service').value;
                const message = document.getElementById('message').value.trim();
                const consent = document.querySelector('input[name="consent"]').checked;

                // Reset message
                formMessage.textContent = '';
                formMessage.className = 'form-message hidden';

                // Validate all fields
                const fields = [{
                        element: document.getElementById('name'),
                        value: name
                    },
                    {
                        element: document.getElementById('email'),
                        value: email
                    },
                    {
                        element: document.getElementById('phone'),
                        value: phone
                    },
                    {
                        element: document.getElementById('service'),
                        value: service
                    },
                    {
                        element: document.getElementById('message'),
                        value: message
                    }
                ];

                let allValid = true;
                fields.forEach(field => {
                    if (!validateField(field.element)) {
                        allValid = false;
                    }
                });

                // Check consent
                if (!consent) {
                    formMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i> Please accept the consent to proceed.';
                    formMessage.classList.remove('hidden');
                    formMessage.classList.add('error');

                    // Scroll to consent checkbox
                    const consentCheckbox = document.querySelector('input[name="consent"]');
                    if (consentCheckbox) {
                        consentCheckbox.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        consentCheckbox.focus();
                    }
                    return;
                }

                if (!allValid) {
                    formMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i> Please fix the errors above and try again.';
                    formMessage.classList.remove('hidden');
                    formMessage.classList.add('error');

                    // Scroll to first error
                    const firstError = contactForm.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                    return;
                }

                // Show loading state
                if (submitButton) {
                    submitButton.classList.add('loading');
                    submitButton.disabled = true;
                }

                // Simulate form submission (in production, this would send to server)
                setTimeout(() => {
                    // Show success message
                    formMessage.innerHTML = '<i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully. We\'ll get back to you within 24 hours.';
                    formMessage.classList.remove('hidden');
                    formMessage.classList.remove('error');
                    formMessage.classList.add('success');

                    // Reset form
                    contactForm.reset();

                    // Remove loading state
                    if (submitButton) {
                        submitButton.classList.remove('loading');
                        submitButton.disabled = false;
                    }

                    // Scroll to message
                    formMessage.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });

                    // Remove success message after 5 seconds
                    setTimeout(() => {
                        formMessage.classList.add('hidden');
                    }, 5000);
                }, 1500);
            });
        }

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.scroll-animate');
        animatedElements.forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>

<?php include 'components/footer.php'; ?>