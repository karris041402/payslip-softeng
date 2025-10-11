<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="icon" type="image/x-icon" href="EARIST_Logo (1).ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #e6ecf5 50%, #cddffb 100%);
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }

        body.dark-mode {
            background: linear-gradient(135deg, #181c23 0%, #1a1f2e 50%, #0f1419 100%) !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .container {
            background: rgba(35, 43, 54, 0.95) !important;
            color: #e0e6ef !important;
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        body.dark-mode .header-container {
            background: linear-gradient(135deg, #1a2332 0%, #2c3e50 100%) !important;
            border-bottom: 2px solid #3498db;
        }

        body.dark-mode .tab-navigation {
            background: #1a2332 !important;
            border-bottom: 1px solid #3498db;
        }

        body.dark-mode .tab-button {
            color: #a0aec0 !important;
            border-bottom: 3px solid transparent;
        }

        body.dark-mode .tab-button:hover {
            background: rgba(52, 152, 219, 0.1) !important;
            color: #3498db !important;
        }

        body.dark-mode .tab-button.active {
            color: #3498db !important;
            background: rgba(52, 152, 219, 0.15) !important;
            border-bottom: 3px solid #3498db;
        }
        body.dark-mode .form-section{
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        body.dark-mode .form-control,
        body.dark-mode input[type="text"],
        body.dark-mode input[type="number"],
        body.dark-mode select {
            background: #1a2332 !important;
            color: #e0e6ef !important;
            border: solid 1px #48535aff !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode input[type="text"]:focus,
        body.dark-mode input[type="number"]:focus {
            border-color: solid 1px #48535aff !important;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2) !important;
        }

        body.dark-mode .sidebar {
            background: #181c23 !important;
            color: #fff !important;
            box-shadow: 2px 0 20px rgba(207, 194, 194, 0.12) !important;
        }

        body.dark-mode .sidebar-menu li:hover {
            background: #3498db !important;
            color: #fff !important;
        }

        body.dark-mode .table {
            background: #1a2332 !important;
        }

        body.dark-mode .table th {
            background: #2c3e50 !important;
            color: #3498db !important;
        }

        body.dark-mode .table td {
            border-color: #3498db !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.1) !important;
        }

        body.dark-mode .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
        }

        body.dark-mode .btn-secondary {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
        }

        body.dark-mode .form-section {
            background: #232b36 !important;
        }

        body.dark-mode .form-section h3 {
            color: #3498db !important;
        }

        body.dark-mode .form-group label {
            color: #ffffffff !important;
        }

        body.dark-mode .section-header h2{
            color: #3498db !important;
        }

        .container {
            position: relative;
            width: calc(100% - 300px);
            margin-left: 280px;
            margin-top: 4px;
            background: rgba(255, 255, 255, 0.50);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1), 
                        0 20px 60px rgba(0,0,0,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            min-height: calc(100vh - 40px);
        }

        .header-container {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            padding: 35px 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(5%, 5%) scale(1.1); }
        }

        .header-container h1 {
            font-size: 2.5em;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .header-container h1 i {
            margin-right: 15px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .header-container p {
            font-size: 1.1em;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .tab-navigation {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #e0e6ed;
            padding: 0;
        }

        .tab-button {
            flex: 1;
            padding: 18px 30px;
            background: transparent;
            border: none;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #5a6c7d;
            border-bottom: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button:hover {
            background: rgba(52, 152, 219, 0.05);
            color: #3498db;
        }

        .tab-button.active {
            color: #3498db;
            background: rgba(52, 152, 219, 0.1);
            border-bottom: 3px solid #3498db;
        }

        .tab-button i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .main-content {
            padding: 40px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            background: linear-gradient(180deg, rgba(44, 62, 80, 0.98) 0%, rgba(52, 73, 94, 0.98) 100%);
            color: #fff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            z-index: 999;
            display: flex;
            flex-direction: column;
            padding-top: 0;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .sidebar-header {
            display: flex;
            padding: 30px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            align-items: center;
        }

        .sidebar-logo {
            width: 55px;
            height: 55px;
            margin-left: 5px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .sidebar-title {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1.5px;
            flex: 1;
            margin-left: 15px;
            line-height: 1.3;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 10px;
            margin: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu li {
            padding: 16px 20px;
            font-size: 1.05em;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3498db;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-menu li:hover::before,
        .sidebar-menu li.activeTab::before {
            transform: scaleY(1);
        }

        .sidebar-menu li:hover {
            background: linear-gradient(90deg, rgba(52, 152, 219, 0.8) 0%, rgba(41, 128, 185, 0.8) 100%);
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .sidebar-menu .activeTab {
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
            color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .sidebar-menu .mode-toggle {
            color: #ffe;
        }

        .credit {
            padding: 15px;
            font-size: 10px;
            color: #bbb;
            text-align: center;
            opacity: 0.6;
            letter-spacing: 0.5px;
            line-height: 1.4;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

       .table-wrapper::-webkit-scrollbar {
            height: 6px;
            background: #f1f1f1;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #29659cff;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #eee;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
            overflow: hidden;
        }

        .table th {
            border-right: solid 1px rgba(23, 28, 48, 0.5);
            background: #3498db ;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            border-right: solid 1px rgba(23, 28, 48, 0.5);
            padding: 12px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background 0.2s ease;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            font-size: 1.4em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select {
            padding: 12px;
            border: 2px solid #e0e6ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn i {
            font-size: 1.1em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(149, 165, 166, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(149, 165, 166, 0.4);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            color: #2c3e50;
            font-size: 1.8em;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.2em;
        }

        .centered-popover {
            padding: 0;
            border: none;
            border-radius: 8px;
            background: #1a2332;
            box-shadow: 0 2px 20px rgba(255, 255, 255, 1);
            width: 400px;
            max-width: 90vw;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        /* Popover backdrop */
        .centered-popover::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        .popover-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px 0 20px;
            margin-bottom: 15px;
        }

        .popover-header h3 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #666;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .close-btn:hover {
            background: #f5f5f5;
            color: #333;
        }

        #department-form {
            padding: 0 20px 20px 20px;
        }

        #department-form .form-group {
            margin-bottom: 20px;
        }

        #department-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        #department-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        #department-form input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        #department-form .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

       

        @media (max-width: 1024px) {
            .container {
                width: 100%;
                margin-left: 0;
                border-radius: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .tab-button {
                padding: 15px 20px;
                font-size: 0.95em;
            }

            .header-container h1 {
                font-size: 1.8em;
            }
        }


        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        body.dark-mode .page-title h1{
            color:  white;
        }
        .page-title h1 {
            color:  #646565ff;
            font-size: 24px;
        }
        .export-btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }

        /* Statistics Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .wrapper-icon{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .wrapper-icon .number{
            margin-top: -10px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        body.dark-mode .stat-card {
            background: #232b36 !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
        }

        body.dark-mode .stat-card .label {
            color: white !important;
        }

        body.dark-mode .stat-card .number {
            color: #acbbefff !important;
        }

        .stat-card .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 28px;
            font-weight: bold;
            color: #023336;
        }
        .stat-card .label {
            color:gray;
            font-size: 14px;
        }


        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 20px 0;
        }

        body.dark-mode .filters-section {
            background: #232b36 !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
            z-index: 1000;
        }
        .filters-title {
            font-size: 18px;
            font-weight: bold;
            color: black;
            margin-bottom: 15px;
        }

        body.dark-mode .filters-title {
            color: white;
        }

        body.dark-mode .filter-group  label {
            color: #c4cdd5ff;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        .filter-group label {
            font-size: 14px;
            color: #4f5051ff;
            margin-bottom: 5px;
        }
        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .filter-actions {
            display: flex;
            gap: 10px;
        }
        .filter-btn {
            margin-left: 10px;
            width: 100%;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .filter-btn.apply {
            background: #4da674;
            color: white;
        }
        .filter-btn.clear {
            background: #6c757d;
            color: white;
        }
        .filter-btn:hover {
            transform: translateY(-1px);
        }


        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        /* Loading Animation Styles - Add to your <style> section */

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        body.dark-mode .loading-overlay {
            background: rgba(24, 28, 35, 0.95);
        }

        .loading-content {
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .spinner {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            border: 4px solid rgba(52, 152, 219, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 18px;
            color: #3498db;
            font-weight: 600;
            margin-bottom: 10px;
        }

        body.dark-mode .loading-text {
            color: #5dade2;
        }

        .loading-subtext {
            font-size: 14px;
            color: #7f8c8d;
            animation: pulse 1.5s ease-in-out infinite;
        }

        body.dark-mode .loading-subtext {
            color: #95a5a6;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        /* Table Loading State */
        .table-loading {
            position: relative;
            min-height: 300px;
        }

        .table-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body.dark-mode .table-loading::before {
            background: rgba(26, 35, 50, 0.8);
        }

        .inline-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(52, 152, 219, 0.2);
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            z-index: 11;
        }

        /* Skeleton Loading for Table */
        .skeleton-row {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            height: 45px;
        }

        body.dark-mode .skeleton-row {
            background: linear-gradient(90deg, #2c3e50 25%, #34495e 50%, #2c3e50 75%);
            background-size: 200% 100%;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-cell {
            padding: 12px;
        }

        .skeleton-content {
            background: #e0e0e0;
            height: 12px;
            border-radius: 4px;
            width: 80%;
        }

        body.dark-mode .skeleton-content {
            background: #34495e;
        }
    </style>
</head>
<body>

    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <div class="loading-text">Loading Employee Data</div>
            <div class="loading-subtext">Please wait while we fetch the information...</div>
        </div>
    </div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="EARIST_Logo (1).png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-title">HUMAN RESOURCES MANAGEMENT SYSTEM</span>
        </div>
        <ul class="sidebar-menu">
            <li><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><i class="fas fa-file-excel"></i>Import Excel</li>
            <li class="activeTab"><i class="fas fa-user"></i> Employees</li>
            <li><i class="fas fa-file-invoice"></i> Payslip Generator</li>
            <li><i class="fas fa-history"></i> Payslip History</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle" onclick="toggleDarkMode()"><i class="fas fa-moon"></i> Dark/Light Mode</li>
        </ul>
        <div class="credit">Payslip Generator System © 2025 Karris Project. Developed for EARIST HRMS. All Rights Reserved.</div>
    </nav>

    <div id="add-department-modal" popover class="centered-popover">
        <div class="popover-header">
            <h3 style="color: #3498db">Add New Department</h3>
            <button popovertarget="add-department-modal" popovertargetaction="hide" class="close-btn">
                <i class="fas fa-times"></i>    
            </button>
        </div>
        <form id="department-form"  method="POST" action="saveDepartment.php">
            <div class="form-group">
                <label for="new-department" style="color: #ffffff">Department Name:</label>
                <input type="text" id="new-department" name="department" required>
            </div>
            <div class="form-actions">
                <button type="button" popovertarget="add-department-modal" popovertargetaction="hide" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Department
                </button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="header-container">
            <h1><i class="fas fa-users"></i>Employee Management</h1>
            <p>Manage your workforce efficiently and effectively</p>
        </div>

        <div class="tab-navigation">
            <button class="tab-button active" onclick="switchTab('view')">
                <i class="fas fa-list"></i> View Employees
            </button>
            <button class="tab-button" onclick="switchTab('add')">
                <i class="fas fa-user-plus"></i> Add Employee
            </button>
        </div>


        <div class="main-content">
            <div id="viewTab" class="tab-content active">

            <div class="page-title">
                <h1><i class="fas fa-chart-bar"></i> Comprehensive Employee Data</h1>
                <button class="export-btn" onclick="exportToCSV()">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>

            <div class="stats-overview">
                <div class="stat-card">
                    <div class="wrapper-icon">
                        <div class="icon" style="color: #4da674;">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="number">342</div>
                    </div>
                    <div class="label">Total Employees</div>
                </div>
                <div class="stat-card">
                    <div class="wrapper-icon">
                        <div class="icon" style="color: #28a745;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="number" id="departments-number">23</div>
                    </div>
                    <div class="label">Total Departments</div>
                </div>
                <div class="stat-card">
                    <div class="wrapper-icon">
                        <div class="icon" style="color: #ffc107;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div id="payslip-number" class="number">45</div>
                    </div>
                    
                    <div class="label">Total Payslips Generated</div>
                </div>
                <div class="stat-card">
                    <div class="wrapper-icon">
                        <div class="icon" style="color: #17a2b8;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div id="grossSalary-number" class="number">12323</div>
                    </div>
                    
                    <div class="label">Total Gross Salary</div>
                </div>
            </div>

                <div class="filters-section">
                    <div class="filters-title">Search Employee Data</div>
                    <form method="GET" action="">
                        <div class="filters-grid">
                            <div class="filter-group">
                                <label for="student">Department</label>
                                <select name="department" id="department">
                                    <option value="">Select Department</option>
                                    <option value="General Administration">General Administration</option>
                                    <option value="Auxiliary">Auxiliary</option>
                                    <option value="Advance Education">Advance Education</option>
                                    <option value="College of Engineering">College of Engineering</option>
                                    <option value="College of Industrial Technology">College of Industrial Technology</option>
                                    <option value="College of Business Administration and Accountancy">College of Business Administration and Accountancy</option>
                                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                    <option value="College of Architecture and Fine Arts">College of Architecture and Fine Arts</option>
                                    <option value="College of Education">College of Education</option>
                                    <option value="Physical Education">Physical Education</option>
                                    <option value="Research">Research</option>
                                    <option value="Cavite Extension">Cavite Extension</option>
                                    <option value="Temporary Employee">Temporary Employee</option>
                                    <option value="New Employee Batch 3">New Employee Batch 3</option>
                                    <option value="New Employee Batch 4">New Employee Batch 4</option>
                                    <option value="New Employee Batch A">New Employee Batch A</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="grade">Month</label>
                                <select name="month" id="month">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label for="dataType">Data Type</label>
                                <select name="dataType" id="dataType">
                                    <option value="">Select Type</option>
                                    <option value="payroll">Payroll</option>
                                    <option value="remittance">Remittance</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="filter-btn apply">Search</button>
                                <button type="button" class="filter-btn clear" onclick="clearFilters()">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-wrapper">
                    <table class="table" id="employeeTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Withholding Tax</th>
                                <th>Personal Life Retirement</th>
                                <th>GSIS Salary Loan</th>
                                <th>GSIS Policy Loan</th>
                                <th>GFAL</th>
                                <th>CPL</th>
                                <th>MPL</th>
                                <th>MPL Lite</th>
                                <th>Emergency Loan</th>
                                <th>Total GSIS Deductions</th>
                                <th>PAG-IBIG Fund Contribution</th>
                                <th>PAG-IBIG 2</th>
                                <th>Multi-Purpose Loan</th>
                                <th>PAG-IBIG Calamity Loan</th>
                                <th>Total PAG-IBIG Deductions</th>
                                <th>PhilHealth</th>
                                <th>Disallowance</th>
                                <th>Landbank Salary Loan</th>
                                <th>Earist Credit Coop</th>
                                <th>FEU</th>
                                <th>MTSLA Salary Loan</th>
                                <th>ESLA</th>
                                <th>Total Other Deductions</th>
                                <th>Total Deductions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>    
                        <tbody id="employeeTableBody">
                            <!-- Employee data rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
                <div id="emptyState" class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>No employees found. Add your first employee to get started!</p>
                </div>
            </div>

            <!-- Add Employee Tab -->
            <div id="addTab" class="tab-content">
                <div class="section-header">
                    <div class="title">
                        <h2>Add New Employee</h2>
                    </div>
                    <div class="add-department-button">
                        <button popovertarget="add-department-modal" type="submit" class="btn btn-primary">
                           <i class="fas fa-plus"></i>  Add Department
                        </button>
                    </div>
                </div>
                <form id="employeeForm" method="POST" action="savePayroll.php">
                    <div class="form-section">
                        <h3><i class="fas fa-user-circle"></i> Basic Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name">Employee Name *</label>
                                <input type="text" id="name" name="name" required placeholder="Enter full name" required>
                            </div>
                            <div class="form-group">
                                <label for="position">Position *</label>
                                <input type="text" id="position" name="position" required placeholder="Enter position" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id="department" class="form-control" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="General Administration">General Administration</option>
                                    <option value="Auxiliary">Auxiliary</option>
                                    <option value="Advance Education">Advance Education</option>
                                    <option value="College of Engineering">College of Engineering</option>
                                    <option value="College of Industrial Technology">College of Industrial Technology</option>
                                    <option value="College of Business Administration and Accountancy">College of Business Administration and Accountancy</option>
                                    <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                                    <option value="College of Architecture and Fine Arts">College of Architecture and Fine Arts</option>
                                    <option value="College of Education">College of Education</option>
                                    <option value="Physical Education">Physical Education</option>
                                    <option value="Research">Research</option>
                                    <option value="Cavite Extension">Cavite Extension</option>
                                    <option value="Temporary Employee">Temporary Employee</option>
                                    <option value="New Employee Batch 3">New Employee Batch 3</option>
                                    <option value="New Employee Batch 4">New Employee Batch 4</option>
                                    <option value="New Employee Batch A">New Employee Batch A</option>
                                </select> 
                            </div>

                            <div class="form-group">
                                <label for="department">Month</label>
                                <select id="month" class="form-control" name="month" required>
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class="form-section payroll-section">
                        <h3><i class="fas fa-file-invoice-dollar"></i> Employee Payroll</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="rateNbc594">rateNbc594</label>
                                <input type="number" step="0.01" id="rateNbc594" name="rateNbc594" placeholder="0.00" required>
                            </div>
                            <div class="form-group">
                                <label for="nbcDiffl597">nbcDiff594</label>
                                <input type="number" step="0.01" id="nbcDiff594" name="nbcDiffl597" placeholder="0.00" required>
                            </div>
                            <div class="form-group">
                                <label for="increment">Increment</label>
                                <input type="number" step="0.01" id="increment" name="increment" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="grossSalary">Gross Salary</label>
                                <input type="number" step="0.01" id="grossSalary" name="grossSalary" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="absent">Absent</label>
                                <input type="number" step="0.01" id="absent" name="absent" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="days">Days</label>
                                <input type="number" step="0.01" id="days" name="days" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="hours">Hours</label>
                                <input type="number" step="0.01" id="hours" name="hours" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="minutes">Minutes</label>
                                <input type="number" step="0.01" id="minutes" name="minutes" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="withHoldingTax">Withholding Tax</label>
                                <input type="number" step="0.01" id="withHoldingTax" name="withHoldingTax" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalGsisDeds">Total GSIS Deductions</label>
                                <input type="number" step="0.01" id="totalGsisDeds" name="totalGsisDeds" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalPagibigDeds">Total PAG-IBIG Deductions</label>
                                <input type="number" step="0.01" id="totalPagibigDeds" name="totalPagibigDeds" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="philHealthEmployeeShare">PhilHealth Employee Share</label>
                                <input type="number" step="0.01" id="philHealthEmployeeShare" name="philHealthEmployeeShare" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalOtherDeds">Total Other Deductions</label>
                                <input type="number" step="0.01" id="totalOtherDeds" name="totalOtherDeds" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalDeds">Total Deductions</label>
                                <input type="number" step="0.01" id="totalDeds" name="totalDeds" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pay1st">1st Pay</label>
                                <input type="number" step="0.01" id="pay1st" name="pay1st" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pay2nd">2nd Pay</label>
                                <input type="number" step="0.01" id="pay2nd" name="pay2nd" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="rtIns">RT Insurance</label>
                                <input type="number" step="0.01" id="rtIns" name="rtIns" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="employeesCompensation">Employee's Compensation</label>
                                <input type="number" step="0.01" id="employeesCompensation" name="employeesCompensation" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="philHealthGovernmentShare">PhilHealth Government Share</label>
                                <input type="number" step="0.01" id="philHealthGovernmentShare" name="philHealthGovernmentShare" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pagibig">PAG-IBIG</label>
                                <input type="number" step="0.01" id="pagibig" name="pagibig" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="netSalary">Net Salary</label>
                                <input type="number" step="0.01" id="netSalary" name="netSalary" placeholder="0.00" required>
                            </div>

                        </div>
                    </div>

                    <div class="form-section remittance-section">
                        <h3><i class="fas fa-file-invoice-dollar"></i> Employee Remittance</h3> 
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="withholdingTax">Withholding Tax</label>
                                <input type="number" step="0.01" id="withholdingTax" name="withholdingTaxRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="personalLifeRet">Personal Life Retirement</label>
                                <input type="number" step="0.01" id="personalLifeRet" name="personalLifeRetRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="gsisSalaryLoan">GSIS Salary Loan</label>
                                <input type="number" step="0.01" id="gsisSalaryLoan" name="gsisSalaryLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="gsisPolicyLoan">GSIS Policy Loan</label>
                                <input type="number" step="0.01" id="gsisPolicyLoan" name="gsisPolicyLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="gfal">GFAL</label>
                                <input type="number" step="0.01" id="gfal" name="gfalRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="cpl">CPL</label>
                                <input type="number" step="0.01" id="cpl" name="cplRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="mpl">MPL</label>
                                <input type="number" step="0.01" id="mpl" name="mplRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="mplLite">MPL Lite</label>
                                <input type="number" step="0.01" id="mplLite" name="mplLiteRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="emergencyLoan">Emergency Loan</label>
                                <input type="number" step="0.01" id="emergencyLoan" name="emergencyLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalGsisDeds">Total GSIS Deductions</label>
                                <input type="number" step="0.01" id="totalGsisDeds" name="totalGsisDedsRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pagibigFundCont">PAG-IBIG Fund Contribution</label>
                                <input type="number" step="0.01" id="pagibigFundCont" name="pagibigFundContRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pagibig2">PAG-IBIG 2</label>
                                <input type="number" step="0.01" id="pagibig2" name="pagibig2Remit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="multiPurpLoan">Multi-Purpose Loan</label>
                                <input type="number" step="0.01" id="multiPurpLoan" name="multiPurpLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="pagibigCalamityLoan">PAG-IBIG Calamity Loan</label>
                                <input type="number" step="0.01" id="pagibigCalamityLoan" name="pagibigCalamityLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalPagibigDeds">Total PAG-IBIG Deductions</label>
                                <input type="number" step="0.01" id="totalPagibigDeds" name="totalPagibigDedsRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="philHealth">PhilHealth</label>
                                <input type="number" step="0.01" id="philHealth" name="philHealthRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="disallowance">Disallowance</label>
                                <input type="number" step="0.01" id="disallowance" name="disallowanceRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="landbankSalaryLoan">Landbank Salary Loan</label>
                                <input type="number" step="0.01" id="landbankSalaryLoan" name="landbankSalaryLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="earistCreditCoop">Earist Credit Coop</label>
                                <input type="number" step="0.01" id="earistCreditCoop" name="earistCreditCoopRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="feu">FEU</label>
                                <input type="number" step="0.01" id="feu" name="feuRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="mtslaSalaryLoan">MTSLA Salary Loan</label>
                                <input type="number" step="0.01" id="mtslaSalaryLoan" name="mtslaSalaryLoanRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="esla">ESLA</label>
                                <input type="number" step="0.01" id="esla" name="eslaRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalOtherDeds">Total Other Deductions</label>
                                <input type="number" step="0.01" id="totalOtherDeds" name="totalOtherDedsRemit" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label for="totalDeds">Total Deductions</label>
                                <input type="number" step="0.01" id="totalDeds" name="totalDedsRemit" placeholder="0.00" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let employees = [];
        let currentDataType = 'remittance';
        let isLoading = false;

        // Show loading overlay
        function showLoadingOverlay() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        // Hide loading overlay
        function hideLoadingOverlay() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Show table loading
        function showTableLoading() {
            const wrapper = document.querySelector('.table-wrapper');
            const tbody = document.getElementById('employeeTableBody');
            
            wrapper.classList.add('table-loading');
            
            // Add inline spinner
            if (!document.querySelector('.inline-spinner')) {
                const spinner = document.createElement('div');
                spinner.className = 'inline-spinner';
                wrapper.appendChild(spinner);
            }
            
            // Show skeleton rows
            tbody.innerHTML = generateSkeletonRows(5);
        }

        // Hide table loading
        function hideTableLoading() {
            const wrapper = document.querySelector('.table-wrapper');
            const spinner = document.querySelector('.inline-spinner');
            
            wrapper.classList.remove('table-loading');
            if (spinner) {
                spinner.remove();
            }
        }

        // Generate skeleton loading rows
        function generateSkeletonRows(count) {
            let rows = '';
            for (let i = 0; i < count; i++) {
                rows += `
                    <tr class="skeleton-row">
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                        <td class="skeleton-cell"><div class="skeleton-content"></div></td>
                    </tr>
                `;
            }
            return rows;
        }

        async function loadEmployees(filters = {}) {
            if (isLoading) return;
            
            isLoading = true;
            showTableLoading();
            
            try {
                const params = new URLSearchParams(filters);
                const response = await fetch(`getEmployeeData.php?${params.toString()}`);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();

                employees = data.employees;
                currentDataType = data.dataType || 'remittance';
                
                // Update statistics with animation
                animateValue('number', 0, data.totalEmployees, 1000);
                animateValue('departments-number', 0, data.totalDepartments, 1000);
                animateValue('payslip-number', 0, data.totalPayslip, 1000);
                document.getElementById('grossSalary-number').textContent = data.totalGrossSalary;

                // Small delay to show loading animation
                await new Promise(resolve => setTimeout(resolve, 500));
                
                renderEmployeeTable();
            } catch (error) {
                console.error('Error loading employees:', error);
                showError('Failed to load employee data. Please try again.');
            } finally {
                isLoading = false;
                hideTableLoading();
            }
        }

        // Animate number counting
        function animateValue(elementId, start, end, duration) {
            const element = document.getElementById(elementId) || document.querySelector(`.${elementId}`);
            if (!element) return;
            
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = Math.round(current);
            }, 16);
        }

        // Show error message
        function showError(message) {
            const tbody = document.getElementById('employeeTableBody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="26" style="text-align: center; padding: 40px; color: #e74c3c;">
                        <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                        <strong>${message}</strong>
                    </td>
                </tr>
            `;
        }

        function renderEmployeeTable() {
            const tbody = document.getElementById('employeeTableBody');
            const thead = document.querySelector('.table thead tr');
            const emptyState = document.getElementById('emptyState');
            
            if (employees.length === 0) {
                tbody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            // Update table headers based on data type
            if (currentDataType === 'payroll') {
                thead.innerHTML = `
                    <th>Name</th>
                    <th>Position</th>
                    <th>Rate NBC 594</th>
                    <th>NBC Diff'l 597</th>
                    <th>Increment</th>
                    <th>Gross Salary</th>
                    <th>Absent</th>
                    <th>Days</th>
                    <th>Hours</th>
                    <th>Minutes</th>
                    <th>Withholding Tax</th>
                    <th>Total GSIS Deds</th>
                    <th>Total PAG-IBIG Deds</th>
                    <th>PhilHealth 1</th>
                    <th>Total Other Deds</th>
                    <th>Total Deds</th>
                    <th>Pay 1st</th>
                    <th>Pay 2nd</th>
                    <th>RT INS</th>
                    <th>Employee Compensation</th>
                    <th>PhilHealth 2</th>
                    <th>PAG-IBIG</th>
                    <th>Net Salary</th>
                    <th>Actions</th>
                `;
                
                tbody.innerHTML = employees.map((employee, index) => `
                    <tr style="animation: fadeIn 0.3s ease-in-out ${index * 0.05}s both;">
                        <td><strong>${employee.name || ''}</strong></td>
                        <td>${employee.position || ''}</td>
                        <td>${employee.rateNbc594 || '0.00'}</td>
                        <td>${employee.nbcDiffl597 || '0.00'}</td>
                        <td>${employee.increment || '0.00'}</td>
                        <td>${employee.grossSalary || '0.00'}</td>
                        <td>${employee.absent || '0.00'}</td>
                        <td>${employee.days || '0.00'}</td>
                        <td>${employee.hours || '0.00'}</td>
                        <td>${employee.minutes || '0.00'}</td>
                        <td>${employee.withHoldingTax || '0.00'}</td>
                        <td>${employee.totalGsisDeds || '0.00'}</td>
                        <td>${employee.totalPagibigDeds || '0.00'}</td>
                        <td>${employee.philHealthEmployeeShare || '0.00'}</td>
                        <td>${employee.totalOtherDeds || '0.00'}</td>
                        <td>${employee.totalDeds || '0.00'}</td>
                        <td>${employee.pay1st || '0.00'}</td>
                        <td>${employee.pay2nd || '0.00'}</td>
                        <td>${employee.rtIns || '0.00'}</td>
                        <td>${employee.employeesCompensation || '0.00'}</td>
                        <td>${employee.philHealthGovernmentShare || '0.00'}</td>
                        <td>${employee.pagibig || '0.00'}</td>
                        <td>${employee.netSalary || '0.00'}</td>
                        <td>
                            <button class="btn-edit" onclick="editEmployee(${index})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="deleteEmployee(${index}, ${employee.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                // Remittance table
                thead.innerHTML = `
                    <th>Name</th>
                    <th>Position</th>
                    <th>Withholding Tax</th>
                    <th>Personal Life Ret</th>
                    <th>GSIS Salary Loan</th>
                    <th>GSIS Policy Loan</th>
                    <th>GFAL</th>
                    <th>CPL</th>
                    <th>MPL</th>
                    <th>MPL Lite</th>
                    <th>Emergency Loan</th>
                    <th>Total GSIS Deds</th>
                    <th>PAG-IBIG Fund Cont</th>
                    <th>PAG-IBIG 2</th>
                    <th>Multi-Purpose Loan</th>
                    <th>PAG-IBIG Calamity Loan</th>
                    <th>Total PAG-IBIG Deds</th>
                    <th>PhilHealth 3</th>
                    <th>Disallowance</th>
                    <th>Landbank Salary Loan</th>
                    <th>Earist Credit Coop</th>
                    <th>FEU</th>
                    <th>MTSLA Salary Loan</th>
                    <th>ESLA</th>
                    <th>Total Other Deds</th>
                    <th>Total Deds</th>
                    <th>Actions</th>
                `;
                
                tbody.innerHTML = employees.map((employee, index) => `
                    <tr style="animation: fadeIn 0.3s ease-in-out ${index * 0.05}s both;">
                        <td><strong>${employee.name || ''}</strong></td>
                        <td>${employee.position || ''}</td>
                        <td>${employee.withHoldingTax || '0.00'}</td>
                        <td>${employee.personalLifeRet || '0.00'}</td>
                        <td>${employee.gsisSalaryLoan || '0.00'}</td>
                        <td>${employee.gsisPolicyLoan || '0.00'}</td>
                        <td>${employee.gfal || '0.00'}</td>
                        <td>${employee.cpl || '0.00'}</td>
                        <td>${employee.mpl || '0.00'}</td>
                        <td>${employee.mplLite || '0.00'}</td>
                        <td>${employee.emergencyLoan || '0.00'}</td>
                        <td>${employee.totalGsisDeds || '0.00'}</td>
                        <td>${employee.pagibigFundCont || '0.00'}</td>
                        <td>${employee.pagibig2 || '0.00'}</td>
                        <td>${employee.multiPurpLoan || '0.00'}</td>
                        <td>${employee.pagibigCalamityLoan || '0.00'}</td>
                        <td>${employee.totalPagibigDeds || '0.00'}</td>
                        <td>${employee.philHealth || '0.00'}</td>
                        <td>${employee.disallowance || '0.00'}</td>
                        <td>${employee.landbankSalaryLoan || '0.00'}</td>
                        <td>${employee.earistCreditCoop || '0.00'}</td>
                        <td>${employee.feu || '0.00'}</td>
                        <td>${employee.mtslaSalaryLoan || '0.00'}</td>
                        <td>${employee.esla || '0.00'}</td>
                        <td>${employee.totalOtherDeds || '0.00'}</td>
                        <td>${employee.totalDeds || '0.00'}</td>
                        <td>
                            <button class="btn-edit" onclick="editEmployee(${index})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="deleteEmployee(${index}, ${employee.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `).join('');
            }
        }

        // Handle filter form submission
        document.querySelector('.filters-section form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const filters = {
                department: document.getElementById('department').value,
                month: document.getElementById('month').value,
                dataType: document.getElementById('dataType').value
            };
            
            loadEmployees(filters);
        });

        function clearFilters() {
            document.getElementById('department').value = '';
            document.getElementById('month').value = '';
            document.getElementById('dataType').value = '';
            loadEmployees();
        }

        function switchTab(tab) {
            const viewTab = document.getElementById('viewTab');
            const addTab = document.getElementById('addTab');
            const tabButtons = document.querySelectorAll('.tab-button');

            if (tab === 'view') {
                viewTab.classList.add('active');
                addTab.classList.remove('active');
                tabButtons[0].classList.add('active');
                tabButtons[1].classList.remove('active');
            } else {
                viewTab.classList.remove('active');
                addTab.classList.add('active');
                tabButtons[0].classList.remove('active');
                tabButtons[1].classList.add('active');
            }
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        }
        

        document.addEventListener('DOMContentLoaded', function() {
            // Show initial loading overlay
            showLoadingOverlay();
            
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
            }
            
            // Load employees on page load
            setTimeout(() => {
                hideLoadingOverlay();
                loadEmployees();
            }, 800);
            
            // Load departments dynamically
            fetch('get_departments.php')
                .then(res => res.json())
                .then(data => {
                    const deptSelects = document.querySelectorAll('#department, select[name="department"]');
                    deptSelects.forEach(select => {
                        const currentValue = select.value;
                        select.innerHTML = '<option value="">Select Department</option>';
                        data.departments.forEach(dept => {
                            select.innerHTML += `<option value="${dept.department_name}">${dept.department_name}</option>`;
                        });
                        if (currentValue) select.value = currentValue;
                    });
                });
        });

        // Sidebar navigation
        document.querySelectorAll('.sidebar-menu li').forEach(item => {
            item.addEventListener('click', function() {
                if (this.textContent.includes('Dashboard')) window.location.href = 'dashboard.php';
                if (this.textContent.includes('Excel')) window.location.href = 'import_excel.php';
                if (this.textContent.includes('Employees')) window.location.href = 'employee.php';
                if (this.textContent.includes('Payslip Generator')) window.location.href = 'index.php';
                if (this.textContent.includes('Payslip History')) window.location.href = 'payslip_history.php';
                if (this.textContent.includes('Reports')) window.location.href = 'reports.php';
                if (this.classList.contains('mode-toggle')) toggleDarkMode();
            });
        });

        // Form submission
        document.getElementById('employeeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            
            fetch('savePayroll.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                alert('Employee added successfully!');
                resetForm();
                switchTab('view');
                loadEmployees();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving employee data. Please try again.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        function resetForm() {
            document.getElementById('employeeForm').reset();
        }

        function deleteEmployee(index, id) {
            if (confirm('Are you sure you want to delete this employee?')) {
                showTableLoading();
                
                fetch(`deleteEmployee.php?id=${id}&type=${currentDataType}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Employee deleted successfully!');
                        loadEmployees();
                    } else {
                        alert('Error deleting employee');
                        hideTableLoading();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting employee');
                    hideTableLoading();
                });
            }
        }

        function exportToCSV() {
            if (employees.length === 0) {
                alert('No data to export');
                return;
            }
            
            let csv = '';
            const headers = Array.from(document.querySelectorAll('.table thead th')).map(th => th.textContent);
            csv += headers.join(',') + '\n';
            
            employees.forEach(employee => {
                const row = Object.values(employee).map(val => `"${val}"`).join(',');
                csv += row + '\n';
            });
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `employees_${currentDataType}_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
        }
    </script>
</body>
</html>
