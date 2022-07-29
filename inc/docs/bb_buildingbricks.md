# Building Bricks
If you have created your brick folder path from [Setup](bb_gettingstarted.md#setup) your halfway there.

## First Category
All bricks live in categories. the idea behind this is gutenberg blocks live in specific categories.  

**Wordpress Defaults**
1. Text
2. Media
3. Design
4. Widgets
5. Theme
6. Embeds


However this these categories may not suit your block prefrence. so create a new category as your folder name.  

!> Note: we will need to define the name and label again so if you wish for a name with space this is possible.  

For this example we will create a new category called **harrypotter**  
```themesdir/templates/bricks/harrypotter/```  

in this folder create a JSON file named ```category.json``` with the following json layout.  

!> Note: you can name this JSON anything. as long as only **1 json** is present it will autoload it.



```json
{
  "slug": "harrypotter",
  "title": "Harry Potter",
  "icon": "editor-table"
}
```

These fields are required. however if you wish to use a custom SVG you can place your custom SVG in this folder.  

!> Note: you can name this SVG anything. as long as only **1 SVG** is present it will autoload it.

This folder now is the base for all blocks that belong in this Category



# First Brick
Now that our category is setup we can create a new folder within it with the name of our new Block.  
for this example ```students```  
```themesdir/templates/bricks/harrypotter/students/```   

This folder contains a few files used to build our brick into a block. some of which require specific naming.


## Block JSON
the block information lives in a JSON file naming of this json can be called the following.
```
info.json
init.json
block.json
brick.json  
```
this json contains the a build up of the block.

- name: **String** the block name namespace ( No Spaces )
- title: **String** title of the new block
- description: **String** description of the block
- icon: **String** dashicons icon for the block
- keywords: **Array** of keywords
- settings: **Object** of restrictions and logged in
- styles: **Array** of **Objects** with defined styles 
- preview: **Object** used for ACF preview  

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
    "loggedin": false
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
!> Note: Using settings / restriction is not required however if using you will be able to see the block in the editor regardless of the user restriction set however on the frontend you will get a default restricted block message this can be extended in Overides.

## ACF Fields JSON
if you have acf installed you will most likely want ACF fields on your new block. you can create local json fields.  
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
Building this json is a stripped down version of the default JSON export for Advanced Custom fields. 
Naming of this json can be called the following.
```
acf.json
fields.json
```

## Styles And Scripts
Bricks enqueues all javascript and styles from your block folder no need for specific naming if its there it will import it.
if there is a chance you do not want it to register it you can use the prefix ```_``` before a filename for it to ignore it completly.

By default bricks enables you to enqueue 
```
css
js
```
However with the [scss-native](https://github.com/) plugin you can enqueue scss files also.

## Icon
Bricks allows you to overide the default dashicons for blocks and use your own custom SVG there is specific naming required for loading icons
```
block.svg
brick.svg
icon.svg
```
!> if a SVG icon is located with one of these filenames it will replace the icon set in the block JSON.

## Template
Bricks allows for 2 types of templates. Vue or PHP
If you create a template using Vue the default Vue 3.X is loaded in production mode, however this can be set to Vue 2.X and or development mode in [Overides](bb_overides.md)

Vue example
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

PHP template example
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