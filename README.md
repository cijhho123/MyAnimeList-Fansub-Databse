# MyAnimeList Fansub Databse
An archive of the Anime Fansub databse from [MyAnimeList](https://myanimelist.net/) as of Sep 25, 2018, which was removed from the site shortly after.  


# Why To Use?
I think that MAL/JustAnotherShiro summarized it pretty good:  
> Fansubs section removed? Now that's huge loss. Much bigger than API or clubs imo. Downloading first episode from multiple groups and comparing them myself is huge pain.

You can use this extensive database to find the best fansub suitted for you for anime up untill 2018. All according to keikaku.  
**Translator's note:** keikaku means plan. 

# The archive
This is the MyAnimeList Fansubs Archive as of Sep 25, 2018. There are 3 folders in this archive: 

## scraper/
Contains PHP scripts used for scraping. You can use those scripts on [mal_pages/](MAL%20Fansubs%20Archive/mal_pages/pages) since MAL have officialy removed it from their website.

## mal_pages/
Contains untouched html pages for all 4531 groups on MAL (from https://myanimelist.net/fansub-groups.php). filenames are each group's ID from MAL. made available in case you want to cross check data (from [data/](MAL%20Fansubs%20Archive/data)) in case MAL ever return this feature (unlikely).

## data/ 
Contains parsed data from each group's page in 4 file formats: SQL, XML, JSON, CSV. All the data is parsed into a MySQL db and then used phpmyadmin's export page for all formats. was only tested import on SQL file, use others on your own. The db has 5 tables:

- **1_index:**
contains links for all letter groups. it was made for scraping, you can ignore this.

- **2_group_links:**
contains links for each group's pages. also made for scraping, you can ignore this as well.

- **groups:**
contains this info on all groups: groups name, shortname, IRC channel, language, user votes, total subbed shows

- **shows:**
contains most of the info you will need: all shows subbed by all groups. 'groupid' is from 'groups' table. 'showid' is MAL id for a show (ex. 5114 id for Fullmetal Alchemist: Brotherhood). 'name' and 'details' are self explanatory. 'approve_line' is just how many users approve a sub. This is further divided into 'total_users' and 'approve' for sorting/ranking purposes which MAL never bothered to do. 'total_comments' is how many comments that sub received. These are available in the 'comments' table.

- **comments:** 
contains all comments on every sub for every show. you can use 'groupid' and 'showid' for searching. 'comment' field contains the actual comment. 'color' is for whether a user liked a sub or not. + means like and - means dislike (red background comments).


**Note:** Each table has an "id" field. This is an autoincrement field used for ordering. It doesn't have anything to do with MAL ids.

## Credits
Thanks to u/iBzOtaku for archiving the data back in 2018, visit the Additional Information folder for more information and context.



# Credits
Thanks to @IA21 u/iBzOtaku
