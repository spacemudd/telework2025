<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header h2 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0 0 10px 0;
        }
        .header p {
            color: #7f8c8d;
            margin: 5px 0;
        }
        .stats-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin: 0 0 30px 0;
            flex-wrap: wrap;
        }
        .stat-box {
            flex: 1;
            min-width: 150px;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }
        .stat-box.assigned {
            border-top: 4px solid #3498db;
        }
        .stat-box.updated {
            border-top: 4px solid #f39c12;
        }
        .stat-box.completed {
            border-top: 4px solid #27ae60;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
            color: #2c3e50;
        }
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }
        .summary-section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .summary-title {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 15px;
            padding-right: 10px;
            border-right: 4px solid #3498db;
        }
        .section {
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 6px;
            padding: 20px;
        }
        .employee-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #3498db;
            color: #fff;
            border-radius: 4px;
        }
        .task-list {
            margin: 20px 0;
        }
        .task-list h3 {
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 15px;
            padding-right: 10px;
            border-right: 4px solid #3498db;
        }
        .task-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }
        .task-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .task-meta {
            color: #666;
            font-size: 14px;
            display: flex;
            gap: 15px;
        }
        .task-meta span {
            display: inline-block;
            padding: 4px 8px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .no-tasks {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .priority-high {
            color: #e74c3c;
        }
        .priority-medium {
            color: #f39c12;
        }
        .priority-low {
            color: #27ae60;
        }
        .status-completed {
            color: #27ae60;
        }
        .status-in_progress {
            color: #f39c12;
        }
        .status-pending {
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ url('/img/logo_v2_on_white.png') }}" alt="الشعار" class="logo">
            <h2>تقرير المهام اليومي</h2>
            <p>التاريخ: {{ \Carbon\Carbon::parse($yesterday)->translatedFormat('l j F Y') }}</p>
            <p>الشركة: {{ $company->name }}</p>
        </div>

        <div class="summary-section">
            <h3 class="summary-title">ملخص الأنشطة</h3>
            <div class="stats-container">
                @php
                    $totalAssigned = 0;
                    $totalUpdated = 0;
                    $totalCompleted = 0;

                    foreach($tasksByEmployee as $tasks) {
                        $totalAssigned += count($tasks['assigned']);
                        $totalUpdated += count($tasks['updated']);
                        $totalCompleted += count($tasks['completed']);
                    }
                @endphp

                <div class="stat-box assigned">
                    <div class="stat-number">{{ $totalAssigned }}</div>
                    <div class="stat-label">مهام جديدة</div>
                </div>

                <div class="stat-box updated">
                    <div class="stat-number">{{ $totalUpdated }}</div>
                    <div class="stat-label">مهام محدثة</div>
                </div>

                <div class="stat-box completed">
                    <div class="stat-number">{{ $totalCompleted }}</div>
                    <div class="stat-label">مهام مكتملة</div>
                </div>
            </div>
        </div>

        @if(count($tasksByEmployee) > 0)
            @foreach($tasksByEmployee as $employeeName => $tasks)
                <div class="section">
                    <div class="employee-name">{{ $employeeName }}</div>

                    @if(count($tasks['assigned']) > 0)
                        <div class="task-list">
                            <h3>المهام الجديدة المسندة:</h3>
                            @foreach($tasks['assigned'] as $task)
                                <div class="task-item">
                                    <div class="task-title">{{ $task->title }}</div>
                                    <div class="task-meta">
                                        <span class="priority-{{ $task->priority }}">
                                            الأولوية: {{ __('words.' . $task->priority) }}
                                        </span>
                                        <span>
                                            تاريخ الاستحقاق: {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('l j F Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(count($tasks['updated']) > 0)
                        <div class="task-list">
                            <h3>المهام المحدثة:</h3>
                            @foreach($tasks['updated'] as $task)
                                <div class="task-item">
                                    <div class="task-title">{{ $task->title }}</div>
                                    <div class="task-meta">
                                        <span class="status-{{ $task->status }}">
                                            الحالة الجديدة: {{ __('words.'. $task->status) }}
                                        </span>
                                        <span class="priority-{{ $task->priority }}">
                                            الأولوية: {{ __('words.' . $task->priority) }}
                                        </span>
                                        <span>
                                            تاريخ الاستحقاق: {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('l j F Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(count($tasks['completed']) > 0)
                        <div class="task-list">
                            <h3>المهام المكتملة:</h3>
                            @foreach($tasks['completed'] as $task)
                                <div class="task-item">
                                    <div class="task-title">{{ $task->title }}</div>
                                    <div class="task-meta">
                                        <span class="priority-{{ $task->priority }}">
                                            الأولوية: {{ __('words.' . $task->priority) }}
                                        </span>
                                        <span>
                                            تاريخ الاستحقاق: {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('l j F Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <p class="no-tasks">لم يتم تسجيل أي نشاط للمهام بالأمس.</p>
        @endif
    </div>
</body>
</html>
