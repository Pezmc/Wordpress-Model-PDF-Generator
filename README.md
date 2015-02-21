# Wordpress Model PDF Generator
Generate PDF's from arrays of images, designed for use on model websites powered by wordpress

# How to use
1. Upload/git clone to a wordpress server in the wp-content/plugins/ directory
2. Install dependendencies using composer `composer install` in the wordpress-model-pdf-generator directory
3. `chmod -R 777` the vendor/cache directory to ensure the thumbnail generation works correctly
4. Customise `views/renderPDF.php` depending on how your wordpress post data is stored
5. Customise (or create a new template) `templates/MyModelPDF.php` to meet your needs
6. Activate the plugin in wordpress
7. Add some links that point to the plugin on the appropdiate pages, for example:

```
<a href="<?php echo get_permalink();  ?>pdf/split-grid" target="_blank">Generate Split Grid PDF</a>
<a href="<?php echo get_permalink(); ?>pdf/side-by-side" target="_blank">Generate a Side by Side PDF</a>
<a href="<?php echo get_permalink(); ?>pdf/grid" target="_blank">Generate a Grid PDF</a>
```

# Example PDF appearance:
## Split Grid
![Imgur](http://i.imgur.com/tEzpLzKl.jpg)

## Side by Side
![Imgur](http://i.imgur.com/3nemgOOl.jpg)

## Grid
![Imgur](http://i.imgur.com/O841zMal.jpg)
