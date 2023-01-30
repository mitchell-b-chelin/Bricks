![logo](./inc/docs/_images/WPBricks.png)

# Bricks <small>2.1</small>
![lego 1](./inc/docs/_images/lego_1.png)
> Bricks is a valuable plugin for developers seeking to create custom blocks for the Gutenberg editor in WordPress using Advanced Custom Fields Pro.

With Bricks, developers can efficiently build blocks that are both reusable and well-structured.

This enhances the management and maintenance of the blocks while delivering an exceptional user experience.

The integrated registration method enables the inclusion of CSS, JavaScript, and SCSS, and the comprehensive set of block JSON features allows for extension of blocks without additional coding.

Whether creating complex blocks with ACF fields or constructing fast-performing blocks without the need for compiling, Bricks provides the necessary tools for creating professional and high-quality blocks that are both functional and visually appealing

# Key Features
![lego 2](./inc/docs/_images/lego_2.png)
- **Developer-friendly**: Bricks is designed with the needs of developers in mind, providing a simple and intuitive interface for building custom blocks for the Gutenberg editor.
- **No React knowledge required**: Bricks does not require any knowledge of React, making it accessible to a wide range of developers.
- **Customizable**: Bricks offers a high degree of customization, allowing you to create blocks that perfectly match your needs.
- **User restrictions**: Bricks includes user restrictions, allowing you to control who can access and use your blocks.
- **Vue@2 and Vue@3 support**: Bricks supports both Vue@2 and Vue@3, giving you the flexibility to choose the version that best fits your needs.
- **Works natively (limited)**: Bricks has native support, with some limitations, making it easy to use and integrate with your existing projects.
- **Easy to set up**: Bricks is easy to set up, with a straightforward installation process that gets you up and running in no time.
- **Reusable blocks**: Bricks enables the creation of reusable blocks, making it easier to manage and maintain your custom blocks.
- **Auto-enqueuing files**: Bricks includes an auto-enqueuing feature, ensuring that your blocks are properly loaded and accessible.
- **SVG support**: Bricks supports SVG, allowing you to use scalable vector graphics in your custom blocks.
- **Category support**: Bricks includes category support, allowing you to categorize your blocks for easier organization and management.
- **Styles support**: Bricks supports styles, giving you the ability to customize the look and feel of your blocks.
- **All Gutenberg WordPress support types**: Bricks supports all types of WordPress Gutenberg blocks, making it a versatile and comprehensive solution for block creation.

# Links
![lego 3](./inc/docs/_images/lego_3.png)
[ACF Blocks](https://www.advancedcustomfields.com/resources/blocks/)  
[Wordpress Blocks](https://wordpress.com/support/wordpress-editor/blocks/)
[GitHub Bricks](https://github.com/mitchell-b-chelin/Bricks)

Bricks leverages the power of [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) to simplify the process of registering custom blocks in the WordPress Gutenberg editor. By incorporating ACF fields, Bricks provides developers with a comprehensive solution for creating custom blocks that are both functional and visually appealing.

# Setup
![lego 4](./inc/docs/_images/lego_4.png)
To start using Bricks in your WordPress instance, create a new folder named "templates" in your theme's directory, and within that folder, create another folder named "bricks" at the following location: `themesdir/templates/bricks/` This folder will serve as the home for all your custom Gutenberg blocks.

The plugin directory includes an "example" folder, which contains a readme file and a sample setup for categories and blocks. You can use these as a reference or follow the provided documentation.

!> Please note that the base directory naming can be changed later on through the Overides features.

# Building Blocks with Bricks
![lego 5](./inc/docs/_images/lego_5.png)
To get started, make sure you have followed the setup instructions in the Getting Started Guide and have created the brick folder path in your themes directory.

## Creating a Category
All blocks in Bricks are organized into categories. These categories are similar to the default categories in the Gutenberg editor:

1. Text
2. Media
3. Design
4. Widgets
5. Theme
6. Embeds

However, if these categories do not fit your needs, you can create your own custom category. To do so, create a new folder in your brick folder path with the desired name. For example, if you want to create a "Harry Potter" category, create a folder named `harrypotter` in `themesdir/templates/bricks/`.

In this folder, create a JSON file named `category.json` with the following content:

```json
{
  "slug": "harrypotter",
  "title": "Harry Potter",
  "icon": "editor-table"
}
```
The `slug`, `title`, and `icon` fields are required. If you wish to use a custom SVG as the icon, place the SVG file in the same folder as the category.json file.

This folder will now serve as the base for all blocks in the **Harry Potter** category.

# Building your first brick
![lego 6](./inc/docs/_images/lego_6.png)
Creating a brick involves setting up a specific directory structure and adding required files within it to create a functional Gutenberg block. The files typically include templates, styles, and scripts, which define the structure and functionality of the block.

Additionally, fields can be defined using ACF, providing a way to input custom data for the block.

With this setup, developers can easily create reusable and customizable blocks to extend the functionality of their WordPress site.
## Required Files for a Brick

- **template.php | template.vue**: contains the logic and template structure of your block.
- **scripts.js**: contains the JavaScript code for your block. (optional)
- **acf.json**: contains the advanced custom fields json that should be available in the backend. (optional)
- **style.css | styles.scss**: contains the styles for your block. (optional)
- Alternatively, you can use style.scss if you prefer.

## Recommended Naming Conventions
For ease of parsing and access, it's recommended to keep template file names consistent across your blocks.

The same goes for styling and javascript files, as all will be loaded during runtime.

Having a consistent naming pattern for these files can simplify management of multiple blocks.


## Example Structure
```
themesdir/templates/bricks/harrypotter/students/
    |- block.json (required)
    |- template.php (required vue or php file)
    |- style.scss (optional)
    |- scripts.js (optional)
    |- acf.json (optional)
    |- style.css (optional)
    |- block.svg (optional)
```
# Block JSON
![lego 7](./inc/docs/_images/lego_7.png)
The block information that is stored in `block.json`. 
contains the following information:

- `name`: A string representing the block name, which must be unique and should not contain any spaces.
- `title`: A string representing the title of the block, which will be displayed in the editor.
- `description`: A string that provides a description of the block and its purpose.
- `icon`: A string representing the dashicons icon to be used for the block.
- `keywords`: An array of keywords that can be used to categorize and search for the block.
- `settings`: An object containing restrictions and login requirements for the block.
- `styles`: An array of objects that define different styles for the block.
- `preview`: An object used for displaying a preview of the block using Advanced Custom Fields (ACF).
## Example json
```json
{
  "name": "students",
  "title": "Hogwarts Students",
  "description": "A List of all hogwarts students",
  "icon": "admin-comments",
  "keywords": [
    "Students",
    "Harry Potter"
  ],
  "settings": {
    "restrict": {
      "values": [
        "keep_gate",
        1,
        2
      ],
      "type": "or"
    },
    "loggedin": true
  },
  "styles": [
    {
      "class": "light",
      "label": "Light",
      "default": true
    },
    {
      "class": "dark",
      "label": "Dark"
    },
    {
      "class": "orange",
      "label": "orange"
    }
  ],
  "preview": {
    "title": "Hello World",
    "subtitle": "Lorem Ipsum"
  }
}
```
> **Important Note**
It is not necessary to use settings or restrictions. However, if you choose to use them, the block will still be visible in the editor, regardless of the user restriction. On the front end, a default restricted block message will be displayed. This can be customized in the Overrides section.

## ACF Fields JSON
When creating a new block, you may want to include advanced custom fields (ACF) for added customization.

To do this, you can export your ACF fields as a local JSON file from the ACF settings. 

You only need the field information, as demonstrated in the example.

You can also manually create fields, as no unique keys are required. If a key is not provided, one will be automatically generated upon loading.
```json
[
  {
    "key": "title",
    "label": "Title",
    "name": "Title",
    "type": "text"
  },
  {
    "key": "subtitle",
    "label": "Subtitle",
    "name": "Subtitle",
    "type": "text"
  },
]
```

## Styles and Scripts Management

Bricks automatically imports all JavaScript and styles from your block folder. No specific naming is required; if a file exists in the folder, it will be imported.

If you don't want a file to be registered, you can add a prefix `_` before its filename. The file will be ignored and not imported by Bricks.

By default, Bricks enables the enqueueing of CSS, JS, and Vue files. To enqueue SCSS files, you need to install the [scss-native](https://github.com/) plugin.


## Icon

Bricks allows you to use your own custom SVG icon instead of the default dashicons for blocks. The following filenames are recognized for loading icons:

- `block.svg`
- `brick.svg`
- `icon.svg`

> Note: If an SVG icon is located with any of these filenames, it will replace the icon set in the block JSON.

## Templates

Bricks supports two types of templates: Vue or PHP. If you choose to use a Vue template, Vue@3 will be loaded in production mode by default.  

However, this can be changed to Vue@2 or development mode in the [Overrides](bb_overides.md).

## Vue@3 example
```vue
<template>
  <div class="test">
    <h1>{{data.Title}}</h1>
    <h2>{{data.Subtitle}}</h2>
    <hr>
    <p>{{ count }}</p>
    <button @click="count--">count down -</button>
    <button @click="count++">count up +</button>
  </div>
</template>

<script>
export default {
    name: 'test',
    components: {},
    data: () => ({
        data: $GLOBAL, //Global is passed into this vue using ACF fields and Current Post Meta
        count: 0
    }),
    // Full Vue lifecylce is avialable 
    setup() {
    },
    beforeCreate() {
    },
    created() {
    },
    beforeMount() {
    },
    mounted() {
    },
    beforeUpdate() {
    },
    updated() {
    },
    beforeUnmount() {
    },
    unmounted() {
    },
    computed: {
    },
    methods: {
    }
}
</script>

<style>
.dark .test {
  background-color: #333;
  color: #fff;
}
.light .test {
  background-color: #fff;
  color: #333;
}
.orange .test {
    background-color: #ffa500;
    color: #fff;
}
</style>

<!-- if SCSS-Native plugin is installed you can use inline SCSS -->
<style lang="scss">
.dark {
    .test {
        background-color: #333;
        color: #fff;
    }
}
.light {
    .test {
        background-color: #fff;
        color: #333;
    }
}
.orange {
    .test {
        background-color: #ffa500;
        color: #fff;
    }
}
</style>
```

## PHP template example
```php
<div class="test">
    <h1><?php get_field('title'); ?></h1>
    <h2><?php get_field('subtitle'); ?></h2>
</div>

<style>
.dark .test {
  background-color: #333;
  color: #fff;
}
.light .test {
  background-color: #fff;
  color: #333;
}
.orange .test {
    background-color: #ffa500;
    color: #fff;
}
</style>

<!-- if SCSS-Native plugin is installed you can use inline SCSS -->
<style lang="scss">
.dark {
    .test {
        background-color: #333;
        color: #fff;
    }
}
.light {
    .test {
        background-color: #fff;
        color: #333;
    }
}
.orange {
    .test {
        background-color: #ffa500;
        color: #fff;
    }
}
</style>
```
# Overides
![lego 8](./inc/docs/_images/lego_8.png)
Bricks provides a way to change the default directory, loaded assets, and other properties within Bricks. 

To achieve this, you can use the following code in your `functions.php` file
```php
/* functions.php */

/* Is not required rename the namespace using MBC\inc before the class is fine */
use MBC\brick as BRICKS;

BRICKS\Prepare::setup(array(
    //Template path for where your bricks are stored.
    'template_path' => get_stylesheet_directory() . '/templates/blocks/',
    // Template restriction php
    'template_restriction' => get_stylesheet_directory() . '/templates/core/block_restricted.php',
    // Vue version and enviroment loaded
    'vue' => array(
        'version' => '3',
        'enviroment' => 'development'
    ),
    // block globals loaded each instance of a block
    'global' => array(
        // Javascript globals
        'javascript' => array(
            get_stylesheet_directory_uri() . '/assets/js/script1.js',
            get_stylesheet_directory_uri() . '/assets/js/script2.js',
        ),
        // Stylesheet globals
        'css' => array(
            get_stylesheet_directory_uri() . '/assets/css/style1.css',
            get_stylesheet_directory_uri() . '/assets/css/style2.css',
        ),
        // Sass Globals ( if you are using SCSS-Native Plugin otherwise a empty array is required )
        'scss' => array(
            'mixins' => array(
                get_stylesheet_directory_uri() . '/assets/scss/mixins/mixin1.scss',
                get_stylesheet_directory_uri() . '/assets/scss/mixins/mixin2.scss',
            ),
            'stylesheets' => array(
                get_stylesheet_directory_uri() . '/assets/scss/style1.scss',
                get_stylesheet_directory_uri() . '/assets/scss/style2.scss',
            )
        )
    )
));
```