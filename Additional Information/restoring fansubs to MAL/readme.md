# Note 
This is a brief text version of the [reddit post](https://www.reddit.com/r/anime/comments/9kq1ch/bringing_fansubs_back_on_mal/) (also saved in a PDF version [here](../Bringing%20fansubs%20back%20on%20MAL%20_%20r_anime.pdf))

# Post
Last week, I posted an archive of MAL fansub data. Today, I'm sharing a [userscript](Userscript%20for%20displaying%20(archived)%20fansub%20info%20on%20MAL%20anime%20pages.js) [ [source](https://gist.github.com/IA21/ae266dddddf96ab5d5b58604f1fa45a7) ] that displays the archived fansub info on MAL anime pages, exactly like it used to be before they removed it.  

The script relies on an [API](api.php) [ [source](https://gist.github.com/IA21/726bd716876fdbcb0603478c4e2ad7e4) ]. The API pulls data from the archive so this will only display fansub data that was on MAL until the archiving date (September 25, 2018). I won't be adding to this data. I made this to make my transition to anidb easier (their fansub ratings are lacking and I couldn't give up on MAL's ratings). And I'm sharing because why not :)  

The script is updated to autoload subs and added a checkbox for hiding non-English subs. You can set default behavior for hiding by changing window.hidesubs variable on line#13.

Happy watching.
