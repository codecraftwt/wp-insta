@extends('layouts.app')

@section('content')
    <section class="tands p-5">
        <div class="termscondi">
            <div class="ti">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="title title-tands">Terms of Service</div>
            <div class="date date-tands">
                <i class="bi bi-clock"></i>
                <span id="currentDate"></span>
            </div>
        </div>
    </section>

    <section id="condition" class="condition mt-5">
        <div class="container mt-2">
            <div class="row">
                <!-- Left Sidebar for buttons -->
                <div class="col-md-3 leftbutton">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="btn-nav" href="#agreementContent">Agreement to Terms</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-nav" href="#intellectualContent">Intellectual Property</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-nav" href="#publishingContent">Publishing Guidelines</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-nav" href="#contactContent">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- RC-->
                <div class="col-md-9">
                    <div class="content-wrapper">
                        <div id="content" class="content">
                            <div id="agreementContent" class="content-section">
                                <h2 class="section-title">1. Agreement to Terms</h2>
                                <p>This is the content for the agreement terms...
                                    Here are more details about the agreement terms. You should read carefully to understand
                                    all
                                    the
                                    legal conditions and clauses. The agreement includes rules, responsibilities, and
                                    obligations
                                    for both parties involved in the contract
                                    Additional explanations and examples might be provided in further documents or sections.
                                    The
                                    agreement can be updated or modified based on mutual consent
                                    Make sure to acknowledge all the points in the agreement to ensure compliance. Any
                                    disagreements
                                    must be addressed through the proper channels outlined in the agreement
                                    The agreement is legally binding once both parties sign or accept the terms. All aspects
                                    of
                                    the
                                    agreement will be enforceable by law
                                    Terms and conditions vary by jurisdiction, so be sure to check if there are any regional
                                    differences that may affect the agreement
                                    Other related terms may include privacy policies, refund policies, and dispute
                                    resolution
                                    clauses
                                    The document might also include time frames, penalties, and other important dates
                                    It is always advisable to consult a lawyer if you have any questions about the terms or
                                    need
                                    assistance understanding them
                                    We may update this agreement as necessary and will notify all relevant parties about any
                                    significant changes to the terms
                                    Failure to abide by the terms can result in penalties, including termination of the
                                    agreement or
                                    legal action
                                    Always keep a copy of the agreement for your reference, either digitally or in physical
                                    form.

                                    In case of issues, reach out to the support team to address any concerns about the
                                    agreement
                                    or
                                    the services offered
                                    We value your trust and will do our best to keep your experience positive while adhering
                                    to
                                    the
                                    terms of this agreement
                                    For more details, refer to the related documents or visit our website for updates
                                    If you need any clarifications or have questions, feel free to contact us via the
                                    details
                                    provided in the "Contact Us" section</p>
                            </div>

                            <div id="intellectualContent" class="content-section">
                                <h2 class="section-title">2. Intellectual Property Rights</h2>
                                <p>This is the content for intellectual property...
                                    Here we explain the intellectual property rights, including copyrights, patents,
                                    trademarks,
                                    and other related legal concepts. These rights give you exclusive control over your
                                    creations and innovations
                                    Intellectual property is essential for protecting your unique products or ideas. It
                                    ensures
                                    that your work is not copied or used without your permission.
                                    There are several ways to protect intellectual property, such as registering your
                                    trademarks,
                                    patents, and copyrights with the appropriate authorities.
                                    By securing intellectual property rights, creators can ensure that their work is not
                                    exploited by others for profit without permission.
                                    Infringement of intellectual property rights can lead to legal action, including
                                    lawsuits
                                    and
                                    financial penalties. Understanding your rights is crucial to prevent such violations.
                                    It's important to acknowledge the intellectual property of others and ensure that you do
                                    not
                                    infringe upon their rights while using or creating your own content.
                                    If you have any concerns regarding intellectual property violations, you can consult
                                    legal
                                    experts or use specialized platforms to protect your creations.
                                    Protecting your intellectual property can increase the value of your creations and
                                    ensure
                                    that you retain control over how they are used and distributed.
                                    We provide tools and resources to help you understand and protect your intellectual
                                    property
                                    in the best way possible.
                                    When you agree to our terms, you are also agreeing to respect the intellectual property
                                    rights of others and to use all content in accordance with the law.</p>
                            </div>

                            <div id="publishingContent" class="content-section">
                                <h2 class="section-title">3. Publishing Guidelines</h2>
                                This is the content for publishing guidelines...
                                Our publishing guidelines provide detailed instructions on how to publish content, adhere to
                                content standards, and avoid legal issues related to published material
                                Following these guidelines is important to ensure that all content published meets our
                                quality and legal standards, ensuring a positive user experience.
                                Content published on our platform must be accurate, respectful, and free from any offensive
                                material. We do not allow content that promotes hate speech, illegal activities, or other
                                harmful behavior.
                                Proper citation, attribution, and respecting others' intellectual property are key
                                aspects of
                                our publishing guidelines.
                                If you publish content that violates any of these guidelines, your content may be removed
                                or
                                your access may be suspended.
                                We encourage contributors to always fact-check their content and provide sources where
                                necessary to maintain the credibility of their work.
                                For more information on how to contribute and follow the publishing guidelines, please
                                refer
                                to our dedicated publishing section.
                                We value the contributions of all users and strive to create a safe and engaging platform
                                where content can be freely shared and discussed.
                                Any content submitted to us must comply with our terms and conditions, including our
                                publishing guidelines and intellectual property policies.
                                If you need assistance or clarification regarding the guidelines, feel free to reach out
                                to
                                our support team.</p>
                            </div>

                            <div id="contactContent" class="content-section">
                                <h2 class="section-title">4. Contact Us</h2>
                                <p>This is the content for contact information..
                                    If you have any questions, concerns, or need assistance, you can contact us using the
                                    details
                                    below:
                                    Phone: 123-456-7890
                                    Email: support@example.com
                                    Address: 123 Example St, City, Country
                                    Our team is available Monday through Friday, from 9 AM to 5 PM, and will respond to your
                                    inquiries as soon as possible.
                                    If you need immediate assistance, please call our hotline, and our customer support
                                    agents
                                    will assist you directly.
                                    We appreciate your feedback and are always looking for ways to improve our services and
                                    support experience.
                                    Feel free to use our online contact form available on our website for more convenient
                                    communication.
                                    We take your privacy seriously and ensure that all your personal information will be
                                    handled
                                    securely and confidentially.
                                    If you would like to receive updates, newsletters, or promotional offers, please
                                    subscribe to
                                    our newsletter.
                                    Thank you for choosing our services. We look forward to assisting you.</>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    // JavaScript to get the current date
    document.addEventListener("DOMContentLoaded", function() {
        const currentDate = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const formattedDate = currentDate.toLocaleDateString('en-US', options);
        document.getElementById("currentDate").textContent = formattedDate;
    });

    // JavaScript for smooth scrolling behavior
    document.addEventListener("DOMContentLoaded", function() {
        // Attach smooth scroll to all nav links
        const navLinks = document.querySelectorAll('.btn-nav');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Prevent default behavior to handle scroll
                e.preventDefault();

                // Get the target section to scroll to
                const targetId = link.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);

                // Check if target section exists before scrolling
                if (targetSection) {
                    // Scroll the section into view with smooth scrolling
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start' // Scroll the section to the top
                    });
                } else {
                    console.warn(`Section with id ${targetId} does not exist.`);
                }
            });
        });
    });
</script>

<style>
    .tands {
        text-align: center;
        background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);
        font-size: 36px;
        font-weight: 700;
        color: #333;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 2px;

    }

    .ti {
        font-size: 50px;
        color: #00695c;
    }

    .title-tands {
        font-size: 5rem;
        font-weight: bold;
        margin-top: 10px;
    }

    .date-tands {
        font-size: 18px;
        color: gray;
        margin-top: 5px;
    }

    .condition {
        padding: 20px 0;
    }

    /* Left Sidebar for buttons */
    .nav-link {
        cursor: pointer;
    }

    /* Right Column (Content Section) */
    .content-wrapper {
        overflow-y: auto;
        max-height: 600px;
        padding: 15px;
        background-color: #f9f9f9;
    }

    .content-section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-top: 30px;
    }

    .content p {
        font-size: 16px;
        line-height: 1.5;
        color: #333;
    }

    /* Sidebar Navigation */
    .nav {
        padding-left: 0;
        margin-bottom: 0;
    }

    .nav-item {
        margin-bottom: 15px;
    }

    .btn-nav {
        display: block;
        background-color: rgb(0, 94, 84);
        border-color: rgb(76, 142, 135);
        border-radius: 8px;
        padding: 12px 20px;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s, box-shadow 0.3s;
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .leftbutton {
            display: none;
        }

        .btn-nav {
            display: none;
        }
    }

    /* Hover Effect */
    .btn-nav:hover {
        background-color: rgb(0, 120, 106);
        box-shadow: 0 4px 8px rgba(0, 94, 84, 0.3);
    }

    /* Active State Styling */
    .btn-nav.active {
        background-color: rgb(0, 120, 106);
        border-color: rgb(56, 112, 105);
        font-weight: bold;
    }

    .nav-item .active {
        border-left: 4px solid rgb(76, 142, 135);
        background-color: rgb(0, 120, 106);
    }

    /* Sidebar fixed position */
    .col-md-3 {
        position: sticky;
        top: 20px;
        max-height: 90vh;
        overflow-y: auto;
    }

    /* Enable smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 767px) {

        .col-md-3,
        .col-md-9 {
            width: 100%;
            max-height: none;
            padding: 10px;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 20px;
        }

        .content p {
            font-size: 14px;
        }

        .ti {
            font-size: 40px;
        }

        .title-tands {
            font-size: 28px;
        }
    }

    @media (max-width: 991px) {
        .col-md-3 {
            max-height: 70vh;
        }
    }
</style>
