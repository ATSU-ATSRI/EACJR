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

ECHO Gathering input files.

dir /A-D /B /OD /S "..\input_data\OMTAdverseEvent*.csv" >> "%curr_dir%\input_data\filelist.txt

ECHO Processing Data: !time!.
C:\Tools\php-5.6.22nts\php.exe "%curr_dir%\code\phase-check.php"

chdir /d "%curr_dir%"

ECHO End of commands: !time!.
