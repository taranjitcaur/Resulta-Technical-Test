== Description ==

nfl-team plugin display a dynamic list of data on the page 'NFL TEAMS' which create itself on plugin activation. On plugin deactivation the page 
'NFL TEAMS' will get deleted automatically.
 
== Installation ==
 
1. Go the dashboard and open the Plugins section.
2. Then upload the zipped file on the Add New Plugin page.
3. Once the plugin uploads successfully, activate the plugin.
4. A new page 'NFL TEAMS' will be created on plugin activation and the page will display the data from the API.
5. A shortcode [nfl-list] can be used on any page in dashboard other than 'NFL TEAMS' page.
6. On the template page use the code below,
<?php echo do_shortcode('[nfl-list]'); ?>