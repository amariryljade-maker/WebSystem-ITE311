<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Search System Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .gradient-icon {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .test-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .test-result {
            background: white;
            border-left: 4px solid #28a745;
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 5px;
        }

        .test-error {
            border-left-color: #dc3545;
        }

        .test-warning {
            border-left-color: #ffc107;
        }

        .btn-modern {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-success { background-color: #28a745; }
        .status-error { background-color: #dc3545; }
        .status-warning { background-color: #ffc107; }
        .status-info { background-color: #17a2b8; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <header class="text-center mb-5">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-search gradient-icon me-3"></i>
                        Course Search System Test
                    </h1>
                    <p class="lead text-muted">
                        Comprehensive testing of client-side and server-side search functionality
                    </p>
                </header>

                <!-- Test Overview -->
                <div class="test-section">
                    <h3 class="mb-4">
                        <i class="bi bi-clipboard-check me-2"></i>Test Overview
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="bi bi-laptop me-2"></i>Client-Side Features</h5>
                            <ul class="list-unstyled">
                                <li><span class="status-indicator status-success"></span>Real-time search filtering</li>
                                <li><span class="status-indicator status-success"></span>Debounced input handling</li>
                                <li><span class="status-indicator status-success"></span>Dynamic result sorting</li>
                                <li><span class="status-indicator status-success"></span>Filter combination</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-server me-2"></i>Server-Side Features</h5>
                            <ul class="list-unstyled">
                                <li><span class="status-indicator status-success"></span>AJAX search endpoints</li>
                                <li><span class="status-indicator status-success"></span>Advanced filtering</li>
                                <li><span class="status-indicator status-success"></span>Autocomplete suggestions</li>
                                <li><span class="status-indicator status-success"></span>JSON API responses</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- AJAX Endpoint Tests -->
                <div class="test-section">
                    <h3 class="mb-4">
                        <i class="bi bi-gear me-2"></i>AJAX Endpoint Tests
                    </h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-modern btn-primary w-100 mb-2" onclick="testSearchEndpoint()">
                                <i class="bi bi-search me-2"></i>Test Search Endpoint
                            </button>
                            <button class="btn btn-modern btn-info w-100 mb-2" onclick="testSuggestionsEndpoint()">
                                <i class="bi bi-lightbulb me-2"></i>Test Suggestions Endpoint
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-modern btn-success w-100 mb-2" onclick="testFiltersEndpoint()">
                                <i class="bi bi-funnel me-2"></i>Test Filters Endpoint
                            </button>
                            <button class="btn btn-modern btn-warning w-100 mb-2" onclick="testAllEndpoints()">
                                <i class="bi bi-play-circle me-2"></i>Run All Tests
                            </button>
                        </div>
                    </div>

                    <div id="testResults"></div>
                </div>

                <!-- Interactive Search Demo -->
                <div class="test-section">
                    <h3 class="mb-4">
                        <i class="bi bi-search me-2"></i>Interactive Search Demo
                    </h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="position-relative">
                                <input type="text" 
                                       class="form-control form-control-lg border-0 bg-light" 
                                       id="demoSearchInput" 
                                       placeholder="Try searching for 'web', 'javascript', 'database'..."
                                       autocomplete="off">
                                <div id="demoSuggestions" class="position-absolute w-100 mt-1" style="z-index: 1000;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-modern btn-primary btn-lg w-100" onclick="performDemoSearch()">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="demoCategory">
                                <option value="">All Categories</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Programming">Programming</option>
                                <option value="Database">Database</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Level</label>
                            <select class="form-select" id="demoLevel">
                                <option value="">All Levels</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sort By</label>
                            <select class="form-select" id="demoSort">
                                <option value="newest">Newest First</option>
                                <option value="title">Title A-Z</option>
                                <option value="rating">Highest Rated</option>
                            </select>
                        </div>
                    </div>

                    <div id="demoResults"></div>
                </div>

                <!-- Client-Side Filtering Test -->
                <div class="test-section">
                    <h3 class="mb-4">
                        <i class="bi bi-laptop me-2"></i>Client-Side Filtering Test
                    </h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="text" 
                                   class="form-control" 
                                   id="clientSearchInput" 
                                   placeholder="Filter sample courses...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="clientCategoryFilter">
                                <option value="">All Categories</option>
                                <option value="web development">Web Development</option>
                                <option value="programming">Programming</option>
                                <option value="database">Database</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="clientSortFilter">
                                <option value="title">Title A-Z</option>
                                <option value="category">Category</option>
                                <option value="rating">Rating</option>
                            </select>
                        </div>
                    </div>

                    <div id="clientSideCourses" class="row">
                        <!-- Sample courses will be populated here -->
                    </div>
                </div>

                <!-- Performance Test -->
                <div class="test-section">
                    <h3 class="mb-4">
                        <i class="bi bi-speedometer2 me-2"></i>Performance Test
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-modern btn-outline-primary w-100 mb-2" onclick="testSearchPerformance()">
                                <i class="bi bi-stopwatch me-2"></i>Test Search Performance
                            </button>
                            <button class="btn btn-modern btn-outline-info w-100 mb-2" onclick="testAutocompletePerformance()">
                                <i class="bi bi-lightning me-2"></i>Test Autocomplete Performance
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div id="performanceResults" class="p-3 bg-light rounded">
                                <h6>Performance Metrics</h6>
                                <div id="performanceData"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample course data for client-side testing
        const sampleCourses = [
            {
                id: 1,
                title: 'Web Development Fundamentals',
                category: 'Web Development',
                level: 'Beginner',
                rating: 4.5,
                instructor: 'John Smith',
                description: 'Learn HTML, CSS, and JavaScript basics'
            },
            {
                id: 2,
                title: 'Advanced JavaScript',
                category: 'Programming',
                level: 'Advanced',
                rating: 4.8,
                instructor: 'Jane Doe',
                description: 'Master advanced JavaScript concepts'
            },
            {
                id: 3,
                title: 'Database Management',
                category: 'Database',
                level: 'Intermediate',
                rating: 4.2,
                instructor: 'Mike Johnson',
                description: 'Learn SQL and database design'
            },
            {
                id: 4,
                title: 'React Development',
                category: 'Web Development',
                level: 'Intermediate',
                rating: 4.6,
                instructor: 'Sarah Wilson',
                description: 'Build modern web apps with React'
            },
            {
                id: 5,
                title: 'Python Programming',
                category: 'Programming',
                level: 'Beginner',
                rating: 4.7,
                instructor: 'Tom Brown',
                description: 'Learn Python from scratch'
            }
        ];

        // Initialize client-side courses
        function initializeClientSideCourses() {
            const container = $('#clientSideCourses');
            container.empty();
            
            sampleCourses.forEach(course => {
                const courseCard = `
                    <div class="col-md-6 mb-3 course-item" 
                         data-title="${course.title.toLowerCase()}"
                         data-category="${course.category.toLowerCase()}"
                         data-rating="${course.rating}">
                        <div class="card card-modern">
                            <div class="card-body">
                                <h6>${course.title}</h6>
                                <p class="text-muted small">${course.description}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary">${course.category}</span>
                                    <span class="badge bg-success">★ ${course.rating}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(courseCard);
            });
        }

        // Client-side filtering
        function filterClientSideCourses() {
            const searchTerm = $('#clientSearchInput').val().toLowerCase();
            const categoryFilter = $('#clientCategoryFilter').val().toLowerCase();
            const sortBy = $('#clientSortFilter').val();
            
            let filteredCourses = sampleCourses.filter(course => {
                const matchesSearch = !searchTerm || 
                    course.title.toLowerCase().includes(searchTerm) ||
                    course.description.toLowerCase().includes(searchTerm);
                const matchesCategory = !categoryFilter || 
                    course.category.toLowerCase() === categoryFilter;
                
                return matchesSearch && matchesCategory;
            });

            // Sort courses
            filteredCourses.sort((a, b) => {
                switch(sortBy) {
                    case 'title':
                        return a.title.localeCompare(b.title);
                    case 'category':
                        return a.category.localeCompare(b.category);
                    case 'rating':
                        return b.rating - a.rating;
                    default:
                        return 0;
                }
            });

            // Update display
            const container = $('#clientSideCourses');
            container.empty();
            
            filteredCourses.forEach(course => {
                const courseCard = `
                    <div class="col-md-6 mb-3 course-item" 
                         data-title="${course.title.toLowerCase()}"
                         data-category="${course.category.toLowerCase()}"
                         data-rating="${course.rating}">
                        <div class="card card-modern">
                            <div class="card-body">
                                <h6>${course.title}</h6>
                                <p class="text-muted small">${course.description}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary">${course.category}</span>
                                    <span class="badge bg-success">★ ${course.rating}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(courseCard);
            });
        }

        // AJAX Endpoint Tests
        function testSearchEndpoint() {
            addTestResult('Testing Search Endpoint...', 'info');
            
            $.ajax({
                url: '<?= base_url("courses/search") ?>',
                method: 'GET',
                data: { q: 'web', limit: 5 },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        addTestResult(`✓ Search endpoint working. Found ${response.courses.length} courses.`, 'success');
                    } else {
                        addTestResult(`✗ Search endpoint failed: ${response.message}`, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    addTestResult(`✗ Search endpoint error: ${error}`, 'error');
                }
            });
        }

        function testSuggestionsEndpoint() {
            addTestResult('Testing Suggestions Endpoint...', 'info');
            
            $.ajax({
                url: '<?= base_url("courses/get-suggestions") ?>',
                method: 'GET',
                data: { q: 'web', limit: 3 },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        addTestResult(`✓ Suggestions endpoint working. Found ${response.suggestions.length} suggestions.`, 'success');
                    } else {
                        addTestResult(`✗ Suggestions endpoint failed: ${response.message}`, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    addTestResult(`✗ Suggestions endpoint error: ${error}`, 'error');
                }
            });
        }

        function testFiltersEndpoint() {
            addTestResult('Testing Filters Endpoint...', 'info');
            
            $.ajax({
                url: '<?= base_url("courses/get-filters") ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        addTestResult(`✓ Filters endpoint working. Categories: ${response.filters.categories.length}, Levels: ${response.filters.levels.length}`, 'success');
                    } else {
                        addTestResult(`✗ Filters endpoint failed: ${response.message}`, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    addTestResult(`✗ Filters endpoint error: ${error}`, 'error');
                }
            });
        }

        function testAllEndpoints() {
            testSearchEndpoint();
            setTimeout(() => testSuggestionsEndpoint(), 500);
            setTimeout(() => testFiltersEndpoint(), 1000);
        }

        function addTestResult(message, type) {
            const resultClass = type === 'success' ? 'test-result' : 
                              type === 'error' ? 'test-result test-error' : 
                              type === 'warning' ? 'test-result test-warning' : 'test-result';
            
            const resultHtml = `
                <div class="${resultClass}">
                    <small class="text-muted">${new Date().toLocaleTimeString()}</small><br>
                    ${message}
                </div>
            `;
            
            $('#testResults').prepend(resultHtml);
            
            // Keep only last 10 results
            const results = $('#testResults .test-result');
            if (results.length > 10) {
                results.slice(10).remove();
            }
        }

        // Demo search functionality
        function performDemoSearch() {
            const query = $('#demoSearchInput').val();
            const category = $('#demoCategory').val();
            const level = $('#demoLevel').val();
            const sort = $('#demoSort').val();
            
            addTestResult(`Searching for: "${query}" with filters...`, 'info');
            
            $.ajax({
                url: '<?= base_url("courses/search") ?>',
                method: 'GET',
                data: { q: query, category: category, level: level, limit: 6 },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayDemoResults(response.courses);
                        addTestResult(`✓ Found ${response.courses.length} courses`, 'success');
                    } else {
                        addTestResult(`✗ Search failed: ${response.message}`, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    addTestResult(`✗ Search error: ${error}`, 'error');
                }
            });
        }

        function displayDemoResults(courses) {
            const container = $('#demoResults');
            container.empty();
            
            if (courses.length === 0) {
                container.html('<div class="alert alert-info">No courses found matching your criteria.</div>');
                return;
            }
            
            let html = '<div class="row">';
            courses.forEach(course => {
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card card-modern">
                            <div class="card-body">
                                <h6>${course.title}</h6>
                                <p class="text-muted small">${course.short_description || course.description}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary">${course.category}</span>
                                    <span class="badge bg-success">★ ${course.rating}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.html(html);
        }

        // Performance tests
        function testSearchPerformance() {
            addTestResult('Running search performance test...', 'info');
            const startTime = performance.now();
            
            $.ajax({
                url: '<?= base_url("courses/search") ?>',
                method: 'GET',
                data: { q: 'javascript', limit: 20 },
                dataType: 'json',
                success: function(response) {
                    const endTime = performance.now();
                    const duration = (endTime - startTime).toFixed(2);
                    updatePerformanceMetrics('Search Response Time', `${duration}ms`);
                    addTestResult(`✓ Search performance: ${duration}ms`, 'success');
                }
            });
        }

        function testAutocompletePerformance() {
            addTestResult('Running autocomplete performance test...', 'info');
            const startTime = performance.now();
            
            $.ajax({
                url: '<?= base_url("courses/get-suggestions") ?>',
                method: 'GET',
                data: { q: 'web', limit: 5 },
                dataType: 'json',
                success: function(response) {
                    const endTime = performance.now();
                    const duration = (endTime - startTime).toFixed(2);
                    updatePerformanceMetrics('Autocomplete Response Time', `${duration}ms`);
                    addTestResult(`✓ Autocomplete performance: ${duration}ms`, 'success');
                }
            });
        }

        function updatePerformanceMetrics(test, value) {
            const container = $('#performanceData');
            const existingMetric = container.find(`[data-test="${test}"]`);
            
            if (existingMetric.length) {
                existingMetric.find('.metric-value').text(value);
            } else {
                const metricHtml = `
                    <div class="mb-2" data-test="${test}">
                        <small class="text-muted">${test}:</small>
                        <strong class="metric-value ms-2">${value}</strong>
                    </div>
                `;
                container.append(metricHtml);
            }
        }

        // Initialize on page load
        $(document).ready(function() {
            initializeClientSideCourses();
            
            // Set up client-side filtering
            $('#clientSearchInput').on('input', filterClientSideCourses);
            $('#clientCategoryFilter, #clientSortFilter').on('change', filterClientSideCourses);
            
            // Demo search with debouncing
            let searchTimeout;
            $('#demoSearchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if ($(this).val().length >= 2) {
                        performDemoSearch();
                    }
                }, 500);
            });
            
            // Demo suggestions
            $('#demoSearchInput').on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
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
                        }
                    });
                } else {
                    hideSuggestions();
                }
            });
            
            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#demoSearchInput, #demoSuggestions').length) {
                    hideSuggestions();
                }
            });
        });

        function displaySuggestions(suggestions) {
            const container = $('#demoSuggestions');
            let html = '<div class="card shadow-sm"><div class="list-group list-group-flush">';
            
            suggestions.forEach(suggestion => {
                html += `
                    <a href="#" class="list-group-item list-group-item-action suggestion-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">${suggestion.title}</div>
                                <small class="text-muted">${suggestion.category}</small>
                            </div>
                            <i class="bi bi-arrow-right text-muted"></i>
                        </div>
                    </a>
                `;
            });
            
            html += '</div></div>';
            container.html(html).show();
        }

        function hideSuggestions() {
            $('#demoSuggestions').hide();
        }
    </script>
</body>
</html>
