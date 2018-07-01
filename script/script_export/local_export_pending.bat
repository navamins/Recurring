@echo off
::===============================================================
:: Script export file with command artisan on Laravel 5.6
::
::===============================================================

title Batch autoscript export to cardlink!

:: This script displays
echo Export transaction on status "Pending" for check data matching to CardLink System
echo Processing system
echo Please Waiting...

:: Open folder my project on Laravel 
cd C:\xampp\htdocs\Recurring 

:: Command line artisan export at custom:exportcardlink
C:\xampp\php\php.exe artisan custom:exportcardlink
exit