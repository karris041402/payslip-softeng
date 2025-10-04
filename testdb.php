

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-dark: #023336;
            --primary-light: #eaf8e7;
            --primary-green: #4da674;
            --primary-lightgreen: #c1e6ba;
            --danger: #ff3a30;
            --white: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
            --shadow-md: 0 5px 15px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
            --radius-sm: 5px;
            --radius-md: 10px;
            --radius-lg: 20px;
            --transition: all 0.3s ease;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        body {
            background: #dfe4efff;
            transition: var(--transition);
        }

        /* Prevent scrolling when sidebar is active */
        body.sidebar-active {
            overflow: hidden !important;
            position: fixed !important;
            width: 100% !important;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100%;
            background: var(--primary-dark);
            color: #fff;
            transform: translateX(-100%);
            transition: var(--transition);
            z-index: 1000;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar .fa-times{
            position: absolute;
            right: 20px;
            top: 13px;
        }

        .sidebar-header {
            display: flex;
            padding: 35px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: relative;
            align-items: center;
            gap: 15px;
            font-size: 13px;
        }
        .sidebar-header img {
            height: 50px;
            width: 50px;
            transition: var(--transition);
            filter: brightness(0) invert(1);
        }

        .sidebar-header strong {
            font-weight: 900;
        }

        .sidebar-header em {
            font-weight: 300;
            font-style: italic;
        }

        .sidebar-header:hover img {
            transform: scale(1.05);
        }

        .sidebar-title {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 2px;
            flex: 1;
            margin-left: 17px;
        }

        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 2em;
            cursor: pointer;
            position: absolute;
            right: 12px;
            top: 10px;
            display: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu li {
            padding: 16px 28px;
            font-size: 15px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            margin-left: 15px;
            gap: 12px;
        }

        .sidebar-menu li:hover {
            background: var(--primary-lightgreen);
            color: black;
            width: 85%;
        }

        .sidebar-menu .activeTab {
            background: var(--primary-lightgreen);
            color: black;
             width: 85%;
        }

        .sidebar-menu .logout {
            color: #ffd1d1;
            margin-top: auto;
        }

        .sidebar-menu .mode-toggle {
            color: #ffe;
        }

        .credit {
            bottom: 15px;
            position: absolute;
            font-size: 11px;
            color: #ccc;
            text-align: center;
            width: 230px;
            opacity: 0.4;
            left: 12px;
            letter-spacing: 1px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile - no margin, full width */
        .main-content {
            margin-left: 0;
            transition: var(--transition);
            min-height: 100vh;
        }

        .container {
            width: 100%;
            padding: 15px 20px;
            background-color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
        }

        .top-header {
            display: flex;
            justify-content:space-between;
            align-items: center;
            width: 100%;
            gap: 20px;
        }

        .profileTab {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            gap: 10px;
            color: gray;
        }

        .profileTab img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .caret {
            transition: transform 0.3s;
        }

        .dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .dropdown ul {
            list-style: none;
            margin: 0;
            padding: 10px 0;
        }

        .dropdown ul li {
            padding: 10px 20px;
            cursor: pointer;
        }

        .dropdown ul li:hover {
            background-color: #f0f0f0;
        }

        .profileTab.active .dropdown {
            display: block;
        }

        .profileTab.active .caret {
            transform: rotate(180deg);
        }

        .summary-status {
            display: flex;
            width: 100%;
            padding: 0 30px;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .summary-status .card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 25px 25px;
            width: 22%;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 20px;
            min-width: 200px;
        }

        .students-icon { color: #913cbbff; }
        .active-icon   { color: #289dc8ff; }
        .average-icon  { color: #ef7c2bff; }
        .completed-icon{ color: #e7354fff; }

        .icon-design1{
            background-color: #c9a6dbff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .icon-design2{
            background-color: #8ac4d9ff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .icon-design3{
            background-color: #dfaf8cff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .icon-design4{
            background-color: #d87a88ff;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .card-content{
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .card-content p{
            font-size: 13px;
            color: gray;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .card-content strong{
            font-size: 17px;
        }

        .summary-graphs{
            background-color: var(--white);
            display: flex;
            width: calc(100% - 60px);
            height: 300px;
            margin: 20px 30px;
            border-radius: 10px;
        }

        .bar-container {
            padding: 25px 20px;
            width: 100%;
            min-width: 300px;
            height: 300px;
            box-sizing: border-box;
            position: relative; /* Add this */
            overflow: hidden;
        }

        #summaryGenderChart {
            width: 100% !important;
            height: 100% !important;
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .vertical-line{
            margin: 0 20px;
            height: 260px;
            width: 2px;
            background-color: rgb(0, 0, 0, 0.1);
            z-index: 1;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .summary-status {
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .summary-status .card {
                width: 45%;
                min-width: 150px;
            }
        }

.dashboard-row {
    display: flex;
    gap: 20px;
    margin: 20px 30px;
    flex-wrap: wrap;
}

.bar-container canvas,
.chart-container canvas,
.pie-container canvas {
    max-width: 100% !important;
    height: auto !important;
    max-height: 100% !important;
}


.chart-container {
    background-color: var(--white);
    border-radius: 10px;
    padding: 20px;
    box-shadow: var(--shadow-md);
    flex: 1;
    min-width: 300px;
    height: 280px; /* Fixed height */
    position: relative; /* Add this */
    overflow: hidden;
}

.chart-container canvas {
    max-height: 220px !important; /* Prevent stretching */
}

.chart-container h3 {
    margin-bottom: 15px;
    color: var(--primary-dark);
    font-size: 16px;
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 30px;
}

.mini-card {
    background: var(--white);
    padding: 15px;
    border-radius: 8px;
    box-shadow: var(--shadow-sm);
    border-left: 4px solid var(--primary-green);
}

.mini-card h4 {
    color: var(--primary-dark);
    margin-bottom: 5px;
    font-size: 14px;
}

.mini-card .value {
    font-size: 20px;
    font-weight: bold;
    color: var(--primary-green);
}

.mini-card .change {
    font-size: 12px;
    margin-top: 5px;
}

.change.positive { color: #28a745; }
.change.negative { color: #dc3545; }

.progress-bar {
    width: 100%;
    height: 8px;
    background-color: #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
    margin: 10px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-green), var(--primary-lightgreen));
    transition: width 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-row {
        margin: 15px 20px;
        flex-direction: column;
    }
    
    .chart-container {
        min-width: auto;
        width: 100%;
        height: 250px;
    }
    
    .stats-grid {
        margin: 15px 20px;
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .summary-graphs {
        flex-direction: column;
        height: auto;
        width: calc(100% - 40px);
        margin: 20px 20px;
    }
    
    .vertical-line {
        display: none;
    }
    
    .pie-container {
        width: 100% !important;
        margin-top: 20px;
    }
}

@media (max-width: 480px) {
    .dashboard-row {
        margin: 10px 15px;
    }
    
    .stats-grid {
        margin: 10px 15px;
    }
    
    .chart-container {
        padding: 15px;
        height: 220px;
    }
    
    .summary-graphs {
        width: calc(100% - 30px);
        margin: 15px 15px;
    }
}


/* Mobile adjustments */
@media (max-width: 767px) {
    .container {
        padding: 10px 15px;
        margin-bottom: 15px;
    }
    
    .summary-status {
        flex-direction: column;
        gap: 15px;
        padding: 0 15px;
    }
    
    .summary-status .card {
        width: 100%;
        min-width: auto;
    }
    
    .summary-graphs {
        flex-direction: column;
        height: auto;
        margin: 15px;
        width: calc(100% - 30px);
    }
    
    .vertical-line {
        display: none;
    }
    
    .dashboard-row {
        margin: 15px;
        flex-direction: column;
    }
    
    .stats-grid {
        margin: 15px;
        grid-template-columns: 1fr;
    }
}

/* Tablet adjustments */
@media (min-width: 768px) and (max-width: 1023px) {
    .summary-status .card {
        width: 45%;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media screen and (max-width: 768px) {
    .summary-graphs {
        height: auto !important; /* Auto on mobile */
        flex-direction: column !important;
    }
    
    .bar-container {
        height: 250px !important; /* Fixed mobile height */
        width: 100% !important;
        padding: 15px !important;
    }
    
    .chart-container {
        height: 220px !important; /* Fixed mobile height */
        padding: 15px !important;
    }
    
    .chart-container canvas {
        max-height: 180px !important;
    }
}

@media screen and (min-width: 769px) {
    .summary-graphs {
        height: 300px !important;
    }
    
    .bar-container {
        height: 300px !important;
    }
    
    .chart-container {
        height: 280px !important;
    }
}
    </style>
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="images/logo.png" alt="error" >
            <p><strong>BANGSAMORO READING</strong><br><em>ASSESSMENT TOOLS</em></p>
        </div>
        <ul class="sidebar-menu">
            <li class="activeTab"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><i class="fas fa-users"></i> Students</li>
            <li><i class="fas fa-book"></i> Reading Materials</li>
            <li><i class="fas fa-pencil-alt"></i> Assessments</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle"><i class="fas fa-cog"></i> Settings</li>
            <li><i class="fas fa-sign-out-alt"></i> Logout</li>
        </ul>

        <h5 class="credit">Bangsamoro Reading Assessment Tools v1.0</h5>

        <i class="fas fa-times" id="hide" style="cursor: pointer;" onclick="toggleSidebar()"></i>
    </nav>


<div class="main-content" id="mainContent">
    <div class="container">
        <div class="top-header">
            <i class="fas fa-bars" onclick="toggleSidebar()" style="cursor: pointer; font-size: 20px; color: var(--primary-dark);"></i>
            <div class="profileTab">
                <img src="images/avatar.png" alt="error">
                <span><?php echo htmlspecialchars($_SESSION['teacher_name'] ?? 'Teacher'); ?></span>
                <div class="caret">&#9660;</div> 
                <div class="dropdown">
                    <ul>
                        <li>Profile</li>
                        <li>Settings</li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="summary-status">
        <div class="card">
            <div class="icon-design1"><i class="fas fa-user-friends students-icon"></i></div>
            <div class="card-content">
                <strong>45</strong>
                <p>Total Students</p>
            </div> 
        </div>
         <div class="card">
            <div class="icon-design2"><i class="fas fa-file-alt active-icon"></i></div>
            <div class="card-content">
                <strong>105</strong>
                <p>Active Assessment</p>
            </div> 
        </div>
         <div class="card">
            <div class="icon-design3"><i class="fas fa-chart-line average-icon"></i></div>
            <div class="card-content">
                <strong>123</strong>
                <p>Average Score</p>
            </div>
        </div>
         <div class="card">
            <div class="icon-design4"><i class="fas fa-clipboard-check completed-icon"></i></div>
            <div class="card-content">
                <strong>234</strong>
                <p>Completed Assessment</p>
            </div>
        </div>
    </div>

    <div class="summary-graphs">
        <div class="bar-container">
            <canvas id="summaryGenderChart"></canvas>
        </div>
        <div class="vertical-line"></div>
        <div class="pie-container" style="width: 20%; padding: 0 20px;">
            <canvas id="overallGenderPie"></canvas>
        </div>
    </div>

    <!-- NEW STATISTICS SECTIONS - Now properly inside main-content -->
    <div class="stats-grid">
        <div class="mini-card">
            <h4>Reading Comprehension</h4>
            <div class="value">87%</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 87%"></div>
            </div>
            <div class="change positive">↑ 5% from last month</div>
        </div>
        
        <div class="mini-card">
            <h4>Vocabulary Skills</h4>
            <div class="value">74%</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 74%"></div>
            </div>
            <div class="change positive">↑ 2% from last month</div>
        </div>
        
        <div class="mini-card">
            <h4>Reading Fluency</h4>
            <div class="value">68%</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 68%"></div>
            </div>
            <div class="change negative">↓ 1% from last month</div>
        </div>
        
        <div class="mini-card">
            <h4>Critical Thinking</h4>
            <div class="value">82%</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 82%"></div>
            </div>
            <div class="change positive">↑ 7% from last month</div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="chart-container">
            <h3>Monthly Progress Trend</h3>
            <canvas id="monthlyProgressChart"></canvas>
        </div>
        
        <div class="chart-container">
            <h3>Assessment Categories</h3>
            <canvas id="assessmentCategoriesChart"></canvas>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="chart-container">
            <h3>Student Performance Distribution</h3>
            <canvas id="performanceDistributionChart"></canvas>
        </div>
        
        <div class="chart-container">
            <h3>Weekly Activity</h3>
            <canvas id="weeklyActivityChart"></canvas>
        </div>
    </div>
</div>
    
</body>
<script>

    document.querySelectorAll('.sidebar-menu li').forEach(item => {
            item.addEventListener('click', function() {
                if (this.textContent.includes('Dashboard')) window.location.href = 'teacher_panel.php';
                if (this.textContent.includes('Students')) window.location.href = 'students.php';
                if (this.textContent.includes('Reading Materials')) window.location.href = 'reading-materials.php';
                if (this.textContent.includes('Assessments')) window.location.href = 'assessments.php';
                if (this.textContent.includes('Reports')) window.location.href = 'reports.php';
                if (this.textContent.includes('Settings')) window.location.href = 'settings.php';
                if (this.textContent.includes('Logout')) window.location.href = 'logout.php';
            });
        });

    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const hideBtn = document.getElementById("hide");
    const showBtn = document.getElementById("show");

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");

        document.body.classList.toggle("sidebar-active");
        
        // Lock/unlock body scroll
        if (sidebar.classList.contains("active")) {
            document.body.classList.add("sidebar-active");
        } else {
            document.body.classList.remove("sidebar-active");
        }
    }

    // Update overlay click handler
    document.getElementById("overlay").addEventListener('click', () => {
        document.getElementById("sidebar").classList.remove("active");
        document.getElementById("overlay").classList.remove("active");
        document.body.classList.remove("sidebar-active"); // Add this line
    });


    const profileTab = document.querySelector('.profileTab');
    profileTab.addEventListener('click', () => {
        profileTab.classList.toggle('active');
    });

    // Bar Chart
    const ctxBar = document.getElementById('summaryGenderChart').getContext('2d');

   const summaryGenderChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Total Students', 'Active Assessments', 'Average Score', 'Completed Assessments'],
        datasets: [
            {
                label: 'Boys',
                data: [25, 60, 75, 100],
                backgroundColor: '#289dc8ff'
            },
            {
                label: 'Girls',
                data: [20, 45, 80, 90],
                backgroundColor: '#ef7c2bff'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Important!
        aspectRatio: 2, // Add this for consistent ratio
        plugins: {
            title: {
                display: true,
                text: 'Boys vs Girls Trend',
                color: '#333',
                font: {
                    size: 20,
                    weight: '600'
                },
                padding: {
                    top: 10,
                    bottom: 20
                },
                align: 'start',
                position: 'top'
            },
            legend: { position: 'top' },
            tooltip: { enabled: true }
        },
        scales: {
            y: { 
                beginAtZero: true,
                max: 120
            },
            x: { stacked: false }
        }
    }
});

    // Pie Chart (Overall Boys vs Girls)
    const ctxPie = document.getElementById('overallGenderPie').getContext('2d');
    const overallGenderPie = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Boys', 'Girls'],
            datasets: [{
                data: [25+60+75+100, 20+45+80+90],
                backgroundColor: ['#289dc8ff', '#ef7c2bff']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1.8,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
    });


    const ctxProgress = document.getElementById('monthlyProgressChart').getContext('2d');
const monthlyProgressChart = new Chart(ctxProgress, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Average Score',
            data: [65, 72, 78, 75, 85, 87],
            borderColor: '#4da674',
            backgroundColor: 'rgba(77, 166, 116, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#4da674',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1.8,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { 
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Assessment Categories Doughnut Chart
const ctxCategories = document.getElementById('assessmentCategoriesChart').getContext('2d');
const assessmentCategoriesChart = new Chart(ctxCategories, {
    type: 'doughnut',
    data: {
        labels: ['Reading Comp.', 'Vocabulary', 'Fluency', 'Critical Thinking'],
        datasets: [{
            data: [35, 25, 20, 20],
            backgroundColor: ['#913cbbff', '#289dc8ff', '#ef7c2bff', '#4da674']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Performance Distribution Histogram
const ctxDistribution = document.getElementById('performanceDistributionChart').getContext('2d');
const performanceDistributionChart = new Chart(ctxDistribution, {
    type: 'bar',
    data: {
        labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
        datasets: [{
            label: 'Students',
            data: [2, 5, 12, 18, 8],
            backgroundColor: '#289dc8ff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Weekly Activity Chart
const ctxWeekly = document.getElementById('weeklyActivityChart').getContext('2d');
const weeklyActivityChart = new Chart(ctxWeekly, {
    type: 'radar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Assessments Taken',
            data: [8, 12, 15, 10, 18, 5, 3],
            backgroundColor: 'rgba(77, 166, 116, 0.2)',
            borderColor: '#4da674',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            r: {
                beginAtZero: true,
                max: 20
            }
        }
    }
});

</script>

</html>