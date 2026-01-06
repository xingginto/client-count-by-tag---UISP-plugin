# Client Count by Tag - UISP Plugin

A UISP/UCRM plugin that displays client count statistics grouped by client tags.

## Features

- **Dashboard Widget**: Displays a compact summary of client counts by tag on the UISP dashboard
- **Full Report Page**: Accessible from Reports menu with detailed statistics
- **Statistics Include**:
  - Total clients per tag
  - Active clients
  - Suspended clients
  - Archived clients
  - Lead clients

## Installation

1. Run `composer install` in the plugin directory to install dependencies
2. Create a ZIP archive of the plugin contents
3. Upload the ZIP archive to UISP (System > Plugins)
4. Enable the plugin

## Building the Plugin

```bash
cd client-count-by-tag
composer install
cd ..
zip -r client-count-by-tag.zip client-count-by-tag -x "*.git*" -x "*.DS_Store"
```

Or use the UCRM Plugin SDK pack script:
```bash
cd client-count-by-tag
./vendor/bin/pack-plugin
```

## Requirements

- UCRM 2.14.0+ or UISP 1.0.0+
- PHP 7.4+

## Views

### Dashboard Widget
Shows a compact view with:
- Summary totals (Total, Active, Suspended, Archived)
- List of tags with their respective counts

### Full Report (Reports > Client Count by Tag)
Shows:
- Summary cards with grand totals
- Detailed table with all tags and counts
- Visual tag cards for quick overview

## API Endpoints Used

- `GET /client-tags` - Fetches all client tags
- `GET /clients` - Fetches all clients with their tags and status

## Client Statuses

- **Lead (0)**: Potential client
- **Active (1)**: Currently active client
- **Suspended (2)**: Temporarily suspended client
- **Archived (3)**: Archived/inactive client

## License

MIT
