<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Frequently Asked Questions</h1>
                <a href="<?= base_url('help') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Help
                </a>
            </div>

            <div class="accordion" id="faqAccordion">
                <!-- Getting Started -->
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne">
                                <i class="fas fa-user-plus me-2"></i>How do I create an account?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                        <div class="card-body">
                            To create an account, click on the "Register" button on the login page. Fill in your name, email, password, and select your role (student, teacher, or admin). Click "Register" to create your account. You will receive a confirmation email to verify your account.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">
                                <i class="fas fa-sign-in-alt me-2"></i>How do I login to my account?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                        <div class="card-body">
                            Go to the login page and enter your registered email and password. Click "Login" to access your account. If you forgot your password, click on "Forgot Password" to reset it.
                        </div>
                    </div>
                </div>

                <!-- For Students -->
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">
                                <i class="fas fa-graduation-cap me-2"></i>How do I enroll in a course?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                        <div class="card-body">
                            Browse available courses from the courses page. Click on a course to view details, then click "Enroll Now" button. You may need to pay for the course if it's not free. Once enrolled, the course will appear in your dashboard.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour">
                                <i class="fas fa-file-alt me-2"></i>How do I submit assignments?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                        <div class="card-body">
                            Navigate to your enrolled course and find the assignment section. Click on the assignment you want to submit, upload your files or enter your text, and click "Submit Assignment". Make sure to submit before the due date.
                        </div>
                    </div>
                </div>

                <!-- For Teachers -->
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive">
                                <i class="fas fa-chalkboard-teacher me-2"></i>How do I create a course?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
                        <div class="card-body">
                            Go to the Teacher Dashboard and click "Create Course". Fill in the course details including title, description, category, level, and price. Add course content like lessons and assignments. Set the course as published when ready for students.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix">
                                <i class="fas fa-tasks me-2"></i>How do I grade assignments?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#faqAccordion">
                        <div class="card-body">
                            Go to your courses and click on "Assignments". Select the assignment you want to grade, then click "Grade Assignment" for each student submission. Review the work, provide feedback, and assign a grade. Students will be notified of their grades.
                        </div>
                    </div>
                </div>

                <!-- Technical Issues -->
                <div class="card">
                    <div class="card-header" id="headingSeven">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven">
                                <i class="fas fa-lock me-2"></i>How do I reset my password?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#faqAccordion">
                        <div class="card-body">
                            Click on "Forgot Password" on the login page. Enter your registered email address. You will receive a password reset link via email. Click the link and follow the instructions to create a new password.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingEight">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseEight">
                                <i class="fas fa-cog me-2"></i>How do I update my profile information?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#faqAccordion">
                        <div class="card-body">
                            Go to your profile page by clicking on your name in the navigation bar. Click "Edit Profile" to update your information. You can change your name, email, and other details. Don't forget to save your changes.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingNine">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseNine">
                                <i class="fas fa-bell me-2"></i>How do notifications work?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#faqAccordion">
                        <div class="card-body">
                            Notifications keep you updated about important events like new assignments, grades, course announcements, and system updates. You can view all notifications in the Notifications section. Click on a notification to mark it as read.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Still Need Help?</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">Can't find the answer you're looking for? Contact our support team for personalized assistance.</p>
                    <a href="<?= base_url('help/contact') ?>" class="btn btn-primary mt-2">
                        <i class="fas fa-envelope me-1"></i>Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
