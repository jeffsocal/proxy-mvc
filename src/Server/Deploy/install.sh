#!/bin/bash
# 
# Written by Jeff Jones (jeff@socalbioinformatics.com)
# Copyright (2016) SoCal Bioinformatics Inc.
# 
# See LICENSE.txt for the license.
# 
# install dependancies for [PRODUCT :: PROXY - Website] 
#
###########################################################
#CreateDirectory() { mkdir $PATH }
# 
#for DIR in log
#do
#    $PATH='../../../'$DIR
#    CreateDirectory
#done

###########################################################

sudo apt-get install zip unzip php7.0-zip composer

eval cd /usr/local/scbi/
eval git clone https://github.com/jeffsocal/proxy-mvc.git
eval composer install
eval sudo mkdir /usr/local/scbi/proxy-mvc/log
eval sudo chown -R www-data:www-data /usr/local/scbi/*
eval sudo chmod -R 700 /usr/local/scbi/*
eval sudo chmod -R 755 /usr/local/scbi/proxy-mvc/log
