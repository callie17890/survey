How To Read The Error Log
=========================

error log defaults to reading 10 lines

    $ vagrant ssh -- tail /var/log/apache2/error.log

to continue watching the error logs
    
    $ vagrant ssh -- tail -f /var/log/apache2/error.log

to read only one line 

    $ vagrant ssh -- tail -n 1 /var/log/apache2/error.log

to follow the error log and read no lines 

    $ vagrant ssh -- tail -f -n 0 /var/log/apache2/error.log

### For Windows Machines ###

    $ vagrant ssh -c "tail -f -n 0 /var/log/apache2/error.log"