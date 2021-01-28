#!/bin/bash

# Get datahub simple downloads
wget --content-disposition --spider http://localhost/get_datahub_list.php

#Download Users Differential 
wget --content-disposition http://localhost/get_datahub_download.php?fileid=e8339b7a-2d32-414e-9136-2adf3215a09c -O Users-Differential.zip

#Download Login Differential 
wget --content-disposition http://localhost/get_datahub_download.php?fileid=49ac9b6f-8cbc-4a98-a95c-6ce0d89bca57 -O User-Logins-Differential.zip

#Download Org Units Differential 
wget --content-disposition http://localhost/get_datahub_download.php?fileid=867fb940-2b80-49da-9c8b-277c99686fc3 -O Org-Units-Differential.zip

