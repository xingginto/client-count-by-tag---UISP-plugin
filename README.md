# Client Count by Tag - UISP Plugin

A comprehensive UISP/UCRM plugin that displays detailed client count statistics grouped by client tags with both dashboard widget and full reporting capabilities.

## Features

- **Dashboard Widget**: Compact summary of client counts by tag directly on UISP dashboard
- **Full Report Page**: Detailed statistics accessible from Reports menu
- **Comprehensive Statistics**:
  - Total clients per tag
  - Active clients count
  - Suspended clients count
  - Archived clients count
  - Lead clients count
- **Real-time Data**: Live client information from UCRM database
- **Visual Interface**: Clean, modern UI with card-based layout

## Requirements

- **UCRM Version**: 2.14.0 or higher
- **UISP Version**: 1.0.0 or higher
- **PHP Version**: 7.4 or higher
- **Composer**: For dependency management

## Installation

### Method 1: Direct Upload (Recommended)

1. **Download the Plugin**
   - Download the plugin ZIP file from the GitHub repository
   - Or clone the repository and build the plugin (see Building section)

2. **Upload to UISP**
   - Log in to your UISP admin panel
   - Navigate to **System > Plugins**
   - Click **"Add Plugin"** or **"Upload Plugin"**
   - Select the downloaded ZIP file
   - Click **"Upload"**

3. **Enable the Plugin**
   - Find "Client Count by Tag" in the plugins list
   - Click the toggle to enable it
   - The plugin will appear in:
     - Dashboard widgets
     - Reports menu (under "Client Count by Tag")

### Method 2: Manual Installation

1. **Access Server**
   - SSH into your UISP server
   - Navigate to the plugins directory: `/var/www/ucrm/data/plugins/`

2. **Extract Plugin**
   ```bash
   cd /var/www/ucrm/data/plugins/
   unzip client-count-by-tag.zip
   ```

3. **Set Permissions**
   ```bash
   chown -R www-data:www-data client-count-by-tag/
   chmod -R 755 client-count-by-tag/
   ```

4. **Restart Services**
   ```bash
   sudo systemctl restart ucrm
   ```

## Building the Plugin

If you want to build from source:

```bash
# Clone or navigate to plugin directory
cd "Client Count by Tag with details V1.0.0"

# Install dependencies
composer install

# Create ZIP package
zip -r client-count-by-tag.zip . -x "*.git*" -x "*.DS_Store" -x "vendor/composer/*" -x "composer.lock"

# Or use UCRM Plugin SDK
./vendor/bin/pack-plugin
```

## Usage

### Dashboard Widget
- Automatically appears on the main dashboard after installation
- Shows quick overview of client counts by tag
- Click to view detailed report

### Full Report
1. Navigate to **Reports > Client Count by Tag**
2. View comprehensive statistics including:
   - Summary cards with grand totals
   - Detailed table with all tags and counts
   - Visual tag cards for quick overview
   - Client status breakdowns

## Client Statuses Explained

- **Lead (0)**: Potential clients not yet activated
- **Active (1)**: Currently active clients with services
- **Suspended (2)**: Clients with temporarily suspended services
- **Archived (3)**: Inactive or closed client accounts

## API Endpoints Used

- `GET /client-tags` - Retrieves all available client tags
- `GET /clients` - Fetches client data with tags and status information

## Troubleshooting

### Plugin Not Showing
- Ensure plugin is properly enabled
- Check UISP logs for errors
- Verify file permissions are correct

### No Data Displayed
- Check if clients have tags assigned
- Verify UCRM API connectivity
- Ensure client data exists in the system

### Dashboard Widget Issues
- Clear browser cache
- Refresh the dashboard
- Check browser console for JavaScript errors

## Security

- Uses UCRM authentication system
- Respects user permissions
- No external API calls
- Secure data access patterns

## Performance

- Optimized database queries
- Efficient data caching
- Minimal server impact
- Fast loading times

## Support

For plugin-related issues:
- Create issue in GitHub repository
- Check UCRM documentation
- Verify UISP system requirements

## Author

**xingginto**

## License

MIT License - feel free to modify and distribute
