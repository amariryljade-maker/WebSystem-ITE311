<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-search me-3"></i>Course Search
                    </h1>
                    <p class="text-muted mb-0">Find the perfect course for your learning journey</p>
                </div>
            </div>

            <!-- Search Interface -->
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <form id="searchForm">
                        <div class="row g-3">
                            <!-- Main Search Input -->
                            <div class="col-md-8">
                                <div class="position-relative">
                                    <input type="text" 
                                           class="form-control form-control-lg border-0 bg-light" 
                                           id="searchInput" 
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
                <div id="courseGrid" class="row" style="display: none;"></div>

                <!-- Course List -->
                <div id="courseList" style="display: none;"></div>

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

                <!-- Load More Button -->
                <div class="text-center mt-4" id="loadMoreContainer" style="display: none;">
                    <button class="btn btn-modern btn-outline-primary" id="loadMoreBtn">
                        <i class="bi bi-arrow-down-circle me-2"></i>Load More Courses
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Templates (Client-side) -->
<template id="courseCardTemplate">
    <div class="col-xl-4 col-lg-6 mb-4">
        <div class="card card-modern h-100">
            <div class="card-header" style="background: var(--primary-gradient); border: none; color: white; padding: 1.5rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge badge-modern bg-light text-dark">
                        <i class="bi bi-tag me-1"></i><span data-field="category"></span>
                    </span>
                    <span class="badge badge-modern bg-success">
                        <i class="bi bi-star me-1"></i><span data-field="rating"></span>
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-3">
                    <i class="bi bi-book gradient-icon" style="font-size: 4rem;"></i>
                </div>
                <h5 class="card-title text-center mb-3 fw-bold" data-field="title"></h5>
                <p class="card-text text-muted text-center mb-4" data-field="description"></p>
                <div class="row text-center mb-4">
                    <div class="col-6">
                        <small class="text-muted">Level</small>
                        <div class="fw-bold" data-field="level"></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Duration</small>
                        <div class="fw-bold" data-field="duration"></div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-modern btn-outline-primary view-course-btn" data-course-id="">
                        <i class="bi bi-eye me-2"></i>View Course
                    </a>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <small class="text-muted">
                    <i class="bi bi-person me-1"></i>
                    <span data-field="instructor_name"></span>
                </small>
            </div>
        </div>
    </div>
</template>

<template id="courseListItemTemplate">
    <div class="col-12 mb-3">
        <div class="card card-modern">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2" data-field="title"></h5>
                        <p class="text-muted mb-2" data-field="description"></p>
                        <div class="d-flex gap-3">
                            <span class="badge badge-modern bg-primary">
                                <i class="bi bi-tag me-1"></i><span data-field="category"></span>
                            </span>
                            <span class="badge badge-modern bg-info">
                                <i class="bi bi-bar-chart me-1"></i><span data-field="level"></span>
                            </span>
                            <span class="badge badge-modern bg-warning">
                                <i class="bi bi-clock me-1"></i><span data-field="duration"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="mb-2">
                            <span class="badge bg-success">
                                <i class="bi bi-star me-1"></i><span data-field="rating"></span>
                            </span>
                        </div>
                        <a href="#" class="btn btn-modern btn-outline-primary view-course-btn" data-course-id="">
                            <i class="bi bi-eye me-2"></i>View Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Search system variables
    let searchTimeout;
    let currentOffset = 0;
    let isLoading = false;
    let hasMoreResults = false;
    let currentSearchQuery = '';
    let currentFilters = {
        keyword: '',
        category: '',
        level: '',
        sort: 'newest'
    };

    // Initialize search system
    initSearchSystem();

    function initSearchSystem() {
        // Load initial filters
        loadFilters();
        
        // Set up event listeners
        setupEventListeners();
        
        // Load initial courses if there's a search query
        if (getUrlParameter('q') || getUrlParameter('category') || getUrlParameter('level')) {
            performSearch();
        }
    }

    function setupEventListeners() {
        // Search form submission
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            performSearch();
        });

        // Real-time search with debouncing
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    showSuggestions(query);
                }, 300);
            } else {
                hideSuggestions();
            }
        });

        // Filter changes
        $('#categoryFilter, #levelFilter, #sortBy').on('change', function() {
            performSearch();
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

        // Load more
        $('#loadMoreBtn').on('click', function() {
            loadMoreCourses();
        });

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#searchInput, #searchSuggestions').length) {
                hideSuggestions();
            }
        });
    }

    function loadFilters() {
        $.ajax({
            url: '<?= base_url("courses/get-filters") ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    populateFilters(response.filters);
                }
            },
            error: function() {
                console.error('Failed to load filters');
            }
        });
    }

    function populateFilters(filters) {
        // Populate categories
        const categorySelect = $('#categoryFilter');
        categorySelect.find('option:not(:first)').remove();
        filters.categories.forEach(function(category) {
            categorySelect.append(`<option value="${category}">${category}</option>`);
        });

        // Populate levels
        const levelSelect = $('#levelFilter');
        levelSelect.find('option:not(:first)').remove();
        filters.levels.forEach(function(level) {
            levelSelect.append(`<option value="${level}">${level}</option>`);
        });
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
            $('#searchInput').val(courseTitle);
            hideSuggestions();
            performSearch();
        });
    }

    function hideSuggestions() {
        $('#searchSuggestions').hide();
    }

    function performSearch() {
        // Update current filters
        currentFilters = {
            keyword: $('#searchInput').val(),
            category: $('#categoryFilter').val(),
            level: $('#levelFilter').val(),
            sort: $('#sortBy').val()
        };

        // Reset pagination
        currentOffset = 0;
        
        // Show loading state
        showLoadingState();
        
        // Perform AJAX search
        $.ajax({
            url: '<?= base_url("courses/search") ?>',
            method: 'GET',
            data: {
                q: currentFilters.keyword,
                category: currentFilters.category,
                level: currentFilters.level,
                limit: 12,
                offset: currentOffset
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displaySearchResults(response);
                    updateActiveFilters();
                    updateUrl();
                } else {
                    showError(response.message);
                }
            },
            error: function() {
                showError('Search failed. Please try again.');
            },
            complete: function() {
                hideLoadingState();
            }
        });
    }

    function displaySearchResults(response) {
        const courses = response.courses;
        const totalCount = response.total_count;
        
        // Update result count
        $('#resultCount').text(totalCount);
        
        // Check if there are results
        if (courses.length === 0) {
            showNoResults();
            return;
        }
        
        // Display courses
        if ($('#gridViewBtn').hasClass('active')) {
            displayCoursesGrid(courses);
        } else {
            displayCoursesList(courses);
        }
        
        // Update pagination state
        hasMoreResults = response.has_more;
        updateLoadMoreButton();
        
        // Show results
        $('#resultsHeader').show();
        $('#courseGrid, #courseList').show();
        $('#noResults').hide();
    }

    function displayCoursesGrid(courses) {
        const container = $('#courseGrid');
        container.empty();
        
        courses.forEach(function(course) {
            const template = $('#courseCardTemplate').html();
            const card = $(template);
            
            // Populate course data
            card.find('[data-field="title"]').text(course.title);
            card.find('[data-field="description"]').text(course.short_description || course.description);
            card.find('[data-field="category"]').text(course.category);
            card.find('[data-field="level"]').text(course.level);
            card.find('[data-field="duration"]').text(course.duration);
            card.find('[data-field="rating"]').text(course.rating.toFixed(1) + ' (' + course.total_ratings + ')');
            card.find('[data-field="instructor_name"]').text(course.instructor_name);
            
            // Set course link
            card.find('.view-course-btn').attr('href', '<?= base_url("courses/show") ?>/' + course.id);
            card.find('.view-course-btn').attr('data-course-id', course.id);
            
            container.append(card);
        });
        
        container.show();
        $('#courseList').hide();
    }

    function displayCoursesList(courses) {
        const container = $('#courseList');
        container.empty();
        
        courses.forEach(function(course) {
            const template = $('#courseListItemTemplate').html();
            const item = $(template);
            
            // Populate course data
            item.find('[data-field="title"]').text(course.title);
            item.find('[data-field="description"]').text(course.short_description || course.description);
            item.find('[data-field="category"]').text(course.category);
            item.find('[data-field="level"]').text(course.level);
            item.find('[data-field="duration"]').text(course.duration);
            item.find('[data-field="rating"]').text(course.rating.toFixed(1) + ' (' + course.total_ratings + ')');
            
            // Set course link
            item.find('.view-course-btn').attr('href', '<?= base_url("courses/show") ?>/' + course.id);
            item.find('.view-course-btn').attr('data-course-id', course.id);
            
            container.append(item);
        });
        
        container.show();
        $('#courseGrid').hide();
    }

    function showGridView() {
        $('#gridViewBtn').addClass('active');
        $('#listViewBtn').removeClass('active');
        
        if ($('#courseGrid').children().length === 0) {
            // Reload current results in grid view
            performSearch();
        } else {
            $('#courseGrid').show();
            $('#courseList').hide();
        }
    }

    function showListView() {
        $('#listViewBtn').addClass('active');
        $('#gridViewBtn').removeClass('active');
        
        if ($('#courseList').children().length === 0) {
            // Reload current results in list view
            performSearch();
        } else {
            $('#courseList').show();
            $('#courseGrid').hide();
        }
    }

    function loadMoreCourses() {
        if (isLoading || !hasMoreResults) return;
        
        isLoading = true;
        $('#loadMoreBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Loading...');
        
        currentOffset += 12;
        
        $.ajax({
            url: '<?= base_url("courses/search") ?>',
            method: 'GET',
            data: {
                q: currentFilters.keyword,
                category: currentFilters.category,
                level: currentFilters.level,
                limit: 12,
                offset: currentOffset
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if ($('#gridViewBtn').hasClass('active')) {
                        appendCoursesGrid(response.courses);
                    } else {
                        appendCoursesList(response.courses);
                    }
                    
                    hasMoreResults = response.has_more;
                    updateLoadMoreButton();
                }
            },
            error: function() {
                showError('Failed to load more courses.');
            },
            complete: function() {
                isLoading = false;
                $('#loadMoreBtn').prop('disabled', false).html('<i class="bi bi-arrow-down-circle me-2"></i>Load More Courses');
            }
        });
    }

    function appendCoursesGrid(courses) {
        const container = $('#courseGrid');
        
        courses.forEach(function(course) {
            const template = $('#courseCardTemplate').html();
            const card = $(template);
            
            // Populate course data
            card.find('[data-field="title"]').text(course.title);
            card.find('[data-field="description"]').text(course.short_description || course.description);
            card.find('[data-field="category"]').text(course.category);
            card.find('[data-field="level"]').text(course.level);
            card.find('[data-field="duration"]').text(course.duration);
            card.find('[data-field="rating"]').text(course.rating.toFixed(1) + ' (' + course.total_ratings + ')');
            card.find('[data-field="instructor_name"]').text(course.instructor_name);
            
            // Set course link
            card.find('.view-course-btn').attr('href', '<?= base_url("courses/show") ?>/' + course.id);
            card.find('.view-course-btn').attr('data-course-id', course.id);
            
            container.append(card);
        });
    }

    function appendCoursesList(courses) {
        const container = $('#courseList');
        
        courses.forEach(function(course) {
            const template = $('#courseListItemTemplate').html();
            const item = $(template);
            
            // Populate course data
            item.find('[data-field="title"]').text(course.title);
            item.find('[data-field="description"]').text(course.short_description || course.description);
            item.find('[data-field="category"]').text(course.category);
            item.find('[data-field="level"]').text(course.level);
            item.find('[data-field="duration"]').text(course.duration);
            item.find('[data-field="rating"]').text(course.rating.toFixed(1) + ' (' + course.total_ratings + ')');
            
            // Set course link
            item.find('.view-course-btn').attr('href', '<?= base_url("courses/show") ?>/' + course.id);
            item.find('.view-course-btn').attr('data-course-id', course.id);
            
            container.append(item);
        });
    }

    function updateActiveFilters() {
        const container = $('#activeFilters');
        let html = '';
        
        if (currentFilters.keyword) {
            html += `<span class="badge bg-primary me-2 mb-2">
                <i class="bi bi-search me-1"></i>${currentFilters.keyword}
                <button type="button" class="btn-close btn-close-white ms-1" data-filter="keyword"></button>
            </span>`;
        }
        
        if (currentFilters.category) {
            html += `<span class="badge bg-info me-2 mb-2">
                <i class="bi bi-tag me-1"></i>${currentFilters.category}
                <button type="button" class="btn-close btn-close-white ms-1" data-filter="category"></button>
            </span>`;
        }
        
        if (currentFilters.level) {
            html += `<span class="badge bg-warning me-2 mb-2">
                <i class="bi bi-bar-chart me-1"></i>${currentFilters.level}
                <button type="button" class="btn-close btn-close-white ms-1" data-filter="level"></button>
            </span>`;
        }
        
        container.html(html);
        
        // Handle filter removal
        container.find('.btn-close').on('click', function() {
            const filterType = $(this).data('filter');
            removeFilter(filterType);
        });
    }

    function removeFilter(filterType) {
        switch(filterType) {
            case 'keyword':
                $('#searchInput').val('');
                break;
            case 'category':
                $('#categoryFilter').val('');
                break;
            case 'level':
                $('#levelFilter').val('');
                break;
        }
        performSearch();
    }

    function clearAllFilters() {
        $('#searchInput').val('');
        $('#categoryFilter').val('');
        $('#levelFilter').val('');
        $('#sortBy').val('newest');
        performSearch();
    }

    function updateUrl() {
        const params = new URLSearchParams();
        
        if (currentFilters.keyword) params.set('q', currentFilters.keyword);
        if (currentFilters.category) params.set('category', currentFilters.category);
        if (currentFilters.level) params.set('level', currentFilters.level);
        
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.replaceState({}, '', newUrl);
    }

    function showLoadingState() {
        $('#loadingState').show();
        $('#resultsHeader, #courseGrid, #courseList, #noResults, #loadMoreContainer').hide();
    }

    function hideLoadingState() {
        $('#loadingState').hide();
    }

    function showNoResults() {
        $('#resultsHeader, #courseGrid, #courseList, #loadMoreContainer').hide();
        $('#noResults').show();
    }

    function updateLoadMoreButton() {
        if (hasMoreResults) {
            $('#loadMoreContainer').show();
        } else {
            $('#loadMoreContainer').hide();
        }
    }

    function showError(message) {
        // You could implement a toast notification here
        console.error(message);
        $('#searchResults').html(`
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>${message}
            </div>
        `);
    }

    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Initialize form values from URL parameters
    function initializeFromUrl() {
        const keyword = getUrlParameter('q');
        const category = getUrlParameter('category');
        const level = getUrlParameter('level');
        
        if (keyword) $('#searchInput').val(keyword);
        if (category) $('#categoryFilter').val(category);
        if (level) $('#levelFilter').val(level);
    }

    // Initialize on page load
    initializeFromUrl();
});
</script>
<?= $this->endSection() ?>
