# Testing Notes - Events Page

## Current Changes (Temporary)

### File: `app/Http/Controllers/EventController.php`

**Lines 26-38**: Temporary modification for testing

#### What was changed:
```php
// BEFORE (Production):
$params = [
    'date_from' => $today, // Shows only future events from today onwards
    'sort_by' => 'date',
    'sort_order' => 'ASC',
];

// AFTER (Testing - Current):
$monthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
$monthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');

$params = [
    'date_from' => $monthStart, // Shows all events from start of current month
    'date_to' => $monthEnd,     // Up to end of current month
    'sort_by' => 'date',
    'sort_order' => 'ASC',
];
```

#### Why changed:
- **Testing purpose**: To load and display ALL events for the current month (January 2026)
- **Original behavior**: Only shows events from today onwards (future events only)
- **Test behavior**: Shows events from Jan 1, 2026 to Jan 31, 2026 (including past dates within current month)

#### To restore production behavior:
Replace lines 26-38 in `EventController.php` with:
```php
$params = [
    'page' => $page,
    'per_page' => 9,
    'date_from' => $today, // Always search only future events
    'sort_by' => 'date',
    'sort_order' => 'ASC',
];
```

Remove these lines:
- Line 26-29: Comment and month calculation
- Line 35: `'date_to' => $monthEnd,`

---

## Additional Test Scenarios

### To test different months:
```php
// February 2026
$monthStart = Carbon::create(2026, 2, 1)->format('Y-m-d');
$monthEnd = Carbon::create(2026, 2, 28)->format('Y-m-d');

// All events for 2026
$params['date_from'] = '2026-01-01';
$params['date_to'] = '2026-12-31';
```

### To test without date restrictions (all events):
```php
$params = [
    'page' => $page,
    'per_page' => 9,
    // Remove 'date_from' completely
    'sort_by' => 'date',
    'sort_order' => 'ASC',
];
```

---

## Modified: 2026-01-18
## TODO: Restore production settings after testing is complete
