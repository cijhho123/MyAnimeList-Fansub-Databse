# The archive
This is the MyAnimeList Fansubs Archive as of Sep 25, 2018. There are 3 folders in this archive: 

## scraper/
contains PHP scripts I used for scraping. You can use those scripts on mal_pages.zip as well, in case MAL fansub pages aren't online anymore. 

## mal_pages/
contains untouched html pages for all 4531 groups on MAL (from https://myanimelist.net/fansub-groups.php). filenames are each group's ID from MAL. made available in case you want to cross check data (from data.zip) or want to parse the pages in your prefered way and you won't hammer MAL's server (or get ip blocked). Or maybe MAL will finally pull the plug on fansub-groups.php pages.

## data/ 
contains parsed data from each group's page in 4 file formats: SQL, XML, JSON, CSV. All the data is parsed into a MySQL db and then used phpmyadmin's export page for all formats. I've only tested import on SQL file, use others on your own. The db has 5 tables:

1_index: 
contains links for all letter groups. it was made for scraping, you can ignore this.

2_group_links: 
contains links for each group's pages. also made for scraping, you can ignore this as well.

groups: 
contains this info on all groups: groups name, shortname, IRC channel, language, user votes, total subbed shows

shows: 
contains most of the info you will need: all shows subbed by all groups. 'groupid' is from 'groups' table. 'showid' is MAL id for a show (ex. 5114 id for Fullmetal Alchemist: Brotherhood). 'name' and 'details' are self explanatory. 'approve_line' is just how many users approve a sub. This is further divided into 'total_users' and 'approve' for sorting/ranking purposes which MAL never bothered to do. 'total_comments' is how many comments that sub received. These are available in the 'comments' table.

comments: 
contains all comments on every sub for every show. you can use 'groupid' and 'showid' for searching. 'comment' field contains the actual comment. 'color' is for whether a user liked a sub or not. + means like and - means dislike (red background comments).


Note: Each table has an "id" field. This is an autoincrement field used for ordering. It doesn't have anything to do with MAL ids.

## Credits
Thanks to u/iBzOtaku for archiving and parsing the data back in 2018, visit the Additional Information folder for more information and context.