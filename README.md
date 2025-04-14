# WP Contributors

WordPress plugin to add a Contributors metabox and display contributors on posts.

---

## Index
- [Overview](#overview)
- [Installation](#installation)
- [Browser Support](#browser-support)
- [Usage Instructions](#usage-instructions)
- [Hooks](#hooks)
- [Filters](#filters)
- [Actions](#actions)
- [Unit Testing](#unit-testing)
- [Minimum Requirements](#minimum-requirements)
- [License](#license)

---

## Overview

**WP Contributors** plugin enhances WordPress posts by allowing the selection of multiple contributors from registered users.  
Contributors are displayed on the post front-end along with their Gravatars and links to their author pages.

- Select multiple authors/contributors while editing a post.
- Automatically show contributors at the bottom of the post.
- Fully customizable and extendable via WordPress hooks and filters.
- Designed following WordPress coding standards.

---

## Installation

### 1. Clone and Install Dependencies

```bash
git clone https://github.com/spiderwares/wp-contributors.git
cd wp-contributors
composer install
```

### 2. Upload and Activate

- Upload the `wp-contributors` directory to the `/wp-content/plugins/` directory.
- Activate the **WP Contributors** plugin through the WordPress admin dashboard under **Plugins**.

---

## Browser Support

All major modern browsers are supported as the plugin relies on WordPress admin and standard HTML output.

| Chrome | Firefox | Safari | Edge | Opera |
|:------:|:-------:|:------:|:----:|:-----:|
|  ✅    |   ✅    |   ✅   | ✅   |  ✅   |

---

## Usage Instructions

1. Go to the **Post Editor** screen (Add New or Edit Post).
2. Locate the **Contributors** metabox on the right or bottom of the editor screen.
3. Select one or multiple users from the list by checking the checkboxes.
4. Save or update the post.

On the front-end, the contributors selected for the post will be displayed at the bottom of the post content along with their Gravatars and links to their author archive pages.

---

## Hooks

### Filters

| Filter | Description | Parameters |
|:------|:-------------|:-----------|
| `wpcb_get_metabox_contributors` | Modify the list of users displayed in the Contributors metabox. | `$authors` (array) |
| `wpcb_pre_save_contributors_ids` | Modify contributor IDs before saving them into post meta. | `$contributor_ids` (array) |
| `wpcb_get_contributors_ids` | Modify retrieved contributor IDs for displaying on frontend. | `$saved_contributors` (array), `$post_id` (int) |
| `wpcb_contributors_list_tempalte` | Override the template path used to render the Contributors box on the front-end. | `$template_path` (string) |

---

### Actions

| Action | Description | Parameters |
|:-------|:------------|:------------|
| `wpcb_after_contributors_saved` | Fires after contributors are saved in post meta. | `$post_id` (int), `$contributor_ids` (array) |

---

## Unit Testing

### Running Tests

Ensure you install development dependencies:
```bash
composer install
```

Run PHPUnit tests:

```bash
vendor/bin/phpunit
```

### Code Quality - WordPress Coding Standards (WPCS)

Check coding standards:

```bash
vendor/bin/phpcs --standard=WordPress .
```
---

## Minimum Requirements

- WordPress >= 6.5
- PHP >= 8.2

---

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
