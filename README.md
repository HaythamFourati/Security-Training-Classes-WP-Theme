# Security Training Classes - WordPress Theme

This is a custom WordPress theme developed for the Security Training Academy website. Its primary feature is a dynamic "Upcoming Classes & Registration" section on the homepage that integrates with the Bookeo API to display real-time class availability.

## Features

- **Bookeo API Integration**: Fetches and displays upcoming classes directly from the Bookeo platform, ensuring the schedule is always up-to-date.
- **Dynamic Class Grid**: Presents classes in a clean, responsive grid layout on the homepage.
- **Client-Side Filtering & Pagination**: Allows users to filter classes by category (Guard Training, Firearms, SPO) and navigate through pages without reloading the page.
- **"Read More" Modal Popups**: Each class card has a "Read More" link that opens a modal popup with the full class description, providing detailed information without navigating away from the main page.
- **Responsive Design**: Built with Tailwind CSS for a fully responsive experience on desktops, tablets, and mobile devices.
- **Secure API Key Handling**: API keys are stored securely in the WordPress options table and are not exposed on the client-side.

## Technical Stack

- **Backend**: WordPress, PHP
- **Frontend**: JavaScript (ES6+), Tailwind CSS
- **Build Tool**: `@wordpress/scripts` for compiling JavaScript and managing dependencies.
- **API**: Bookeo API v2

## Setup & Installation

1.  **Clone the repository** into your `wp-content/themes` directory:
    ```bash
    git clone https://github.com/HaythamFourati/Security-Training-Classes-WP-Theme.git security-training-classes-wp-theme
    ```

2.  **Install dependencies** using npm:
    ```bash
    cd security-training-classes-wp-theme
    npm install
    ```

3.  **Set Bookeo API Keys**:
    This theme requires Bookeo API and Secret keys to function. For security, these are stored in the WordPress database. You must add them to the `wp_options` table with the following `option_name` values:
    - `bookeo_api_key`
    - `bookeo_secret_key`

4.  **Activate the theme** in the WordPress admin dashboard under `Appearance > Themes`.

## Development

This theme uses `@wordpress/scripts` for asset compilation.

-   **To build for production (minify assets):**
    ```bash
    npm run build
    ```

-   **To start the development server (with live reloading):**
    ```bash
    npm run start
    ```

## Key Files & Structure

-   `front-page.php`: Contains the primary logic for fetching data from the Bookeo API and rendering the upcoming classes section.
-   `template-parts/class-card.php`: A reusable template part for displaying a single class card and its corresponding modal structure.
-   `src/index.js`: Handles all client-side interactivity, including the filtering, pagination, and modal popup logic.
-   `functions.php`: Handles theme setup, such as enqueueing scripts and styles, and defining helper functions.
-   `tailwind.config.js`: Configuration file for Tailwind CSS, where theme colors and fonts are defined.
