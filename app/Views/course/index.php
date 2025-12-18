<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-book me-3"></i>Courses
                    </h1>
                    <p class="text-muted mb-0">Explore our comprehensive course catalog</p>
                </div>
            </div>

            <!-- Search Interface -->
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <form id="courseSearchForm">
                        <div class="row g-3">
                            <!-- Main Search Input -->
                            <div class="col-md-8">
                                <div class="position-relative">
                                    <input type="text" 
                                           class="form-control form-control-lg border-0 bg-light" 
                                           id="courseSearchInput" 
                                           name="q" 
                                           placeholder="Search for courses, topics, or instructors..."
                                           value="<?= esc($keyword ?? '') ?>"
                                           autocomplete="off">
                                    <div id="searchSuggestions" class="position-absolute w-100 mt-1" style="z-index: 1000;"></div>
                                </div>
                            </div>
                            
                            <!-- Search Button -->
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-modern btn-primary btn-lg w-100">
                                    <i class="bi bi-search me-2"></i>Search Courses
                                </button>
                            </div>
                        </div>

                        <!-- Advanced Filters -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Category</label>
                                <select class="form-select border-0 bg-light" id="categoryFilter" name="category">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories ?? [] as $category): ?>
                                        <option value="<?= esc($category) ?>" <?= ($category ?? '') === $category ? 'selected' : '' ?>>
                                            <?= esc($category) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Level</label>
                                <select class="form-select border-0 bg-light" id="levelFilter" name="level">
                                    <option value="">All Levels</option>
                                    <?php foreach ($levels ?? [] as $level): ?>
                                        <option value="<?= esc($level) ?>" <?= ($level ?? '') === $level ? 'selected' : '' ?>>
                                            <?= esc($level) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Sort By</label>
                                <select class="form-select border-0 bg-light" id="sortBy" name="sort">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="title">Title A-Z</option>
                                    <option value="rating">Highest Rated</option>
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div id="activeFilters" class="mt-3"></div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            <div id="searchResults">
                <!-- Loading State -->
                <div id="loadingState" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Searching for courses...</p>
                </div>

                <!-- Results Header -->
                <div id="resultsHeader" class="d-flex justify-content-between align-items-center mb-4" style="display: none;">
                    <h5 class="mb-0">
                        <span id="resultCount">0</span> courses found
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="gridViewBtn">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="listViewBtn">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>

                <!-- Course Grid -->
                <div id="courseGrid" class="row" style="display: none;">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-xl-4 col-lg-6 mb-4 course-item" 
                                 data-title="<?= esc(strtolower($course['title'])) ?>"
                                 data-category="<?= esc(strtolower($course['category'] ?? 'general')) ?>"
                                 data-instructor="<?= esc(strtolower($course['instructor_name'] ?? '')) ?>">
                                <div class="card card-modern h-100">
                                    <!-- Course Header -->
                                    <div class="card-header" style="background: var(--primary-gradient); border: none; color: white; padding: 1.5rem;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-modern bg-light text-dark">
                                                <i class="bi bi-tag me-1"></i><?= esc($course['category'] ?? 'General') ?>
                                            </span>
                                            <span class="badge badge-modern bg-success">
                                                <i class="bi bi-star me-1"></i><?= number_format($course['rating'] ?? 0, 1) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Body -->
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <i class="bi bi-book gradient-icon" style="font-size: 4rem;"></i>
                                        </div>
                                        
                                        <h5 class="card-title text-center mb-3 fw-bold">
                                            <?= esc($course['title']) ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted text-center mb-4">
                                            <?= substr(strip_tags($course['description'] ?? ''), 0, 100) . (strlen(strip_tags($course['description'] ?? '')) > 100 ? '...' : '') ?>
                                        </p>
                                        
                                        <!-- Course Info -->
                                        <div class="row text-center mb-4">
                                            <div class="col-6">
                                                <small class="text-muted">Level</small>
                                                <div class="fw-bold"><?= esc($course['level'] ?? 'Beginner') ?></div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Duration</small>
                                                <div class="fw-bold"><?= esc($course['duration'] ?? 'N/A') ?></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <a href="<?= base_url('courses/show/' . $course['id']) ?>" 
                                               class="btn btn-modern btn-outline-primary">
                                                <i class="bi bi-eye me-2"></i>View Course
                                            </a>
                                            <?php if (is_user_logged_in() && get_user_role() === 'student'): ?>
                                                <button class="btn btn-modern btn-success enroll-btn" data-course-id="<?= $course['id'] ?>">
                                                    <i class="bi bi-plus-circle me-2"></i>Enroll Now
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Footer -->
                                    <div class="card-footer bg-light border-0">
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>
                                            <?= esc($course['instructor_name'] ?? 'N/A') ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Course List -->
                <div id="courseList" style="display: none;">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-12 mb-3 course-item" 
                                 data-title="<?= esc(strtolower($course['title'])) ?>"
                                 data-category="<?= esc(strtolower($course['category'] ?? 'general')) ?>"
                                 data-instructor="<?= esc(strtolower($course['instructor_name'] ?? '')) ?>">
                                <div class="card card-modern">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 class="mb-2"><?= esc($course['title']) ?></h5>
                                                <p class="text-muted mb-2"><?= substr(strip_tags($course['description'] ?? ''), 0, 200) . '...' ?></p>
                                                <div class="d-flex gap-3">
                                                    <span class="badge badge-modern bg-primary">
                                                        <i class="bi bi-tag me-1"></i><?= esc($course['category'] ?? 'General') ?>
                                                    </span>
                                                    <span class="badge badge-modern bg-info">
                                                        <i class="bi bi-bar-chart me-1"></i><?= esc($course['level'] ?? 'Beginner') ?>
                                                    </span>
                                                    <span class="badge badge-modern bg-warning">
                                                        <i class="bi bi-clock me-1"></i><?= esc($course['duration'] ?? 'N/A') ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <div class="mb-2">
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-star me-1"></i><?= number_format($course['rating'] ?? 0, 1) ?>
                                                    </span>
                                                </div>
                                                <a href="<?= base_url('courses/show/' . $course['id']) ?>" class="btn btn-modern btn-outline-primary">
                                                    <i class="bi bi-eye me-2"></i>View Course
                                                </a>
                                                <?php if (is_user_logged_in() && get_user_role() === 'student'): ?>
                                                    <button class="btn btn-modern btn-success enroll-btn ms-2" data-course-id="<?= $course['id'] ?>">
                                                        <i class="bi bi-plus-circle me-1"></i>Enroll
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- No Results -->
                <div id="noResults" class="text-center py-5" style="display: none;">
                    <div class="mb-4">
                        <i class="bi bi-search gradient-icon" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-gray-600 mb-3">No Courses Found</h5>
                    <p class="text-gray-500 mb-4">
                        Try adjusting your search terms or filters to find what you're looking for.
                    </p>
                    <button class="btn btn-modern btn-outline-primary" id="clearFiltersBtn">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                    </button>
                </div>

                <!-- Pagination -->
                <?php if (isset($total_pages) && $total_pages > 1): ?>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination">
                                <?php if ($current_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('courses?page=' . ($current_page - 1) . '&q=' . urlencode($keyword ?? '') . '&category=' . urlencode($category ?? '') . '&level=' . urlencode($level ?? '')) ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= base_url('courses?page=' . $i . '&q=' . urlencode($keyword ?? '') . '&category=' . urlencode($category ?? '') . '&level=' . urlencode($level ?? '')) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($current_page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('courses?page=' . ($current_page + 1) . '&q=' . urlencode($keyword ?? '') . '&category=' . urlencode($category ?? '') . '&level=' . urlencode($level ?? '')) ?>">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Search system variables
    let searchTimeout;
    let isLoading = false;
    let currentFilters = {
        keyword: '<?= esc($keyword ?? '') ?>',
        category: '<?= esc($category ?? '') ?>',
        level: '<?= esc($level ?? '') ?>',
        sort: 'newest'
    };

    // Initialize search system
    initCourseSearch();

    function initCourseSearch() {
        // Set up event listeners
        setupEventListeners();
        
        // Perform client-side filtering for existing courses
        if ($('#courseGrid .course-item').length > 0) {
            initClientSideFiltering();
        }
    }

    function setupEventListeners() {
        // Search form submission
        $('#courseSearchForm').on('submit', function(e) {
            e.preventDefault();
            performServerSearch();
        });

        // Real-time search with debouncing
        $('#courseSearchInput').on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();
            currentFilters.keyword = query;
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    showSuggestions(query);
                }, 300);
            } else {
                hideSuggestions();
                // Trigger client-side filtering
                filterCoursesClientSide();
            }
        });

        // Filter changes
        $('#categoryFilter, #levelFilter, #sortBy').on('change', function() {
            updateCurrentFilters();
            performServerSearch();
        });

        // View toggle buttons
        $('#gridViewBtn').on('click', function() {
            showGridView();
        });

        $('#listViewBtn').on('click', function() {
            showListView();
        });

        // Clear filters
        $('#clearFiltersBtn').on('click', function() {
            clearAllFilters();
        });

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#courseSearchInput, #searchSuggestions').length) {
                hideSuggestions();
            }
        });

        // Enrollment buttons
        $('.enroll-btn').on('click', function() {
            const courseId = $(this).data('course-id');
            enrollInCourse(courseId, $(this));
        });
    }

    function initClientSideFiltering() {
        // Initial filter based on URL parameters
        filterCoursesClientSide();
    }

    function updateCurrentFilters() {
        currentFilters = {
            keyword: $('#courseSearchInput').val(),
            category: $('#categoryFilter').val(),
            level: $('#levelFilter').val(),
            sort: $('#sortBy').val()
        };
    }

    function filterCoursesClientSide() {
        const courseItems = $('.course-item');
        let visibleCount = 0;

        courseItems.forEach(function() {
            const $item = $(this);
            const title = $item.data('title') || '';
            const category = $item.data('category') || '';
            const instructor = $item.data('instructor') || '';
            
            // Search filter
            const matchesSearch = currentFilters.keyword === '' || 
                title.includes(currentFilters.keyword.toLowerCase()) || 
                category.includes(currentFilters.keyword.toLowerCase()) || 
                instructor.includes(currentFilters.keyword.toLowerCase());
            
            // Category filter
            const matchesCategory = currentFilters.category === '' || 
                category === currentFilters.category.toLowerCase();
            
            // Apply filters
            if (matchesSearch && matchesCategory) {
                $item.show();
                visibleCount++;
            } else {
                $item.hide();
            }
        });

        // Update result count
        $('#resultCount').text(visibleCount);
        
        // Show/hide no results message
        if (visibleCount === 0) {
            $('#noResults').show();
            $('#courseGrid, #courseList').hide();
        } else {
            $('#noResults').hide();
            if ($('#gridViewBtn').hasClass('active')) {
                $('#courseGrid').show();
                $('#courseList').hide();
            } else {
                $('#courseList').show();
                $('#courseGrid').hide();
            }
        }
        
        $('#resultsHeader').show();
    }

    function performServerSearch() {
        if (isLoading) return;
        
        updateCurrentFilters();
        
        // Show loading state
        showLoadingState();
        
        // Redirect to search URL with parameters
        const params = new URLSearchParams();
        if (currentFilters.keyword) params.set('q', currentFilters.keyword);
        if (currentFilters.category) params.set('category', currentFilters.category);
        if (currentFilters.level) params.set('level', currentFilters.level);
        
        const newUrl = '<?= base_url('courses') ?>?' + params.toString();
        window.location.href = newUrl;
    }

    function showSuggestions(query) {
        $.ajax({
            url: '<?= base_url("courses/get-suggestions") ?>',
            method: 'GET',
            data: { q: query, limit: 5 },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.suggestions.length > 0) {
                    displaySuggestions(response.suggestions);
                } else {
                    hideSuggestions();
                }
            },
            error: function() {
                hideSuggestions();
            }
        });
    }

    function displaySuggestions(suggestions) {
        const container = $('#searchSuggestions');
        let html = '<div class="card shadow-sm"><div class="list-group list-group-flush">';
        
        suggestions.forEach(function(suggestion) {
            html += `
                <a href="#" class="list-group-item list-group-item-action suggestion-item" data-course-id="${suggestion.id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">${suggestion.highlight}</div>
                            <small class="text-muted">${suggestion.category}</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </div>
                </a>
            `;
        });
        
        html += '</div></div>';
        container.html(html).show();

        // Handle suggestion clicks
        $('.suggestion-item').on('click', function(e) {
            e.preventDefault();
            const courseId = $(this).data('course-id');
            const courseTitle = $(this).find('.fw-bold').text();
            $('#courseSearchInput').val(courseTitle);
            hideSuggestions();
            performServerSearch();
        });
    }

    function hideSuggestions() {
        $('#searchSuggestions').hide();
    }

    function showGridView() {
        $('#gridViewBtn').addClass('active');
        $('#listViewBtn').removeClass('active');
        $('#courseGrid').show();
        $('#courseList').hide();
    }

    function showListView() {
        $('#listViewBtn').addClass('active');
        $('#gridViewBtn').removeClass('active');
        $('#courseList').show();
        $('#courseGrid').hide();
    }

    function clearAllFilters() {
        $('#courseSearchInput').val('');
        $('#categoryFilter').val('');
        $('#levelFilter').val('');
        $('#sortBy').val('newest');
        currentFilters = {
            keyword: '',
            category: '',
            level: '',
            sort: 'newest'
        };
        filterCoursesClientSide();
    }

    function showLoadingState() {
        $('#loadingState').show();
        $('#resultsHeader, #courseGrid, #courseList, #noResults').hide();
    }

    function hideLoadingState() {
        $('#loadingState').hide();
    }

    function enrollInCourse(courseId, button) {
        if (!confirm('Are you sure you want to enroll in this course?')) {
            return;
        }

        button.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Enrolling...');

        $.ajax({
            url: '<?= base_url('course/enroll') ?>',
            method: 'POST',
            data: { course_id: courseId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    // Update button
                    button.removeClass('btn-success').addClass('btn-outline-secondary')
                           .prop('disabled', true)
                           .html('<i class="bi bi-check-circle me-2"></i>Enrolled');
                } else {
                    // Show error message
                    showAlert('danger', response.message);
                    button.prop('disabled', false).html('<i class="bi bi-plus-circle me-2"></i>Enroll Now');
                }
            },
            error: function() {
                showAlert('danger', 'Enrollment failed. Please try again.');
                button.prop('disabled', false).html('<i class="bi bi-plus-circle me-2"></i>Enroll Now');
            }
        });
    }

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('#searchResults').prepend(alertHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
<?= $this->endSection() ?>
