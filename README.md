# Contributors Metabox for WordPress Posts

## Index
- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Admin Side Functionality](#admin-side-functionality)
- [Public Side Functionality](#public-side-functionality)
- [Available Hooks](#available-hooks)
- [Template File](#template-file)
- [License](#license)

---

## Introduction

This plugin adds a **Contributors** feature to WordPress posts. Admins, editors, and authors can select multiple contributors (authors) for a post. These contributors are displayed at the end of each post on the front-end with their names, avatars, and links to their author archive pages.

---

## Features
- Adds a "Contributors" metabox to the post editor.
- Lists all WordPress authors with checkboxes.
- Saves selected contributors when a post is saved.
- Displays selected contributors on the front-end after post content.
- Shows contributors' names, Gravatars, and links to their author pages.
- Fully extendable with provided hooks and filters.

---

## Installation

1. **Via Composer**

```bash
composer require your-vendor/contributors-metabox
```

2. **Manual Installation**

- Download the plugin zip.
- Upload and extract it in the `/wp-content/plugins/` directory.
- Activate the plugin via WordPress Admin > Plugins.

---

## Admin Side Functionality

- A new metabox labeled **"Contributors"** is added to the WordPress post editor.
- It lists all users with the `author`, `editor`, or `administrator` role.
- Users can check/uncheck multiple contributors per post.
- Upon saving the post, selected contributors' IDs are saved as post meta.

**Hook for fetching authors:**
```php
$authors = apply_filters(
	'wpcb_get_metabox_contributors',
	get_users(
		array(
			'who'     => 'authors',
			'orderby' => 'display_name',
			'order'   => 'ASC',
		)
	)
);
```

**Hook for modifying contributor IDs before saving:**
```php
$contributor_ids = apply_filters( 'wpcb_pre_save_contributors_ids', $contributor_ids );
```

---

## Public Side Functionality

- Using `the_content` filter, a Contributors box is appended at the end of each post.
- This box displays contributors with their Gravatar images and clickable names linking to their author archive pages.

**Hook for fetching saved contributor IDs:**
```php
$saved_contributors = apply_filters( 'wpcb_get_contributors_ids', $saved_contributors, $post_id );
```

**Hook for customizing the template path:**
```php
$template_path = apply_filters( 'wpcb_contributors_list_tempalte', WPCB_PATH . '/templates/contributors.php' );
```

---

## Available Hooks

| Hook Name                        | Context     | Description                                                              |
|----------------------------------|-------------|--------------------------------------------------------------------------|
| `wpcb_get_metabox_contributors`  | Admin       | Modify the list of users shown in the Contributors metabox.              |
| `wpcb_pre_save_contributors_ids` | Admin       | Modify contributor IDs before saving to the post meta.                  |
| `wpcb_get_contributors_ids`      | Public      | Modify retrieved contributors' IDs before rendering on front-end.       |
| `wpcb_contributors_list_tempalte`| Public      | Override the template file used for displaying contributors on frontend.|

---

## Template File

The default frontend Contributors box is loaded from:

```
/templates/contributors.php
```

You can override this by using the `wpcb_contributors_list_tempalte` filter to specify a custom path.

---

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

✨ Happy contributing!

