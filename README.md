# Anti-SPAM-Comment-Filter

WordPress has a built-in comment filtering option [Disallowed Comment Keys](https://wordpress.org/support/article/comment-moderation/#comment-blocking) that allows you to keep in moderation queue comments that contain specific words, but the problem with this method is that comments are still saved in the database and size can grow to hundreds of GBs.

Anti-SPAM Comment Filter is a free WordPress plugin that filters comments based on specified keywords and rejectes them when submitted, without recording them in the database! Activate the plugin and under **Settings > Comment FIlter** add a list of keywords to be blocked.

Here is a list of SPAM-reladed keywords that you can use: [https://www.activecampaign.com/blog/spam-words](https://www.activecampaign.com/blog/spam-words)

This plugin hooks into the preprocess\_comment action and checks the comment content for any of the specified keywords. If a keyword is found, the comment submission is halted and an error message is displayed to the user. If no keywords are found, the comment is allowed to be posted as normal.
