# Simulation Commands Documentation

## Fill Missing Simulated Tasks Command

The `simulation:fill-missing-tasks` command is designed to fill in missing simulated tasks for companies that have simulation enabled. This command ensures that companies have a consistent history of simulated tasks since their creation date.

### Features

- **Finds companies with enabled simulation**: Only processes companies that have simulation enabled
- **Identifies missing days**: Finds days without any tasks since company creation
- **Avoids weekends**: Skips Friday and Saturday (weekends in Saudi Arabia)
- **Respects company configuration**: Creates tasks according to each company's `tasks_per_day` setting
- **Dry run mode**: Test the command without actually creating tasks
- **Progress tracking**: Shows progress bar and detailed output

### Usage

#### Basic Usage
```bash
php artisan simulation:fill-missing-tasks
```

#### Dry Run (Recommended for testing)
```bash
php artisan simulation:fill-missing-tasks --dry-run
```

#### Process Specific Company
```bash
php artisan simulation:fill-missing-tasks --company-id="company-uuid-here"
```

#### Process Specific Company with Dry Run
```bash
php artisan simulation:fill-missing-tasks --company-id="company-uuid-here" --dry-run
```

### How It Works

1. **Fetches Companies**: Gets all companies that have simulation enabled (`is_enabled = true`)
2. **Date Range**: For each company, determines the date range from company creation to yesterday (avoids today since regular job handles it)
3. **Missing Days**: Identifies days that don't have any tasks for the company
4. **Weekend Filtering**: Skips Friday (day 5) and Saturday (day 6)
5. **Task Creation**: For each missing day, creates tasks for each employee according to the company's `tasks_per_day` configuration
6. **Job Dispatching**: Uses `GenerateSimulatedTasksForDateJob` to create tasks with proper timestamps

### Output Example

```
Starting to fill missing simulated tasks...
Found 33 companies with enabled simulation.
DRY RUN MODE: No tasks will actually be created.

Processing company: شركة عبد الله مشاري عبد الله الحسيني للهندسة المدنية
Found 77 missing days for company: شركة عبد الله مشاري عبد الله الحسيني للهندسة المدنية
Creating tasks for date: 2025-07-17
Skipping weekend: 2025-07-18 (day of week: 5)
Skipping weekend: 2025-07-19 (day of week: 6)
Creating tasks for date: 2025-07-20
...
Would create 504 tasks for 56 days in company: شركة عبد الله مشاري عبد الله الحسيني للهندسة المدنية

Summary:
- Total companies processed: 33
- Total days processed: 922
- Total tasks would be queued: 10217
```

### Related Commands

- `simulation:enable-all-companies` - Enable simulation for all companies
- `simulation:enable-existing-companies` - Enable simulation for companies without configs

### Files Created

- `app/Console/Commands/FillMissingSimulatedTasks.php` - Main command file
- `app/Jobs/GenerateSimulatedTasksForDateJob.php` - Job for creating tasks with specific dates

### Notes

- The command processes companies up to yesterday to avoid conflicts with the daily scheduled job
- Tasks are created with random timestamps during working hours (8 AM to 5 PM GMT+3)
- Each task is assigned to a random employee within the company
- The command respects the company's `tasks_per_day` configuration
- Weekend skipping is based on Saudi Arabia's weekend (Friday and Saturday) 