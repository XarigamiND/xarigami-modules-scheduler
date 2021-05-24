# XarigamiND Scheduler Module

This module allows you to schedule Xarigami jobs at certain times of the day/week/month (cron)

Those jobs could be for instance :

* sending a daily digest mail
* expiring temporary user passwords
* escalating a workflow process
* doing a backup of the database
* refreshing cache files

The scheduler module relies on other modules to actually execute whatever jobs are 
scheduled, so first you need to find out which module functions can be scheduled. 

Then you need some kind of trigger to wake up the scheduler - this can be done 
e.g. by requesting a specific webpage automatically from your own system via a Unix 
cron entry or Windows AT command, or via a web-based scheduler services, 
or (if you really have no other choice) by relying on web hits from your 
visitors if your site is relatively busy. 

Original Xarigami project page: n/a
