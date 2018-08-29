@REM $rule_1 = "Disallow:harming humans";
@REM $rule_2 = "Disallow:ignoring human orders";
@REM $rule_3 = "Disallow:harm to self";
@REM if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

@ECHO OFF
set curr_dir=%cd%
setlocal enabledelayedexpansion
chdir "%curr_dir%\code"
ECHO Start of command: !time!

ECHO Delete old data: !time!.
del /F /Q "%curr_dir%\code\logfile.txt"

ECHO Gathering input files.
del /F /Q "%curr_dir%\input_data\filelist.txt"
del /F /Q "%curr_dir%\input_data\petlist.txt"
dir /A-D /B /OD /S "..\input_data\*survey.csv" >> "%curr_dir%\input_data\filelist.txt
dir /A-D /B /OD /S "..\input_data\*pet.csv" >> "%curr_dir%\input_data\petlist.txt

ECHO Processing Data: !time!.
C:\Store\Scripting\PHP\php-5.6.17\php.exe "%curr_dir%\code\push2portal.php"

chdir /d "%curr_dir%"

ECHO End of commands: !time!.
